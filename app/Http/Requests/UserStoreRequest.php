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
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|unique:users,email',
            'password' => 'required|string',
            'state_id' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'name.required'     => 'o campo name é obrigatorio',
            'name.string'       => 'o campo name tem que ser do tipo string',
            'name.max'          => 'o campo name tem que ter no maximo 255 caracteres',
            'email.required'    => 'o campo email é obrigatorio',
            'email.string'      => 'o campo email tem que ser do tipo string',
            'email.email'       => 'o campo email tem que ser do tipo email',
            'email.unique'      => 'este email já esta em uso, escolha outro',
            'password.required' => 'o campo password é obrigatorio',
            'password.string'   => 'o campo password tem que ser do tipo string',
            'state_id.required' => 'o campo state_id é obrigatorio',
            'state_id.integer'  => 'o campo state_id tem que ser do tipo integer',
        ];
    }
}
