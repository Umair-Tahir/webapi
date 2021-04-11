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
                'Content-Type'  =>  'application/json'
            ],
            'exceptions' => false,
        ]);
    }

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


    public function GetQuote($userID, $restaurantID) {

    }
}
