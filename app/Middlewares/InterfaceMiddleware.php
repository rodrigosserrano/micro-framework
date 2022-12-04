<?php

namespace App\Middlewares;

use App\Core\Http\Request;

interface InterfaceMiddleware
{
    public function handle(Request $request);
}