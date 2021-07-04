<?php
namespace App\Models;

use App\Mail\OrderNotificationEmail;
use Eloquent as Model;
use GlobalPayments\Api\Entities\Exceptions\ApiException;
use Illuminate\Support\Facades\Mail;

/**
 * Class Order
 * @package App\Models
 * @version August 31, 2019, 11:11 am UTC
 *
 * @property \App\Models\User user
 * @property \App\Models\OrderStatus orderStatus
 * @property \App\Models\FoodOrder[] foodOrders
 * @property integer user_id
 * @property integer order_status_id
 * @property double tax
 * @property double delivery_fee
 * @property string id
 * @property string hint
 */
class Order extends Model
{

    public $table = 'orders';
    


    public $fillable = [
        'user_id',
        'order_status_id',
        'tax',
        'hint',
        'payment_id',
        'restaurant_id',
        'delivery_type_id',
        'delivery_address_id',
        'delivery_fee',
        'active',
        'expected_delivery_time',
        'vendor_shared_price',
        'eezly_shared_price',
        'grand_total',
        'is_french',
        'tip',
        'delivery_company_name',
        'coupon_id',
    ];
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
        'order_status_id' => 'integer',
        'tax' => 'double',
        'tip' => 'double',
        'hint' => 'string',
        'status' => 'string',
        'payment_id' => 'integer',
        'delivery_type_id' => 'integer',
        'delivery_address_id' => 'integer',
        'restaurant_id' => 'integer',
        'delivery_fee'=>'double',
        'active'=>'boolean',
        'delivery_company_name' => 'string',
        'coupon_id' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'user_id' => 'required|exists:users,id',
        'order_status_id' => 'required|exists:order_statuses,id',
        'delivery_type_id' => 'required|exists:delivery_types,id',
        'delivery_address_id' => 'required|exists:delivery_addresses,id',
        'restaurant_id' => 'required|exists:restaurants,id',
        'payment_id' => 'exists:payments,id',
        'coupon_id' => 'exists:coupons,id',
    ];

    /**
     * New Attributes
     *
     * @var array
     */
    protected $appends = [
        'custom_fields',

    ];

    public function customFieldsValues()
    {
        return $this->morphMany('App\Models\CustomFieldValue', 'customizable');
    }

    public function getCustomFieldsAttribute()
    {
        $hasCustomField = in_array(static::class,setting('custom_field_models',[]));
        if (!$hasCustomField){
            return [];
        }
        $array = $this->customFieldsValues()
            ->join('custom_fields','custom_fields.id','=','custom_field_values.custom_field_id')
            ->where('custom_fields.in_table','=',true)
            ->get()->toArray();

        return convertToAssoc($array,'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id', 'id');
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function restaurant()
    {
        return $this->belongsTo(\App\Models\Restaurant::class, 'restaurant_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function orderStatus()
    {
        return $this->belongsTo(\App\Models\OrderStatus::class, 'order_status_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function coupon()
    {
        return $this->belongsTo(\App\Models\Coupon::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     **/
    public function foodOrders()
    {
        return $this->hasMany(\App\Models\FoodOrder::class);
    }



    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function payment()
    {
        return $this->belongsTo(\App\Models\Payment::class, 'payment_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function deliveryAddress()
    {
        return $this->belongsTo(\App\Models\DeliveryAddress::class, 'delivery_address_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function deliveryType()
    {
        return $this->belongsTo(\App\Models\DeliveryType::class, 'delivery_type_id', 'id');
    }

    public function evadeliveryservice(){
        return $this->hasOne(EvaDeliveryService::class);
    }


    /**
     * Send order confirmation email
     **/
    public function sendOrderEmail($isFrench, $order)
    {
        try {
        $toRestaurant = false;
        //Send email invoice to customer $order->user->email
        Mail::to($order->user->email)->send(new OrderNotificationEmail($order, $isFrench, $toRestaurant));
        $toRestaurant = true;
        //Send email invoice to restaurant $order->foodOrders[0]->food->restaurant->users[0]->email
        Mail::to('philippe.dallaire4@gmail.com')->send(new OrderNotificationEmail($order, $isFrench, $toRestaurant));
        } catch (ApiException $e) {
            return $e->getMessage();
        }

        return 'success';
    }
}
