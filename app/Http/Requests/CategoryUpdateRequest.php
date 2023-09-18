<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'  => 'max:255|string|in:brinquedos,smartphones,casa,moda,eletrodomesticos',
            'slug'  => 'max:255|string',
            'image' => 'string',
        ];
    }

    public function messages()
    {
        return [
            'name.max'        => 'o campo name tem que ter no maximo 255 caracteres',
            'name.string'     => 'o campo name tem que ser do tipo string',
            'name.in'         => 'o campo name tem que ser brinquedos, smartphones, casa, moda ou eletrodomesticos,',
            'slug.max'        => 'o campo slug tem que ter no maximo 255 caracteres',
            'slug.string'     => 'o campo slug tem que ser do tipo string',
            'image.string'    => 'o campo image tem que ser do tipo string'
        ];
    }
}
