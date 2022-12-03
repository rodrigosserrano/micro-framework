<?php

namespace App\Controllers;

use App\Controllers\Base\BaseController;
use App\Models\User;

class UserController extends BaseController
{
    public function register()
    {
        (new User())->create($this->request()->toArray());
        \UtilsHelpers::responseJson("Register");
    }

    public function find(int $userId)
    {
        $a = (new User())->find('id', $userId);
        \UtilsHelpers::responseJson($a);
    }

    public function findAll()
    {
        $a = (new User())->findAll();

        \UtilsHelpers::responseJson($a);
    }

    public function drink(int $userId)
    {
        \UtilsHelpers::responseJson("drink $userId");
    }

    public function update(int $userId)
    {
        (new User())->update($this->request()->toArray(), ['id' => $userId]);
        \UtilsHelpers::responseJson("update $userId");
    }

    public function delete(int $userId)
    {
        $a = (new User)->delete('id', $userId);
        \UtilsHelpers::responseJson($a);
    }
}