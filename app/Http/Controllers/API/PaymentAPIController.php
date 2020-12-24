<?php

namespace App\Http\Controllers\API;

use App\Models\Payment;
use App\Repositories\PaymentRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;

use CraigPaul\Moneris\Moneris;

class PaymentAPIController extends Controller
{
    public function __construct(PaymentRepository $paymentRepo)
    {
        $this->paymentRepository = $paymentRepo;
    }


    public function create_payment(Request $request)
    {
        dd($request);
        $input = $request->all();

        /**************************** Request Variables ********
        Card Verification Digits and/or Address Verification Service provided by Moneris
        CVD & AVS are disabled in this payment method
         ***********************/
        $store_id  = $input['store_id'];
        $api_token = $input['token'];

        /************** optional Instantiation    ***************/
        $params = [
            'environment' => Moneris::ENV_TESTING, // default: Moneris::ENV_LIVE
        ];
        $gateway = (new Moneris($store_id, $api_token, $params))->connect();
        $gateway = Moneris::create($store_id, $api_token, $params);
        // dd($gateway);

        /**************** Purchase ****************/
        $params = [
            'order_id' => uniqid('1234-56789', true),
            'amount' => '1.00',
            'credit_card' => '4242424242424242',
            'expiry_month' => '12',
            'expiry_year' => '20',
        ];

        $response = $gateway->purchase($params);

        if($response->errors){
            $errors = $response->errors;
            return $this->sendError($errors);
        }
        else{
            $receipt = $response->receipt();
            return $this->sendResponse($receipt , 'Payment Successfully');
        }

        //Calling Order Function to save order
        $request['payment_id'] = $params['order_id'];
        $request['order_status_id'] = '2';
        $order_response = $this->store_order($request);
    }
}



//Payment which has to be later staged inside above code to work fearlessly

/*******************  Pre-Authorization  * *******************/
//$params = [
//    'order_id' => uniqid('1234-56789', true),
//    'amount' => $input['amount'],
//    'credit_card' => $input['credit_card'],
//    'expiry_month' => $input['expiry_month'],
//    'expiry_year' => $input['expiry_year'],
////            'avs_street_number' => '123',
////            'avs_street_name' => 'lakeshore blvd',
////            'avs_zipcode' => '90210',
////            'cvd' => '111',
//    'payment_indicator' => $input['payment_indicator'],
//    'payment_information' => $input['payment_information'],
//];
//
//$response = $gateway->preauth($params);
//
///****************** Capture (Pre-Authorization Completion) ******************/
//$params = [
//    'order_id' => uniqid('1234-56789', true),
//    'amount' => $input['amount'],
//    'credit_card' => $input['credit_card'],
//    'expiry_month' => $input['expiry_month'],
//    'expiry_year' => $input['expiry_year'],
////            'avs_street_number' => '123',
////            'avs_street_name' => 'lakeshore blvd',
////            'avs_zipcode' => '90210',
////            'cvd' => '111',
//    'payment_indicator' => $input['payment_indicator'],
//    'payment_information' => $input['payment_information'],
//];
//
//$response = $gateway->preauth($params);
//
//$response = $gateway->capture($response->transaction);

