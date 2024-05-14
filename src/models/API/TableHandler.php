<?php 
class TableHandler extends DB {
    protected $db;
    protected $table_name;

    function __construct($table_name){
        $this->db = new DB();
        $this->table_name = $table_name;
    }

    function select(){
        $limit = isset($_GET['limit']) ? "LIMIT ".$_GET['limit'] : "";
        $id = isset($_GET['id']) ? " AND `id`=".$_GET['id'] : "";
        $order = isset($_GET['order']) ? "ORDER BY created_at ".$_GET['order'] : "";
        $query = "SELECT * FROM ".$this->table_name." WHERE `status` >= 0 ".$id." ".$order." ".$limit;
        $result = $this->db->query($query);
        // print_r($result);
        return $result;
    }

    function insert(){
        isset($_POST['password']) && $_POST['password']=password_hash($_POST['password'], PASSWORD_DEFAULT);
        $columns = implode(",", array_keys($_POST));
        $values = implode("','", array_values($_POST));
        $query = "INSERT INTO ".$this->table_name." (".$columns.") VALUES ('".$values."')";
        $result = $this->db->query($query);
        //Nếu tương tác thêm vào bảng chi tiết -> cập nhật số lượng, đơn giá NVL
        if($this->table_name=="import_ingredient_info"){
            $this->table_name = 'ingredients';
            $_GET['id'] = $_POST['ingredient_id'];

            // Giải mã chuỗi JSON thành đối tượng
            $data = json_decode($this->select())->data;
            // echo $this->select();
            $price = $data[0]->price == 0
            ? $data[0]->price+$_POST['real_price']
            : (($data[0]->price*$data[0]->inventory)+($_POST['real_price']*$_POST['quantity']))/($_POST['quantity']+$data[0]->inventory);
            $inventory = $data[0]->inventory+$_POST['quantity'];
            $id=$data[0]->id;

            print_r($this->db->query("UPDATE ingredients SET price=".$price." , inventory=".$inventory." WHERE id=".$id));
    }
        return $result;
    }

    function update(){
        parse_str(file_get_contents('php://input'), $input);
        $set_clause = "";
        foreach($input as $key => $value) {
            $key=='password'&& $value = password_hash($value,PASSWORD_DEFAULT);
            if($key != 'id') {
                $set_clause .= "`".$key."`='".$value."', ";
            }
        }
        $set_clause = rtrim($set_clause, ", ");
        $query = "UPDATE ".$this->table_name." SET ".$set_clause." WHERE `id`=".$input['id'];
        $result = $this->db->query($query);
        print_r($result);
    }

    function delete(){
        parse_str(file_get_contents('php://input'), $_DELETE);
        if(isset($_DELETE['id'])){              
            $query = "UPDATE ".$this->table_name." SET `status` = -1 WHERE `id` = ".$_DELETE['id'];
            $result = $this->db->query($query);
            print_r($result);
        }
    }  

    // Method: POST, PUT, GET etc
// Data: array("param" => "value") ==> index.php?param=value

    function CallAPI($method, $url, $data = false)
    {
        $curl = curl_init();

        switch ($method)
        {
            case "POST":
                curl_setopt($curl, CURLOPT_POST, 1);

                if ($data)
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                break;
            case "PUT":
                curl_setopt($curl, CURLOPT_PUT, 1);
                break;
            default:
                if ($data)
                    $url = sprintf("%s?%s", $url, http_build_query($data));
        }

        // Optional Authentication:
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($curl, CURLOPT_USERPWD, "username:password");

        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($curl);

        curl_close($curl);

        return $result;
    }
}
?>