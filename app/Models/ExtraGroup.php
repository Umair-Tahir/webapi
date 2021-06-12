<?php

namespace App\Models;

use Eloquent as Model;

/**
 * Class ExtraGroup
 * @package App\Models
 * @version April 6, 2020, 10:47 am UTC
 *
 * @property string name
 */
class ExtraGroup extends Model
{

    public $table = 'extra_groups';
    


    public $fillable = [
        'name',
        'min',
        'max'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'min' => 'integer',
        'max' => 'integer',
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'name' => 'required',
        'min' => 'required',
        'max' => 'required',
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

    
    
}
