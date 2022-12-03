<?php

namespace App\Routes;

class Routes
{
    //TODO: Middleware
    public static function get()
    {
        return [
            'GET'       => [
                '/users/[0-9]+'         => 'UserController@find',
                '/users'                => 'UserController@findAll'
            ],
            'POST'      => [
                '/users'                => 'UserController@register',
                '/login'                => 'AuthController@login',
                '/users/[0-9]+/drink'   => 'UserController@drink'
            ],
            'PUT'       => [
                '/users/[0-9]+'         => 'UserController@update'
            ],
            'DELETE'    => [
                '/users/[0-9]+'         => 'UserController@delete'
            ]
        ];
    }
}