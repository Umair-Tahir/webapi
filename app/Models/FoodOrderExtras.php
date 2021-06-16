<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FoodOrderExtras extends Model
{

    public $table = 'food_orders';



    public $fillable = [
        'price',
        'quantity',
        'food_order_id',
        'extra_id'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'price' => 'double',
        'quantity' => 'integer',
        'food_order_id' => 'integer',
        'order_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'price' => 'required',
        'food_order_id' => 'required|exists:foods,id',
        'order_id' => 'required|exists:orders,id'
    ];

    /**
     * New Attributes
     *
     * @var array
     */

}
