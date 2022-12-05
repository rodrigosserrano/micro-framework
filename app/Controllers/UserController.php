<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;
use App\Services\UserService;
use Exception;

class UserController extends BaseController
{
    private UserService $_userService;

    public function __construct(){
        $this->_userService = new UserService();
    }

    /**
     * @throws Exception
     */
    public function register()
    {
        try {
            $this->_userService->register($this->request());
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        $this->response(statusCode:201)->send();
    }

    /**
     * @throws Exception
     */
    public function find(int $userId)
    {
        try {
            $user = $this->_userService->find($userId);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        $this->response($user)->send();
    }

    /**
     * @throws Exception
     */
    public function findAll()
    {
        try {
            $users = $this->_userService->findAll();
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        $this->response($users)->send();
    }

    /**
     * @throws Exception
     */
    public function drink(int $userId)
    {
        try {
            $userDrink = $this->_userService->drink($this->request(), $userId);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        $this->response($userDrink)->send();
    }

    /**
     * @throws Exception
     */
    public function update(int $userId)
    {
        try {
            $this->_userService->updateData($this->request(), $userId);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        $this->response(statusCode: 204)->send();
    }

    /**
     * @throws Exception
     */
    public function delete(int $userId)
    {
        try {
            $this->_userService->delete($userId);
        } catch (Exception $e) {
            throw new Exception($e->getMessage(), $e->getCode());
        }
        $this->response(statusCode: 204)->send();
    }
}