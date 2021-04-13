<?php

namespace App\Models;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class EvaDeliveryService extends Model
{

    private $client;

    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        //Setting Client URL and other Necessary parameters
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://167.99.183.41:5000',
            "headers" => [
                "Authorization" => "muyvhdyohhhanakrzilejspxuxfmnrsfudlbbdwn",
                'Content-Type'  =>  'application/json',
                'Accept-Encoding' => 'gzip, deflate, br'
            ],
            'exceptions' => false,
        ]);
    }

    /**
        Eva Service Available function
     **/
    public function serviceAvailability($deliveryAddress) {
        try {
            $response = $this->client->request('GET', '/is_service_available', [
                'query' => [
                    'pickup_latitude' => $deliveryAddress['latitude'],
                    'pickup_longitude' => $deliveryAddress['longitude'],
                    'ride_service_id'  => 1
                ]
            ]);
        }catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e->getResponse()->getStatusCode();
        }
        return $response;
    }

    /**
        Eva Get Quote Function
     **/
    public function getQuote($restaurant, $deliveryAddress) {

        try {

//            $response = Http::get('http://167.99.183.41:5000/get_quote', [
//                "Authorization" => "muyvhdyohhhanakrzilejspxuxfmnrsfudlbbdwn",
//                'body' => [
//                    'from_latitude' => '45.551676666666665',
//                    'from_longitude' => '73.75928833333334',
//                    'to_latitude' => '45.600853',
//                    'to_longitude' => '7631213',
//                    'ride_service_id'  => 1,
//                ]
//        ]);
//            dd($response);


//            $response = $this->client->post('http://167.99.183.41:5000/get_quote', [
//                'form_params' => [
//                    'from_latitude' => '45.551676666666665',
//                    'from_longitude' => '73.75928833333334',
//                    'to_latitude' => '45.600853',
//                    'to_longitude' => '7631213',
//                    'ride_service_id'  => 1,
//                ]
//            ]);
            $response = $this->client->request('POST', '/get_quote', [
                'params' => [
                    'from_latitude' => '45.551676666666665',
                    'from_longitude' => '73.75928833333334',
                    'to_latitude' => '45.600853',
                    'to_longitude' => '7631213',
                    'ride_service_id'  => 1,
                ]
            ]);
        }catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e->getResponse()->getStatusCode();
        }
        dd(json_decode($response->getBody()));
        return $response;
    }
}
//
//'form_params' => [
//    'from_latitude' => $restaurant['latitude'],
//    'from_longitude' => $restaurant['longitude'],
//    'to_latitude' => $deliveryAddress['latitude'],
//    'to_longitude' => $deliveryAddress['longitude'],
//    'ride_service_id'  => 1,
//]