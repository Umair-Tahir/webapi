<?php

namespace App\Models;

use Eloquent as Model;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\Models\Media;

/**
 * Class Cuisine
 * @package App\Models
 * @version April 11, 2020, 1:57 pm UTC
 *
 * @property \Illuminate\Database\Eloquent\Collection restaurant
 * @property string name
 * @property string description
 */
class DeliveryType extends Model
{

    public $table = 'delivery_types';
    


    public $fillable = [
        'name',
        'description'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'description' => 'string',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
    ];

    /**
     * New Attributes
     *
     * @var array
     */
//    protected $appends = [
//        'restaurants'
//    ];


    public function restaurants()
    {
        return $this->belongsToMany(\App\Models\Restaurant::class, 'restaurant_delivery_types');
    }

        /**
    * @return \Illuminate\Database\Eloquent\Collection
    */
    public function getRestaurantsAttribute()
    {
        return $this->restaurants()->get(['restaurants.id', 'restaurants.name']);
    }
}
