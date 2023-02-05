<?php

namespace App\Http\Requests\auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'email is required.',
            'email.string' => 'email must be string.',
            'email.email' => 'invalid email format.',
            'password.required' => 'password is required.',
            'password.string' => 'password must be string.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
         throw new HttpResponseException(response()->json([
             'success' => false,
             'message' => 'Validation Errors',
             'data' => $validator->errors(),
        ]));
    }
}
