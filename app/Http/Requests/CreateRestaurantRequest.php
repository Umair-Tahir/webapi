<?php

namespace App\Http\Requests;

use App\Models\Restaurant;
use Illuminate\Foundation\Http\FormRequest;

class CreateRestaurantRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        if (auth()->user()->hasRole('admin')) {
            return Restaurant::$adminRules;
        } elseif (auth()->user()->hasRole('manager')) {
            return Restaurant::$managerRules;
        }
    }
}
