<?php

namespace App\Http\Controllers\API\DeliveryService;

use App\Models\TikTakDeliveryService;
Use App\Models\Order;
use App\Models\User;
use App\Models\Restaurant;
use App\Models\DeliveryAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TikTakApiController extends Controller
{

    public function __construct()
    {
        $this->tiktak = new TikTakDeliveryService();
    }


    /************************************************************
     * This is to get Fare estimate
     * before a request is made to TIK TAK
     **************************************************************/
    public function getFareEstimate(Request $request)
    {
        $input = $request->all();

        $restaurant = Restaurant::find($input['restaurantId']);
        $deliveryAddress = DeliveryAddress::find($input['addressId']);

        /********* Calling Modal Function For fare Estimate **************/
        if ($restaurant && $deliveryAddress) {
            $response = $this->tiktak->fareEstimate($deliveryAddress, $restaurant);
        } else if (!$restaurant)
            return $this->sendError('Restaurant not found', 400);
        else
            return $this->sendError('Delivery Address not found', 400);

        $responseBody = json_decode($response->getBody());


//        dd($formula_fields);
//        'distance' => (float) number_format(($responseBody->data->distance/1000), 2), to convert to km
//        'time' => ($responseBody->data->distance/60)/60, // Time is in seconds

        if ($responseBody->status == 200) {
            $formula_fields = ((array)$responseBody->data->formula_fields)[2];
            $data = [
                'distance' => $responseBody->data->distance,
                'time' => $responseBody->data->distance, // Time is in seconds
                $formula_fields[0]->key => [
                    'multiplying_value' => $formula_fields[0]->multiplying_value,
                    'surge' => $formula_fields[0]->surge,
                    'expression' => $formula_fields[0]->expression,
                    'sum' => $formula_fields[0]->sum
                ],
                $formula_fields[1]->key => [
                    'start_value' => $formula_fields[1]->start_value,
                    'multiplying_value' => $formula_fields[1]->multiplying_value,
                    'surge' => $formula_fields[1]->surge,
                    'expression' => $formula_fields[1]->expression,
                    'sum' => $formula_fields[1]->sum
                ],
                $formula_fields[2]->key => [
                    'start_value' => $formula_fields[2]->start_value,
                    'multiplying_value' => $formula_fields[2]->multiplying_value,
                    'surge' => $formula_fields[2]->surge,
                    'expression' => $formula_fields[2]->expression,
                    'sum' => $formula_fields[2]->sum
                ],
                $formula_fields[3]->key => [
                    'multiplying_value' => $formula_fields[3]->multiplying_value,
                    'surge' => $formula_fields[3]->surge,
                    'expression' => $formula_fields[3]->expression,
                    'sum' => $formula_fields[3]->sum
                ],
                $formula_fields[4]->key => [
                    'multiplying_value' => $formula_fields[4]->multiplying_value,
                    'expression' => $formula_fields[4]->expression,
                    'sum' => $formula_fields[4]->sum
                ],
                'total' => ((array)$responseBody->data->total_fields)[2]
            ];
        } else {
            return $this->sendError($responseBody, 400);
        }

        return $this->sendResponse($data, 'success');

    }

    /************************************************************
     * This is a sample function
     * It's main use is to check task creation and response
     **************************************************************/
    public function tiktakCreateTask(Request $request)
    {
        $input = $request->all();

        $validated = $request->validate([
            'restaurantId' => 'required',
            'addressId' => 'required',
            "order_id" => 'required',
        ]);


        $restaurant = Restaurant::find($input['restaurantId']);
        $deliveryAddress = DeliveryAddress::find($input['addressId']);
        $user = Auth::user();

        if ($user) {
            $response = $this->tiktak->tiktakTask($input['order_id'], $restaurant, $deliveryAddress, $user);
        } else
            return $this->sendError('No logged in user was found', 400);


        $responseBody = json_decode($response->getBody());
        dd($responseBody);

        if ($responseBody->status == 200) {

            return $this->sendResponse($responseBody, 'Successful');


        } else {
            return $this->sendError($responseBody, 400);
        }


    }

    /************************************************************
     * This is to Call
     * TIK TAK ride by restaurant
     **************************************************************/

    public function restaurantCallRide(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required'
        ]);

        $tiktakDs = TikTakDeliveryService::where('order_id', $request['order_id'])->first();//find($request['orderId'], 'order_id');


        if ($tiktakDs) {
            $order = Order::find($tiktakDs->order_id);
            $restaurant = Restaurant::find($tiktakDs->restaurant_id);

            if (!$order)
                return $this->sendError('Order Not Found', 404);

            $deliveryAddress = DeliveryAddress::find($order->delivery_address_id);
            $user = User::find($order->user_id);

            $response = $this->tiktak->tiktakTask($order->id, $restaurant, $deliveryAddress, $user);

            $responseBody = json_decode($response->getBody());


            if ($responseBody->status == 200) {

                /************ Store Tracking ID ****************/
                $tiktakDs->job_id = $responseBody->data->job_id;
                $tiktakDs->delivery_job_id = $responseBody->data->delivery_job_id;
                $tiktakDs->job_token = $responseBody->data->job_token;

                $tiktakDs->save();

                return $this->sendResponse($responseBody, 'Call Ride Successful');

            } else {
                return $this->sendError($responseBody, 400);
            }
        } else
            return $this->sendError('TikTak record Not Found', 404);

    }
}
