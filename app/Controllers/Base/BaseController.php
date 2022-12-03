<?php

namespace App\Controllers\Base;

use App\Core\ServerParams;

class BaseController
{

    protected object $_json;

    public function __construct()
    {
        header('Content-Type: application/json');
    }

    /**
     * This method get the body request and validate if is a Json
     * @return object|null
     * @throws \Exception
     */
    protected function request() : object|null
    {
        // Checks if is correct request type
        if (!in_array(ServerParams::requestType(), ServerParams::requestsTypesAcceptBody())) throw new \Exception('Body is not accept in '.ServerParams::requestType(), 400);

        // Checks headers
        $headers = headers_list();
        if(!in_array('Content-Type: application/json', $headers)) throw new \Exception('Content type is not a json.');

        // Checks if is not null
        $body = file_get_contents('php://input');
        if (empty($body)) return null;

        // Checks if is json
        $this->_json = json_decode($body);
        if (!is_object($this->_json)) throw new \Exception('Request body is not a JSON', 400);

        return $this;
    }

    public function toArray(){
        return (array) $this->_json;
    }

    public function toJson(){
        return $this->_json;
    }
}
