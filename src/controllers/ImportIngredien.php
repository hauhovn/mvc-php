<?php 
    class ImportIngredient extends Controller{
        function Welcome()
        {
            $importModel = $this->model('ImportIngredientModel');
            $importModel->get_trial();
        }

        function import_ingredients(...$params){
            // Chuyển $params => GET
            // ID || 
        // Call models
          $ingredientModel =  $this->model("importIngredientModel");
          $_GET['limit']=100;

          // call views
        $this->view("dashboard-layout",[
            "title"=>"importIngredientModel",
            "ingredientsDetail"=> $ingredientModel->get(),
            "page"=>"importIngredient",]);
        }
    }
?>