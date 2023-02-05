<?php

namespace App\Http\Requests\auth;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }


    public function messages()
    {
        return [
            'name.required' => 'username is required.',
            'name.string' => 'username must be string.',
            'name.max' => 'username must be maximum 255 characters.',
            'email.required' => 'email is required.',
            'email.string' => 'email must be string.',
            'email.email' => 'invalid email format.',
            'email.max' => 'email must be maximum 255 characters.',
            'email.unique' => 'email must be unique.',
            'password.required' => 'password is required.',
            'password.string' => 'password must be string.',
            'password.min' => 'password must be minimum 6 characters.',
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
