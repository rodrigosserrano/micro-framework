<?php

namespace App\controllers\Base;

use App\core\ServerParams;
use App\Routes\Routes;

class BaseController
{
    public function __construct()
    {
        header('Content-Type: application/json');
    }
}
