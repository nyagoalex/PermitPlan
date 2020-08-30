<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DepartureTourRequest extends FormRequest
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
            'name' => "required|string|min:3|max:250",
            'arrival_date' => "required|date_format:Y-m-d|after_or_equal:$today",
            'departure_date' => "required|date_format:Y-m-d|after_or_equal:arrival_date",
        ];
    }
}
