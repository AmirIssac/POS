<?php

namespace App\Http\Requests;

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
                'barcode' => 'required',
                'name' => 'required',
                'details' => 'required',
                'price' => 'required',
                'quantity' => 'required',
        ];
    }
    public function messages()
{
    return [
        'barcode.required' => 'ادخال رمز الباركود مطلوب',
        'name.required' => 'ادخال الاسم مطلوب',
        'details.required' => 'ادخال تفاصيل المنتج مطلوب',
        'price.required' => 'ادخال السعر مطلوب',
        'quantity.required' => 'ادخال الكمية مطلوب',
    ];
}
}
