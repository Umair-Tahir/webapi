<?php

namespace App\Http\Controllers\API;


use App\Models\Order;
use App\Models\OrderStatus;
use App\Repositories\OrderStatusRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;

/**
 * Class OrderStatusController
 * @package App\Http\Controllers\API
 */

class OrderStatusAPIController extends Controller
{
    /** @var  OrderStatusRepository */
    private $orderStatusRepository;

    public function __construct(OrderStatusRepository $orderStatusRepo)
    {
        $this->orderStatusRepository = $orderStatusRepo;
    }

    /**
     * Display a listing of the OrderStatus.
     * GET|HEAD /orderStatuses
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $this->orderStatusRepository->pushCriteria(new RequestCriteria($request));
            $this->orderStatusRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            Flash::error($e->getMessage());
        }
        $orderStatuses = $this->orderStatusRepository->all();

        return $this->sendResponse($orderStatuses->toArray(), 'Order Statuses retrieved successfully');
    }

    /**
     * Display the specified OrderStatus.
     * GET|HEAD /orderStatuses/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var OrderStatus $orderStatus */
        if (!empty($this->orderStatusRepository)) {
            $orderStatus = $this->orderStatusRepository->findWithoutFail($id);
        }

        if (empty($orderStatus)) {
            return $this->sendError('Order Status not found');
        }

        return $this->sendResponse($orderStatus->toArray(), 'Order Status retrieved successfully');
    }

    /*Function to Show all User Orders Statuses*/
    public function user_orders(){
        $user_id = auth()->user();
        $order_status = OrderStatus::all()->pluck('id');
        $orders = Order::select('*')
            ->whereIn('order_status_id', $order_status)
            ->where('user_id','=',$user_id->id)
            ->groupBy('order_status_id')
            ->get();

        if($orders){
            return $this->sendResponse($orders->toArray(), 'Showing all orders of User');
        }
        else{
            return $this->sendError('No Orders Found');
        }

    }

    /* Function to show him his User single order */
    public function current_order_status($id)
    {
        $order = Order::select('*')
            ->where('id', '=', $id)
            ->get();
        if ($order->count() > 0) {
            return $this->sendResponse($order->toArray(), 'Showing Order');
        } else {
            return $this->sendError('No Order Found of such id');
        }
    }

}
