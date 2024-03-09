<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterUserRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string',
            'role' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'The name field is mandatory.',
            'email.required' => 'We need your email address.',
            'email.email' => 'Your email address must be valid.',
            'email.unique' => 'This email is already in use.',
            'password.required' => 'A password is required.',
            'role.required' => 'Please specify a role.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            $response = response()->json([
                'error' => $validator->errors()->first(),
            ], 422);

            throw new HttpResponseException($response);
        }
    }
}
