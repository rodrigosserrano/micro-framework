<?php

namespace App\Middlewares;

use App\Core\Http\Request;

class Authentication implements InterfaceMiddleware
{

    public function handle(Request $request)
    {
        if (!$this->validateToken($request)) throw new \Exception('Unauthorized', 401);
    }

    public function validateToken(Request $request) : bool
    {
        $headers = $request->getHeaders();
        if (!array_key_exists('X-Api-Key', $headers)) {
            return false;
        }

        if ($headers['X-Api-Key'] !== '12345') {
            return false;
        }

        return true;
    }
}