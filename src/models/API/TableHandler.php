<?php 
class TableHandler extends DB {
    protected $db;
    protected $table_name;

    function __construct($table_name){
        $this->db = new Database();
        $this->table_name = $table_name;
    }

    function select(){
        $limit = isset($_GET['limit']) ? "LIMIT ".$_GET['limit'] : "";
        $id = isset($_GET['id']) ? " AND `id`=".$_GET['id'] : "";
        $order = isset($_GET['order']) ? "ORDER BY created_at ".$_GET['order'] : "";
        $query = "SELECT * FROM ".$this->table_name." WHERE `status` >= 0 ".$id." ".$order." ".$limit;
        $result = $this->query($query);
        if($result) {
            return $result->fetch_all(MYSQLI_ASSOC);
        } else {
            return ["error" => $this->db->error()];
        }
    }

    function insert(){
        $columns = implode(",", array_keys($_POST));
        $values = implode("','", array_values($_POST));
        $query = "INSERT INTO ".$this->table_name." (".$columns.") VALUES ('".$values."')";
        $result = $this->query($query);
        if($result) {
            return "Insert successful";
        } else {
            return ["error" => $this->db->error()];
        }
    }

    function update(){
        parse_str(file_get_contents('php://input'), $input);
        $set_clause = "";
        foreach($input as $key => $value) {
            if($key != 'id') {
                $set_clause .= "`".$key."`='".$value."', ";
            }
        }
        $set_clause = rtrim($set_clause, ", ");
        $query = "UPDATE ".$this->table_name." SET ".$set_clause." WHERE `id`=".$input['id'];
        $result = $this->query($query);
        if($result) {
            return "Update successful";
        } else {
            return ["error" => $this->db->error()];
        }
    }

    function delete(){
        parse_str(file_get_contents('php://input'), $_DELETE);
        if(isset($_DELETE['id'])){              
            $query = "UPDATE ".$this->table_name." SET `status` = -1 WHERE `id` = ".$_DELETE['id'];
            $result = $this->query($query);
            if($result) {
                return "Delete successful";
            } else {
                return ["error" => $this->db->error()];
            }
        }
    }  
}
?>