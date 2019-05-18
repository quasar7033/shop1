<?php

/**
 * Created by PhpStorm.
 * User: User
 * Date: 29.10.2018
 * Time: 19:19
 */
class Router
{
    /*
     * @var array
     * For site routes
     */
    private $routes;

    public function __construct()
    {
        $routesPath = ROOT.'/config/routes.php';
        $this->routes = include ($routesPath);
    }

    /*
     * Get URI from request
     */
    public function getURI()
    {
        if (!empty($_SERVER['REQUEST_URI'])){
            return trim($_SERVER['REQUEST_URI'],'/');
        }
    }

    /*
     * Connect users uri to controlleers classes
     */
    public function run(){
        $uri = $this->getURI();
        foreach ($this->routes as $uriPattern => $path) {
            if (preg_match("~$uriPattern~",$uri)){
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);
                $segments = explode('/',$internalRoute);
                $controllerName = ucfirst(array_shift($segments).'Controller');
                $actionName = 'action'.ucfirst(array_shift($segments));
                $parametrs = $segments;
                $controllerObject = new $controllerName;
                $result = $controllerObject->$actionName($parametrs);
                if ($result != null){
                    break;
                }
            }
        }
    }

}