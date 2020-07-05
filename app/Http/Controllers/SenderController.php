<?php

namespace App\Http\Controllers;

use App\Mail\MailtrapExample;
use App\Mail\MultipleEmails;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class SenderController extends Controller
{
    public function email()
    {
        return view('madaresona.sender.email');
    }

    public function sendEmail(Request $request)
    {
        $schools = User::where('type', 5)->get('email')->toArray();

       // Mail::to('eyadjaabo@gmail.com')->send(new MultipleEmails($request->title, $request->subjcet));
    }

    public function sms()
    {
        return view('madaresona.sender.sms');
    }

    public function sendSMS(Request $request)
    {

    }
}
