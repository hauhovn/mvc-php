<?php
class API extends Controller {
    // function Ingredients(){
    //     $ingredients=$this->api("ingredients");
    //     if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    //         // Xử lý yêu cầu GET
    //         $ingredients->select();

    //     } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //         // Xử lý yêu cầu POST     
    //         $ingredients->insert();
            
    //     } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    //         // Xử lý yêu cầu PUT
    //         $ingredients->update();

    //     } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    //         // Xử lý yêu cầu DELETE
    //         $ingredients->delete();
    //     }
    // }

    function Users(){
       $this->callTableHandle("users");
    }
    function Ingredients(){
        $this->callTableHandle("ingredients");
    }

    function Import_ingredients(){
        $this->callTableHandle("import_ingredients");
    }
    function Import_ingredient_info(){
        $this->callTableHandle("import_ingredient_info");
        
    }
    function callTableHandle($table_name){
        $handler = new TableHandler($table_name);
                
        // Xử lý yêu cầu
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            // Xử lý yêu cầu GET
            echo $handler->select();
    
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Xử lý yêu cầu POST   
            $handler->insert();
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'PUT') {
            // Xử lý yêu cầu PUT
            $handler->update();
    
        } elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
            // Xử lý yêu cầu DELETE
            $handler->delete();
        }
    }
}
?>