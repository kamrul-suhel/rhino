<?php

namespace App\Http\Controllers\Test;

use App\Appointment;
use App\Guest;
use App\Http\Controllers\Controller;
use App\Mail\GuestConfirmed;
use App\Mail\GuestInvitation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TestMailController extends Controller
{
    public function sendMail()
    {
        Mail::send(new GuestInvitation(Guest::find(75)->id, $this->languageId));
        dd('sent');

        Mail::send('email.test', ['user' => 'kamrul'], function ($m) {
            $m->from('hello@app.com', 'Your Application');
            $m->to('ka@ontoast.com')->subject('Your Reminder!');
        });
    }
}
