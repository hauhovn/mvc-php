<?php 
class ImportIngredientModel extends DB{

    protected $db;
    protected $handle;
    public function __construct() {
        // $this->handle = new TableHandler("import_ingredient_info");
        $this->db = new DB();
    }

    public function get(){
        // return $this->handle->select();
    }

    function get_trial(){
        // lay thong tin 5 lan nhap gan nhat
        $ing_trial =  $this->db->query("SELECT imp.id, imp.name,SUM(inf.real_price) AS total_price
        FROM import_ingredients AS imp
        JOIN import_ingredient_info AS inf ON imp.id = inf.import_ingredient_id
        GROUP BY imp.id ORDER BY imp.id LIMIT 5;");
        $ing_trial = json_decode($ing_trial);
        // print_r($ing_trial->data);
        $data="";
        foreach($ing_trial->data as $item){
            // print_r($item->id);
            $trial_basic_info = $this->db->query("SELECT ing.name , inf.quantity
            FROM ingredients AS ing
            JOIN import_ingredients AS imp
            JOIN import_ingredient_info AS inf ON imp.id = inf.import_ingredient_id 
            WHERE inf.import_ingredient_id=".$item->id." LIMIT 3;");
            $trial_basic_info= ['info'=>(array)json_decode($trial_basic_info)->data];
            $trial_basic_info['id'] = $item->id;
            $trial_basic_info['name'] = $item->name;
            $trial_basic_info['total_price'] = $item->total_price;
            $trial_basic_info = (object)$trial_basic_info;
            $data.=json_encode($trial_basic_info);
        }
        return $data;
    }
}
?>