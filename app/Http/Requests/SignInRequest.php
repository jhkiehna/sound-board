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
            'name'      => 'required|string',
            'password'  => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required'        => 'Username is required',
            'name.string'          => 'Username must be a string',

            'password.required'     => 'Password is required',
            'password.string'       => 'Password must be a string',
        ];
    }
}
