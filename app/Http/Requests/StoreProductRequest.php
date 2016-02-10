<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreProductRequest extends Request
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
            'product_name' => 'required',
            'product_price' => 'required|integer',
            'long_description' => 'required',
            'short_description' => 'required',
            'meta_description' => 'required|max:155',
            'is_active' => 'boolean'
        ];
    }
}
