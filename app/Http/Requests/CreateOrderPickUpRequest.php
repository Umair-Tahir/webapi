<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderPickUpRequest extends FormRequest
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
        return [
            'cvc_code'   => 'required',
            'credit_card' => 'required',
            'expiry_month' => 'required',
            'expiry_year' => 'required',
            "user_id" => 'required',
            'is_french' => 'required',
            'tax' => 'required',
            'vendor_shared_price' => 'required',
            'eezly_shared_price' => 'required',
            "restaurant_id" => 'required',
            'grand_total' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'cvc_code.required' => "CVC code is required",
            'credit_card.required'  =>  "Card Number is required",
            'expiry_month.required'  =>  "Expiry Month is required",
            'expiry_year.required'  =>  "Expiry Year is required",
            'user_id.required'  =>  "User ID is required",
            'is_french.required'  =>  "Is French is required",
            'tax.required'  => "Tax is required",
            'vendor_shared_price.required'  =>  "Vendor Shared Price is required",
            'eezly_shared_price.required'  => "Eezly Shared Price is required",
            'restaurant_id.required'  =>  "Restaurant ID is required",
            'grand_total.required'  =>  "Grand Total is required"
        ];
    }
}
