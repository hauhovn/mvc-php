<?php
class Login extends Controller {

    function Welcome(){
        $this->Login();
    }  

    function Login(){
        $this->view('/pages/login',[]);
    }
    
}
?>