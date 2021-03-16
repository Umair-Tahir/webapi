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

    /*Function to Show User's all Orders grouped according to statuses*/
    public function userOrders(){
        $user_id = auth()->user()->id;
//        $order_status = OrderStatus::all()->pluck('id');

        $orders = Order::select('*')
            ->where('user_id','=',$user_id)
            ->OrderBy('order_status_id')
            ->get();
        if(!$orders->isEmpty()){
            return $this->sendResponse($orders->toArray(), 'Showing all orders of User');
        }
        else{
            return $this->sendError('No Orders Found');
        }

    }

    /* Function to show User's order status*/
    public function currentOrderStatus($id)
    {
        $order_status = Order::select('*')
            ->where('id', '=', $id)
            ->pluck('order_status_id');
        $status_name = OrderStatus::select('*')
            ->where('id', '=', $order_status)
            ->pluck('status');

        if ($status_name->count() > 0) {
            return $this->sendResponse($status_name, 'Showing Order');
        } else {
            return $this->sendError('No Order Found of such id');
        }
    }
}
