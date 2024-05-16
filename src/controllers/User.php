<?php
class User extends Controller {

   
    function Welcome(){
        echo 'User-welcome!';
    }  
    
    function Login(){
        $this->view('login',[]);
    }
    function register(){
     $this->view('register',[]);
    }
}
?>