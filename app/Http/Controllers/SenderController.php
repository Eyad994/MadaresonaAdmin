<?php

namespace App\Http\Controllers;

use App\Imports\UsersImport;
use App\Mail\MailtrapExample;
use App\Mail\MultipleEmails;
use App\Models\SubscribesEmail;
use App\Traits\SMS;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class SenderController extends Controller
{
    use SMS;
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
            $emails = SubscribesEmail::get()->pluck('email')->toArray();
            $emails = implode(',', $emails);
        } elseif ($request->option == 2) {
            $emails = $request->emails;
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
        $arrayphone = [];
        $phones = Excel::toCollection(new UsersImport, request()->file('phones'));
        foreach ($phones[0] as $phone) {
            if ($phone[0] != null) {
                array_push($arrayphone, $phone[0]);
            }
        }
        $array_chunk = array_chunk($arrayphone, 100);

        foreach ($array_chunk as  $array_send) {
            $this->smsMulti($request->sms_text , $array_send);
        }
    }
}
