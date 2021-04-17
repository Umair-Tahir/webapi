<?php

namespace App\Repositories;

use GuzzleHttp\Client;
use App\Models\EvaDeliveryService;
use InfyOm\Generator\Common\BaseRepository;

/**
 *
 */
class EvaDeliveryServiceRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return EvaDeliveryService::class;
    }

    private $client;

    public function __construct()
    {

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


}
