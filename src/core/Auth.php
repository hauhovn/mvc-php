<?php
 // Import lớp UserModel
 require_once "./src/models/UserModel.php";
class Auth {
    public static function authenticate() {
        // $headers = apache_request_headers();
        // if (isset($headers['Authorization'])) {
        //     $authHeader = $headers['Authorization'];
        //     list($token) = sscanf($authHeader, 'Bearer %s');
        if (isset($_COOKIE['token'])) {
            // Get token from COOKIE
            $token = $_COOKIE['token'];

            if ($token) {
                $userModel = new UserModel();
                if ($userModel->validateToken($token)) {
                    return true; // Xác thực thành công
                }else{
                    // Token không hợp lệ
                    http_response_code(401);
                    echo json_encode(array("message" => "Token không hợp lệ."));
                    exit();
                }
            }else{
                // Không nhận được token
                http_response_code(401);
                echo json_encode(array("message" => "Không nhận được token."));
                exit();
            }
        }
        // Xác thực không thành công
        http_response_code(401);
        // echo json_encode(array("message" => "You need set Authorization with Bearen token."));
        echo json_encode(array("message" => "You need set Cookie with token=token-value."));
        exit();
    }
}
?>
