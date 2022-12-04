<?php

namespace App\Controllers\Base;

class NotFoundController extends BaseController
{
    public function index() : void
    {
        $this->response('Not Found', 404)->send();
    }
}