<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SignInRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email'     => 'required|string',
            'password'  => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required'        => 'Email is required',
            'email.string'          => 'Email must be a string',

            'password.required'     => 'Password is required',
            'password.string'       => 'Password must be a string',
        ];
    }
}
