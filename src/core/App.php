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
        // 
        $ca_index = 0;
        // Determine namespace and update controller_path
        if (!empty($url)) {
            switch ($url[$ca_index]) {
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
            // Neu set namespace moi thi huy index hien tai;
            if($this->namespace!=''){
                unset($url[$ca_index]);
                $ca_index+=1;
            }
        }
        
        // Xu ly Controller
        if (isset($url[$ca_index])) {
            //Kiem tra file controller ton tai
            if (file_exists($this->controller_path . $url[$ca_index] . ".php")) {
                $this->controller = $url[$ca_index];
            }
            unset($url[$ca_index]);
            $ca_index+=1;
        }
        require_once $this->controller_path . $this->controller . ".php";
    
        // Xu ly Action
        if (isset($url[$ca_index])) {
            if (method_exists($this->controller, $url[$ca_index])) {
                $this->action = $url[$ca_index];
            }
            unset($url[$ca_index]);
        }
        // Xu ly Params
        $this->params = $url ? array_values($url) : [];

        // // LOGs
        // echo "ctrl path=".$this->controller_path."</br>controller=".$this->controller."</br>action=".$this->action."</br>params=";
        // print_r($this->params);

        // Call func goi Controller-A vs Params
        if($this->namespace=='manager'){
            if(!($this->controller=="login"|| $this->controller== "register")){
                Auth::authenticate();
            }
        }
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