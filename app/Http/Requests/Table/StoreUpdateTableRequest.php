<?php

namespace App\Http\Requests\Table;

use Illuminate\Foundation\Http\FormRequest;

class StoreUpdateTableRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Název je povinný',
            'name.string' => 'Název musí být řetězec',
            'name.max' => 'Název může mít maximálně 255 znaků',
            'capacity.required' => 'Počet míst je povinné',
            'capacity.integer' => 'Počet míst musí být celé číslo',
            'capacity.min' => 'Počet míst musí být minimálně 1',
        ];
    }
}
