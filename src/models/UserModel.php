<?php

class UserModel extends DB {
  
    public function __construct() {
        parent::__construct();
    }
    public function login($phone, $password) {
        // Xác thực người dùng
        if ($this->authenticate($phone, $password)) {
            // Tạo token
            $token = $this->generateToken($phone);
            $this->createToken($token, $phone);
            return $token;
        } else {
            return false;
        }
    }
    public function register($phone, $password,$first_name,$last_name){
        $result = ['code'=>400,'msg'=> ''];
        $userIsset = $this->getUserByUsername($phone);
        if ($userIsset) {
            
        }
    }
    private function authenticate($phone, $password) {
        // Code xác thực người dùng từ cơ sở dữ liệu
        $sql = "SELECT password FROM users WHERE phone = :phone";
        $stmt = $this->query($sql, ['phone' => $phone]);
        $result = $stmt->fetch();
        return isset($result['password'])?password_verify($password,$result['password']) : 0;
    }
    
    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    function jwt_encode($payload, $secret_key) {
        $header = $this->base64url_encode(json_encode(array('typ' => 'JWT', 'alg' => 'HS256')));
        $payload = $this->base64url_encode(json_encode($payload));
        $signature = $this->base64url_encode(hash_hmac('sha256', "$header.$payload", $secret_key, true));
        return "$signature";
    }

    private function generateToken($username) {
        $secret_key = getenv('SECRET_KEY');
        $issued_at = time();
        $expiration_time = $issued_at + (60 * 60); // 1 giờ
        $payload = array(
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "username" => $username
        );
        $token = $this->jwt_encode($payload, $secret_key);
        return $token;
    }

    public function getUserByUsername($username) {
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $this->query($sql, ['username' => $username]);
        return $stmt->fetch();
    }

    public function getUserById($id) {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->query($sql, ['id' => $id]);
        return $stmt->fetch();
    }

    // Use for register user
    public function createUser($phone, $password,$first_name,$last_name) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (phone, password , first_name, last_name)
        VALUES (:phone, :password, :first_name, :last_name)";
        return $this->execute($sql, 
        ['phone' => $phone,
         'password' => $passwordHash,
         'first_name'=> $first_name,
         'last_name'=> $last_name
        ]);
    }

    public function createToken($token,$user_id) {
        $sql = "INSERT INTO user_token (user_id, token)
         VALUES (:user_id, :token)";
       return $this->execute($sql, 
       ['user_id' => $user_id, 'token' => $token]);
    }

    public function validateToken($token) {
        $sql = "SELECT * FROM user_token WHERE token = :token";
        $stmt = $this->query($sql, ['token' => $token]);
        return $stmt->fetch();
    }
    function verifyToken($token) {
        try {
            $secret_key = getenv('SECRET_KEY');
            list($header, $payload, $signature) = explode('.', $token);
            $payloadDecoded = json_decode(base64_decode(strtr($payload, '-_', '+/')), true);
            $validSignature = hash_equals(
                $this->base64url_encode(hash_hmac('sha256', "$header.$payload", $secret_key, true)),
                $signature
            );
            if ($validSignature && $payloadDecoded['exp'] > time()) {
                return $payloadDecoded;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
?>
