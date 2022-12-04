<?php

namespace App\Controllers\Base;

use App\Core\Http\Request;
use App\Core\Http\Response;

class BaseController
{
    public function response($responseBody = null, ?int $statusCode = 200) : Response
    {
        return (new Response($responseBody, $statusCode));
    }

    public function request() : Request
    {
        return (new Request());
    }
}
