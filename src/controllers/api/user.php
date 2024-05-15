<?php
class User extends UserModel {
    
    function __construct(){
        // Kiểm tra loại yêu cầu và xử lý tương ứng
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kiểm tra xem yêu cầu là để tạo tài khoản hay đăng nhập
            if (isset($_POST['action'])) {
                $action = $_POST['action'];

                if ($action === 'register') {
                    // Yêu cầu tạo tài khoản
                    if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['email'])) {
                        $username = $_POST['username'];
                        $password = $_POST['password'];
                        $email = $_POST['email'];

                        // Thực hiện tạo tài khoản
                        $result = $this->register($username, $password, $email);
                        if ($result) {
                            // Trả về thông báo thành công hoặc chuyển hướng đến trang đăng nhập
                            echo json_encode(array("message" => "Tài khoản đã được tạo thành công."));
                            exit;
                        } else {
                            // Trả về thông báo lỗi
                            http_response_code(400);
                            echo json_encode(array("message" => "Không thể tạo tài khoản."));
                            exit;
                        }
                    } else {
                        // Trả về thông báo lỗi nếu thiếu thông tin đăng ký
                        http_response_code(400);
                        echo json_encode(array("message" => "Thiếu thông tin đăng ký."));
                        exit;
                    }
                } elseif ($action === 'login') {
                    // Yêu cầu đăng nhập
                    if (isset($_POST['phone']) && isset($_POST['password'])) {
                        $phone = $_POST['phone'];
                        $password = $_POST['password'];

                        // Thực hiện đăng nhập
                        $token = $this->login($phone, $password);
                        if ($token) {
                            // Trả về token nếu đăng nhập thành công
                            echo json_encode(array("token" => $token));
                            exit;
                        } else {
                            // Trả về thông báo lỗi nếu đăng nhập không thành công
                            http_response_code(401);
                            echo json_encode(array("message" => "Đăng nhập không thành công."));
                            exit;
                        }
                    } else {
                        // Trả về thông báo lỗi nếu thiếu thông tin đăng nhập
                        http_response_code(400);
                        echo json_encode(array("message" => "Thiếu thông tin đăng nhập."));
                        exit;
                    }
                } else {
                    // Trả về thông báo lỗi nếu hành động không hợp lệ
                    http_response_code(400);
                    echo json_encode(array("message" => "Hành động không hợp lệ."));
                    exit;
                }
            } else {
                // Trả về thông báo lỗi nếu không có hành động được chỉ định
                http_response_code(400);
                echo json_encode(array("message" => "Không có hành động được chỉ định."));
                exit;
            }
            } else {
                // Trả về thông báo lỗi nếu yêu cầu không phải là POST
                http_response_code(405);
                echo json_encode(array("message" => "Yêu cầu không hợp lệ."));
                exit;
            }
        }

    function Welcome(){
        // echo $this->login('hello','123');
    }

}
?>
