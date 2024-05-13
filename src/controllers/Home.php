<?php 
    class Home extends Controller{
        function Welcome()
        {
        echo "Home-Welcome";
        }

        function Search($s){
            echo "Search: ".$s;
        }

        function Menu(){
            $menu = $this->Model("MenuModel");
            echo $menu->get();
        }

    }
?>