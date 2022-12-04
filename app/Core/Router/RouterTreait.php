<?php

namespace App\Core\Router;

use App\Core\Http\Request;

class RouterTreait
{
    private string $_uri;
    private string $_requestType;
    private array $_routesMaped;

    /** Initialize vars with
     * Uri - I need know which path URI to redirect to correct controller and method
     * Request Type - I need know which HTTP Verb
     * Routes Maped - I need the routes registered for validade with browser Uri
     */
    public function __construct()
    {
        $this->_uri = Request::uri();
        $this->_requestType = Request::requestType();
        $this->_routesMaped = Router::$routes;
    }

    /**
     * This method checks if URI inputed by user exists in routes maped
     * checks if exists based on http verb requested
     * if exists, returns the "Controller@method"
     * @return mixed|null
     */
    private function simpleRouter() : mixed
    {
        if (array_key_exists($this->_uri, $this->_routesMaped[$this->_requestType])) {
            return $this->_routesMaped[$this->_requestType][$this->_uri];
        }

        return null;
    }

    /**
     * This method checks if URI inputed by user exists in routes maped
     * checks too the regex passed in path, disregarding the path "/"
     * checks if exists based on http verb requested
     * example route /users/2 <- dynamic value passed
     * if exists, returns the "Controller@method"
     * @return mixed|null
     */
    private function regexRouter() : mixed
    {
        $foundClassMethod = null;
        foreach ($this->_routesMaped[$this->_requestType] as $path => $controllerMethod) {
            $rgx = str_replace('/', '\/', ltrim($path, '/'));
            if ($path !== '/' && preg_match("/^$rgx$/", trim($this->_uri, '/'))){
                $foundClassMethod = $controllerMethod;
                break;
            }
        }
        return $foundClassMethod;
    }

    /**
     * This method returns the "Controller@method" matched
     */
    public function get() : string|array {
        if ($this->simpleRouter()) return $this->simpleRouter();
        if ($this->regexRouter()) return $this->regexRouter();

        return 'Base\NotFoundController@index';
    }
}