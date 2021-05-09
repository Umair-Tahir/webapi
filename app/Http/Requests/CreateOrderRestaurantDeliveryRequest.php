<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRestaurantDeliveryRequest extends FormRequest
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

            'credit_card'   => 'required',
            'restaurant_id' => 'required',
            'expiry_month'   => 'required',
            'expiry_year'   => 'required',
            'cvc_code'   => 'required',
            "user_id"       => 'required',
            "delivery_address_id" => 'required',
            "delivery_fee"        => 'required',
            'is_french'           => 'required',
            'tax'                 => 'required',
            'expected_delivery_time' => 'required',
            'vendor_shared_price'    => 'required',
            'eezly_shared_price'     => 'required',
            'grand_total'            => 'required',
            "tip" => 'required'


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
            'grand_total.required'  =>  "Grand Total is required",
            'delivery_address_id.required'  =>  "Delivery Address ID is required",
            'delivery_fee.required'  =>  "Delivery Fee is required",
            'expected_delivery_time.required'  =>  "Expected Delivery Time is required",
            'tip.required'  =>  "Tip is required",
        ];
    }
}
