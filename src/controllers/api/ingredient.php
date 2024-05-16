<?php
require_once 'authenticate.php';
require_once 'IngredientModel.php';

// Kiểm tra xác thực trước khi xử lý yêu cầu
authenticate();

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
        $id = $data['id'];
        $name = $data['name'];
        $price = $data['price'];
        $unit = $data['unit'];
        $inventory = $data['inventory'];
        $result = $ingredientModel->updateIngredient($id, $name, $price, $unit, $inventory);
        echo json_encode(['result' => $result]);
        break;

    case 'DELETE':
        if (isset($_GET['id'])) {
            $result = $ingredientModel->deleteIngredient($_GET['id']);
            echo json_encode(['result' => $result]);
        }
        break;

    default:
        http_response_code(405);
        echo json_encode(['error' => 'Method not allowed']);
        break;
}
?>
