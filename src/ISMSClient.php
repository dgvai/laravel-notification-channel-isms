<?php 
namespace DGvai\ISMS;

class ISMSClient 
{
    protected $API_TOKEN;
    protected $SID;

    const DOMAIN = "https://smsplus.sslwireless.com";
    const ENDPOINT_SINGLE = "/api/v3/send-sms";

    public function __construct($token, $sid)
    {
        $this->API_TOKEN = $token;
        $this->SID = $sid;
    }

    private function callToApi($url, $params)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($params),
            'accept:application/json'
        ));

        $response = curl_exec($ch);
        curl_close($ch);
        return $response;
    }

    protected function sendSMS($msisdn, $messageBody)
    {
        $params = [
            "api_token" => $this->API_TOKEN,
            "sid" => $this->SID,
            "msisdn" => $msisdn,
            "sms" => $messageBody,
            "csms_id" => mt_rand(100000,999999)+mt_rand(100,999)
        ];
        $url = trim(static::DOMAIN, '/').static::ENDPOINT_SINGLE;
        $params = json_encode($params);

        return json_decode($this->callToApi($url, $params));
    }

}