<?php 
    class Ingredient extends Controller{
        
        function get_ingredients(...$params){
            // Call models
            $ingredients = $this->model("IngredientModel");

            $filter = "new";
            $limit = 15;

            // Call views
            $this->view("dashboard-layout",[
                "title"=>"Nguyên liệu",
                "page"=>"ingredients",
                "ingredients"=>
                $ingredients->get(array("filter"=>$filter,"limit"=>$limit))
            ]);
        }

        function add(...$params){
            // Call models
            // $ingredients = $this->model("IngredientModel");

            // $filter = "new";
            // $limit = 15;

            // Call views
            $this->view("dashboard-layout",[
                "title"=>"Nguyên liệu",
                "page"=>"add-ingredients",
            ]);
        }

    }
?>