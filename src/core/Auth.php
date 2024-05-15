<?php
session_start();

function authenticate() {
    if (!isset($_SESSION['user_id'])) {
        http_response_code(401);
        echo json_encode(array("message" => "Truy cập bị từ chối. Vui lòng đăng nhập."));
        exit();
    }
}
?>
