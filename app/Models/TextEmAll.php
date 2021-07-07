<?php

namespace App\Models;

use Dotenv\Regex\Success;
use GuzzleHttp\Psr7\Request;
use Illuminate\Database\Eloquent\Model;
use GuzzleHttp;
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use GuzzleHttp\HandlerStack;


class TextEmAll extends Model
{
    private $client;
    private $status;
    public function __construct(array $attributes = array())
    {
        /******** Checking Status ****/


        $status = getenv('Live_Text_EM_ALL');
        if ($this->status == false)
            $baseURI = 'https://staging-rest.call-em-all.com';
        else
            $baseURI = 'https://rest.call-em-all.com';

        $consumer_key =  getenv('Text_Consumer_Key');
        $oauth_token =  getenv('Text_Oauth_Token');
        $consumer_secret =  getenv('Text_Consumer_Secret');



        // $baseURI = 'https://staging-rest.call-em-all.com';
        // $consumer_key =  '941b33aa-9103-4cd3-8a9a-d30325ab5627';
        // $oauth_token =  'cd3cc89c-1350-4fbe-b0f3-62e300c65e38';
        // $consumer_secret =  '7b6933ec-7b27-444b-ba7d-e0391ea3e46d';

        /****  Setting Authorazation Header ****/
        $stack = HandlerStack::create();
        $middleware = new Oauth1([
            'consumer_key'    => $consumer_key,
            'consumer_secret' => $consumer_secret,
            'token'           => $oauth_token
        ]);
        $stack->push($middleware);
        $this->client = new Client([
            'base_uri' => $baseURI,
            'handler' => $stack,
            'auth' => 'oauth'
        ]);
    }


    /********
     * ************* Create Text ***********************
     * *****************/

    public function createText($order, $restaurant_id)
    {

        $status = getenv('Live_Text_EM_ALL');
        if ($this->status == false) {
            $restaurantNumber[0] = '5148199665';
        } else {
            $restaurantNumber = Restaurant::where('id', $restaurant_id)
                ->pluck('mobile');
        }



        $food_order = $order->foodOrders;
        $extraArray = '';
        $foods_array = '';
        /***** Making a text mesage 
         *          by
         *  getting food orders extras from food orders
         ********/

        foreach ($food_order as $key => $singlefood) {
            if (!$singlefood->extras->isEmpty()) {
                $foodExtras = FoodOrderExtra::where('food_order_id', $singlefood->id)->pluck('quantity');
                foreach ($singlefood->extras as $key => $extrasObj) {
                    $extraArray .= '
Extra Name :' . $extrasObj->name . '
Quantity :' . $foodExtras[$key] . '
';
                }
                $foods_array .= '
food  :' . $singlefood->food[0]->name . '
quantity :' . $singlefood->quantity . '
Extras :' . $extraArray . '
                ';
            } else {
                $foods_array .= '
food :"' . $singlefood->food[0]->name . '
quantity :' . $singlefood->quantity . '
                ';
            }
        }
        $text_message = ' 
New Order Received.
Order No # ' . $order->id . ' from ' . $order->user->name . '
Kindly checkout these details' . $foods_array . '
Thanks Eezly Technologies ';

        $status = $this->createBroadcast($text_message, $restaurantNumber[0]);
        return $status;
    }

    /********
     * ************* Create Broadcast ***********************
     * *****************/
    public function createBroadcast($text_message, $number)
    {
        $response = $this->client->post("v1/broadcasts", [
            GuzzleHttp\RequestOptions::JSON => [
                'BroadcastName' => 'Order Message 4-7-2021',
                'BroadcastType' => 'SMS',
                "TextMessage" => $text_message,
                "Contacts" =>
                [
                    [
                        "PrimaryPhone" =>  $number
                    ]
                ]
            ]
        ]);
        if ($response->getStatusCode() == '200') {
            return 'success';
        } else {
            return json_decode($response->getBody());
        }
    }


    /********
     * ************************************
     * **** *************/



    // public function createConvo()
    // {
    //     $uri = 'v1/conversations';

    //     $response = $this->client->post("v1/conversations", [
    //         GuzzleHttp\RequestOptions::JSON => [
    //             // 'TextPhoneNumber' => '18332450445',
    //             'TextPhoneNumber' => '18334264157',
    //             'PhoneNumber' => '5148199665',
    //             'FirstName' => 'Phil',
    //             'LastName' => 'Dallaire',
    //             "Notes" =>  "Testing Text message from dev Team",
    //             "IntegrationData" =>  ''
    //         ]
    //     ]);
    //     // conversations/single?textphonenumber={{text_phone_number}}&phonenumber={{phone_number}}
    //     // $response = $this->client->get('v1/conversations/single?textphonenumber=18334264157&phonenumber=5148199665');

    //     dd(json_decode($response->getBody()));
    // }

    // /********
    //  * ************************************
    //  * **** *************/
    // public function sendMessage()
    // {
    //     $response = $this->client->post("v1/conversations/17515/textmessages", [
    //         GuzzleHttp\RequestOptions::JSON => [
    //             "Message" => "Hi Phil, this is a testing message from DEV Team via Text-Em-All"
    //         ]
    //     ]);

    //     dd(json_decode($response->getBody()));
    // }

    // /********
    //  * ************************************
    //  * **** *************/
    // public function addContact()
    // {
    //     // $response = $this->client->get('v1/contacts');
    //     // $response = $this->client->get('v1//textnumbers');

    //     $response = $this->client->post("/v1/contacts", [
    //         GuzzleHttp\RequestOptions::JSON => [
    //             "FirstName" =>  "Phil",
    //             "LastName" =>  "Daillaire",
    //             "PrimaryPhone" =>  "5148199665",
    //             "SecondaryPhone" =>  "",
    //             "TertiaryPhone" =>  "",
    //             "Notes" =>  "CEO",
    //         ]
    //     ]);

    //     dd(json_decode($response->getBody()));
    // }

    /***** Making a text mesage by getting food orders extras from food orders
  foreach ($food_order as $key => $singlefood) {
    if (!$singlefood->extras->isEmpty()) {
        $foodExtras = FoodOrderExtra::where('food_order_id', $singlefood->id)->pluck('quantity');
        foreach ($singlefood->extras as $key => $extrasObj) {
            $extraArray[$key] = [
                'name' => $extrasObj->name,
                'quantity' => $foodExtras[$key]
            ];
        }
        $foods_array[$key] = [
            'food' => $singlefood->food[0]->name,
            'quantity' => $singlefood->quantity,
            'Extras'  => $extraArray
        ];
    } else {
        $foods_array[$key] = [
            'food' => $singlefood->food[0]->name,
            'quantity' => $singlefood->quantity
        ];
    }
   
}
     *********************************************/
}
