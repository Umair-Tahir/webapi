<?php


namespace App\Models;

use Illuminate\Http\Request;
use GuzzleHttp;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;

class EvaDeliveryService extends Model
{
    private $client;

    public $table = 'ds_eva';


    public $fillable = [
        'order_id',
        'service_type_id',
        'tip_token_charge'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'service_type_id' => 'integer',
        'tip_token_charge' => 'integer',
        'order_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'order_id' => 'required'
    ];



    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        //Setting Client URL and other Necessary parameters
        $this->client = new Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://167.99.183.41:5000',
            "headers" => [
                "Authorization" => "muyvhdyohhhanakrzilejspxuxfmnrsfudlbbdwn",
                'Content-Type' => 'application/json'
            ],
            'exceptions' => false,
        ]);
    }

    /**
     * Eva Service Available function
     **/
    public function serviceAvailability($deliveryAddress)
    {
        try {
            $response = $this->client->request('GET', '/is_service_available', [
                'query' => [
                    'pickup_latitude' => $deliveryAddress['latitude'],
                    'pickup_longitude' => $deliveryAddress['longitude'],
                    'ride_service_id' => 1
                ]
            ]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e->getResponse()->getStatusCode();
        }
        return $response;
    }

    /**
     * Eva Get Quote Function
     **/
    public function getQuote($restaurant, $deliveryAddress)
    {
        try {
            $response = $this->client->post("/get_quote", [
                GuzzleHttp\RequestOptions::JSON => [
                    'from_latitude' => $restaurant['latitude'],
                    'from_longitude' => $restaurant['longitude'],
                    'to_latitude' => $deliveryAddress['latitude'],
                    'to_longitude' => $deliveryAddress['longitude'],
                    'ride_service_type_id' => 1,
                ]]);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e->getResponse()->getStatusCode();
        }
        return $response;
    }

    public function callRide($restaurant, $deliveryAddress, $user)
    {
        try {
            $response = $this->client->post("/call_ride", [
                GuzzleHttp\RequestOptions::JSON => [
                    'from_latitude' => $restaurant['latitude'],
                    'from_longitude' => $restaurant['longitude'],
                    'to_latitude' => $deliveryAddress['latitude'],
                    'to_longitude' => $deliveryAddress['longitude'],
                    "from_address" => $restaurant['address'],
                    "to_address" => $deliveryAddress['address'],
                    "customer_first_name" => $user['name'],
                    "customer_last_name" => '',
                    "customer_phone" => $user['phone_number'],
                    "customer_email" => $user['email'],
                    'ride_service_type_id' => 1,
                    "tip_token_charge" => 0
                ]]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e->getResponse()->getStatusCode();
        }
        return $response;
    }

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}

//"to_latitude":45.4867,
//"to_longitude":-73.5749,
//"from_latitude":45.551676666666665,
//"from_longitude":-73.75928833333334,
//"from_address":"1695 Boulevard Curé-Labelle",
//"to_address":"2005, Boulevard Dagenais Ouest",

//"customer_first_name": "Raphaelz",
//"customer_last_name": "Godosa",
//"customer_phone": 14185405081,
//"customer_email": "raphael.gaudreault@eva.coop",
//"ride_service_id": 1,
//"tip_token_charge": 200

//[
//    GuzzleHttp\RequestOptions::JSON => [
//         'from_latitude' => $restaurant['latitude'],
//'from_longitude' => $restaurant['longitude'],
//                'to_latitude' => $deliveryAddress['latitude'],
//                'to_longitude' => $deliveryAddress['longitude'],
//                "from_address" => $restaurant['address'],
//                "to_address" => $deliveryAddress['address'],
//                "customer_first_name" => $user['name'],
//                "customer_last_name" => '',
//                "customer_phone" => $user['phone_number'],
//                "customer_email" => $user['email'],
//                'ride_service_type_id' => 1,
//                "tip_token_charge" => 20
//    ]]