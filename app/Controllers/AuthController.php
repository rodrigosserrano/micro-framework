<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;
use App\Services\UserService;

class AuthController extends BaseController
{
    private UserService $userService;

    public function __construct(){
        $this->userService = new UserService();
    }

    public function login()
    {
        try {
            $userInfo = $this->userService->login($this->request());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
        $this->response($userInfo)->send();
    }
}