<?php
 // Import lớp UserModel
require_once './src/models/UserModel.php';
class Auth {
    public static function authenticate() {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            list($token) = sscanf($authHeader, 'Bearer %s');

            if ($token) {
                $userModel = new UserModel();
                if ($userModel->validateToken($token)) {
                    return true; // Xác thực thành công
                }
            }
        }
        // Xác thực không thành công
        http_response_code(401);
        echo json_encode(array("message" => "Token không hợp lệ."));
        exit();
    }
}
?>