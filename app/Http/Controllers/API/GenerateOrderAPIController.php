<?php

namespace App\Http\Controllers\API;



use App\Http\Middleware\App;
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



/*----------------Moneris Payment ------------------*/


    public function moneris_payment(Request $request){
        $input = $request->all();

        /**************************** Request Variables ********
        Card Verification Digits and/or Address Verification Service provided by Moneris
         CVD & AVS are disabled in this payment method
         ***********************/
        $store_id= $input['store_id'];
        $api_token= $input['api_token'];

        /************** optional Instantiation    ***************/
        $params = [
            'environment' => Moneris::ENV_LIVE, // default: Moneris::ENV_LIVE
      /*    'environment' => Moneris::ENV_TESTING, // default: Moneris::ENV_LIVE
            'avs' => true, // default: false
            'cvd' => true, // default: false
            'cof' => true, // default: false */
        ];
        $gateway = (new Moneris($store_id, $api_token, $params))->connect();
        $gateway = Moneris::create($store_id, $api_token, $params);

        /*******************  Pre-Authorization  * *******************/
        $params = [
            'order_id' => uniqid('1234-56789', true),
            'amount' => $input['amount'],
            'credit_card' => $input['credit_card'],
            'expiry_month' => $input['expiry_month'],
            'expiry_year' => $input['expiry_year'],
//            'avs_street_number' => '123',
//            'avs_street_name' => 'lakeshore blvd',
//            'avs_zipcode' => '90210',
//            'cvd' => '111',
            'payment_indicator' => $input['payment_indicator'],
            'payment_information' => $input['payment_information'],
        ];

        $response = $gateway->preauth($params);

        /****************** Capture (Pre-Authorization Completion) ******************/
        $params = [
            'order_id' => uniqid('1234-56789', true),
            'amount' => $input['amount'],
            'credit_card' => $input['credit_card'],
            'expiry_month' => $input['expiry_month'],
            'expiry_year' => $input['expiry_year'],
//            'avs_street_number' => '123',
//            'avs_street_name' => 'lakeshore blvd',
//            'avs_zipcode' => '90210',
//            'cvd' => '111',
            'payment_indicator' => $input['payment_indicator'],
            'payment_information' => $input['payment_information'],
        ];

        $response = $gateway->preauth($params);

        $response = $gateway->capture($response->transaction);

        /**************** Purchase ****************/
        $params = [
            'order_id' => uniqid('1234-56789', true),
            'amount' => $input['amount'],
            'credit_card' => $input['credit_card'],
            'expiry_month' => $input['expiry_month'],
            'expiry_year' => $input['expiry_year'],
            'payment_indicator' => $input['payment_indicator'],
            'payment_information' => $input['payment_information']
        ];

        $response = $gateway->purchase($params);


        if($response->errors){
            $errors = $response->errors;
            return $this->sendError($errors);
        }
        $receipt = $response->receipt();

        //Calling Order Function to save order
        $request['payment_id'] = $params['order_id'];
        $request['order_status_id'] = '2';
        $order_response = $this->store_order($request);

        if($order_response->errors) {
            $errors = $response->errors;
            return $this->sendError($errors);
        }
        else{
        return $this->sendResponse($order_response , 'Order Created Successfully');
        }
    }

/*----------------Moneris Payment ------------------*/



    /**
     * Create new Order after receiving parameters from app
     */
    public function store_order (Request $request){


        $input = $request->all();
        $amount = 0;

        try {
            $user = $this->userRepository->findWithoutFail($input['user_id']);
            if (empty($user)) {
                return $this->sendError('User not found');
            }
            if (empty($input['delivery_address_id'])) {
                $order = $this->orderRepository->create(
                    $request->only('user_id', 'order_status_id', 'tax')
                );
            } else {
                $order = $this->orderRepository->create(
                    $request->only('user_id', 'order_status_id', 'tax', 'delivery_address_id', 'delivery_fee','hint')
                );
            }

            foreach ($input['foods'] as $foodOrder) {
                $foodOrder['order_id'] = $order->id;
                $amount += $foodOrder['price'] * $foodOrder['quantity'];
                $this->foodOrderRepository->create($foodOrder);
            }
            $payment_id = 2;
            $this->orderRepository->update(['payment_id' => $payment_id], $order->id);

        }
        catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($order->toArray(),  __('lang.saved_successfully', ['operator' => __('lang.order')]));
    }

}
