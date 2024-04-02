<?php
namespace App;

class SMS
{

    function __construct()
    { }

    private $API_KEY = '151631APfbJg7c590ff74c';
    private $SENDER_ID = "IFCILT";
    private $ROUTE_NO = 4;
    private $RESPONSE_TYPE = 'json';
	private $DLT_TE_ID = 1207161770681245489;

    public function sendSMS($otp, $mobileNumber)
    {
        $isError = 0;
        $errorMessage = true;

        $message = "One Time Passowrd(OTP) for Login: " . $otp. " Do not share this OTP with anyone! IFCI Ltd";


        //Preparing post parameters
        $postData = array(
            'authkey' => $this->API_KEY,
            'sender' => $this->SENDER_ID,
            'route' => $this->ROUTE_NO,
            'response' => $this->RESPONSE_TYPE,
			'DLT_TE_ID' => $this->DLT_TE_ID,
            'mobiles' => $mobileNumber,
            'message' => $message
        );

        $url = "https://api.msg91.com/api/sendhttp.php";

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $postData
        ));


        //Ignore SSL certificate verification
        //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);


        //get response
        $output = curl_exec($ch);

        //Print error if any
        if (curl_errno($ch)) {
            $isError = true;
            $errorMessage = curl_error($ch);
        }
        curl_close($ch);
        if ($isError) {
            return array('error' => 1, 'message' => $errorMessage);
        } else {
            return array('error' => 0,'message' => $output);
        }

    }
}
