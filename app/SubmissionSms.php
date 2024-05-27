<?php
namespace App;

class SubmissionSms
{

    function __construct()
    {
    }

    private $API_KEY = '662f606468e62';
    private $SENDER_ID = "IFCILT";
    // private $ROUTE_NO = 4;
    private $RESPONSE_TYPE = 'json';
    // private $DLT_TE_ID = 1207161770681245489;

    public function sendSMS($mobileNumber, $message, $module)
    {
        // dd($mobileNumber, $message, $module);

        $scheme = "PLI-Bulk Drugs";
        $isError = 0;
        $errorMessage = true;

        if ($module == 'Claim') {
            $message = "Dear Sir/Madam,%0A%0AYour CLAIM for FY - " . $message[0] . " has been submitted.%0A%0A" . $scheme . "%0AIFCI LTD";

            $url = "https://www.mysmsapp.in/api/push.json?apikey=" . $this->API_KEY . "&sender=" . $this->SENDER_ID . "&mobileno=" . $mobileNumber . "&text=" . $message . "";

        } elseif ($module == 'Qrr') {
            //dd($mobileNumber, $message, $module);

            $message = "Dear Sir/Madam,%0A%0AYour QRR " . $message[0] . " for " . $message[1] . " has been submitted.%0A%0A" . $scheme . "%0AIFCI LTD";

            $url = "https://www.mysmsapp.in/api/push.json?apikey=" . $this->API_KEY . "&sender=" . $this->SENDER_ID . "&mobileno=" . $mobileNumber . "&text=" . $message . "";

        } elseif ($module == 'App') {

            $message = "Dear Sir/Madam,%0A%0AYour Application " . $message[0] . " has been submitted.%0A%0A" . $scheme . "%0AIFCI LTD";

            $url = "https://www.mysmsapp.in/api/push.json?apikey=" . $this->API_KEY . "&sender=" . $this->SENDER_ID . "&mobileno=" . $mobileNumber . "&text=" . $message . "";

        } elseif ($module == 'Correspondance') {

            $message = "Dear Sir/Madam,%0A%0AA query, has been raised. Please check your correspondence module.%0A%0A" . $scheme . "%0AIFCI LTD";

            $url = "https://www.mysmsapp.in/api/push.json?apikey=" . $this->API_KEY . "&sender=" . $this->SENDER_ID . "&mobileno=" . $mobileNumber . "&text=" . $message . "";
        }


        $ch = curl_init();
        curl_setopt_array(
            $ch,
            array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
            )
        );


        $output = curl_exec($ch);

        // Print error if any
        if (curl_errno($ch)) {
            $isError = true;
            $errorMessage = curl_error($ch);
        }
        curl_close($ch);
        if ($isError) {
            return array('error' => 1, 'message' => $errorMessage);
        } else {
            return array('error' => 0, 'message' => $output);
        }

    }
}
