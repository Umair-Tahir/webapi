<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FoodOrderExtra extends Model
{

    public $table = 'food_order_extras';

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
        'extra_id' => 'integer'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'price' => 'required',
        'food_order_id' => 'required|exists:foods,id',
        'extra_id' => 'required|exists:extras,id'
    ];

    /**
     * New Attributes
     *
     * @var array
     */

    public function foodOrder()
    {
        return $this->belongsTo(\App\Models\FoodOrder::class);
    }
}
