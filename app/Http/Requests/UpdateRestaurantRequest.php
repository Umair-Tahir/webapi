<?php

namespace App\Http\Requests;

use App\Models\Restaurant;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRestaurantRequest extends FormRequest
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
        $input = $this->all();

        $input['drivers'] = isset($input['drivers']) ? $input['drivers'] : [];

        if (auth()->user()->hasRole('admin')) {
            $input['users'] = isset($input['users']) ? $input['users'] : [];
            $input['cuisines'] = isset($input['cuisines']) ? $input['cuisines'] : [];
            $input['deliveryTypes'] = isset($input['deliveryTypes']) ? $input['deliveryTypes'] : [];
            $this->replace($input);
            return Restaurant::$adminRules;

        } else {
            unset($input['users']);
            unset($input['cuisines']);
            unset($input['deliveryTypes']);
            $this->replace($input);
            return Restaurant::$managerRules;
        }
    }
}
