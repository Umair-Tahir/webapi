<?php

namespace App\Http\Controllers\API\DeliveryService;

use App\Models\DeliveryAddress;
use App\Models\EvaDeliveryService;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
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
     **/
    public function serviceAvailability($addressID)
    {
        $deliveryAddress = DeliveryAddress::find($addressID);

        if ($deliveryAddress) {
            $response = $this->eva->serviceAvailability($deliveryAddress);
        } else
            return $this->sendError('Restaurant Address not found', 400);

        $responseBody = json_decode($response->getBody());

        if ($responseBody->availability === true) {
            //get Quote;
//            $restaurant = Restaurant::find($restaurantID);
//            $user = Auth::user();
//            $this->eva->GetQuote($restaurant);
        }

        return $this->sendResponse(json_decode($response->getBody()), '');
    }

    /**
     * Get Quote
     **/
    public function getQuote(Request $request)
    {
        $input = $request->all();

        $restaurant = Restaurant::find($input['restaurantID']);
        $deliveryAddress = DeliveryAddress::find($input['addressID']);

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
        $input = $request->all();

        $restaurant = Restaurant::find($input['restaurantID']);
        $deliveryAddress = DeliveryAddress::find($input['addressID']);
        $user = Auth::user();
        /* Also need order id */

        if ($restaurant && $deliveryAddress && $user) {
            $response = $this->eva->callRide($restaurant, $deliveryAddress, $user);
        } else if (!$restaurant)
            return $this->sendError('Restaurant not found', 400);
        else if (!$user)
            return $this->sendError('No logged in user was found', 400);
        else
            return $this->sendError('Delivery Address not found', 400);


        $responseBody = json_decode($response->getBody());

        if (!$responseBody) {
            return $this->sendError('Quote cannot be calculated due to invalid parameters', $response->getStatusCode());
        }

        /* Saving in table */
        $evaDB = new EvaDeliveryService();
        $evaDB->order_id = $input['order_id'];
        $evaDB->save();

        return $this->sendResponse($responseBody, 'Successful');
    }



}
