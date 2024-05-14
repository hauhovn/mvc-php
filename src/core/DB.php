<?php 
class DB {
    public $conn;
    protected $servername = "localhost";
    protected $username = "root";
    protected $password = "";
    protected $dbname = "coffee_db";
    function __construct() {
      
        try {
            $this->conn = mysqli_connect(
                $this->servername,
                $this->username,
                $this->password);
            mysqli_select_db($this->conn, $this->dbname);
            mysqli_query($this->conn,"SET NAMES 'utf8'");
          }catch (Exception $err){
            echo "Connection failed: " . $$err;
          }
        // try {
        //     $conn = new PDO("mysql:host=".$this->servername.";
        //     dbname=".$this->dbname, $this->username, $this->password);
        //     // set the PDO error mode to exception
        //     $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        //   } catch(PDOException $e) {
        //     echo "Connection failed: " . $e->getMessage();
        //   }
    }

    function query($sql) {

      try {     
        $result= mysqli_query($this->conn,$sql);
        $status = "Không tìm được dữ liệu";
        $data=null;
        $code=1;
        // Kiểm tra kết quả truy vấn và lặp qua dữ liệu
          if ($result) {
            // Nếu là GET thì lấy data
            if($_SERVER['REQUEST_METHOD'] === 'GET'){
                $status = "Dữ liệu tìm được: ".$result->num_rows;
                $code=2;
                while ($row = $result->fetch_assoc()) {
                    // Thêm dữ liệu vào mảng
                    $data[] = $row;
                }
            }else{
                $status = "Thực hiện truy vấn thành công";
                $code=2;
            }
            
          }
        // Trả về mảng kết quả
        return json_encode(["status"=>$status,"code"=>$code,"data"=>$data,"sql"=>$sql]);
      } catch ( Exception $e) {
        $status = "Thực thi SQL thất bại";
        $data=null;
        $code=0;
        return json_encode(
          ["status"=>$status,
          "code"=>$code,
          "error"=>$e->getMessage(),
          "data"=>$data,
          "sql"=>$sql]);
      }
    }
}
?>