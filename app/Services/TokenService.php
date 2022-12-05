<?php

namespace App\Services;

use App\Models\Token;

class TokenService
{
    private Token $_tokenModel;

    public function __construct(){
        $this->_tokenModel = new Token();
    }

    /**
     * @throws \Exception
     */
    public function newToken(int $userId): string
    {
        $createdToken = $this->_tokenModel->create([
            'user_id'       => $userId,
            'token'         => bin2hex(random_bytes(32)),
            'date_expires'  => date('Y-m-d H:i:s', strtotime(getenv('TOKEN_EXPIRES'))),
        ]);

        if (!$createdToken) throw new \Exception('Error to create a new token.', 500);

        $res = $this->_tokenModel->find('id', $createdToken);

        return $res->token;
    }

    public function validateToken(string $token): bool
    {
        $res = $this->_tokenModel->find('token', $token);

        // Checks if token exists
        if (empty($res)) return false;

        //Checks if token is valid
        if ($res->date_expires <= date('Y-m-d H:i:s')) return false;

        return true;
    }

}