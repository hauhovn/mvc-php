<?php
class API extends Controller {


    function Ingredients(){
        $ingredients=$this->api("ingredients");
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Xử lý yêu cầu GET
            $ingredients->select();

        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý yêu cầu POST     
            $ingredients->insert();
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            // Xử lý yêu cầu PUT
            $ingredients->update();

        } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Xử lý yêu cầu DELETE
            $ingredients->delete();
        }
    }

    function Users(){
        $ingredients=$this->api("TableHandler");
    }
}
?>