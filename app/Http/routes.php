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

$app->get('/phpinfo', function () use ($app) {
    echo phpinfo();
});

$app->get('/cassandra-connect', function () use ($app) {
    $cluster   = Cassandra::cluster()                 // connects to localhost by default
                ->withContactPoints('172.16.10.51')
                ->withCredentials("cassandra", "cassandra")
                ->withPort(9042)
                ->build();
    $keyspace  = 'mykeyspace';
    $session   = $cluster->connect($keyspace);        // create session, optionally scoped to a keyspace
    $statement = new Cassandra\SimpleStatement(       // also supports prepared and batch statements
        'SELECT * from users'
    );
    $future    = $session->executeAsync($statement);  // fully asynchronous and easy parallel execution
    $result    = $future->get();                      // wait for the result, with an optional timeout

    foreach ($result as $row) {                       // results and rows implement Iterator, Countable and ArrayAccess
        echo '<pre>';
        var_dump($row);
    }
});

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