<?php
class Ingredient extends Controller {

    function Welcome(){
        $this->getAllIngrediet();
    }  

    function getAllIngrediet(){
        // Call model
        $ingModel = $this->model('IngredientModel');
        // Call view with data
        $this->view("manager-layout",[
            'title'=>'Ingredient',
            'page'=>'ingredient',
            'ingredientList'=>$ingModel->getAllIngredients()
        ]);
    }
    
}
?>