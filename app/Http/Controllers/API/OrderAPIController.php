<?php
namespace App\Http\Controllers\API;


use App\Events\OrderChangedEvent;
use App\Http\Controllers\Controller;
use App\Mail\OrderNotificationEmail;
use App\Models\FoodOrder;
use App\Models\Order;
use App\Models\Restaurant;
use App\Notifications\NewOrder;
use App\Notifications\StatusChangedOrder;
use App\Repositories\CartRepository;
use App\Repositories\NotificationRepository;
use App\Repositories\OrderRepository;
use App\Repositories\PaymentRepository;
use App\Repositories\FoodOrderRepository;
use App\Repositories\UserRepository;
use App\Models\Food;
use Braintree\Gateway;
use Illuminate\Support\Facades\DB;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;
use Stripe\Token;

/**
 * Class OrderController
 * @package App\Http\Controllers\API
 */
class OrderAPIController extends Controller
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
    /** @var  NotificationRepository */
    private $notificationRepository;

    /**
     * OrderAPIController constructor.
     * @param OrderRepository $orderRepo
     * @param FoodOrderRepository $foodOrderRepository
     * @param CartRepository $cartRepo
     * @param PaymentRepository $paymentRepo
     * @param NotificationRepository $notificationRepo
     * @param UserRepository $userRepository
     */
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
     * Display a listing of the Order.
     * GET|HEAD /orders
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        Log::error("get orders");
        try {
            $this->orderRepository->pushCriteria(new RequestCriteria($request));
            $this->orderRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            Flash::error($e->getMessage());
        }
        $orders = $this->orderRepository->all();

        return $this->sendResponse($orders->toArray(), 'Orders retrieved successfully');
    }

    /**
     * Display the specified Order.
     * Order -> FoodOrder -> Foods
     * GET|HEAD /orders/{id}
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Request $request, $id)
    {
        /** @var Order $order */
        if (!empty($this->orderRepository)) {
            try {
                $this->orderRepository->pushCriteria(new RequestCriteria($request));
                $this->orderRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                Flash::error($e->getMessage());
            }

            $order = $this->orderRepository->findWithoutFail($id);

            if (!empty($order)) {
                $food_order = FoodOrder::select('*')
                    ->where('order_id', $order->id)
                    ->get();

                foreach ($food_order as $key => $singlefood) {
                    $food_array = Food::where('id', $singlefood->food_id)->get();
                    $singlefood['food'] = $food_array[0];
                }
                $order['food_order'] = $food_order;
            }
        }
        if (empty($order)) {
            return $this->sendError('Order not found');
        }

        return $this->sendResponse($order, 'Order retrieved successfully');
    }

    /** Currently Not Working
     * Store a newly created Order in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $payment = $request->only('payment');
        if (isset($payment['payment']) && $payment['payment']['method']) {
            if ($payment['payment']['method'] == "Credit Card (Stripe Gateway)") {
                return $this->stripPayment($request);
            } else {
                return $this->cashPayment($request);

            }
        }
    }

    /** Currently Not Working
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    private function stripPayment(Request $request)
    {
        $input = $request->all();
        $amount = 0;
        try {
            $user = $this->userRepository->findWithoutFail($input['user_id']);
            if (empty($user)) {
                return $this->sendError('User not found');
            }
            $stripeToken = Token::create(array(
                "card" => array(
                    "number" => $input['stripe_number'],
                    "exp_month" => $input['stripe_exp_month'],
                    "exp_year" => $input['stripe_exp_year'],
                    "cvc" => $input['stripe_cvc'],
                    "name" => $user->name,
                )
            ));
            if ($stripeToken->created > 0) {
                if (empty($input['delivery_address_id'])) {
                    $order = $this->orderRepository->create(
                        $request->only('user_id', 'order_status_id', 'tax')
                    );
                } else {
                    $order = $this->orderRepository->create(
                        $request->only('user_id', 'order_status_id', 'tax', 'delivery_address_id', 'delivery_fee')
                    );
                }
                foreach ($input['foods'] as $foodOrder) {
                    $foodOrder['order_id'] = $order->id;
                    $amount += $foodOrder['price'] * $foodOrder['quantity'];
                    $this->foodOrderRepository->create($foodOrder);
                }
                $amount += $order->delivery_fee;
                $amountWithTax = $amount + ($amount * $order->tax / 100);
                $charge = $user->charge((int)($amountWithTax * 100), ['source' => $stripeToken]);
                $payment = $this->paymentRepository->create([
                    "user_id" => $input['user_id'],
                    "description" => trans("lang.payment_order_done"),
                    "price" => $amountWithTax,
                    "status" => $charge->status, // $charge->status
                    "method" => $input['payment']['method'],
                ]);
                $this->orderRepository->update(['payment_id' => $payment->id], $order->id);

                $this->cartRepository->deleteWhere(['user_id' => $order->user_id]);

                Notification::send($order->foodOrders[0]->food->restaurant->users, new NewOrder($order));
            }
        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($order->toArray(), __('lang.saved_successfully', ['operator' => __('lang.order')]));
    }

    /** Currently Not Working
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    private function cashPayment(Request $request)
    {
        $input = $request->all();
        $amount = 0;
        try {
            if (empty($input['delivery_address_id'])) {
                $order = $this->orderRepository->create(
                    $request->only('user_id', 'order_status_id', 'tax')
                );
            } else {
                $order = $this->orderRepository->create(
                    $request->only('user_id', 'order_status_id', 'tax', 'delivery_address_id', 'delivery_fee')
                );
            }
            foreach ($input['foods'] as $foodOrder) {
                $foodOrder['order_id'] = $order->id;
                $amount += $foodOrder['price'] * $foodOrder['quantity'];
                $this->foodOrderRepository->create($foodOrder);
            }
            $amount += $order->delivery_fee;
            $amountWithTax = $amount  + ($amount * $order->tax / 100);
            $payment = $this->paymentRepository->create([
                "user_id" => $input['user_id'],
                "description" => trans("lang.payment_order_waiting"),
                "price" => $amountWithTax,
                "status" => 'Waiting for Client',
                "method" => $input['payment']['method'],
            ]);

            $this->orderRepository->update(['payment_id' => $payment->id], $order->id);

            $this->cartRepository->deleteWhere(['user_id' => $order->user_id]);

            Notification::send($order->foodOrders[0]->food->restaurant->users, new NewOrder($order));

        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($order->toArray(), __('lang.saved_successfully', ['operator' => __('lang.order')]));
    }

    /** Currently Not Working
     * Update the specified Order in storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id, Request $request)
    {
        $oldOrder = $this->orderRepository->findWithoutFail($id);

        if (empty($oldOrder)) {
            return $this->sendError('Order not found');
        }
        $oldStatus = $oldOrder->payment->status;
        $input = $request->all();

        try {
            $order = $this->orderRepository->update($input, $id);
            if ($input['order_status_id'] == 5 && !empty($order)) {
                $this->paymentRepository->update(['status' => 'Paid'], $order['payment_id']);
            }
            event(new OrderChangedEvent($oldStatus, $order));
            Notification::send([$order->user], new StatusChangedOrder($order));

        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }

        return $this->sendResponse($order->toArray(), __('lang.saved_successfully', ['operator' => __('lang.order')]));
    }


    public function generateInvoice(Request $request,$id){

        /** @var Order $order */
        if (!empty($this->orderRepository)) {
            try {
                $this->orderRepository->pushCriteria(new RequestCriteria($request));
                $this->orderRepository->pushCriteria(new LimitOffsetCriteria($request));
            } catch (RepositoryException $e) {
                Flash::error($e->getMessage());
            }
            $order = $this->orderRepository->findWithoutFail($id);

        }

        if (empty($order)) {
            return $this->sendError('Order not found');
        }

        $isFrench=true;
        $toRestaurant=false;
//        return (new CustomerInvoice($order))->render();
        //Send email invoice to customer
        Mail::to($order->user->email)->send(new OrderNotificationEmail($order,$isFrench,$toRestaurant));
        $toRestaurant=true;
        //Send email invoice to restaurant
        Mail::to($order->foodOrders[0]->food->restaurant->users[0]->email)->send(new OrderNotificationEmail($order,$isFrench,$toRestaurant));


        return $this->sendResponse($order->toArray(), 'Order retrieved successfully');

          }
}
