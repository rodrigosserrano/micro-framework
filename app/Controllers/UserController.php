<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;
use App\Models\User;
use App\Services\UserService;

class UserController extends BaseController
{
    private UserService $userService;

    public function __construct(){
        $this->userService = new UserService();
    }

    public function register()
    {
        try {
            $this->userService->registerUser($this->request());
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage(), $e->getCode());
        }
        $this->response(statusCode:201)->send();
    }

    public function find(int $userId)
    {
        $a = (new User())->find('id', $userId);
        $this->response($a)->send();
    }

    public function findAll()
    {
        $a = (new User())->findAll();

        $this->response($a)->send();
    }

    public function drink(int $userId)
    {
        $this->response("drink $userId")->send();
    }

    public function update(int $userId)
    {
//        \UtilsHelpers::dd($this->request());
//        (new User())->update($this->request()->toArray(), ['id' => $userId]);
        $this->response("update $userId")->send();
    }

    public function delete(int $userId)
    {
//        $a = (new User)->delete('id', $userId);
        $this->response("delete $userId")->send();
    }
}