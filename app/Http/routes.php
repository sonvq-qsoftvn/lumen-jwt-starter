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

/*
 * A base restful api function to generate route base on action 
 * Included actions are index, show, store, update, destroy
 */
function baseRestAPI($path, $controller) {
    global $app;

    $app->get($path, $controller . '@index');
    $app->get($path . '/{id}', $controller . '@show');
    $app->post($path, $controller . '@store');
    $app->put($path . '/{id}', $controller . '@update');
    $app->delete($path . '/{id}', $controller . '@destroy');
}



$app->group(['prefix' => 'api/v1'], function () use ($app) {
    
    baseRestAPI('posts', 'App\Http\Controllers\PostController');
    $app->get('posts-new', 'App\Http\Controllers\PostController@newposts'); 
    
    // GET PHP Info from server
    $app->get('/phpinfo', function () use ($app) {
        echo phpinfo();
    });
    
    $app->get('/mail', 'App\Http\Controllers\MailController@send');
    
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