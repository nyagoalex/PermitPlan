<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PermitRequest extends FormRequest
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
            "permit_type_id" => ["required", "exists:permit_types,id"],
            "sector_id" => ["required", "exists:sectors,id"],
            "cost" => ["required", "numeric", "gte:0"],
            'tracking_date' => "required|date_format:Y-m-d|after_or_equal:$today"
        ];
    }
}
