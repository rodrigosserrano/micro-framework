<?php

namespace App\Core\Http;

use Exception;

class Request
{
    private ?object $_json;
    private ?array $_headers;

    public static array $requestsTypesAcceptBody = ['POST', 'PATCH', 'PUT'];

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->requestHeaders()->requestBody();
    }

    public static function uri(): string
    {
        return trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
    }

    public static function requestType(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function queryString(): array
    {
        if (isset($_SERVER['QUERY_STRING'])) {
           return $_GET;
        }
        return [];
    }

    // Treatment cors and origins allowed
    public static function cors(bool $enable = true, array $origins = []): void
    {
        if (!$enable) {
            header("Access-Control-Allow-Origin: *");
        } else {
            self::allowedOrigins($origins);
        }

        header('Access-Control-Allow-Credentials: true');
        header('Access-Control-Max-Age: 86400');
    }

    private static function allowedOrigins(array $origins = []): void
    {
        if (!empty($origins)) {
            if (!empty($_SERVER['HTTP_ORIGIN'])) {
                if (in_array($_SERVER['HTTP_ORIGIN'], $origins)) {
                    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
                }
            }
        }
    }

    private function requestHeaders(): Request
    {
        $this->_headers = getallheaders();
        return $this;
    }

    /**
     * This method get the body request and validate if is a Json
     * @return void
     * @throws Exception
     */
    private function requestBody(): void
    {
        // Checks if is not null
        $body = file_get_contents('php://input');
        if (empty($body) && !in_array(self::requestType(), self::$requestsTypesAcceptBody)) return;

        // Checks if is correct request type
        if (!in_array(self::requestType(), self::$requestsTypesAcceptBody)) throw new Exception('Body is not accept in '.self::requestType(), 400);

        // Checks if is json
        $this->_json = json_decode($body);
        if (!is_object($this->_json)) throw new Exception('Request body is not a JSON or is null', 400);
    }

    public function getHeaders(): array
    {
        return $this->_headers;
    }

    public function toJson(): ?object
    {
        return $this->_json;
    }

    public function toArray(): ?array
    {
        return (array) $this->_json;
    }
}