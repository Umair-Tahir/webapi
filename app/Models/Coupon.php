<?php
namespace App\Models;

use Eloquent as Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * Class Category
 * @package App\Models
 * @version April 11, 2020, 1:57 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection Food
 * @property string name
 * @property string description
 */
class Coupon extends Model
{
    public $table = 'coupons';



    public $fillable = [
        'code',
        'name',
        'description',
        'uses',
        'max_uses',
        'max_uses_user',
        'type',
        'discount_amount',
//        'percent_off',
        'user_id',
        'active',
        'starts_at',
        'expires_at'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'code' => 'string',
        'name' => 'string',
        'description' => 'string',
        'uses' => 'integer',
        'max_uses' => 'integer',
        'max_uses_user' => 'integer',
        'type' => 'integer',
        'discount_amount' => 'double',
        'user_id' => 'integer',
//        'percent_off' => 'integer',
        'active' => 'boolean'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'code' => 'required',
        'name' => 'required',
        'type' => 'required'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function orders()
    {
        return $this->hasMany(\App\Models\Order::class,'coupon_id');
    }
    public function couponValid($couponCode){
        $coupon= self::where([['code','=',strtolower($couponCode)],['active','=',1]])->first();
        if($coupon){
            $currentDate = date('Y-m-d');
            $couponStart=date('Y-m-d', strtotime($coupon->starts_at));
            $couponExpire=date('Y-m-d', strtotime($coupon->expires_at));
            if (($currentDate >= $couponStart) && ($currentDate <= $couponExpire)){
                return $coupon;
            }
        }
        return false;
    }

    public function restaurantEligibility(Coupon $coupon, $restaurantId){
        $couponOwner=$coupon->user;
        if($couponOwner->roles->first()->name=='admin'){
            return true;
        }else{
            $userRestaurantsId=$couponOwner->restaurants->pluck('id')->toArray();
            if(in_array($restaurantId,$userRestaurantsId)){
                return true;
            }
        }
        return false;
    }

    public function usageLimit(Coupon $coupon,$userId){
          $userUsageCount=$coupon->orders->where('user_id',$userId)->count();
          if((0<$coupon->max_uses)&&($userUsageCount<$coupon->max_uses_user)){
             return true;
          }
          return false;
    }

    public function calculatedDiscount(Coupon $coupon, $amount){
        $data=[
            'discountable_amount'=>0,
            'message'=>'No calculations were done as no type defined'
        ];
        $couponType=$coupon->type;
        $discountableAmount=$coupon->discount_amount;
        switch ($couponType) {
            case 1:
                  $data['discountable_amount']=$discountableAmount;
                  $data['message']="Displaying amount discountable via applying " .config('enums.coupon_types_array.'.$couponType). " coupon";
                break;
            case 2:
                $data['discountable_amount']=$amount*($discountableAmount/100);
                $data['message']="Displaying amount discountable via applying " .config('enums.coupon_types_array.'.$couponType). " coupon";
                break;
            case 3:
                $data['discountable_amount']=$discountableAmount;
                $data['message']="Displaying amount discountable via applying " .config('enums.coupon_types_array.'.$couponType). " coupon";
                break;
        }
        return $data;
    }
}
