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

    public function users()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

}
