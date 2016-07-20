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
    
    // GET PHP Info from server
    $app->get('/phpinfo', function () use ($app) {
        echo phpinfo();
    });

    $app->get('/videos', ['as' => 'videos_index', 'uses' => 'App\Http\Controllers\VideoController@index']);
    $app->get('/videos/{id}', ['as' => 'videos_show', 'uses' => 'App\Http\Controllers\VideoController@show']);
    $app->post('/videos', ['as' => 'videos_store', 'uses' => 'App\Http\Controllers\VideoController@store']);
    $app->put('/videos/{id}', ['as' => 'videos_update', 'uses' => 'App\Http\Controllers\VideoController@update']);
    $app->delete('/videos/{id}', ['as' => 'videos_destroy', 'uses' => 'App\Http\Controllers\VideoController@destroy']);
    $app->delete('/videos', ['as' => 'videos_delete', 'uses' => 'App\Http\Controllers\VideoController@delete']);
    
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