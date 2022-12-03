<?php

namespace App\Controllers\Base;

class NotFoundController extends BaseController
{
    public function index() : void
    {
        \UtilsHelpers::responseJson("Path not found :(", 404);
    }
}