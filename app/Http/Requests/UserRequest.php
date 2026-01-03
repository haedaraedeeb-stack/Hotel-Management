<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; 
    }

    public function rules(): array
    {
        $id = $this->route('user');

        return [
            'name' => ['required','string','max:255'],
            'email' => ['required','email', Rule::unique('users','email')->ignore($id)],
            'password' => $id ? ['nullable','min:6'] : ['required','min:6'],
            'role' => ['required','string'], // مدير فندق أو موظف استقبال
        ];
    }
}
