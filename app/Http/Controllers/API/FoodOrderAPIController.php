<?php

namespace App\Http\Controllers\API;


use App\Models\FoodOrder;
use App\Repositories\FoodOrderRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Support\Facades\Response;
use Prettus\Repository\Exceptions\RepositoryException;
use Flash;

/**
 * Class FoodOrderController
 * @package App\Http\Controllers\API
 */

class FoodOrderAPIController extends Controller
{
    /** @var  FoodOrderRepository */
    private $foodOrderRepository;

    public function __construct(FoodOrderRepository $foodOrderRepo)
    {
        $this->foodOrderRepository = $foodOrderRepo;
    }

    /**
     * Display a listing of the FoodOrder.
     * GET|HEAD /foodOrders
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        try{
            $this->foodOrderRepository->pushCriteria(new RequestCriteria($request));
            $this->foodOrderRepository->pushCriteria(new LimitOffsetCriteria($request));
        } catch (RepositoryException $e) {
            Flash::error($e->getMessage());
        }
        $foodOrders = $this->foodOrderRepository->all();

        return $this->sendResponse($foodOrders->toArray(), 'Food Orders retrieved successfully');
    }

    /**
     * Display the specified FoodOrder.
     * GET|HEAD /foodOrders/{id}
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        /** @var FoodOrder $foodOrder */
        if (!empty($this->foodOrderRepository)) {
            $foodOrder = $this->foodOrderRepository->findWithoutFail($id);
        }

        if (empty($foodOrder)) {
            return $this->sendError('Food Order not found');
        }

        return $this->sendResponse($foodOrder->toArray(), 'Food Order retrieved successfully');
    }

    /**
     * Store a newly created Food Order in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
//    public function store(Request $request)
//    {
//        $input = $request->all();
//       try {
//            $foodOrder = $this->foodOrderRepository->create($input);
//
//        } catch (ValidatorException $e) {
//            return $this->sendError($e->getMessage());
//        }
//
//        return $this->sendResponse($foodOrder->toArray(), __('lang.saved_successfully', ['operator' => __('lang.foodOrder')]));
//    }
}
