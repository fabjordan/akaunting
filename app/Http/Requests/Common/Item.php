<?php

namespace App\Http\Requests\Common;

use App\Abstracts\Http\FormRequest;

class Item extends FormRequest
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
        $picture = 'nullable';

        if ($this->request->get('picture', null)) {
            $picture = 'mimes:' . config('filesystems.mimes') . '|between:0,' . config('filesystems.max_size') * 1024;
        }

        return [
            'name' => 'required|string',
            'sale_price' => 'required',
            'purchase_price' => 'required',
            'tax_id' => 'nullable|integer',
            'category_id' => 'nullable|integer',
            'enabled' => 'integer|boolean',
            'picture' => $picture,
            'quantity' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'O Nome é obrigatório.',
            'name.string' => 'O Nome deve conter o formato de texto.',
            'sale_price.required' => 'O Preço de Venda é obrigatório.',
            'purchase_price.required' => 'O Preço de Compra é obrigatório.',
            'quantity.required' => 'A Quantidade é obrigatória.',
        ];
    }
}
