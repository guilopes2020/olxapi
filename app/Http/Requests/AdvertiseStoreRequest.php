<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertiseStoreRequest extends FormRequest
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
            'user_id'       => 'required|integer',
            'state_id'      => 'required|integer',
            'category_id'   => 'required|integer',
            'title'         => 'required|string|max:255',
            'price'         => 'required|numeric',
            'is_negotiable' => 'required|boolean',
            'description'   => 'string|max:255',
            'views'         => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'user_id.required'      => 'o campo user_id é obrigatorio',
            'user_id.integer'       => 'o campo user_id tem que ser do tipo integer',
            'state_id.required'     => 'o campo state_id é obrigatorio',
            'state_id.integer'      => 'o campo state_id tem que ser do tipo integer',
            'category_id.required'  => 'o campo category_id é obrigatorio',
            'category_id.integer'   => 'o campo category_id tem que ser do tipo integer',
            'title.required'        => 'o campo title é obrigatorio',
            'title.string'          => 'o campo title tem que ser do tipo string',
            'title.max'             => 'o campo title tem que ter no maximo 255 caracteres',
            'price.required'        => 'o campo price é obrigatorio',
            'price.numeric'         => 'o campo price tem que ser um tipo numérico',
            'is_negotiable'         => 'o campo is_negotiable é obrigatorio',
            'is_negotiable.boolean' => 'o campo is_negotiable tem que ser do tipo booleano',
            'description.string'    => 'o campo description tem que ser do tipo string',
            'description.max'       => 'o campo description tem que ter no maximo 255 caracteres',
            'views.required'        => 'o campo views é obrigatorio',
            'views.integer'         => 'o campo views tem que ser do tipo integer',
        ];
    }
}
