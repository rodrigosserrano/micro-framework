<?php

namespace App\Services;

use App\Core\Http\Request;
use App\Models\User;
use UtilsHelpers;

class UserService
{
    private User $user;

    public function __construct(){
        $this->user = new User();
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function registerUser(Request $request) : void
    {
        //TODO: password_bcrypt
        $data = $request->toJson();
        if (!$data->email || !$data->name || !$data->password) throw new \Exception('Needs Email, Name and Password.', 400);
        $userExists = $this->user->find('email', $data->email);

        if($userExists) throw new \Exception('User already exists.', 200);

        $data->password = password_hash($data->password, PASSWORD_BCRYPT);

        $this->user->create($request->toArray());
    }

    /**
     * @param Request $request
     * @throws \Exception
     */
    public function login(Request $request) : object
    {
        $data = $request->toJson();
        if (!$data->email || !$data->password) throw new \Exception('Needs Email and Password.', 400);
        $user = $this->user->find('email', $data->email);

        if(!$user) throw new \Exception('User not exists or is invalid email and password.', 200);

        if(!password_verify($data->password, $user->password)) throw new \Exception('User not exists or is invalid email and password.', 200);

        // remove password from return
        unset($user->password);

        return $user;
    }
}