<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'state_id' => 'integer',
            'name'     => 'string|max:255',
            'email'    => 'string|email|unique:users,email',
            'password' => 'min:6'
        ];
    }

    public function messages()
    {
        return [
            'state_id.integer'  => 'o campo state_id tem que ser do tipo integer',  
            'name.string'       => 'o campo name tem que ser do tipo string',
            'name.max'          => 'o campo name tem que ter no maximo 255 caracteres',
            'email.string'      => 'o campo email tem que ser do tipo string',
            'email.email'       => 'o campo email tem que ser do tipo email',
            'email.unique'      => 'este email ja esta em uso, escolha outro',
            'password.min'      => 'o campo password tem que ter no minimo 6 caracteres',
        ];
    }
}
