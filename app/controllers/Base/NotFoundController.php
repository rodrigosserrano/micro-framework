<?php

namespace App\controllers\Base;

class NotFoundController extends BaseController
{
    public function index() : void
    {
        \UtilsHelpers::responseJson("Path not found :(", 404);
    }
}