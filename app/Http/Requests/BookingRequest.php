<?php

namespace App\Http\Requests;

use App\Rules\AgentStatusValidator;
use Illuminate\Foundation\Http\FormRequest;

class BookingRequest extends FormRequest
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
            "ref" => 'required|alpha_dash|max:30',
            "agent_id" => ["required", "exists:agents,id", new AgentStatusValidator],
            "no_of_persons" => ["required", "integer", "min:1", "max:100"],
            "cost_per_person" => ["required", "numeric", "gte:0"],
            'arrival_date' => "required|date_format:Y-m-d|after_or_equal:$today",
            'departure_date' => "required|date_format:Y-m-d|after_or_equal:experience_since",
            'client_name' => "required|string"
        ];
    }
}
