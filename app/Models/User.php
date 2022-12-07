<?php

namespace App\Models;

use App\Core\Db\Model;
use Exception;

class User extends Model
{
    protected string $table = 'users';

    /**
     * @throws Exception
     */
    public function checksRequiredFieldsRegister(object $request)
    {
        if (!$request->email || !$request->name || !$request->password) throw new Exception('Invalid body, needs Email, Name and Password.', 400);
    }

    /**
     * @throws Exception
     */
    public function checksRequiredFieldsLogin(object $request)
    {
        if (!$request->email || !$request->password) throw new Exception('Invalid body, needs Email and Password.', 400);
    }
}