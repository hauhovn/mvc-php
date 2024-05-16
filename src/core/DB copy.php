<?php 
class DBCu {
    public $conn;
    public $pdo;
    protected $servername = "localhost";
    protected $username = "root";
    protected $password = "";
    protected $dbname = "coffee_db";
    protected $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
    function __construct() {
      
        // try {
        //     $this->conn = mysqli_connect(
        //         $this->servername,
        //         $this->username,
        //         $this->password);
        //     mysqli_select_db($this->conn, $this->dbname);
        //     mysqli_query($this->conn,"SET NAMES 'utf8'");
        //   }catch (Exception $err){
        //     echo "Connection failed: " . $$err;
        //   }
          try {
            $this->pdo = new PDO($this->dsn, $this->user, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Lỗi kết nối: " . $e->getMessage());
        }
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
            if(stripos($sql, "SELECT") !== false){
                $status = "Dữ liệu tìm được: ".$result->num_rows;
                $code=3;
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

    function authenticate() {
        if (!isset($_GET['api_key'])) {
            http_response_code(401);
            echo json_encode(array("message" => "Truy cập bị từ chối. Không có API Key."));
            exit();
        }
    
        global $pdo;
        $apiKey = $_GET['api_key'];
        $stmt = $pdo->prepare("SELECT * FROM api_keys WHERE api_key = :api_key");
        $stmt->execute(['api_key' => $apiKey]);
        $apiKeyData = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$apiKeyData) {
            http_response_code(401);
            echo json_encode(array("message" => "Truy cập bị từ chối. API Key không hợp lệ."));
            exit();
        }
    }
}
?>