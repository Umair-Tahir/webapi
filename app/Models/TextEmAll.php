<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TextEmAll extends Model
{
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $baseURI = 'https://rest.call-em-all.com/v1';// live

        $baseURI = ' https://staging-rest.call-em-all.com/v1';

        $consumer_key = '941b33aa-9103-4cd3-8a9a-d30325ab5627';
        $oauth_token = 'cd3cc89c-1350-4fbe-b0f3-62e300c65e38';

        $consumer = new \OAuth($this->consumerKey, $this->consumerSecret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);
        $timestamp = time();
        $nonce = md5($timestamp);
        $consumer->setTimestamp($timestamp);
        $consumer->setNonce($nonce);
        $signature = $consumer->generateSignature('POST', $baseURI, $this->parameters);

        $timestamp = time();
        $nonce = md5($timestamp);


        $timestamp = round(microtime(true) * 1000);

        $version = "1.0";
        $signatureMethod = "HMAC-SHA1";

//        oauth_consumer_key="0685bd9184jfhq22",
//  oauth_token="ad180jjd733klru7",
//  oauth_signature_method="HMAC-SHA1",
//  oauth_signature="wOJIO9A2W5mFwDgiDvZbTSMK%2FPY%3D",
//  oauth_timestamp="137131200",
//  oauth_nonce= $nonce,
//  oauth_version="1.0"

        $this->client = new Client([
            'base_uri' => 'https://api.montreal.eva.cab/',
            "headers" => [
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
//                "Authorization": "OAuth oauth_consumer_key= $consumer_key
//                                    "oauth_token= $oauth_token
//                                    "oauth_nonce="4572616e48616d6d65724c61686176"
//                                    "oauth_timestamp= $timestamp
//                                    "oauth_signature_method="HMAC-SHA1"
//                                    oauth_version="1.0
//                                    "oauth_signature="...."",
            ],
            'exceptions' => false,
//            'exceptions' => true,
        ]);


//        $this->api_key = getenv('Tik_Tak_API_TOKEN');
//        $this->live_tiktak = getenv('Live_Tik_Tak');
//        $this->google_api_key = getenv('Google_Maps_Key');
    }
}
