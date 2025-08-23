<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->user()->admin;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $this->route('user')->id],
            'password' => ['nullable', Password::min(8)->letters()->numbers()],
            'contract_starts_at' => ['nullable', 'date'],
            'can_access' => ['boolean'],
            'admin' => ['boolean'],
            'address' => ['nullable', 'string'],
            'amount' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'The email address is already taken.',
            'password' => 'The password must be at least 8 characters and contain letters and numbers.',
        ];
    }
}
