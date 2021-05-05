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
        'tip_token_charge',
        'tracking_id',
        'business_tracking_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'service_type_id' => 'integer',
        'tip_token_charge' => 'integer',
        'order_id' => 'integer',
        'tracking_id'=> 'string',
        'business_tracking_id'=> 'string'
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
//            'base_uri' => 'http://167.99.183.41:5000',
            'base_uri' => 'https://api.montreal.eva.cab/',

            "headers" => [
//                "Authorization" => "muyvhdyohhhanakrzilejspxuxfmnrsfudlbbdwn", //Local
                "Authorization" => 'ymbabljvgbxtlpgrughwawginziswxmlvxwuwhsd',
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


    /**
     * Eva Call Ride Function
     **/

    public function callRide($order_id, $restaurant, $deliveryAddress, $user, $tip)
    {
        try {
            $response = $this->client->post("/call_ride", [
                GuzzleHttp\RequestOptions::JSON => [
                    'order_number' => "O-".$order_id,
                    'from_latitude' => $restaurant['latitude'],
                    'from_longitude' => $restaurant['longitude'],
                    'to_latitude' => $deliveryAddress['latitude'],
                    "pick_up_company_name" => $restaurant['name'],
                    'to_longitude' => $deliveryAddress['longitude'],
                    "from_address" => $restaurant['address'],
                    "customer_last_name" => $user['name'],
                    "pickup_phone" => preg_replace( '/[^0-9]/', '', $restaurant['phone'] ),
                    "to_address" => $deliveryAddress['address'],
                    "customer_first_name" => $user['name'],
                    "customer_phone" => $user['phone_number'],
                    "customer_email" => $user['email'],
                    'ride_service_type_id' => 1,
                    "tip_token_amount" => $tip * 100
                ]]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e->getResponse()->getStatusCode();
        }
        return $response;
    }

    /**
     * Save Parameters after payment is made
     *But restaurant haven't called rider to pick food up
     **/
    public function createEvaFromOrder($data)
    {

        $evaDB = new EvaDeliveryService();

        $evaDB->order_id = $data['order_id'];
        $evaDB->restaurant_id = $data['restaurant_id'];
        $evaDB->distance = $data['distance'];
        $evaDB->total_charges_plus_tax = $data['total_charges_plus_tax'];
        $evaDB->delivery_tax = $data['delivery_tax'];
        $evaDB->tip_token_charge = $data['tip_token_charge'];
        $response = $evaDB->save();

        return $response;
    }

    /*One to One relationship with Order */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
