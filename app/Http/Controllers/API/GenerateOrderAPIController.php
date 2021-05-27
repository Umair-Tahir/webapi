<?php

namespace App\Http\Controllers\API;


use App\Http\Middleware\App;
use App\Http\Requests\CreateOrderEvaDeliveryRequest;
use App\Http\Requests\CreateOrderPickUpRequest;
use App\Http\Requests\CreateOrderRestaurantDeliveryRequest;
use App\Mail\OrderNotificationEmail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MonerisPaymentService;
use App\Repositories\CartRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\FoodOrderRepository;
use App\Repositories\UserRepository;
use App\Models\EvaDeliveryService;
use App\Models\TikTakDeliveryService;

use Flash;
use Illuminate\Support\Facades\Mail;
use Prettus\Validator\Exceptions\ValidatorException;
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
    /* @var  NotificationRepository */
    private $notificationRepository;

    private $monerisPaymentService;

    public function __construct(OrderRepository $orderRepo, FoodOrderRepository $foodOrderRepository, CartRepository $cartRepo, PaymentRepository $paymentRepo, NotificationRepository $notificationRepo, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepo;
        $this->foodOrderRepository = $foodOrderRepository;
        $this->cartRepository = $cartRepo;
        $this->userRepository = $userRepository;
        $this->paymentRepository = $paymentRepo;
        $this->notificationRepository = $notificationRepo;
        $this->monerisPaymentService = new MonerisPaymentService();
        $this->tiktakDeliveryService = new TikTakDeliveryService();
    }


    /*************Pickup Food order request *************/
    public function pickupOrder(CreateOrderPickUpRequest $request)
    {
        try {
            $input = $request->all();
            $input['delivery_type_id'] = 1;
            $input['delivery_address_id'] = null;
            $input['delivery_fee'] = null;
            $input ['tip'] = null;


            /******  Find User ******/
            $user = $this->userRepository->findWithoutFail($input['user_id']);
            if (empty($user)) {
                $this->sendError('User was not found', 400);
            } else {
                /***** Moneris Setup *****/
                $gateway_env = getenv("Live_ENV_MONERIS");

                /***** Setting Moneris Pre Request params *****/
                $statusResponse = $this->monerisPaymentService->monerisStatus($gateway_env);

                /**************** Purchase ****************/
                $paymentStatus = $this->createPurchase($input, $statusResponse);
                if ($paymentStatus['status'] == 'Failed')
                    return $this->sendError('Payment was not successful due to false parameters. Check for payment credentials');
                elseif ($paymentStatus['status'] == 'moneris_error')
                    return $this->sendError($paymentStatus['data']);

                /**************** Purchase Successful ****************/
                $input['payment_id'] = $paymentStatus['data'];

                /**************** Store Order Function ****************/
                $orderResponse = $this->store_order($input);
                if ($orderResponse['status'] == 'success') {

                    /************ Send Email ****************/
                    $this->monerisPaymentService->sendOrderEmail($input['is_french'], $orderResponse['order']);
                    return $this->sendResponse($orderResponse, 'Payment and order are successfully created');
                } else {
                    return ($orderResponse);
                }
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 401);
        }
    }

    /*************Restaurant Delivery order request *************/

    public function restaurantDeliveryOrder(CreateOrderRestaurantDeliveryRequest $request)
    {

        try {
            $input = $request->all();
            $input['delivery_type_id'] = 2;

            /******  Find User ******/
            $user = $this->userRepository->findWithoutFail($input['user_id']);
            if (empty($user)) {
                return $this->sendError('User was not found', 400);
            } else {
                /***** Moneris Setup *****/
                $gateway_env = getenv("Live_ENV_MONERIS");
                /***** Setting Moneris Pre Request params *****/
                $statusResponse = $this->monerisPaymentService->monerisStatus($gateway_env);

                /**************** Purchase ****************/
                $paymentStatus = $this->createPurchase($input, $statusResponse);
                if ($paymentStatus['status'] == 'Failed')
                    return $this->sendError('Payment was not successful due to false parameters. Check for payment credentials');
                elseif ($paymentStatus['status'] == 'moneris_error')
                    return $this->sendError($paymentStatus['data']);

                /**************** Purchase Successful ****************/
                $input['payment_id'] = $paymentStatus['data'];

                /**************** Store Order Function ****************/
                $orderResponse = $this->store_order($input);

                if ($orderResponse['status'] == 'success') {

                    /************ Send Email ****************/
                    $this->monerisPaymentService->sendOrderEmail($input['is_french'], $orderResponse['order']);
                    return $this->sendResponse($orderResponse, 'Payment and order are successfully created');
                } else {
                    return ($orderResponse);
                }
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 401);
        }


    }


    /*************EVA Delivery Service order request *************/
    public function deliveryServiceOrder(CreateOrderEvaDeliveryRequest $request)
    {
        try {
            $input = $request->all();
            $input['delivery_type_id'] = 3;

            /******  Find User ******/
            $user = $this->userRepository->findWithoutFail($input['user_id']);
            if (empty($user)) {
                return $this->sendError('User was not found', 400);
            } else {
                /***** Moneris Setup *****/
                $gateway_env = getenv("Live_ENV_MONERIS");
                /***** Setting Moneris Pre Request params *****/
                $statusResponse = $this->monerisPaymentService->monerisStatus($gateway_env);


                /**************** Purchase ****************/
                $paymentStatus = $this->createPurchase($input, $statusResponse);
                if ($paymentStatus['status'] == 'Failed')
                    return $this->sendError('Payment was not successful due to false parameters. Check for payment credentials');
                elseif ($paymentStatus['status'] == 'moneris_error')
                    return $this->sendError($paymentStatus['data']);

                /**************** Purchase Successful ****************/
                $input['payment_id'] = $paymentStatus['data'];

                /**************** Store Order Function ****************/
                $orderResponse = $this->store_order($input);

                if ($orderResponse['status'] == 'success') {
                    /************ Creating EVA Ds ****************/
                    $evaParams = [
                        'order_id' => $orderResponse['order']->id,
                        'restaurant_id' => $input['restaurant_id'],
                        'distance' => $input['distance'],
                        'delivery_tax' => $input['delivery_tax'],
                        'total_charges_plus_tax' => $input['total_charges_plus_tax'],
                        'tip_token_charge' => $input['tip'],
                    ];
                    $evaModal = new EvaDeliveryService();
                    $evaModal->createEvaFromOrder($evaParams);

                    /************ Send Email ****************/
                    $this->monerisPaymentService->sendOrderEmail($input['is_french'], $orderResponse['order']);
                    return $this->sendResponse($orderResponse, 'Payment and order are successfully created');
                } else {
                    return ($orderResponse);
                }
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 401);
        }

    }


    /************* Tookan (Tik Tak) Delivery Service order request *************/
    public
    function tiktakDeliveryService(Request $request)
    {
        try {
            $input = $request->all();
            $input['delivery_type_id'] = 3;

            /******  Find User ******/
            $user = $this->userRepository->findWithoutFail($input['user_id']);
            if (empty($user)) {
                return $this->sendError('User was not found', 400);
            } else {
                /***** Moneris Setup *****/
                $gateway_env = getenv("Live_ENV_MONERIS");
                /***** Setting Moneris Pre Request params *****/
                $statusResponse = $this->monerisPaymentService->monerisStatus($gateway_env);

                /**************** Purchase ****************/
                $paymentStatus = $this->createPurchase($input, $statusResponse);
                if ($paymentStatus['status'] == 'Failed')
                    return $this->sendError('Payment was not successful due to false parameters. Check for payment credentials');
                elseif ($paymentStatus['status'] == 'moneris_error')
                    return $this->sendError($paymentStatus['data']);

                /**************** Purchase Successful ****************/
                $input['payment_id'] = $paymentStatus['data'];

                /**************** Store Order Function ****************/
                $orderResponse = $this->store_order($input);

                if ($orderResponse['status'] == 'success') {

                   $tiktakParams = [
                        'order_id' => $orderResponse['order']->id,
                        'restaurant_id' => $input['restaurant_id'],
                        'distance' => $input['distance'],
                        'total' => $input['total'] // This is the delivery fee of tik tak
                    ];
                    $tiktakModal = new TikTakDeliveryService();
                    $tiktakModal->createTikTakFromOrder($tiktakParams);

                    /************ Send Email ****************/
//                    $this->monerisPaymentService->sendOrderEmail($input['is_french'], $orderResponse['order']);
                    return $this->sendResponse($orderResponse, 'Payment and order are successfully created');
                } else {
                    return ($orderResponse);
                }
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 401);
        }
    }


    /**
     * Create new Purchase
     */
    public
    function createPurchase($input, $statusResponse)
    {
        /**************** Purchase ****************/
        $params = [
            'cvd' => $input['cvc_code'],
            'order_id' => uniqid('1234-56789', true) . '_' . date('Y-m-d'),
            'amount' => $input['grand_total'],
            'credit_card' => str_replace(' ', '', $input['credit_card']),
            'expiry_month' => $input['expiry_month'],
            'expiry_year' => $input['expiry_year'],
        ];
        $purchaseResponse = $statusResponse['gateway']->purchase($params);

        /********* Checking for payment status
         * &
         * Saving Payment
         **********/
        if ($purchaseResponse->successful) {
            $receipt = $purchaseResponse->receipt();
            $receipt_json = json_encode($receipt);
            $variable = $receipt->read('message');
            $variable = substr((string)$variable, 0, strpos((string)$variable, "  "));
            $payment = $this->paymentRepository->create([
                "price" => $receipt->read('amount'),
                "user_id" => $input['user_id'],
                "status" => $variable,
                "method" => 'moneris',
                'moneris_order_id' => $receipt->read('id'),
                'moneris_receipt' => $receipt->read('reference')
            ]);
            return $response = [
                'status' => 'Success',
                'data' => $payment->id
            ];
        } elseif ($purchaseResponse->errors) {
            $errors = $purchaseResponse->errors;
            return $response = [
                'status' => 'moneris_error', //These errors are generated by moneris
                'data' => $errors
            ];
        } else
            return $response = [
                'status' => 'Failed'
            ];

    }


    /**
     * Create new Order after receiving parameters from app
     */
    public
    function store_order($input)
    {
        /************* Create Order *****/
        try {
            $order = $this->orderRepository->create([
                'user_id' => $input['user_id'],
                'order_status_id' => 1,
                'tax' => $input['tax'],
                'hint' => $input['hint'],
                'active' => 1,
                'payment_id' => $input['payment_id'],
                'tip' => $input['tip'],
                'vendor_shared_price' => $input['vendor_shared_price'],
                'eezly_shared_price' => $input['eezly_shared_price'],
                'grand_total' => $input['grand_total'],
                'is_french' => $input['is_french'],

                'restaurant_id' => $input['restaurant_id'],
                "delivery_address_id" => $input['delivery_address_id'],
                'expected_delivery_time' => $input['expected_delivery_time'],
                "delivery_fee" => $input['delivery_fee'],
                'delivery_type_id' => $input['delivery_type_id'],
            ]);

            /******** Making Food Order  ***/
            foreach ($input['foods'] as $foodOrder) {
                $foodOrder['order_id'] = $order->id;
                $this->foodOrderRepository->create($foodOrder);
            }

            $orderResponse = [
                'status' => 'success',
                'order' => $order
            ];
        } catch (ValidatorException $e) {
            return ($e->getMessage());
        }

        return $orderResponse;
    }
}
