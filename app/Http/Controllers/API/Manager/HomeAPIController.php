<?php

namespace App\Http\Controllers\API\Manager;

use App\Models\Food;
use App\Models\FoodOrder;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeAPIController extends Controller
{
    public function show($id){
            /* Show Data on Manager's home screen of a single restaurant
            Api get orders count of a restaurant
            */

            $restaurant_id = $id;
        try {
            $rest_foods = Food::select('id')->where('restaurant_id' , $restaurant_id)->pluck('id');

            /* Condition So that if no restaurant is found error could be sent*/
            if(!empty($rest_foods->first())){
            $food_sales = FoodOrder::select('id','price')->where('food_id' , $rest_foods)->pluck('price');
            }
            else{
                return $this->sendError('No restaurant found against the request id',404);
            }

            $total = 0;
            if(!empty($food_sales[1])) {

                foreach ($food_sales as $price)
                    $total += $price;
            }
            else{
                $orderResponse=[
                    'total_orders ' => 0,
                    'total_sales' => '$'.'0',
                    'future_payouts' => '$'.'0'
                ];

                return $this->sendResponse($orderResponse,'No Orders were made in last 14 days');
            }

            $orderResponse=[
                'total_orders ' => count($food_sales),
                'total_sales' => '$'.round($total, 2),
                'future_payouts' => '0'
            ];
        } catch (ValidatorException $e) {
            return($e->getMessage());
        }

        return $this->sendResponse($orderResponse, 'total orders and total sales retrieved successfully');
    }

}
