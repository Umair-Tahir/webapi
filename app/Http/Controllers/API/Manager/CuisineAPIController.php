<?php

namespace App\Http\Controllers\API\Manager;

use App\Models\Cuisine;
use Illuminate\Http\Request;

use App\Models\FoodOrder;
use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use App\Repositories\CuisineRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;

class CuisineAPIController extends Controller
{
    public function __construct(CuisineRepository $cuisineRepo, RestaurantRepository $restaurantRepo)
    {
        $this->cuisineRepository = $cuisineRepo;
        $this->restaurantRepository = $restaurantRepo;
    }

    /* Function to show cuisine of a restaurant */
    public function show_all($id){

        $res = Restaurant::find($id);
        $cuisines = Cuisine::select('*')
                        ->where('id', '=', $id)
                        ->get();

        if ($cuisines->count() > 0) {
            return $this->sendResponse($cuisines->toArray(), 'Showing cuisine');
        } else {
            return $this->sendError('No Cuisine Found of such id');
        }
    }
}
