<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'product_name'=>'required',
            'price'=>'required| numeric',
            'quantity'=>'required | numeric | min:0',
            'description'=>'required',
            'category_id'=>'required',
            'user_id'=>'required',
            'picture'=>'required | image| mimes:jpg,jpeg,png,bmp,gif | max:2000',
        ];
    }
}
