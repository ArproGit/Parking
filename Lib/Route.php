<?php 
namespace Lib;

class Route {
    private static $routes = [];
    static public function get($uri, $callback){
        $uri = trim($uri, '/');
        self::$routes['GET'][$uri] = $callback;
    }
    static public function post($uri, $callback){
        $uri = trim($uri, '/');
        self::$routes['POST'][$uri] = $callback;
    }
    static public function dispatch(){
        $uri = $_SERVER['REQUEST_URI'];
        $method = $_SERVER['REQUEST_METHOD'];
        if (strpos($uri, '?')) {
            $uri = substr($uri, 0, strpos($uri, '?'));
        }

        if (URL_FRONT == '') {
            $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/');
        } else{
            $basePath = rtrim(constant('URL_FRONT'), '/');
        }	

        $basePathLength = strlen($basePath);
        if (substr($uri, 0, $basePathLength) === $basePath) {
            $uri = substr($uri, $basePathLength);
        }
         $uri = trim($uri, '/');

        foreach (self::$routes[$method] as $route => $callback){

            if (strpos($route, ':') !== false) {
                // Decodificar la URL

                $decodedRoute = urldecode($route);
                $route = preg_replace('#:([a-zA-Z_]+)#', '([a-zA-Z0-9_]+)', $decodedRoute);

                // $route = preg_replace('#:[a-zA-Z\s]+#', '([a-zA-Z0-9\s]+)', $route);
                // $route = preg_replace('#:([a-zA-Z]+)(%20[a-zA-Z]+)*#', '([a-zA-Z0-9\+]+)', $route);
                // $route = preg_replace('#:([a-zA-Z]+)(\s[a-zA-Z]+)*#', '([a-zA-Z0-9\s]+)', $route);


            } 
            if (preg_match("#^$route$#", $uri, $matches)) {
                $params = array_slice($matches, 1);
                if (is_callable($callback)) {
                    $response = $callback(...$params);
                } 
                if (is_array($callback)) {
                    $controller = new $callback[0];
                    $response = $controller->{$callback[1]}(...$params);
                } 
                if (is_array($response) || is_object($response)) {
                    header('content-type: application/json');
                    echo json_encode($response);
                } else {
                    echo $response;
                }
                return;
            } 
        }
        
        $url_base = URL_FRONT;
        header("Location: {$url_base}");
		exit();	
    }
}