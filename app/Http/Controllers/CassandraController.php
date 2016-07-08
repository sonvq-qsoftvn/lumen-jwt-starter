<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Cassandra;
use Cassandra\Request\Request;

class CassandraController extends Controller {

   
    public function index() { 
//        $articles = Article::all();
//        foreach ($articles as $singleArticle) {
//            $singleArticle->delete();
//        }
//        return response()->json('success');
        $nodes = [
//            '127.0.0.1', // simple way, hostname only
//            '192.168.0.2:9042', // simple way, hostname with port 
//            [               // advanced way, array including username, password and socket options
//                'host' => '10.205.48.70',
//                'port' => 9042, //default 9042
//                'username' => 'admin',
//                'password' => 'pass',
//                'socket' => [SO_RCVTIMEO => ["sec" => 10, "usec" => 0], //socket transport only
//                ],
//            ],
//            [               // advanced way, using Connection\Stream, persistent connection
//                'host' => '10.205.48.70',
//                'port' => 9042,
//                'username' => 'admin',
//                'password' => 'pass',
//                'class' => 'Cassandra\Connection\Stream', //use stream instead of socket, default socket. Stream may not work in some environment
//                'connectTimeout' => 10, // connection timeout, default 5,  stream transport only
//                'timeout' => 30, // write/recv timeout, default 30, stream transport only
//                'persistent' => true, // use persistent PHP connection, default false,  stream transport only  
//            ],
            [               // advanced way, using SSL
                'class' => 'Cassandra\Connection\Stream', // "class" must be defined as "Cassandra\Connection\Stream" for ssl or tls
                'host' => '172.16.10.51', // or 'tls://10.205.48.70'
                'port' => 9042,
//                'username' => 'cassandra',
//                'password' => 'cassandra',
            ],
        ];

        // Create a connection.
        $connection = new Cassandra\Connection($nodes, 'mykeyspace');

        //Connect
        try {
            $connection->connect();
        } catch (Cassandra\Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
            exit; //if connect failed it may be good idea not to continue
        }


        // Set consistency level for farther requests (default is CONSISTENCY_ONE)
        $connection->setConsistency(Request::CONSISTENCY_QUORUM);

        // Run query synchronously.
        try {
            
            $response = $connection->querySync('SELECT * FROM "users"');
            $value = $response->fetchOne(); 
            var_dump($response);die;
            return $response;
        } catch (Cassandra\Exception $e) {
            echo ($e);
            return;
        }
    }

}
