<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Email je povinný údaj',
            'email.email' => 'Email musí být ve správném formátu',
            'email.unique' => 'Uživatel s tímto emailem již existuje',
            'password.required' => 'Heslo je povinný údaj',
            'password.string' => 'Heslo musí být text',
            'password.min' => 'Heslo musí mít alespoň :min znaků',
            'password.confirmed' => 'Hesla se neshodují',
        ];
    }
}
