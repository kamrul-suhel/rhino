<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestMailController extends Controller
{
    public function sendMail(){
        Mail::send('email.test', ['user' => 'kamrul'] ,function ($m) {
            $m->from('hello@app.com', 'Your Application');
            $m->to('ka@ontoast.com')->subject('Your Reminder!');
        });
    }
}
