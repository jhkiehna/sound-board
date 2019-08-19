<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SoundClipUploadRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'audioFile' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'audioFile.required'    => 'An audio file is required',
            'audioFile.string'      => 'Audio file must be sent base64 encoded',
        ];
    }
}
