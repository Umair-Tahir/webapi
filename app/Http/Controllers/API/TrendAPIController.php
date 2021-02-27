<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FoodOrder;
use App\Models\Food;
use App\Repositories\FoodRepository;
use Carbon\Carbon;
use PhpParser\Node\Expr\Array_;

class TrendAPIController extends Controller
{
    /** @var  FoodRepository */
    private $foodRepository;

    public function __construct(FoodRepository $foodRepo )
    {
        $this->foodRepository = $foodRepo;
    }

    //Function to get Current Trending Foods
    public function trending_foods() {

      $date = \Carbon\Carbon::today()->subDays(-700);
      $food_orders =  FoodOrder::select('food_id')
                      ->where( 'created_at', '>=', $date)
                      ->groupBy('food_id')->orderByRaw('COUNT(*) DESC')
                      ->limit(5)
                      ->get();
       // dd($food_orders);
        if(!$food_orders->isEmpty()){
            $i=0;
            $food=Array();
            foreach ($food_orders as $fid) {
                $food[$i] = $this->foodRepository->findWithoutFail($fid['food_id']);
                $i++;
            }
            return $this->sendResponse($food, 'Showing Trending Foods');
        }
        else{
            $foods =  Food::inRandomOrder()
                ->limit(5)
                ->get();
            }
            return $this->sendResponse($foods, 'Showing Random Foods');
        }


    //Function to get Month Popular Foods
    public function popular_foods(){
        $food_orders = FoodOrder::select('food_id')
            ->where( 'created_at', '>', Carbon::now()->subDays(30))
            ->groupBy('food_id')->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->get();

//        select('name')>groupBy('name')->orderByRaw('COUNT(*) DESC')->limit(1)->get();

        if(!$food_orders->isEmpty()){
            $i=0;
            $food=Array();
            foreach ($food_orders as $fid) {
                $food[$i] = $this->foodRepository->findWithoutFail($fid['food_id']);
                $i++;
            }
            return $this->sendResponse($food, 'Showing Popular foods');

        }else{
            $foods = Food::inRandomOrder()
                ->limit(5)
                ->get();
        }
        return $this->sendResponse($foods, 'Showing Random Popular Foods');
    }
}
