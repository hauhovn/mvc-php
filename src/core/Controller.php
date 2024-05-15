<?php 
class Controller {
    public function model($model){
        require_once "./src/models/".$model.".php";
        return new $model;
    }
    public function api($api){
        require_once "./src/api/".$api.".php";
        return new $api;
    }
    public function view($view,$data){
        require_once "./src/views/".$view.".php";
    }
}
?>