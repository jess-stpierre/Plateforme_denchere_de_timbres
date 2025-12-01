<?php

namespace App\Routes;

use App\Providers\View;

class Route {

    private static $routes = [];

    public static function get($url, $controller){
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'GET'];
    }

    public static function post($url, $controller){
        self::$routes[] = ['url' => $url, 'controller' => $controller, 'method' => 'POST'];
    }

    public static function dispatch(){
        $url = $_SERVER['REQUEST_URI'];
        $urlSegments = explode('?', $url);
        $urlPath = $urlSegments[0];
        $method = $_SERVER['REQUEST_METHOD']; //method: http get or post

        foreach(self::$routes as $route){
            if(BASE.$route['url'] == $urlPath && $route['method'] == $method) {

                $controllerSegments = explode('@', $route['controller']); //cest un tableaux associatif
                $controllerName = 'App\\Controllers\\'.$controllerSegments[0];
                $methodName = $controllerSegments[1]; //method = functions in class
                $controllerInstance = new $controllerName();

                if($method == 'GET'){//method: http get or post //does the get contain parameters??

                    if(isset($urlSegments[1])){
                        parse_str($urlSegments[1], $queryParams);
                        $controllerInstance->$methodName($queryParams);
                    }
                    else {
                        $controllerInstance->$methodName(); //method = functions in class
                    }
                }
                elseif($method == 'POST'){

                    if(isset($urlSegments[1])){
                        parse_str($urlSegments[1], $queryParams);
                        $controllerInstance->$methodName($_POST, $queryParams);
                    }
                    else {
                        $controllerInstance->$methodName($_POST);
                    }
                }
            return;
            }
        }

        http_response_code(404);
        return View::render('error', ['msg' => '404 page pas trouvee!']);
    }
}

?>