<?php
require_once "./src/models/IngredientModel.php";
require_once "./src/core/Auth.php";
class Ingredient extends IngredientModel{
   function __construct(){
    parent::__construct();
            
    // Kiểm tra xác thực trước khi xử lý yêu cầu
    Auth::authenticate();
    $ingredientModel = new IngredientModel();

    header('Content-Type: application/json');

    $method = $_SERVER['REQUEST_METHOD'];
    switch ($method) {
        case 'GET':
            if (isset($_GET['id'])) {
                $ingredient = $ingredientModel->getIngredientById($_GET['id']);
                echo json_encode($ingredient);
            } else {
                $ingredients = $ingredientModel->getAllIngredients();
                echo json_encode($ingredients);
            }
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $name = $data['name'];
            $price = $data['price'];
            $unit = $data['unit'];
            $inventory = $data['inventory'];
            $result = $ingredientModel->createIngredient($name, $price, $unit, $inventory);
            echo json_encode(['result' => $result]);
            break;
            
        case 'PUT':
            $data = json_decode(file_get_contents('php://input'), true);
            if(isset($data['id'])&&isset($data['name'])&&isset($data['price'])&&isset($data['unit'])&&isset($data['inventory'])){
                $id = $data['id'];
                $name = $data['name'];
                $price = $data['price'];
                $unit = $data['unit'];
                $inventory = $data['inventory'];
                $result = $ingredientModel->updateIngredient($id, $name, $price, $unit, $inventory);
                http_response_code(201);
                echo json_encode(['result' => $result]);
            }else{
               // Trả về thông báo lỗi nếu thiếu thông tin
               http_response_code(400);
               echo json_encode(array("message" => "Thiếu thông tin."));
            }
            
            break;

        case 'DELETE':
            if (isset($_GET['id'])) {
                $result = $ingredientModel->deleteIngredient($_GET['id']);
                http_response_code(201);
                echo json_encode(['result' => $result]);
            }else{
                // Trả về thông báo lỗi nếu thiếu thông tin
               http_response_code(400);
               echo json_encode(array("message" => "Thiếu thông tin."));
            }
            break;

        default:
            http_response_code(405);
            echo json_encode(['error' => 'Method not allowed']);
            break;
    // }
    }

   }
   function Welcome(){
    // echo $this->login('hello','123');
    }
}
?>
