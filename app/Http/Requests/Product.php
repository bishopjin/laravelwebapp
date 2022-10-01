<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Product extends FormRequest
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
            'inventory_item_brand_id' => ['required','numeric'],
            'inventory_item_size_id' => ['required', 'numeric'],
            'inventory_item_color_id' => ['required', 'numeric'],
            'inventory_item_type_id' => ['required', 'numeric'],
            'inventory_item_category_id' => ['required', 'numeric'],
            'price'=> ['required', 'numeric'],
        ];
    }
}
