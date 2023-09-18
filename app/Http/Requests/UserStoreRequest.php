<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'state_id' => 'required|integer',
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'state_id.required' => 'o campo state_id e obrigatorio',
            'state_id.integer'  => 'o campo state_id tem que ser do tipo integer',  
            'name.required'     => 'o campo name e obrigatorio',
            'name.string'       => 'o campo name tem que ser do tipo string',
            'name.max'          => 'o campo name tem que ter no maximo 255 caracteres',
            'email.required'    => 'o campo email e obrigatorio',
            'email.string'      => 'o campo email tem que ser do tipo string',
            'email.email'       => 'o campo email tem que ser do tipo email',
            'email.unique'      => 'este email ja esta em uso, escolha outro',
            'password.required' => 'o campo password e obrigatorio',
            'password.min'      => 'o campo password tem que ter no minimo 6 caracteres',
        ];
    }
}
