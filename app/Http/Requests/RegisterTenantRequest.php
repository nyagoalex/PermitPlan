<?php

namespace App\Http\Requests;

use App\Rules\PhoneValidator;
use Illuminate\Foundation\Http\FormRequest;

class RegisterTenantRequest extends FormRequest
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
            "company_name" => 'required|alpha|max:100|unique:tenants,id',
            "first_name" => 'required|string|max:100',
            "last_name" => 'required|string|max:100',
            "username" => 'required|alpha_dash|max:100',
            "email" => ['required', "email:filter"],
            "password" => ['required', "confirmed", "alpha_num"]
        ];
    }
}
