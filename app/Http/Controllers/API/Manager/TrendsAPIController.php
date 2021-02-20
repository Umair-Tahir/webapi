<?php

namespace App\Http\Controllers\API\Manager;

use App\Models\FoodOrder;
use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Food;
use Prettus\Validator\Exceptions\ValidatorException;
use App\Http\Controllers\Controller;

class TrendsAPIController extends Controller
{
    private $restaurantRepository;

    public function __construct(RestaurantRepository $restaurantRepo)
    {
        parent::__construct();
        $this->restaurantRepository = $restaurantRepo;
    }

    /*
       Sales Chart on the basis of Daily, Monthly Bases
    */
    public function sales_chart($days){

        try {
            $sales = array();
            for( $i=0; $i<$days; $i++){
                $date = date('Y-m-d',strtotime('-'.$i.' days'));
                $s_count =  FoodOrder::select('id', 'created_at')
                                    ->whereDate('created_at', '=', $date)
                                    ->get()
                                    ->count();
                $sales[$i] = [$date => $s_count];
            }
        } catch (ValidatorException $e) {
            return($e->getMessage());
        }
        return $this->sendResponse($sales, 'Dates with sales retrieved successfully');
    }


    /*
        Best Seller food of last Month
    */

    public function best_seller($id){

        try {
            if($this->restaurantRepository->findWithoutFail($id)){
                $res_foods = Food::select('restaurant_id', 'id')
                                    ->where('restaurant_id', '=', $id)
                                    ->pluck('id');

                //filtering top 3 foods if exist
                $date  = \Carbon\Carbon::today()->subDays(14);
                $foods = FoodOrder::select('food_id')
                                    ->whereIn('food_id', $res_foods)
                                    ->where('created_at','>',$date)
                                    ->groupBy('food_id')
                                    ->orderByRaw('COUNT(*) DESC')
                                    ->limit(3)
                                    ->pluck('food_id');

                //Counting top records in specific time
                $total = FoodOrder::select('food_id')
                    ->whereIn('food_id', $res_foods)
                    ->where('created_at','>',$date)
                    ->get()
                    ->count();

                //Getting top counts
                $count = array();
                $i= 0;
                foreach ($foods as $food){
                    $num = FoodOrder::select('food_id')
                        ->where('food_id', '=', $food)
                        ->where('created_at','>',$date)
                        ->get()
                        ->count();
                    $count[$i] = [$foods[$i] => $num];
                    $i++;


                    $data = [$count, 'total_orders' => $total];
                }

                }
            else{
                return $this->sendError( 'No restaurant found',404);
            }
          } catch (ValidatorException $e) {
        return($e->getMessage());
        }
        return $this->sendResponse($data, 'Most populars foods of my restaurant along with there totsl orders');
    }



}
