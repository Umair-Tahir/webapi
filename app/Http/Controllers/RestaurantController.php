<?php
namespace App\Http\Controllers;

use App\Criteria\Restaurants\RestaurantsOfUserCriteria;
use App\Criteria\Users\DriversCriteria;
use App\Criteria\Users\ManagersCriteria;
use App\DataTables\RestaurantDataTable;
use App\Events\RestaurantChangedEvent;
use App\Http\Requests\CreateRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\Food;
use App\Repositories\CustomFieldRepository;
use App\Repositories\CuisineRepository;
use App\Repositories\DeliveryTypeRepository;
use App\Repositories\RestaurantRepository;
use App\Repositories\UploadRepository;
use App\Repositories\UserRepository;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class RestaurantController extends Controller
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
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var CuisineRepository
     */
    private $cuisineRepository;

    /** @var  DeliveryTypeRepository */
    private $deliveryTypeRepository;

    public function __construct(RestaurantRepository $restaurantRepo, CustomFieldRepository $customFieldRepo, UploadRepository $uploadRepo, UserRepository $userRepo,DeliveryTypeRepository $deliveryTypeRepo, CuisineRepository $cuisineRepository)
    {
        parent::__construct();
        $this->restaurantRepository = $restaurantRepo;
        $this->customFieldRepository = $customFieldRepo;
        $this->uploadRepository = $uploadRepo;
        $this->userRepository = $userRepo;
        $this->cuisineRepository = $cuisineRepository;
        $this->deliveryTypeRepository = $deliveryTypeRepo;
    }

    /**
     * Display a listing of the Restaurant.
     *
     * @param RestaurantDataTable $restaurantDataTable
     * @return Response
     */
    public function index(RestaurantDataTable $restaurantDataTable)
    {
        return $restaurantDataTable->render('restaurants.index');
    }

    /**
     * Show the form for creating a new Restaurant.
     *
     * @return Response
     */
    public function create()
    {

        $user = $this->userRepository->getByCriteria(new ManagersCriteria())->pluck('name', 'id');
        $deliveryType = $this->deliveryTypeRepository->pluck('name', 'id');
        $cuisine = $this->cuisineRepository->pluck('name', 'id');
        $usersSelected = [];
        $deliveryTypesSelected = [];
        $cuisinesSelected = [];
        $hasCustomField = in_array($this->restaurantRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->restaurantRepository->model());
            $html = generateCustomField($customFields);
        }
        return view('restaurants.create')->with("customFields", isset($html) ? $html : false)->with("user", $user)->with("usersSelected", $usersSelected)->with('cuisine', $cuisine)->with('cuisinesSelected', $cuisinesSelected)->with('deliveryType', $deliveryType)->with('deliveryTypesSelected', $deliveryTypesSelected);
    }

    /**
     * Store a newly created Restaurant in storage.
     *
     * @param CreateRestaurantRequest $request
     *
     * @return Response
     */
    public function store(CreateRestaurantRequest $request)
    {

        $input = $request->all();
        if (auth()->user()->hasRole('manager')) {
            $input['users'] = [auth()->id()];
        }
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->restaurantRepository->model());
        try {
            $restaurant = $this->restaurantRepository->create($input);
            $restaurant->customFieldsValues()->createMany(getCustomFieldsValues($customFields, $request));
            if (isset($input['image']) && $input['image']) {
                $cacheUpload = $this->uploadRepository->getByUuid($input['image']);
                $mediaItem = $cacheUpload->getMedia('image')->first();
                $mediaItem->copy($restaurant, 'image');
            }
            event(new RestaurantChangedEvent($restaurant));
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.restaurant')]));

        return redirect(route('restaurants.index'));
    }

    /**
     * Display the specified Restaurant.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function show($id)
    {

        $this->restaurantRepository->pushCriteria(new RestaurantsOfUserCriteria(auth()->id()));
        $restaurant = $this->restaurantRepository->findWithoutFail($id);
        if (empty($restaurant)) {
            Flash::error('Restaurant not found');

            return redirect(route('restaurants.index'));
        }
        $categories=Food::with('category')->where('foods.restaurant_id',$id)->get()->pluck('category.name','category_id')->toArray();
        $menu=[];
        foreach ($categories as $key=>$value){
            $section['category']=$value;
            $section['foods']=Food::where([['category_id','=',$key],['restaurant_id','=',$id]])->get();
            array_push($menu,$section);
        }

        return view('restaurants.show')->with(compact('menu','restaurant'));
    }

    /**
     * Show the form for editing the specified Restaurant.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function edit($id)
    {
        $this->restaurantRepository->pushCriteria(new RestaurantsOfUserCriteria(auth()->id()));
        $restaurant = $this->restaurantRepository->findWithoutFail($id);

        if (empty($restaurant)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.restaurant')]));
            return redirect(route('restaurants.index'));
        }

        $user = $this->userRepository->getByCriteria(new ManagersCriteria())->pluck('name', 'id');
        $deliveryType = $this->deliveryTypeRepository->pluck('name', 'id');
        $cuisine = $this->cuisineRepository->pluck('name', 'id');

        $usersSelected = $restaurant->users()->pluck('users.id')->toArray();
        $cuisinesSelected = $restaurant->cuisines()->pluck('cuisines.id')->toArray();
        $deliveryTypesSelected = $restaurant->deliveryTypes()->pluck('delivery_types.id')->toArray();

        $customFieldsValues = $restaurant->customFieldsValues()->with('customField')->get();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->restaurantRepository->model());
        $hasCustomField = in_array($this->restaurantRepository->model(), setting('custom_field_models', []));
        if ($hasCustomField) {
            $html = generateCustomField($customFields, $customFieldsValues);
        }

        return view('restaurants.edit')->with('restaurant', $restaurant)->with("customFields", isset($html) ? $html : false)->with("user", $user)->with("usersSelected", $usersSelected)->with('cuisine', $cuisine)->with('cuisinesSelected', $cuisinesSelected)->with('deliveryType', $deliveryType)->with('deliveryTypesSelected', $deliveryTypesSelected);
    }

    /**
     * Update the specified Restaurant in storage.
     *
     * @param int $id
     * @param UpdateRestaurantRequest $request
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function update($id, UpdateRestaurantRequest $request)
    {
        $this->restaurantRepository->pushCriteria(new RestaurantsOfUserCriteria(auth()->id()));
        $restaurant = $this->restaurantRepository->findWithoutFail($id);

        if (empty($restaurant)) {
            Flash::error('Restaurant not found');
            return redirect(route('restaurants.index'));
        }
        $input = $request->all();
        $customFields = $this->customFieldRepository->findByField('custom_field_model', $this->restaurantRepository->model());
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
            event(new RestaurantChangedEvent($restaurant));
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.restaurant')]));

        return redirect(route('restaurants.index'));
    }

    /**
     * Remove the specified Restaurant from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function destroy($id)
    {
        if (!env('APP_DEMO', false)) {
            $this->restaurantRepository->pushCriteria(new RestaurantsOfUserCriteria(auth()->id()));
            $restaurant = $this->restaurantRepository->findWithoutFail($id);

            if (empty($restaurant)) {
                Flash::error('Restaurant not found');

                return redirect(route('restaurants.index'));
            }

            $this->restaurantRepository->delete($id);

            Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.restaurant')]));
        } else {
            Flash::warning('This is only demo app you can\'t change this section ');
        }
        return redirect(route('restaurants.index'));
    }

    /**
     * Remove Media of Restaurant
     * @param Request $request
     */
    public function removeMedia(Request $request)
    {
        $input = $request->all();
        $restaurant = $this->restaurantRepository->findWithoutFail($input['id']);
        try {
            if ($restaurant->hasMedia($input['collection'])) {
                $restaurant->getFirstMedia($input['collection'])->delete();
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }
    }
}
