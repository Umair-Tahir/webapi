<?php

namespace App\Http\Controllers\API\Manager;

use Illuminate\Http\Request;
use App\Models\Food;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Controllers\Controller;

class TrendsAPIController extends Controller
{
    public function sales_chart($days){
        try {

            $dates = array();
            $sales = array();

            for( $i=0; $i<$days; $i++){
                //date('Y-m-d',strtotime("-6 days")); ->toDateString()
                $date = date('Y-m-d');// \Carbon\Carbon::today()->subDays($i+1);
                $sales[$i] =  Food::select('id') ->pluck('created_at');
                             //  ->where( 'created_at', '=', $date)
                              // ->pluck('created_at');
                dd($sales[$i]);
                $dates[$i] =$date;
            }



               // ->groupBy('food_id')->orderByRaw('COUNT(*) DESC')
                //->get();

//                Food::select('id')->where('restaurant_id' , '1')->pluck('id');


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
