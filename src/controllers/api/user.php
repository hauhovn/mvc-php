<?php
require_once "./src/models/UserModel.php";
class User extends UserModel {
    
    function __construct(){
        // Gọi phương thức khởi tạo của lớp cha (DB)
        parent::__construct();
        // Kiểm tra loại yêu cầu và xử lý tương ứng
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kiểm tra xem yêu cầu là để tạo tài khoản hay đăng nhập
            if (isset($_POST['action'])) {
                $action = $_POST['action'];

                if ($action === 'register') {
                    // Yêu cầu tạo tài khoản
                    if (isset($_POST['phone']) && isset($_POST['password']) 
                    && isset($_POST['first_name'])&& isset($_POST['last_name'])) {
                        $phone = $_POST['phone'];
                        $password = $_POST['password'];
                        $first_name = $_POST['first_name'];
                        $last_name = $_POST['last_name'];

                        // Thực hiện tạo tài khoản
                        $result = $this->createUser($phone, $password, $first_name, $last_name);
                        if ($result) {
                            // Trả về thông báo thành công hoặc chuyển hướng đến trang đăng nhập
                            http_response_code(201);
                            echo json_encode(array("message" => "Tài khoản đã được tạo thành công."));
                            exit;
                        } else {
                            // Trả về thông báo lỗi
                            http_response_code(400);
                            echo json_encode(array("message" => "Số điện thoại đã được đăng ký."));
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
                            echo json_encode(["token" => $token,"message"=> "Đăng nhập thành công."]);
                            exit;
                        } else {
                            // Trả về thông báo lỗi nếu đăng nhập không thành công
                            http_response_code(401);
                            echo json_encode(array("message" => "Thông tin đăng nhập không chính xác."));
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
        }elseif ($_SERVER['REQUEST_METHOD'] === 'GET'){
            if(isset( $_GET['id'] )){
                echo json_encode($this->getUserById($_GET['id']));
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
