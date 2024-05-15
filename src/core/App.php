<?php
class App
{
    protected $namespace = ""; // Namespace for controller
    protected $controller = "Home";
    protected $action = "Welcome";
    protected $params = [];
    protected $controller_path = "./src/controllers/";

    function __construct()
    {
        
        // Check url
        $url = isset($_GET['url']) ? $this->UrlProcess($_GET['url']) : [];
        
        // Determine namespace and update controller_path
        if (!empty($url)) {
            switch ($url[0]) {
                case 'api':
                    $this->namespace = 'api';
                    $this->controller_path .= 'api/';
                    break;
                case 'manager':
                    $this->namespace = 'manager';
                    $this->controller_path .= 'manager/';
                    break;
                default:
                    break;
            }
            if ($this->namespace) {
                unset($url[0]);
            }
        }
    
        // Xu ly Controller
        if (isset($url[1])) {
            // Là web khách hàng
            if(isset($url[0])){
                //Kiem tra file controller ton tai
                if (file_exists($this->controller_path . $url[0] . ".php")) {
                    $this->controller = $url[0];
                    unset($url[0]);
                }
            }else{
                //Kiem tra file controller ton tai
                if (file_exists($this->controller_path . $url[1] . ".php")) {
                    $this->controller = $url[1];
                }
                unset($url[1]);
            }
        }
        require_once $this->controller_path . $this->controller . ".php";
    
        // Xu ly Action
        if (isset($url[2])||isset($url[1])) {
            if(isset($url[1])){
               // ton tai func trong class
                if (method_exists($this->controller, $url[1])) {
                    $this->action = $url[1];
                }
                unset($url[1]);
            }else{
                // ton tai func trong class
                if (method_exists($this->controller, $url[2])) {
                    $this->action = $url[2];
                }
                unset($url[2]);
            }
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