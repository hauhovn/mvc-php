<?php 
    class Ingredients extends DB {
        function __contruct(){
            echo "Ingredients-db";
        }
        function select(){
            // Xác định các điều kiện và tham số của câu truy vấn
            $conditions = array();
            
            // Kiểm tra và thêm điều kiện về id
            if(isset($_GET['id'])){
                $conditions[] = "`id`=".$_GET['id'];
            }
            
            // Kiểm tra và thêm điều kiện về status
            $conditions[] = "`status` >= 0";
            
            // Kiểm tra và thêm điều kiện về sắp xếp ASC/DESC
            $order = "";
            if(isset($_GET['order'])){
                $order = "ORDER BY created_at ".$_GET['order'];
            }
            // Kiểm tra và thêm điều kiện về limit
            $limit = "";
            if(isset($_GET['limit'])){
                $limit = "LIMIT ".$_GET['limit'];
            }
            
            // Tạo câu truy vấn từ các điều kiện và tham số
            $query = "SELECT * FROM ingredients";
            if(!empty($conditions)){
                $query .= " WHERE ".implode(" AND ", $conditions);
            }
            $query .= " ".$order." ".$limit;

            // Thực hiện câu truy vấn
            $exc=$this->query($query);
            print_r($exc);
        }
        function insert(){
            // Kiểm tra POST data
            if(isset($_POST['name'])&&isset($_POST['price'])&&isset($_POST['unit'])){              
                $query="INSERT INTO `ingredients` (`name`,`price`,`unit`)
                VALUES ('".$_POST['name']."',".$_POST['price'].",'".$_POST['unit']."')";
                $exc=$this->query($query);
                print_r($exc);
            }   
        }
        function update(){
            // Đọc dữ liệu từ phần thân của yêu cầu
            parse_str(file_get_contents('php://input'), $_PUT);
            if(isset($_PUT['id'])&&isset($_PUT['name'])&&isset($_PUT['price'])&&isset($_PUT['unit'])){              
                $query="UPDATE `ingredients` SET `name`='".$_PUT['name']."', `price`= ".$_PUT['price'].", `unit`='".$_PUT['unit']."'  WHERE  `id`=".$_PUT['id'];
                $exc=$this->query($query);
                print_r($exc);
            } 
        }

        function delete(){
            // Kiểm tra POST data
            parse_str(file_get_contents('php://input'), $_DELETE);
            if(isset($_DELETE['id'])){              
                $query="UPDATE `ingredients` SET `status` = -1 WHERE `id` = ".$_DELETE['id'];
                $exc=$this->query($query);
                print_r($exc);
            }   
        }
        
    }
?>