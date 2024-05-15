<?php
class UserModel extends DB {

    public function login($username, $password) {
        // Xác thực người dùng
        if ($this->authenticate($username, $password)) {
            // Tạo token
            $token = $this->generateToken($username);
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
        $secret_key = "YOUR_SECRET_KEY";
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

    public function createUser($username, $password) {
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        return $this->execute($sql, ['username' => $username, 'password' => $passwordHash]);
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
