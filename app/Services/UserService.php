<?php

namespace App\Services;

use App\Core\Http\Request;
use App\Models\User;
use Exception;

class UserService
{
    private User $_userModel;
    private TokenService $_tokenService;

    public function __construct(){
        $this->_userModel = new User();
        $this->_tokenService = new TokenService();
    }

    /**
     * @param Request $request
     * @throws Exception
     */
    public function register(Request $request): void
    {
        $data = $request->toJson();
        if (!$data->email || !$data->name || !$data->password) throw new Exception('Invalid body, needs Email, Name and Password.', 400);
        $userExists = $this->_userModel->find('email', $data->email);

        if($userExists) throw new Exception('User already exists.', 200);

        $data->password = password_hash($data->password, PASSWORD_BCRYPT);

        $this->_userModel->create($request->toArray());
    }

    /**
     * @param Request $request
     * @return object
     * @throws Exception
     */
    public function login(Request $request): object
    {
        $data = $request->toJson();
        if (!$data->email || !$data->password) throw new Exception('Invalid body, needs Email and Password.', 400);
        $user = $this->_userModel->find('email', $data->email);

        if(!$user) throw new Exception('User not exists or is invalid email and password.', 200);

        if(!password_verify($data->password, $user->password)) throw new Exception('User not exists or is invalid email and password.', 200);

        $user->token = $this->_tokenService->newToken($user->id);
        // remove password and token id from return
        unset($user->password, $user->token_id);

        return $user;
    }

    /**
     * @param Request $request
     * @param int $userId
     * @return object
     * @throws Exception
     */
    public function drink(Request $request, int $userId): object
    {
        $data = $request->toJson();
        if (!$data->drink) throw new Exception('Invalid body, needs Drink', 400);

        $user = $this->_userModel->find('id', $userId);
        if (empty($user)) throw new Exception('User not exists.', 400);

        $user->drink_counter += $data->drink;

        if (!$this->_userModel->update((array) $user, ['id' => $userId])) throw new Exception('Error to update drink counter.', 500);

        return $user;
    }

    /**
     * @throws Exception
     */
    public function updateData(Request $request, int $userId): void
    {
        $data = $request->toJson();
        $columnsAccepted = ['name', 'email', 'password'];
        foreach($request->toArray() as $key => $value){
            if (!in_array($key, $columnsAccepted)) throw new Exception("Invalid '$key' in body.", 400);
        }

        if ($data->password) $data->password = password_hash($data->password, PASSWORD_BCRYPT);

        if(!$this->_userModel->update($request->toArray(), ['id' => $userId])) throw new Exception('Error to update user.', 500);
    }

    /**
     * @throws Exception
     */
    public function delete(int $userId): void
    {
        if (!$this->_userModel->delete('id', $userId)) throw new Exception('Error to delete user.', 500);
    }

    /**
     * @throws Exception
     */
    public function find(int $userId): ?object
    {
        return $this->_userModel->find('id', $userId);
    }

    /**
     * @throws Exception
     */
    public function findAll(): ?array
    {
        return $this->_userModel->findAll()->paginate(5)->get();
    }
}