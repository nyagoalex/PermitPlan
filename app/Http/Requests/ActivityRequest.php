<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
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
            'name' => "required|string|min:3|max:250",
            'location' => "required|string|min:3|max:250",
            "cost_per_person" => ["required", "numeric", "gte:0"],
            'description' => "nullable|string",
        ];
    }
}
