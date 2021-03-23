<?php

namespace App\Http\Controllers\API\Manager;

use App\Criteria\Restaurants\RestaurantsOfCuisinesCriteria;
use App\Criteria\Restaurants\NearCriteria;
use App\Criteria\Restaurants\PopularCriteria;
use App\Models\Restaurant;
use App\Repositories\CustomFieldRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\UploadRepository;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Exceptions\RepositoryException;
use Prettus\Validator\Exceptions\ValidatorException;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RestaurantAPIController extends Controller
{
    /** @var  RestaurantRepository */
    private $restaurantRepository;

    /**
     * @var CustomFieldRepository
     */
    private $customFieldRepository;

    /**
     * @var UploadRepository
     */
    private $uploadRepository;


    public function __construct(RestaurantRepository $restaurantRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo)
    {
        parent::__construct();
        $this->restaurantRepository = $restaurantRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $restaurant = $this->restaurantRepository->findWithoutFail($id);

        if (empty($restaurant)) {
            return $this->sendError('Restaurant not found');
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository
                             ->findByField('custom_field_model', $this->restaurantRepository->model());

        try {
            $restaurant = $this->restaurantRepository->update($input, $id);

            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($restaurant, 'image');
            }
            foreach (getCustomFieldsValues($customFields, $request) as $value) {
                $restaurant->customFieldsValues()
                    ->updateOrCreate(['custom_field_id' => $value['custom_field_id']], $value);
            }
        } catch (ValidatorException $e) {
            return $this->sendError($e->getMessage());
        }
        return $this->sendResponse($restaurant->toArray(), __('lang.updated_successfully', ['operator' => __('lang.restaurant')]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*
        Function to show All restaurants of a manager
    */
    public function showRestaurants(){
        $user = auth()->user();
        $restaurants = $user->restaurants;

            //If User has restaurants
        if(!empty($restaurants)){
            foreach ($restaurants as $restaurant){
                $foods = Restaurant::where('restaurants.id', $restaurant->id)
                    ->join('foods', 'foods.restaurant_id', '=', 'restaurants.id')
                    ->select('foods.*')->get();

                $restaurant['foods'] = $foods;
            }
        }
        else
            return $this->sendError("User don't have any restaurants", 404);

        return $this->sendResponse($restaurants, 'success');
    }
}
