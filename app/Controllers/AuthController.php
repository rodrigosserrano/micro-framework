<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;
use App\Models\User;
use App\Services\UserService;

class AuthController extends BaseController
{
    private UserService $userService;
    private User $_userModel;

    public function __construct(){
        $this->_userModel = new User();
        $this->userService = new UserService($this->_userModel);
    }

    public function login()
    {
        try {
            $this->_userModel->checksRequiredFieldsLogin($this->request()->toJson());
            $userInfo = $this->userService->login($this->request());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
        $this->response($userInfo)->send();
    }
}