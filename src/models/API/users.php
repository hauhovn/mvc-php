<?php 
class Users extends TableHandler {

}
// Sử dụng
$table_name = "user"; // Thay đổi thành tên bảng cần sử dụng
$handler = new TableHandler($table_name);

// Xử lý yêu cầu
switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        echo json_encode($handler->select());
        break;
    case 'POST':
        echo json_encode($handler->insert());
        break;
    case 'PUT':
        echo json_encode($handler->update());
        break;
    case 'DELETE':
        echo json_encode($handler->delete());
        break;
    default:
        http_response_code(405);
        echo json_encode(["error" => "Method not allowed"]);
    }

?>