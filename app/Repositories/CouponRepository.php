<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Coupon;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CategoryRepository
 * @package App\Repositories
 * @version April 11, 2020, 1:57 pm UTC
 *
 * @method Category findWithoutFail($id, $columns = ['*'])
 * @method Category find($id, $columns = ['*'])
 * @method Category first($columns = ['*'])
*/
class CouponRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'code',
        'name',
        'description',
        'uses',
        'max_uses',
        'max_uses_user',
        'type',
        'discount_amount',
//        'percent_off',
        'active',
        'starts_at',
        'expires_at'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Coupon::class;
    }


    public function verifyCoupon(array $input){
        $result=[
            'success'=>false,
            'message'=>'Coupon does not exist or has been expired Coupon.',
        ];
        $coupon=$this->couponValid($input['coupon_code']);
        if($coupon){
           if($this->restaurantEligibility($coupon,$input['restaurant_id'])){
                if($this->usageLimit($coupon,$input['user_id'])){
                            $result=$this->calculatedDiscount($coupon);
                            $result['success']=true;
                }else{
                    $result['message']='Your limit of applying this coupon has been exceeded';
                }
           }else{
               $result['message']='Coupon is not applicable on selected restaurant';
           }
        }
        return $result;

    }
}
