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
            'name'      => 'required|string|unique:users',
            'email'     => 'string|email|unique:users,email',
            'password'  => 'required|string|confirmed',
        ];
    }

    public function messages()
    {
        return [
            'name.required'         => 'A username is required',
            'name.string'           => 'Username must be a string',
            'name.unique'           => 'Account already exists',

            'email.string'          => 'Email must be a string',
            'email.email'           => 'Email must be valid',
            'email.unique'          => 'An account with this email already exists',

            'password.required'     => 'Password is required',
            'password.string'       => 'Password must be a string',
            'password.confirmed'    => 'Your password fields must match',
        ];
    }
}
