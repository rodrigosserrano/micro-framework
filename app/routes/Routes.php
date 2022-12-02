<?php

namespace App\Routes;

class Routes
{
    //TODO: Middleware
    public static function get()
    {
        return [
            'GET'       => [
                '/' => 'IndexController@index',
                '/user' => 'UserController@show'
            ],
            'POST'      => [
                '/' => 'UserController@getUser',
                '/user/[0-9]+' => 'UserController@index',
                '/user/[0-9]+/[a-z]+' => 'UserController@drunk',
                '/test' => 'TestController@test',
                '/test/[0-9]+' => 'TestController@test',
            ],
            'PUT'       => [],
            'DELETE'    => []
        ];
    }
}