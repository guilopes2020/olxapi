<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategoryStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|max:255|string|in:brinquedos,smartphones,casa,moda,eletrodomesticos',
            'slug'  => 'required|max:255|string',
            'image' => 'string',
        ];
    }

    public function messages()
    {
        return [
            'name.required'   => 'o campo name é obrigatorio',
            'name.max'        => 'o campo name tem que ter no maximo 255 caracteres',
            'name.string'     => 'o campo name tem que ser do tipo string',
            'name.in'         => 'o campo name tem que ser brinquedos, smartphones, casa, moda ou eletrodomesticos,',
            'slug.required'   => 'o campo slug é obrigatorio',
            'slug.max'        => 'o campo slug tem que ter no maximo 255 caracteres',
            'slug.string'     => 'o campo slug tem que ser do tipo string',
            'image.string'    => 'o campo image tem que ser do tipo string'
        ];
    }
}
