<?php
class Register extends Controller {

    function Welcome(){
       $this->Register();
    }  

    function Register(){
        $this->view('/pages/register',[]);
    }
    
}
?>