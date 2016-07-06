<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$app->group(['prefix' => 'api/v1'], function () use ($app) {
    $app->post('/auth/login', 'App\Http\Controllers\Auth\AuthController@postLogin');    


    $app->group(['middleware' => 'jwt.auth', 'prefix' => 'api/v1/'], function ($app) {
        $app->get('/version', function () use ($app) {
            return [
                'success' => [
                    'app' => $app->version(),
                ],
            ];
        });

        $app->get('/user', function () use ($app) {
            return [
                'success' => [
                    'user' => JWTAuth::parseToken()->authenticate(),
                ],
            ];
        });

        $app->get('/auth/invalidate', 'App\Http\Controllers\Auth\AuthController@getInvalidate');
    });

});