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

          // call views
        $this->view("dashboard-layout",[
            "title"=>"Current ingredients",
            "ingredients"=> $ingredientModel->get(),
            "page"=>"ingredients",]);
        }

        function inventory(){
            $inventory =  $this->model("inventoryModel");
            $inventory->Welcome();
        }

    }
?>