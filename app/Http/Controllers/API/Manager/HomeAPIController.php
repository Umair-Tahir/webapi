<?php

namespace App\Http\Controllers\API\Manager;

use App\Models\Food;
use App\Models\FoodOrder;
use Prettus\Validator\Exceptions\ValidatorException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeAPIController extends Controller
{
    public function show(Request $request){
            /* Show Data on Manager's home screen of a single restaurant */

        try {
            $restaurant_id = $request->all();

            $rest_foods = Food::select('id')->where('restaurant_id' , $restaurant_id)->pluck('id');
            $food_sales = FoodOrder::select('id','price')->where('food_id' , $rest_foods)->pluck('price');

            $total = 0;
            foreach ($food_sales as $price)
                $total += $price;

            $orderResponse=[
                'Total orders ' => count($food_sales),
                'Total Sales' => round($total, 2)
            ];
        } catch (ValidatorException $e) {
            return($e->getMessage());
        }

        return $this->sendResponse($orderResponse, 'total orders and total sales retrieved successfully');
    }

}
