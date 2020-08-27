<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GuestRequest extends FormRequest
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
        $today = today()->format('Y-m-d');
        return [
            'first_name' => ['required', 'string', 'max:20'],
            'last_name' => ['required', 'string', 'max:20'],
            'dob' => "required|date_format:Y-m-d|before_or_equal:$today",
            'nationality' => "required|string|min:3|max:250",
            'passport' => "required|alpha_dash|min:3|max:100",
        ];
    }
}
