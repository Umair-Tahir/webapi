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

    public function __construct(FoodRepository $foodRepo)
    {
        $this->foodRepository = $foodRepo;
    }

    //Function to get Current Trending Foods
    public function trendingFoods()
    {

        $date = \Carbon\Carbon::today()->subDays(-700);
        $foodOrders = FoodOrder::select('food_id')
            ->where('created_at', '>=', $date)
            ->groupBy('food_id')->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->pluck('food_id')->toArray();

        if (!empty($foodOrders)) {
            $foods = $this->foodRepository->getFoodsWithRestaurant($foodOrders);
        } else {
            $foods = $this->foodRepository->randomFoodsWithRestaurant(5);

        }
        return $this->sendResponse($foods, 'Showing Random Trending Foods');
    }


    //Function to get Month Popular Foods
    public function popular_foods()
    {
        $foodOrders = FoodOrder::select('food_id')
            ->where('created_at', '>', Carbon::now()->subDays(30))
            ->groupBy('food_id')->orderByRaw('COUNT(*) DESC')
            ->limit(5)
            ->pluck('food_id')->toArray();


        if (!empty($foodOrders)) {
            $foods = $this->foodRepository->getFoodsWithRestaurant($foodOrders);
        } else {
            $foods = $this->foodRepository->randomFoodsWithRestaurant(5);

        }
        return $this->sendResponse($foods, 'Showing Random Popular Foods');
    }
}
