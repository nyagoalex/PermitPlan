<?php

namespace App\Http\Requests;

use App\Rules\PhoneValidator;
use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
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
            "company_name" => 'required|string|max:100',
            "physical_address" => 'required|string|max:45',
            "permit_expiry_in_days" => 'required|integer|max:100',
            "registration_no" => 'required|string|max:45',
            "email" => ['nullable', "email:filter"],
            "phone" => ['required', new PhoneValidator],
            "website" => ['nullable', 'url'],
        ];
    }
}
