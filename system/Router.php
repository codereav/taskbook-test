<?php

namespace App\System;

/**
 * Class Router
 * @package App\System
 */
final class Router
{
    /**
     * @var array
     */
    private $routes = [];
    /**
     * @var array
     */
    private $params = [];
    /**
     * @var
     */
    private $requestUri;

    /**
     * Router constructor.
     * @param $routes
     */
    public function __construct($routes)
    {
        $this->routes = array_merge($this->routes, $routes);
    }

    /**
     * @param $url
     * @return array
     */
    private function splitUrl($url): array
    {
        return str_ireplace($_SERVER['HTTP_HOST'], '', preg_split('/\//', $url, -1, PREG_SPLIT_NO_EMPTY));
    }

    /**
     * Method parse request uri and find routes,
     * then call execute method
     * @param null $requestUri
     */
    public function dispatch($requestUri = null)
    {
        if ($requestUri === null) {
            $uriArray = explode('?', $_SERVER['REQUEST_URI']);
            $uri = reset($uriArray);
            $requestUri = urldecode(rtrim($uri, '/'));
        }
        $this->requestUri = $requestUri;

        //if isset same route url, set array of url parts into $params
        if (isset($this->routes[$requestUri])) {
            $this->params = $this->splitUrl($requestUri);
        }

        foreach ($this->routes as $route => $uri_path) {

            //If exists '::' string in route, replace keys by regexp
            if (strpos($route, '::') !== false) {
                $route = str_replace(['::any', '::num'], ['(.+)', '([0-9]+)'], $route);
            }

            //If the request url matches the regular expression, replace it by $uri_path and replace $uri_path
            if (preg_match('#^' . $route . '$#', $requestUri)) {
                if (strpos($uri_path, '$') !== false && strpos($route, '(') !== false) {
                    $uri_path = preg_replace('#^' . $route . '$#', $uri_path, $requestUri);
                }

                //set array of url parts
                $this->params = $this->splitUrl($uri_path);
                break;
            }
        }
        $this->execute();
    }

    /**
     * Method execute needle method by parsed url params
     */
    private function execute()
    {
        $controller = 'App\Controller\\' . ($this->params[0] ?? 'MainController');
        $action = $this->params[1] ?? 'index';
        $params = array_slice($this->params, 2);
        (new $controller())->$action($params ? implode(', ', $params) : false);
    }
}