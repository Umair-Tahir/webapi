<?php

namespace App\Http\Controllers\API\DeliveryService;
use App\Models\DeliveryAddress;

use App\Models\EvaDeliveryService;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class EvaAPIController extends Controller
{
    private $client;

//    public function __construct()
//    {
//        $this->client = new Client([
//            // Base URI is used with relative requests
//            'base_uri' => 'http://167.99.183.41:5000',
//            "headers" => [
//                "Authorization" => "muyvhdyohhhanakrzilejspxuxfmnrsfudlbbdwn",
//                'Content-Type'  =>  'application/json'
//            ],
//            'exceptions' => false,
//        ]);
//    }

    public function serviceAvailability($addressID) {

        $deliveryAddress = DeliveryAddress::find($addressID);


        if($deliveryAddress){
//            $foo = new EvaDeliveryService();
//            $response = $foo->serviceAvailability($deliveryAddress);

            //$response = EvaDeliveryService serviceAvailability($deliveryAddress);
        }
        else
            return $this->sendError('Restaurant Address not found', 400);

        dd($response);
        return $this->sendResponse($response);



//        $response = $this->client->request('GET', '/is_service_available', [
//            "headers" => [
//                "Authorization" => "muyvhdyohhhanakrzilejspxuxfmnrsfudlbbdwn"
//            ],
//            'query' => [
//            'pickup_latitude' => '45.512867657087085',
//            'pickup_longitude' => '73.40459145153145',
//            'ride_service_id'  => 2
//        ]
//        ]);

        try {
            $response = $this->client->request('GET', '/is_service_available', [
                'query' => [
                    'pickup_latitude' => '45.512867657087085',
                    'pickup_longitude' => '73.40459145153145',
                    'ride_service_id'  => 1
                ]
            ]);
        }catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e->getResponse()->getStatusCode();
        }

        return $response;

        //dd($responseBody);

//        if($response->error)

//        dd($response->getBody());
        //dd(json_decode($response->getBody()));
//is_service_available?pickup_latitude=45.512867657087085&pickup_longitude=-73.40459145153145&ride_service_id=1
//        $headers = [
//            'Authorization' => 'muyvhdyohhhanakrzilejspxuxfmnrsfudlbbdwn',
//            'Connection' => 'keep-alive'
//        ];
//        $response = $this->client->request('GET', $this->client, [
//            'pickup_latitude' => '45.512867657087085',
//            'pickup_longitude' => '73.40459145153145',
//            'ride_service_id'  => 1
//        ]);
        //dd($response);
//       // $response = $client->get('http://httpbin.org/get');
//
//        withToken('token')->post(...);
//
//        $response = Http::get('http://167.99.183.41:5000', [
//            'pickup_latitude' => '45.512867657087085',
//            'pickup_longitude' => '73.40459145153145',
//            'ride_service_id'  => 1
//        ]);

    }
}
