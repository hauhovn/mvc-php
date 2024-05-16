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
            return $token;
        } else {
            return false;
        }
    }
    
    private function authenticate($username, $password) {
        // Code xác thực người dùng từ cơ sở dữ liệu
        return true;
    }
    
    function base64url_encode($data) {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
    
    function jwt_encode($payload, $secret_key) {
        $header = $this->base64url_encode(json_encode(array('typ' => 'JWT', 'alg' => 'HS256')));
        $payload = $this->base64url_encode(json_encode($payload));
        $signature = $this->base64url_encode(hash_hmac('sha256', "$header.$payload", $secret_key, true));
        return "$header.$payload.$signature";
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

    public function verifyUser($username, $password) {
        $user = $this->getUserByUsername($username);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }
}
?>