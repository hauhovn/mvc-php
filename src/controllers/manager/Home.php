<?php
class Home extends Controller {
    function Welcome(){
        $this->view("manager-layout",[
            'title'=>'Home',
            'page'=>'home'
        ]);
    }   
}
?>