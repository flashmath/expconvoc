<?php


class Request
{
    public $request;
    public $query;
    public $cookies;
    public $files;
    public $server;
    public $controllerName;
    public $action;
    public $params=[];
    public $defaultController;

    protected static $requestFactory;

    public function __construct($query,$request,$cookies,$files,$server)
    {
        if (isset($_SESSION['controller'])){
            $this->defaultController = $_SESSION['controller'];
        } else {
            $this->defaultController = "log";
        }
        $this->initialize($query,$request,$cookies,$files,$server);

        spl_autoload_register(function ($class) {
            include 'controller/' . $class . '.php';
        });
    }

    private function getRoute(){
        if (isset($_GET) && (count($_GET))){
            $route = array_keys($_GET)[0];
        } else {
            $route = $this->defaultController;
        }
        $q = explode('/',$route);
        $this->controllerName = ucfirst(strtolower($q[0]));
        array_shift($q);
        if (array_key_exists(0,$q)) {
            $this->action = strtolower($q[0]).'Action';
            array_shift($q);
        } else {
            $this->action = 'defaultAction';
        }

        $this->params = $q;

    }

    public function initialize($query,$request,$cookies,$files,$server){
        $this->request = $request;
        $this->query = $query;
        $this->cookies = $cookies;
        $this->files = $files;
        $this->server = $server;

        $this->getRoute();
    }

    private static function createRequestFromFactory($query=[],$request=[],$cookies=[],$files=[],$server=[]){
        return new  static($query,$request,$cookies,$files,$server);
    }

    public static function createFromGlobals(){
        return self::createRequestFromFactory($_GET,$_POST,$_COOKIE,$_FILES,$_SERVER);

    }

    public static function setFactory($callable){
        self::$requestFactory = $callable;
    }

    public function setDefaultController($default){
        $this->defaultController = $default;
    }

    public function setRole($role){
        switch ($role){
            case 1 :
                $_SESSION['controller'] = 'admin';
                break;
            case 2:
                $_SESSION['controller'] = 'order';
                break;
            default:
                $_SESSION['controller'] = 'log';

        }
        $this->setDefaultController($_SESSION['controller']);
    }
}