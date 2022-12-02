<?php

namespace App\controllers;

use App\controllers\Base\BaseController;

class UserController extends BaseController
{
    public function index()
    {

    }

    public function show()
    {
        return 'show';
    }

    public function drunk($p)
    {
        list($p1, $p2) = $p;
//        \UtilsHelpers::dd('sdsd');
        \UtilsHelpers::dd($p2);
    }
}