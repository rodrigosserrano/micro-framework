<?php

namespace App\Middlewares;

use App\Core\Http\Request;
use App\Core\Interfaces\Middleware\InterfaceMiddleware;
use App\Services\TokenService;
use Exception;

class Authentication implements InterfaceMiddleware
{

    /**
     * @throws Exception
     */
    public function handle(Request $request)
    {
        if (!$this->validateToken($request)) throw new Exception('Unauthorized', 401);
    }

    /**
     * @throws Exception
     */
    public function validateToken(Request $request): bool
    {
        if (!array_key_exists('token', $request->getHeaders())) return false;

        $tokenService = new TokenService();
        return $tokenService->validateToken($request->getHeaders()['token']);
    }
}