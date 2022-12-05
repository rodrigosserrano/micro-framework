<?php

namespace App\Core\Http;

class Response
{
    private array $_headers;
    private mixed $_responseBody;
    private string $_contentType = 'application/json';
    private int $_statusCode;

    public function __construct($responseBody = null, int $statusCode = 200)
    {
        http_response_code($statusCode);
        $this->_responseBody = $responseBody;
        $this->_statusCode = $statusCode;
    }

    public function addHeader(array $headers): Response
    {
        $this->_headers = $headers;
        return $this;
    }

    public function setHeaders(): void
    {
        foreach ($this->_headers as $keyH => $valueH) {
            header("$keyH: $valueH");
        }
    }

    public function setContentType($contentType): Response
    {
        $this->_contentType = $contentType;
        return $this;
    }

    public function send(): void
    {
        header("Content-Type: {$this->_contentType}");

        if ($this->_contentType == 'application/json') {
            if (!is_null($this->_responseBody)) {
                $keyResp = (!is_string($this->_responseBody)) ? 'data' : 'message';
                echo json_encode([
                    $keyResp => $this->_responseBody,
                    'statusCode' => $this->_statusCode
                ]);
            }
            // If necessary, add news contents types here -- TODO: Alter if to Switch Case
        }
    }
}