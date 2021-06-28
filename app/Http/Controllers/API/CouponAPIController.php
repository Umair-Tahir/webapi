<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Criteria\Coupons\CouponsOfUserCriteria;
use App\DataTables\CouponDataTable;
use App\Http\Requests\CreateCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Http\Requests\ValidateCouponRequest;
use App\Repositories\CouponRepository;
use App\Repositories\CustomFieldRepository;
use App\Repositories\UploadRepository;
use Carbon\Carbon;
use Flash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Prettus\Validator\Exceptions\ValidatorException;

class CouponAPIController extends Controller
{
    /** @var  CouponRepository */
    private $couponRepository;

    public function __construct(CouponRepository $couponRepo)
    {
        parent::__construct();
        $this->couponRepository = $couponRepo;
    }

    public function validateCoupon(ValidateCouponRequest $request)
    {
        $input = $request->all();
        $result=$this->couponRepository->verifyCoupon($input);
        return $result;

    }


}
