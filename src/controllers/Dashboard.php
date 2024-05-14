<?php 
    class Dashboard extends Controller{
        function Welcome()
        {
            // Default
            $this->Ingredient("Show",100);
        }

        function Ingredient(...$params){
            // Chuyển $params => GET
            // ID || 
        // Call models
          $ingredientModel =  $this->model("ingredientModel");
          $_GET['limit']=100;
          $_GET['id']= 1134;
          echo json_encode($ingredientModel->get());

          // call views
        $this->view("dashboard-layout",[
            "title"=>"Current ingredients",
            "data"=> $ingredientModel->get(),
            "page"=>"ingredients",]);
        }

    }
?>