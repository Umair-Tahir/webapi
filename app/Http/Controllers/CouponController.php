<?php

namespace App\Http\Controllers;

use App\Criteria\Coupons\CouponsOfUserCriteria;
use App\DataTables\CouponDataTable;
use App\Http\Requests\CreateCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Repositories\CouponRepository;
use App\Repositories\CustomFieldRepository;
use App\Repositories\UploadRepository;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class CouponController extends Controller
{
    /** @var  CouponRepository */
    private $couponRepository;

    public function __construct(CouponRepository $couponRepo)
    {
        parent::__construct();
        $this->couponRepository = $couponRepo;
    }

    /**
     * Display a listing of the coupon.
     *
     * @param CouponDataTable $couponDataTable
     * @return Response
     */
    public function index(CouponDataTable $couponDataTable)
    {
        return $couponDataTable->render('coupons.index');
    }

    /**
     * Show the form for creating a new coupon.
     *
     * @return Response
     */
    public function create()
    {
        
        return view('coupons.create');
    }

    /**
     * Store a newly created coupon in storage.
     *
     * @param CreateCouponRequest $request
     *
     * @return Response
     */
    public function store(CreateCouponRequest $request)
    {
        $input = $request->all();
        $input['user_id']=auth()->id();
        if($input['starts_at']!=null){
            $input['starts_at']=Carbon::parse($input['starts_at']);
        }
        if($input['expires_at']!=null){
            $input['expires_at']=Carbon::parse($input['expires_at']);
        }
        try {
            $coupon = $this->couponRepository->create($input);
        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.saved_successfully', ['operator' => __('lang.coupon')]));

        return redirect(route('coupons.index'));
    }

    /**
     * Display the specified coupon.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $this->couponRepository->pushCriteria(new CouponsOfUserCriteria(auth()->id()));
        $coupon = $this->couponRepository->findWithoutFail($id);

        if (empty($coupon)) {
            Flash::error('coupon not found');

            return redirect(route('coupons.index'));
        }

        return view('coupons.show')->with('coupon', $coupon);
    }

    /**
     * Show the form for editing the specified coupon.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $this->couponRepository->pushCriteria(new CouponsOfUserCriteria(auth()->id()));
        $coupon = $this->couponRepository->findWithoutFail($id);


        if (empty($coupon)) {
            Flash::error(__('lang.not_found', ['operator' => __('lang.coupon')]));

            return redirect(route('coupons.index'));
        }

        return view('coupons.edit')->with('coupon', $coupon);
    }

    /**
     * Update the specified coupon in storage.
     *
     * @param int $id
     * @param UpdateCouponRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateCouponRequest $request)
    {
        $this->couponRepository->pushCriteria(new CouponsOfUserCriteria(auth()->id()));
        $coupon = $this->couponRepository->findWithoutFail($id);

        if (empty($coupon)) {
            Flash::error('coupon not found');
            return redirect(route('coupons.index'));
        }
        $input = $request->all();
        $input['user_id']=auth()->id();
        if($input['starts_at']!=null){
            $input['starts_at']=Carbon::parse($input['starts_at']);
        }
        if($input['expires_at']!=null){
            $input['expires_at']=Carbon::parse($input['expires_at']);
        }

        try {
            $coupon = $this->couponRepository->update($input, $id);

        } catch (ValidatorException $e) {
            Flash::error($e->getMessage());
        }

        Flash::success(__('lang.updated_successfully', ['operator' => __('lang.coupon')]));

        return redirect(route('coupons.index'));
    }

    /**
     * Remove the specified coupon from storage.
     *
     * @param int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        $this->couponRepository->pushCriteria(new CouponsOfUserCriteria(auth()->id()));
        $coupon = $this->couponRepository->findWithoutFail($id);

        if (empty($coupon)) {
            Flash::error('coupon not found');

            return redirect(route('coupons.index'));
        }

        $this->couponRepository->delete($id);

        Flash::success(__('lang.deleted_successfully', ['operator' => __('lang.coupon')]));

        return redirect(route('coupons.index'));
    }

}
