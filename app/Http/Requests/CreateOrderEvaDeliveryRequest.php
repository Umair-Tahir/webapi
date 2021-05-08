<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderEvaDeliveryRequest extends FormRequest
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
            'grand_total' => 'required',
            "delivery_address_id" => 'required',
            "delivery_fee" => 'required',
            'expected_delivery_time' => 'required',
            "distance" => 'required',
            "total_charges_plus_tax" => 'required',
            "delivery_tax" => 'required',
            "tip" => 'required',

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
            'distance.required'  =>  "Distance is required",
            'total_charges_plus_tax.required'  =>  "Total Charges Plus tax of Delivery service is required",
            'delivery_tax.required'  =>  "Delivery Tax is required",
            'tip.required'  =>  "Tip is required",
        ];
    }
}
