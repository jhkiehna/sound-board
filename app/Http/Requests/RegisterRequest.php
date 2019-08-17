<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'     => 'required|string|email|unique:users,email',
            'password'  => 'required|string|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'email.required'        => 'Email is required',
            'email.string'          => 'Email must be a string',
            'email.email'           => 'Email must be valid',
            'email.unique'          => 'Account already exists',

            'password.required'     => 'Password is required',
            'password.string'       => 'Password must be a string',
            'password.confirmed'    => 'Your password fields must match',
        ];
    }
}
