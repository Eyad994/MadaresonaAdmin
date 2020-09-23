<?php

namespace App\Traits;

trait SMS
{
    public function sms($message, $userMobile, $password)
    {
        $url = 'http://josmsservice.com/sms/api/SendSingleMessage.cfm';
        $massage2 = $message . " " . $password ;
        $fields = array(
            'AccName' => "Madaresona",        // The user name of gateway
            'AccPass' => 'E0!pW7@BiR7', // the password of gateway
            'numbers' => $userMobile, // [962790000000, 962790000000, 962790000000]
            'msg' => $massage2,
            'senderid' => "Madaresona"
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

    public function smsMulti($message, $Mobiles)
    {
        $url = 'http://josmsservice.com/sms/api/SendBulkMessages.cfm';
        $fields = array(
            'AccName' => "Madaresona",        // The user name of gateway
            'AccPass' => 'E0!pW7@BiR7', // the password of gateway
            'numbers' => $Mobiles, //[962790000000, 962790000000, 962790000000]
            'msg' => $message,
            'senderid' => "Madaresona",
            'requesttimeout'=> "5000000"
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