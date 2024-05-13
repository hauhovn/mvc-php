<?php 
class MenuModel extends DB{
    public function get(){
        $qr = "SELECT * FROM ingredients";
        return mysqli_query($this->con,$qr) or die(mysqli_error($this->con));
    }
}
?>