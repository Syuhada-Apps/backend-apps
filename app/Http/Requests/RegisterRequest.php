<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|unique:users|min:5|max:15',
            'password' => 'required|min:8|max:20',
            'firstname' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phone_number' => 'required|numeric|unique:users'
        ];
    }

    use ApiResponse;
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            $this->errorValidationResponse($validator->errors())
        );
    }
}
