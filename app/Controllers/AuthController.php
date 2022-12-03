<?php

namespace App\Controllers;

class AuthController
{
    public function login()
    {
        \UtilsHelpers::responseJson("Login");
    }
}