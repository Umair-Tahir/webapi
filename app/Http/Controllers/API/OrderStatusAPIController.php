<?php

namespace App\Http\Controllers\API;


use App\Models\Order;
use App\Models\OrderStatus;
use App\Repositories\OrderStatusRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Validator;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\DB;
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

    public function __construct(OrderStatusRepository $orderStatusRepo, OrderRepository $orderRepo)
    {
        $this->orderStatusRepository = $orderStatusRepo;
        $this->orderRepository = $orderRepo;
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

    /*Function to update Order status
    Put orderStatuses/{id}
     **/
    public function update(Request $request, $id){

        $order = $this->orderRepository->find($id);
        if(!empty($order)){         //Check if order exist
            $validator = Validator::make($request->all(), [
                'new_status' => 'required'
            ]);
            if ($validator->fails()) {      //Check if request has new status
                return $this->sendError($validator->messages(), 404);
            }
            else{
                $newStatus = OrderStatus::find($request->input('new_status'));
                if(!empty($newStatus))  //Check if request has new status
                {   $value = ["order_status_id" => $newStatus->id];
                    $updatedOrder = $this->orderRepository->update($value, $id);
                }
                else
                    return $this->sendError("New Status passed doesn't exist",404);
            }

        }else {
            return $this->sendError('order not found', 404);
        }

        return $this->sendResponse($updatedOrder,'Order Status Updated');


    }

    /*Function to Show User's all Orders grouped according to statuses*/
    public function userOrders(){
        $user_id = auth()->user()->id;
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
        $order = Order::where('orders.id', $id)
            ->join('order_statuses', 'order_statuses.id', '=', 'orders.order_status_id')
            ->select('orders.id',  'order_statuses.status')
            ->first();

//
//        $order_status = Order::select('*')
//            ->where('id', '=', $id)
//            ->pluck('order_status_id');
//        $status_name = OrderStatus::select('*')
//            ->where('id', '=', $order_status)
//            ->pluck('status');

        if ($order->count() > 0) {
            return $this->sendResponse($order, 'Showing Order');
        } else {
            return $this->sendError('No Order Found of such id');
        }
    }
}
