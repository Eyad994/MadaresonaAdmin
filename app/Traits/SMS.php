<?php

namespace App\Traits;

trait SMS
{
    public function sms($message,$userMobile)
    {
        $url = '';

        $fields = array(
            'AccName' => "",		// The user name of gateway
            'AccPass' => '', // the password of gateway
            'numbers' => $userMobile, // [962790000000, 962790000000, 962790000000]
            'msg' => $message,
            'senderid' => ""
        );

        //open connection
        $ch = curl_init();

        //set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //execute post
        $result = curl_exec($ch);
        //close connection
        curl_close($ch);
    }
}