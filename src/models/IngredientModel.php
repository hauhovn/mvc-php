<?php 
class IngredientModel extends DB{

    public $id;
    public $name;
    public $price;
    public $unit;
    public $created_at;


    public function __construct($id = null, $name = null, $price = null, $unit = null, $created_at = null) {
        $this->id = $id;
        $this->name = $name;
        $this->price = $price;
        $this->unit = $unit;
        $this->created_at = $created_at;
    }

    public function get($params){
        // Khởi tạo mảng kết quả
        $data = array();
        
        // Thiết lập filter và limit từ tham số
        $filter = (isset($params['filter']) && $params['filter'] == "new") ? "ORDER BY created_at DESC" : "";
        $limit = isset($params['limit']) ? $params['limit'] : 5;

        // Thực hiện truy vấn SQL
        $query = "SELECT * FROM ingredients $filter LIMIT $limit";
        $result = mysqli_query($this->conn, $query);

        // Kiểm tra kết quả truy vấn và lặp qua dữ liệu
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                // Thêm dữ liệu vào mảng
                $data[] = $row;
            }
        }
        // Trả về mảng kết quả
        return $data;
    }
}
?>