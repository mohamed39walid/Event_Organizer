<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            "fname" => "required|min:3",
            "lname" => "required|min:3",
            "username" => "required|min:3|unique:users,username",
            "email" => "required|unique:users,email|email",
            'password' => 'required|string|min:8|confirmed',
            "role" => "required",
        ];
    }
}
