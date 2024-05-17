<?php
class Ingredient extends Controller {

    function Welcome(){
        $this->view("manager-layout",[
            'title'=>'Ingredient',
            'page'=>'ingredient'
        ]);
    }  
    
}
?>