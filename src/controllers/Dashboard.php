<?php 
    class Dashboard extends Controller{
        function Welcome()
        {
            // Default
            $this->Ingredients("Show",100);
        }

        function Ingredients(...$params){
            // Chuyển $params => GET
            // ID || 
        // Call models
          $ingredientModel =  $this->model("ingredientModel");
          $_GET['limit']=100;

          // call views
        $this->view("dashboard-layout",[
            "title"=>"Current ingredients",
            "ingredients"=> $ingredientModel->get(),
            "page"=>"ingredients",]);
        }

        function import_ingredients(...$params){
            // Chuyển $params => GET
            // ID || 
        // Call models
          $ingredientModel =  $this->model("importIngredientModel");
         echo  $ingredientModel->get_trial();
        //   $_GET['limit']=100;

          // call views
        $this->view("dashboard-layout",[
            "title"=>"importIngredientModel",
            "ingredientsDetail"=> $ingredientModel->get_trial(),
            "page"=>"importIngredient",]);
        }
    }
?>