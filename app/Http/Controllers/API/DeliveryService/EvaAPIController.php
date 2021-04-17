<?php

namespace App\Http\Controllers\API\DeliveryService;

use App\Models\DeliveryAddress;
use App\Models\EvaDeliveryService;

use App\Http\Controllers\Controller;
use App\Models\Restaurant;
use Illuminate\Http\Request;

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
        $restaurant = Restaurant::find($request['restaurantID']);
        $deliveryAddress = DeliveryAddress::find($request['addressID']);
        //dd($deliveryAddress);

        if ($restaurant && $deliveryAddress) {
            $response = $this->eva->getQuote($restaurant, $deliveryAddress);
        } else
            return $this->sendError('Restaurant Address not found', 400);

        dd(json_decode($response->getBody()));
        $data = [
            'distance(km)' => $response['distance'],
            'duration(min)' => $response['duration'],
            'total_charges_plus_tax' => ($response['total_charges_plus_tax'] / 100),
            'total_tax' => ($response['total_tax'] / 100)
        ];
        return $this->sendResponse($data, '');
    }

    /**
     * Get Quote
     **/
    public function callRide(Request $request)
    {
        dd('behbhe');
    }

}
