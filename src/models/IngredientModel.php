<?php 
class IngredientModel extends TableHandler{

    protected $handle;
    public function __construct() {
        $this->handle = new TableHandler("ingredients");
    }

    public function get(){
        return $this->handle->select();
    }
}
?>