<?php

namespace App\Models;

use CraigPaul\Moneris\Moneris;
use App\Mail\OrderNotificationEmail;
use Illuminate\Support\Facades\Mail;

use Illuminate\Database\Eloquent\Model;

class MonerisPaymentService extends Model
{

    public function monerisStatus($status = false)
    {
        /***************** Order Payment  ****************/
        /***Card Verification Digits and/or Address Verification Service provided by Moneris
         * CVD & AVS are disabled in this payment method
         ***********************/
        /************** optional Instantiation    ***************/

        if ($status === 'true') {
            $store_id = getenv("Live_MONERIS_STORE_ID");
            $api_token = getenv("Live_MONERIS_API_TOKEN");
            $params = [
                'environment' => Moneris::ENV_LIVE, // default: Moneris::ENV_LIVE
                'cvd' => true,
            ];
            $resp_message = 'Moneris Set to live';

        } else {
            $store_id = getenv("Local_MONERIS_STORE_ID");
            $api_token = getenv("Local_MONERIS_API_TOKEN");
            $params = [
                'environment' => Moneris::ENV_TESTING, // default: Moneris::ENV_LIVE
                'cvd' => false,
            ];
            $resp_message = 'Moneris is set to development. grand_total should be 1.00';

        }
//        else {
//            return "Wrong Parameters. Need to send TRUE or False";
//        }


        $gateway = (new Moneris($store_id, $api_token, $params))->connect();
        $gateway = Moneris::create($store_id, $api_token, $params);
        $response = [
            'store_id' => $store_id,
            'api_token' => $api_token,
            'params' => $params,
            'message' => $resp_message,
            'gateway' => $gateway
        ];
        return $response;
    }

    public function sendOrderEmail($isFrench, $order)
    {
//        $toRestaurant = false;
//        //Send email invoice to customer $order->user->email
//        Mail::to($order->user->email)->send(new OrderNotificationEmail($order, $isFrench, $toRestaurant));
//        $toRestaurant = true;
//        //Send email invoice to restaurant $order->foodOrders[0]->food->restaurant->users[0]->email
//        Mail::to('philippe.dallaire4@gmail.com')->send(new OrderNotificationEmail($order, $isFrench, $toRestaurant));

    }


}
