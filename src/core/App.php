<?php
class App
{
    protected $controller = "Home";
    protected $action = "Welcome";
    protected $params = [];
    protected $controller_path = "./src/controllers/";

    function __construct()
    {
        
        // Check url
        $url = isset($_GET['url'])?$this->UrlProcess($_GET['url']):"";
        // Xu ly Controller
        if (isset($url[0])) {
            //Kiem tra file controller ton tai
            if (file_exists($this->controller_path. $url[0] . ".php")) {
                $this->controller = $url[0];
            }
            unset($url[0]);
        }
        require_once $this->controller_path. $this->controller . ".php";

        // Xu ly Action
        if (isset($url[1])) {
            // ton tai func trong class
            if (method_exists($this->controller, $url[1])) {
                $this->action = $url[1];
            }
            unset($url[1]);
        }

        // Xu ly Params
        $this->params = $url ? array_values($url) : [];

        // // LOGs
        // echo "ctrl path=".$this->controller_path."</br>controller=".$this->controller."</br>action=".$this->action."</br>params=";
        // print_r($this->params);

        // Call func goi Controller-A vs Params
        call_user_func_array([new $this->controller, $this->action], $this->params);
    }

    function UrlProcess($url)
    {
            //Xu ly chuoi
            $trimUrl = trim($url);
            $validateUrl = filter_var($trimUrl, FILTER_VALIDATE_DOMAIN);
 
            // Cat chuoi
            return explode("/", $validateUrl);
    }
}
?>