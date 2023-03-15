<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StateStoreRequest extends FormRequest
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
            'name' => 'required|string',
            'slug' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'o campo name é obrigatorio',
            'name.string'   => 'o campo name tem que ser do tipo string',
            'slug.required' => 'o campo slug é obrigatorio',
            'slug.string'   => 'o campo slug tem que ser do tipo string',
        ];
    }
}
