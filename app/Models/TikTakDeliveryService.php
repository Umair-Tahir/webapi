<?php

namespace App\Models;

use GuzzleHttp;
use GuzzleHttp\Client;

use Illuminate\Database\Eloquent\Model;

class TikTakDeliveryService extends Model
{
    private $client;
    private $api_key;
    private $google_api_key;
    private $live_tiktak;


    public $table = 'ds_tiktak';


    public $fillable = [
        'order_id',
        'job_id',
        'delivery_job_id',
        'job_token',
        'total'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */

    protected $casts = [
        'job_id' => 'string',
        'delivery_job_id' => 'string',
        'order_id' => 'integer',
        'total' => 'integer',
        'job_token' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'order_id' => 'required'
    ];


    /************  Setting Client URL
     * &
     * other Necessary parameters  **********/
    public function __construct(array $attributes = array())
    {
        parent::__construct($attributes);

        $this->client = new Client([
            "headers" => [
                'Content-Type' => 'application/json'
            ],
            'exceptions' => false,
//            'exceptions' => true,
        ]);


        $this->api_key = getenv('Tik_Tak_API_TOKEN');
        $this->live_tiktak = getenv('Live_Tik_Tak');
        $this->google_api_key = getenv('Google_Maps_Key');
    }


    /********* Checking for Fare ****************************
     * By Tik Tak
     ********************************************************/
    public function fareEstimate($deliverAddress, $restaurant)
    {

        $description = " Fare estimate Request By Ezzly";
        $parameters = [
            "template_name" => "Order_Details",
            "pickup_longitude" => $deliverAddress['longitude'],
            "pickup_latitude" => $deliverAddress['latitude'],
            "api_key" => $this->api_key,
            "delivery_latitude" => $restaurant['latitude'],
            "delivery_longitude" => $restaurant['longitude'],
            "formula_type" => 3,
            "map_keys" => [
                "map_plan_type" => 1,
                "google_api_key" => $this->google_api_key
            ]];


        try {
            $response = $this->client->post("https://api.tookanapp.com/v2/get_fare_estimate", [
                GuzzleHttp\RequestOptions::JSON => $parameters,
            ]);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e->getResponse()->getStatusCode();
        }
        return $response;

    }


    /***************************** This is the  ****************************
     *           Call Ride function for Tik Tak
     *********************************************************/

    public function tiktakTask($orderId, $restaurant, $deliveryAddress, $user)
    {
        if ($this->live_tiktak == 'false')
            $description = "Testing Pick Up and Delivery Request By Ezzly";
        else
            $description = "Live Pick Up and Delivery Request By Ezzly";

        $parameters = [
            "api_key" => $this->api_key,
            "order_id" => $orderId,
            "team_id" => "",
            "auto_assignment" => "0",

            "job_description" => $description,
            "job_pickup_phone" => $restaurant['phone'],
            "job_pickup_name" => $restaurant['name'],
            "job_pickup_email" => "",
            "job_pickup_address" => $restaurant['address'],
            "job_pickup_latitude" => $restaurant['latitude'],
            "job_pickup_longitude" => $restaurant['longitude'],
            "job_pickup_datetime" => date("Y-m-d"),

            "customer_email" => '',
            "customer_username" => $user['name'],
            "customer_phone" => $user['phone_number'],
            "customer_address" => $deliveryAddress['address'],
            "latitude" => $deliveryAddress['latitude'],
            "longitude" => $deliveryAddress['longitude'],
            "job_delivery_datetime" => date("Y-m-d"),

            "has_pickup" => "1",
            "has_delivery" => "1",
            "layout_type" => "0",
            "tracking_link" => 1,
            "timezone" => "-4",
            "custom_field_template" => "",
            "meta_data" => [],

            "pickup_custom_field_template" => "",
            "pickup_meta_data" => [],
            "fleet_id" => '',
            "p_ref_images" => [],
            "ref_images" => [],
            "notify" => 0,
            "tags" => "",
            "geofence" => 1,
            "ride_type" => 0,

        ];

        try {
            $response = $this->client->post('https://api.tookanapp.com/v2/create_task', [
                GuzzleHttp\RequestOptions::JSON => $parameters
            ]);

        } catch (\GuzzleHttp\Exception\ClientException $e) {
            return $e->getResponse()->getStatusCode();
        }
        return $response;

    }

    /***************************** This is to  ****************************
     *           save order data into Tik Tak table
     *********************************************************/

    public function createTikTakFromOrder($data)
    {

        $tiktak = new TikTakDeliveryService();

        $tiktak->order_id = $data['order_id'];
        $tiktak->restaurant_id = $data['restaurant_id'];
        $tiktak->distance = $data['distance'];
        $tiktak->total = $data['total'];
        $response = $tiktak->save();

        return $response;
    }

    /*One to One relationship with Order */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

}