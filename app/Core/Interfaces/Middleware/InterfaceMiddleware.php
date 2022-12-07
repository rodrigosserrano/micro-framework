<?php

namespace App\Core\Interfaces\Middleware;

use App\Core\Http\Request;

interface InterfaceMiddleware
{
    public function handle(Request $request);
}