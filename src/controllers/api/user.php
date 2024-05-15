<?php
$user = new User();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Nhận dữ liệu từ yêu cầu
    $input = json_decode(file_get_contents('php://input'), true);
    $username = $input['username'];
    $password = $input['password'];

    // Đăng nhập và nhận token
    $token = $user->login($username, $password);

    if ($token) {
        // Trả về token nếu đăng nhập thành công
        echo json_encode(array("token" => $token));
    } else {
        // Trả về lỗi nếu đăng nhập không thành công
        http_response_code(401);
        echo json_encode(array("message" => "Đăng nhập không thành công."));
    }
}
?>
