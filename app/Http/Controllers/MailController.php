<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Mail as Mail;
use App\Http\Controllers\Controller;

class MailController extends Controller {
    public function send() {
        try {
            Mail::send('emails.welcome', array('name' => 'Son'), function($message)
            {
                $message->from('vuquangson1610@gmail.com');
                $message->to('son.littletigers@gmail.com')->subject('Welcome!');
            });
            return response()->json(array('success' => true), 200);  
        } catch (Exception $e) {
            echo $e->getMessage();
        }
    }

}
