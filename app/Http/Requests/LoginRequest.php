<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  // Set this to "true" else Unauthorized error will be thrown
    }

    public function rules()
    {
        return [
            'email'     => ['required', 'string','email'],
            'password'  => ['required', 'string'],
        ];
    }
}
