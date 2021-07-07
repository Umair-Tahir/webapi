<?php

namespace App\Http\Controllers\API;


use App\Models\Restaurant;
use App\Models\User;
use App\Models\DeliveryAddress;
use App\Http\Requests\CreateOrderEvaDeliveryRequest;
use App\Http\Requests\CreateOrderPickUpRequest;
use App\Http\Requests\CreateOrderRestaurantDeliveryRequest;
use App\Repositories\GlobalPaymentRepository;
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
use App\Models\Order;
use App\models\TextEmAll;
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

    private $globalPaymentRepository;

    public function __construct(OrderRepository $orderRepo, TikTakDeliveryService $tikTakDeliveryService, EvaDeliveryService $evaDeliveryService, FoodOrderRepository $foodOrderRepository, CartRepository $cartRepo, PaymentRepository $paymentRepo, GlobalPaymentRepository $globalPaymentRepository, NotificationRepository $notificationRepo, UserRepository $userRepository)
    {
        $this->orderRepository = $orderRepo;
        $this->foodOrderRepository = $foodOrderRepository;
        $this->cartRepository = $cartRepo;
        $this->userRepository = $userRepository;
        $this->paymentRepository = $paymentRepo;

        $this->globalPaymentRepository = $globalPaymentRepository;
        $this->notificationRepository = $notificationRepo;
        $this->tikTakDeliveryService = $tikTakDeliveryService;
        $this->eva = $evaDeliveryService;
        $this->textEmAll = new TextEmAll();
    }


    /*************Pickup Food order request *************/
    public function pickupOrder(CreateOrderPickUpRequest $request)
    {
        try {
            $input = $request->all();
            $input['delivery_type_id'] = 1;
            $input['delivery_address_id'] = null;
            $input['delivery_fee'] = 0;
            $input['tip'] = 0;


            /******  Find User ******/
            $user = $this->userRepository->findWithoutFail($input['user_id']);
            if (empty($user)) {
                $this->sendError('User was not found', 400);
            } else {

                /**************** GPS Payment deduction request ****************/
                $paymentCharge = $this->paymentTransaction($input);
                if ($paymentCharge['status'] == 'Failed')
                    return $this->sendError($paymentCharge['error']);

                /**************** Purchase Successful ****************/
                $input['payment_id'] = $paymentCharge['payment_id'];

                /**************** Store Order Function ****************/
                $orderResponse = $this->store_order($input);
                if ($orderResponse['status'] == 'success') {
                    /************ Send Text ****************/
                    $textemall = $this->textEmAll->createText($orderResponse['order'], $input['restaurant_id']);
                    /************ Send Email ****************/
                    $sentEmail = $this->orderRepository->sendOrderEmail($input['is_french'], $orderResponse['order']);
                    if ($sentEmail  != 'success') {
                        return $sentEmail;
                    } else if ($textemall != 'success')
                        return $this->sendError($textemall, 'Failed');

                    return $this->sendResponse($orderResponse, 'Payment and order are successfully created');
                } else {
                    return ($orderResponse);
                }
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 401);
        }
        return $this->sendError("internal server error", 500);
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
                $this->sendError('User was not found', 400);
            } else {
                /**************** Payment deduction request ****************/
                $paymentCharge = $this->paymentTransaction($input);
                if ($paymentCharge['status'] == 'Failed')
                    return $this->sendError($paymentCharge['error']);

                /**************** Purchase Successful ****************/
                $input['payment_id'] = $paymentCharge['payment_id'];

                /**************** Store Order Function ****************/
                $orderResponse = $this->store_order($input);

                if ($orderResponse['status'] == 'success') {
                    /************ Send Text ****************/
                    $textemall = $this->textEmAll->createText($orderResponse['order'], $input['restaurant_id']);
                    /************ Send Email ****************/
                    $sentEmail = $this->orderRepository->sendOrderEmail($input['is_french'], $orderResponse['order']);
                    if ($sentEmail  != 'success') {
                        return $sentEmail;
                    } else if ($textemall != 'success')
                        return $this->sendError($textemall, 'Failed');

                    return $this->sendResponse($orderResponse, 'Payment and order are successfully created');
                } else {
                    return ($orderResponse);
                }
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 401);
        }
        return $this->sendError("internal server error", 500);
    }


    /*************EVA Delivery Service order request *************/
    public function deliveryServiceOrder(CreateOrderEvaDeliveryRequest $request)
    {
        try {
            $input = $request->all();
            $input['delivery_type_id'] = 3;
            $input['delivery_company_name'] = 'eva';

            /******  Find User ******/
            $user = $this->userRepository->findWithoutFail($input['user_id']);
            if (empty($user)) {
                $this->sendError('User was not found', 400);
            } else {
                /**************** Payment deduction request ****************/
                $paymentCharge = $this->paymentTransaction($input);
                if ($paymentCharge['status'] == 'Failed')
                    return $this->sendError($paymentCharge['error']);

                /**************** Purchase Successful ****************/
                $input['payment_id'] = $paymentCharge['payment_id'];

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
                        'tip_token_charge' => ($input['tip']) ? $input['tip'] : 0
                    ];
                    $evaModal = new EvaDeliveryService();
                    $evaModal->createEvaFromOrder($evaParams);

                    /************ Send Text ****************/
                    $textemall = $this->textEmAll->createText($orderResponse['order'], $input['restaurant_id']);
                    /************ Send Email ****************/
                    $sentEmail = $this->orderRepository->sendOrderEmail($input['is_french'], $orderResponse['order']);
                    if ($sentEmail  != 'success') {
                        return $sentEmail;
                    } else if ($textemall != 'success')
                        return $this->sendError($textemall, 'Failed');
                    return $this->sendResponse($orderResponse, 'Payment and order are successfully created');
                } else {
                    return ($orderResponse);
                }
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 401);
        }
        return $this->sendError("internal server error", 500);
    }


    /************* Tookan (Tik Tak) Delivery Service order request *************/
    public function tiktakDeliveryService(Request $request)
    {
        try {
            $input = $request->all();
            $input['delivery_type_id'] = 3;
            $input['delivery_company_name'] = 'tik_tak';

            /******  Find User ******/
            $user = $this->userRepository->findWithoutFail($input['user_id']);
            if (empty($user)) {
                $this->sendError('User was not found', 400);
            } else {
                /**************** Payment deduction request ****************/
                $paymentCharge = $this->paymentTransaction($input);
                if ($paymentCharge['status'] == 'Failed')
                    return $this->sendError($paymentCharge['error']);

                /**************** Purchase Successful ****************/
                $input['payment_id'] = $paymentCharge['payment_id'];

                /**************** Store Order Function ****************/
                $orderResponse = $this->store_order($input);

                if ($orderResponse['status'] == 'success') {

                    $tiktakParams = [
                        'order_id' => $orderResponse['order']->id,
                        'restaurant_id' => $input['restaurant_id'],
                        'distance' => $input['distance'],
                        'total' => $input['total'] // This is the delivery fee of tik tak
                    ];
                    $this->tikTakDeliveryService->createTikTakFromOrder($tiktakParams);

                    /************ Send Text ****************/
                    $textemall = $this->textEmAll->createText($orderResponse['order'], $input['restaurant_id']);
                    /************ Send Email ****************/
                    $sentEmail = $this->orderRepository->sendOrderEmail($input['is_french'], $orderResponse['order']);
                    if ($sentEmail  != 'success') {
                        return $sentEmail;
                    } else if ($textemall != 'success')
                        return $this->sendError($textemall, 'Failed');
                    return $this->sendResponse($orderResponse, 'Payment and order are successfully created');
                } else {
                    return ($orderResponse);
                }
            }
        } catch (\Exception $e) {
            return $this->sendError($e->getMessage(), 401);
        }
        return $this->sendError("internal server error", 500);
    }


    /*************   Restaurant Call Ride ********************************************
     *       A single function is created for every call ride for every type of
     *       company delivery service
     *********************************************************/
    public function callRide(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required'
        ]);

        $order = Order::find($request['order_id']);
        if ($order) {
            $restaurant = Restaurant::find($order->restaurant_id);
            $deliveryAddress = DeliveryAddress::find($order->delivery_address_id);
            $user = User::find($order->user_id);

            /************************************* For Eva **********************/
            if ($order->delivery_type_id == 3 && $order->delivery_company_name == 'eva') {
                $evaDs = EvaDeliveryService::where('order_id', $request['order_id'])->first();
                $response = $this->eva
                    ->callRide($order->id, $restaurant, $deliveryAddress, $user, $evaDs->tip_token_charge);

                $responseBody = json_decode($response->getBody());
                if (!$responseBody) {
                    return $this
                        ->sendError(
                            'Ride cannot be called as EVA is currently not available',
                            $response->getStatusCode()
                        );
                }

                $evaDs->tracking_id = $responseBody->tracking_id;
                if ($responseBody->business_tracking_id)
                    $evaDs->business_tracking_id = $responseBody->business_tracking_id;
                $evaDs->save();

                $tracking_link = 'https://business.eva.cab/public/live_tracker?tracking_id=' . $responseBody
                    ->tracking_id;
                $responseBody->tracking_link = $tracking_link;
                return $this->sendResponse($responseBody, 'Successful');

                /************************************* For Tik Tak **********************/
            } elseif ($order->delivery_type_id == 3 && $order->delivery_company_name == 'tik_tak') {
                $tiktakDs = TikTakDeliveryService::where('order_id', $request['order_id'])->first();
                $response = $this->tikTakDeliveryService->tiktakTask($order->id, $restaurant, $deliveryAddress, $user);

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
                return $this->sendError(
                    'Order was not selected to be delivered by a delivery service',
                    400
                );
        } else
            return $this->sendError('Order Not Found', 404);
    }


    /**
     * Do payment request to Global payments and save detail upon success
     */
    public function paymentTransaction($input)
    {
        /**************** Purchase ****************/
        $user = $this->userRepository->findOrFail($input['user_id']);
        $input['user_name'] = $user->name;
        $paymentResponse = $this->globalPaymentRepository->authorizePayment($input);
        if (gettype($paymentResponse) == 'object' && $paymentResponse->responseCode == 00) {

            //On success payment save details and return payment ID
            $payment = $this->paymentRepository->create([
                "price" => $input['grand_total'],
                "user_id" => $input['user_id'],
                "status" => 'success',
                "method" => 'global_payment',
                'response_code' => $paymentResponse->responseCode,
                'response_message' => $paymentResponse->responseMessage,
                'gp_order_id' => $paymentResponse->orderId,
                'authorization_code' => $paymentResponse->authorizationCode,
                'transaction_id' => $paymentResponse->transactionId,
                'scheme_id' => $paymentResponse->schemeId,
            ]);

            $response = [
                'status' => 'Success',
                'payment_id' => $payment->id
            ];
        } else {
            //On transaction errors  return error message by Global Payments/Custom message
            $response = [
                'status' => 'Failed',
                //                'error' => $paymentResponse,
                'error' => "Unable to authorize the payment. Please check your debit/credit card details."
            ];
        }

        return $response;
    }


    /**
     * Create new Order after receiving parameters from app
     */
    public function store_order($input)
    {
        /************* Create Order *****/
        try {
            $input['order_status_id'] = 1;
            $order = $this->orderRepository->create($input);

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
