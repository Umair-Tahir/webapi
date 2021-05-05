<?php

namespace App\Http\Controllers\API\DeliveryService;

use App\Models\DeliveryAddress;
use App\Models\EvaDeliveryService;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Restaurant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EvaAPIController extends Controller
{
    private $eva;

    public function __construct()
    {
        $this->eva = new EvaDeliveryService();
    }

    /**
     * Check if service is available in user's location
     * if true this function will request quotation from EVA
     * and will return quotation result
     **/

    public function serviceAvailability(Request $request)
    {

        /**** Checking for request parameters ****/
        $restaurant = Restaurant::find($request['restaurantId']);
        $deliveryAddress = DeliveryAddress::find($request['addressId']);

        if ($restaurant && $deliveryAddress) {
            $response = $this->eva->serviceAvailability($deliveryAddress);
        } else if (!$restaurant)
            return $this->sendError('Restaurant not found', 400);
        else
            return $this->sendError('Delivery Address not found', 400);


        $responseBody = json_decode($response->getBody());

        /**** Get Quote ****/
        if ($responseBody->availability == true) {
            $QuoteResponse = $this->eva->getQuote($restaurant, $deliveryAddress);
        } else
            return $this->sendResponse($responseBody, 'Service not available');


        /** Quotation Process  ***/
        $QuoteResponse = json_decode($QuoteResponse->getBody());

        if (!$QuoteResponse) {
            return $this->sendError('Quote cannot be calculated due to invalid parameters', 400);
        }

        /**** Sending Quotation data ****/
        $data = [
            'Service Availability' => $responseBody->availability,
            'distance(km)' => $QuoteResponse->distance,
            'duration(min)' => $QuoteResponse->duration,
            'total_charges_plus_tax' => ($QuoteResponse->total_charges_plus_tax / 100),
            'total_tax' => ($QuoteResponse->total_tax / 100)
        ];

        return $this->sendResponse($data, 'Successful');
    }


    /**
     * Get Quote
     **/
    public function getQuote(Request $request)
    {
        $input = $request->all();

        $restaurant = Restaurant::find($input['restaurantId']);
        $deliveryAddress = DeliveryAddress::find($input['addressId']);

        if ($restaurant && $deliveryAddress) {
            $response = $this->eva->getQuote($restaurant, $deliveryAddress);
        } else if (!$restaurant)
            return $this->sendError('Restaurant not found', 400);
        else
            return $this->sendError('Delivery Address not found', 400);

        /* After Response */
        $responseBody = json_decode($response->getBody());

        if (!$responseBody) {
            return $this->sendError('Quote cannot be calculated due to invalid parameters', 400);
        }

        $data = [
            'distance(km)' => $responseBody->distance,
            'duration(min)' => $responseBody->duration,
            'total_charges_plus_tax' => ($responseBody->total_charges_plus_tax / 100),
            'total_tax' => ($responseBody->total_tax / 100)
        ];
        return $this->sendResponse($data, 'Successful');
    }

    /**
     * Call a Ride
     **/
    public function callRide(Request $request)
    {
        $tip = $request['tip_token_charge'];


        $validated = $request->validate([
            'tip_token_charge' => 'required',
            'restaurantId' => 'required',
            'addressId' => 'required',
            "order_id" => 'required',
            "distance" => 'required',
            "total_charges_plus_tax" => 'required',
            "delivery_tax" => 'required',
        ]);

        $restaurant = Restaurant::find($request['restaurantId']);
        $deliveryAddress = DeliveryAddress::find($request['addressId']);
        $user = Auth::user();
        /* Also need order id */

        if ($user) {
            $response = $this->eva->callRide($request['order_id'], $restaurant, $deliveryAddress, $user, $request['tip_token_charge']);
        } else
            return $this->sendError('No logged in user was found', 400);


        $responseBody = json_decode($response->getBody());
        if (!$responseBody) {
            return $this->sendError('Ride cannot be called as EVA is currently not available', $response->getStatusCode());
        }

        /* Saving in table */
        $evaDB = new EvaDeliveryService();
        $evaDB->order_id = $request['order_id'];
        $evaDB->restaurant_id = $request['restaurantId'];
        $evaDB->distance = $request['distance'];
        $evaDB->total_charges_plus_tax = $request['total_charges_plus_tax'];
        $evaDB->delivery_tax = $request['delivery_tax'];
        $evaDB->tracking_id = $responseBody->tracking_id;
        $evaDB->tip_token_charge = $request['tip_token_charge'];
        $evaDB->service_type_id = 1;

        $evaDB->save();

        return $this->sendResponse($responseBody, 'Successful');
    }


    public function restaurantCallRide(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required'
        ]);

        $evaDs = EvaDeliveryService::where('order_id', $request['order_id'])->first();//find($request['orderId'], 'order_id');

        if ($evaDs) {
            $order = Order::find($evaDs->order_id);
            $restaurant = Restaurant::find($evaDs->restaurant_id);

            if (!$order)
                return $this->sendError('Order Not Found', 404);

            $deliveryAddress = DeliveryAddress::find($order->delivery_address_id);
            $user = User::find($order->user_id);


            $response = $this->eva->callRide($order->id, $restaurant, $deliveryAddress, $user, $evaDs->tip_token_charge);

            $responseBody = json_decode($response->getBody());

            if (!$responseBody) {
                return $this->sendError('Ride cannot be called as EVA is currently not available', $response->getStatusCode());
            }
        } else
            return $this->sendError('EVA record Not Found', 404);

        /************ Store Tracking ID ****************/
        $evaDs->tracking_id = $responseBody->tracking_id;

        if ($responseBody->business_tracking_id)
            $evaDs->business_tracking_id = $responseBody->business_tracking_id;

        $evaDs->save();
        $tracking_link = 'https://business.eva.cab/public/live_tracker?tracking_id='.$responseBody->tracking_id;

        $responseBody->tracking_link = $tracking_link;
        return $this->sendResponse($responseBody, 'Successful');
    }


}



//
//$deliveryAddress = DeliveryAddress::find($addressID);
//
//if ($deliveryAddress) {
//    $response = $this->eva->serviceAvailability($deliveryAddress);
//} else
//    return $this->sendError('Restaurant Address not found', 400);
//
//$responseBody = json_decode($response->getBody());
//
//if ($responseBody->availability === true) {