<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class FoodOrder
 * @package App\Models
 * @version August 31, 2019, 11:18 am UTC
 *
 * @property \App\Models\Food food
 * @property \Illuminate\Database\Eloquent\Collection extra
 * @property \App\Models\Order order
 * @property double price
 * @property integer quantity
 * @property integer food_id
 * @property integer order_id
 */
class FoodOrder extends Model
{

    public $table = 'food_orders';
    


    public $fillable = [
        'price',
        'quantity',
        'food_id',
        'order_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'double',
        'quantity' => 'integer',
        'food_id' => 'integer',
        'order_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'price' => 'required',
        'food_id' => 'required|exists:foods,id',
        'order_id' => 'required|exists:orders,id'
    ];

    /**
     * New Attributes
     *
     * @var array
     */
    protected $appends = [
        'custom_fields',
        'extras',
        'food'
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
    public function food()
    {
        return $this->belongsTo(\App\Models\Food::class, 'food_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     **/
    public function extras()
    {
        return $this->belongsToMany(\App\Models\Extra::class, 'food_order_extras');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     **/
    public function order()
    {
        return $this->belongsTo(\App\Models\Order::class, 'order_id', 'id');
    }
        /**
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function getExtrasAttribute()
    {
        return $this->extras()->get(['extras.id', 'extras.name']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getFoodAttribute()
    {
        return $this->food()->get(['foods.id', 'foods.name','foods.price','foods.unit','foods.weight']);
    }
}
