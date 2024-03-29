<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SoundClipRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        switch ($this->getMethod()) {
            case "POST":
                return $this->postRules();
                break;
            case "PATCH":
                return $this->patchRules();
                break;
        }
    }
    
    private function postRules()
    {
        return [
            'name'      => 'required|string',
        ];
    }

    private function patchRules()
    {
        return [
            'name'      => 'string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required',
            'name.string'   => 'Name must be a string',
        ];
    }
}
