<?php

namespace App\Http\Controllers;

use App\Mail\MailtrapExample;
use App\Mail\MultipleEmails;
use App\Models\SubscribesEmail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class SenderController extends Controller
{
    public function email()
    {
        return view('madaresona.sender.email');
    }

    public function sendEmail(Request $request)
    {

        $validations = Validator::make($request->all(), [
            'title' => 'required',
            'email_content' => 'required',
        ]);

        if ($validations->fails()) {
            return response()->json(['errors' => $validations->errors(), 'status' => 422]);
        }

        if ($request->option == 2 && $request->emails == null) {
            return response()->json(['message' => 'Please Select Email', 'status' => 4222]);
        }

        if ($request->option == 1) {
            $emails=SubscribesEmail::get()->pluck('email')->toArray();
                $emails=implode(',',$emails);
        }elseif ($request->option == 2)
        {
            $emails= $request->emails;
        }

        Mail::to($emails)->send(new MultipleEmails($request->title, $request->subjcet));

        return response()->json(['message' => 'Send successfully', 'status' => 200]);

    }

    public function sms()
    {
        return view('madaresona.sender.sms');
    }

    public function sendSMS(Request $request)
    {

    }
}
