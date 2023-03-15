<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertiseUpdateRequest extends FormRequest
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
            'user_id'       => 'integer',
            'state_id'      => 'integer',
            'category_id'   => 'integer',
            'title'         => 'string|max:255',
            'price'         => 'numeric',
            'is_negotiable' => 'boolean',
            'description'   => 'string|max:255',
            'views'         => 'integer',
        ];
    }

    public function messages()
    {
        return [
            'user_id.integer'       => 'o campo user_id tem que ser do tipo integer',
            'state_id.integer'      => 'o campo state_id tem que ser do tipo integer',
            'category_id.integer'   => 'o campo category_id tem que ser do tipo integer',
            'title.string'          => 'o campo title tem que ser do tipo string',
            'title.max'             => 'o campo title tem que ter no maximo 255 caracteres',
            'price.numeric'         => 'o campo price tem que ser um tipo numérico',
            'is_negotiable.boolean' => 'o campo is_negotiable tem que ser do tipo booleano',
            'description.string'    => 'o campo description tem que ser do tipo string',
            'description.max'       => 'o campo description tem que ter no maximo 255 caracteres',
            'views.integer'         => 'o campo views tem que ser do tipo integer',
        ];
    }
}
