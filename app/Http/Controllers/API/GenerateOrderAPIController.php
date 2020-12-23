<?php

namespace App\Http\Controllers\API;



use App\Http\Middleware\App;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Events\OrderChangedEvent;
use App\Models\Order;
use App\Notifications\NewOrder;
use App\Notifications\StatusChangedOrder;
use App\Repositories\CartRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\FoodOrderRepository;
use App\Repositories\UserRepository;

use Flash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;
use Stripe\Token;
use Illuminate\Support\Facades\Validator;
use CraigPaul\Moneris\Moneris;

class GenerateOrderAPIController extends Controller
{
    /** @var  OrderRepository */
    private $orderRepository;
    /** @var  FoodOrderRepository */
    private $foodOrderRepository;
    /** @var  CartRepository */
    private $cartRepository;
    /** @var  UserRepository */
    private $userRepository;
    /** @var  PaymentRepository */
    private $paymentRepository;
    /* @var  NotificationRepository  */
    private $notificationRepository;

    public function __construct(OrderRepository $orderRepo, FoodOrderRepository $foodOrderRepository, CartRepository $cartRepo, PaymentRepository $paymentRepo, NotificationRepository $notificationRepo, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepo;
        $this->foodOrderRepository = $foodOrderRepository;
        $this->cartRepository = $cartRepo;
        $this->userRepository = $userRepository;
        $this->paymentRepository = $paymentRepo;
        $this->notificationRepository = $notificationRepo;
    }

    /**
     * Create new Order after receiving parameters from app
     */
    public function store_order (Request $request){
        $input = $request->all();
        $amount = 0;  //defining variable

        /* ----Validating Request ---*/
        $rules=[
            "user_id"=> 'required',
            "delivery_address_id" => 'required',
            "delivery_fee" => 'required',
            "driver_id" => 'required',
            'is_french' => 'required',
            'tax' => 'required',
            'expected_delivery_time' => 'required',
            'vendor_shared_price' => 'required',
            'eezly_shared_price' => 'required',
            'grand_total' => 'required'
        ];
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {                                      //pass validator errors as errors object for ajax response
            return response()->json(['errors'=>$validator->errors()]);
        } else {                                                        //On passing Validation find user
                try {
                    $user = $this->userRepository->findWithoutFail($input['user_id']);
                    if (empty($user)) {
                        return $this->sendError('User was not found');
                    }
                    else { //id user found
                       $payment_response = $this->create_payment($request);

                        if($payment_response->successful){
                              $payment_receipt =  $payment_response->receipt();
                              $payment_id = $payment_receipt->read('id');


                            $order = $this->orderRepository->create([
                                'user_id' => $input['user_id'],
                                "delivery_address_id" => $input['delivery_address_id'],
                                "delivery_fee" => $input['delivery_fee'],
                                "driver_id" => $input['driver_id'],
                                'is_french' => $input['is_french'],
                                'hint' => $input['hint'],
                                'order_status_id' => 1,
                                'active' => 1,
                                'tax' => $input['hint'],
                                'expected_delivery_time' => $input['expected_delivery_time'],
                                'vendor_shared_price' => $input['vendor_shared_price'],
                                'eezly_shared_price' => $input['eezly_shared_price'],
                                'grand_total' => $input['grand_total'],
                                'payment_id' => $payment_id
                            ]);
                            dd($order);

                            foreach ($input['foods'] as $foodOrder) {
                                $foodOrder['order_id'] = $order->id;
                                $this->foodOrderRepository->create([$foodOrder]);
                            }
                        }
                        else
                        {
                            $payment_errors = $payment_response->receipt();   //errors
                            dd($payment_errors);
                            return $this->sendResponse(\GuzzleHttp\json_encode($payment_errors), 'Payment Failed');
                        }
                    }
                } catch (ValidatorException $e) {
                return $this->sendError($e->getMessage());
                }
            return $this->sendResponse($order->toArray(), __('lang.saved_successfully', ['operator' => __('lang.order')]));
        }
    }



    public function create_payment(Request $request)
    {
        $input = $request->all();
        $rules=[
            "store_id"=> 'required',
            "token" => 'required',
            'credit_card' => 'required',
            'expiry_month' => 'required',
            'expiry_year' => 'required',
        ];
        $validator = Validator::make($input, $rules);

        if ($validator->fails()) {                                      //pass validator errors as errors object for ajax response
            return response()->json(['errors'=>$validator->errors()]);
        } else {
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

            /**************** Purchase ****************/
            $params = [
                'order_id' => uniqid('1234-56789', true),
                'amount' => $input['grand_total'],
                'credit_card' => $input['credit_card'],//'4242424242424242',
                'expiry_month' => $input['expiry_month'],//'12',
                'expiry_year' => $input['expiry_year'],//'20',
            ];
            $response = $gateway->purchase($params);
            if($response->errors){
                return($response);
//                $errors = $response->errors;   //errors
//                return($errors);
            }
            else{
                //Save Payment and sending response if payment is successful
                $receipt = $response->receipt();
                $payment = $this->paymentRepository->create([
                    "price" => $receipt->read('amount'),
                    "user_id" => $input['user_id'],
                    "status" => $receipt->read('message'),
                    "method" => 'moneris',
                ]);
                return($response);
            }
        }

        //Calling Order Function to save order
//        $request['payment_id'] = $params['order_id'];
//        $request['order_status_id'] = '2';
//        $order_response = $this->store_order($request);
    }
}


//'user_id',
//        'delivery_address_id',
//        'delivery_fee',
//        'driver_id',
//        'is_french'
//        'active',   1
//        'tax',
//        'order_status_id',
//        'hint',
//        'payment_id',
//        'expected_delivery_time',
//        'vendor_shared_price',
//        'eezly_shared_price',
//        'grand_total',
