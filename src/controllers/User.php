<?php
class User extends Controller {

    function Welcome(){
        echo 'User-welcome!';
    }  
    
    function Login(){
        $this->view('/pages/login',[]);
    }
    function register(){
     $this->view('/pages/register',[]);
    }
}
?>