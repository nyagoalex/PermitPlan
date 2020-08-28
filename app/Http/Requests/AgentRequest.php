<?php

namespace App\Http\Requests;

use App\Rules\PhoneValidator;
use Illuminate\Foundation\Http\FormRequest;

class AgentRequest extends FormRequest
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
        // check validation for either creating or updating user
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('patch')) {
            return $this->updateRules();
        }
        return [];
    }

    // create validations
    protected function createRules()
    {
        return [
            'name' => "required|string|min:3|max:250",
            // 'code' => "required|alpha_dash|min:3|max:250|unique:agents",
            'country' => "required|string|min:3|max:250",
            'city' => "required|string|min:3|max:250",
            'email' => "nullable|email:filter",
            "phone" => ['required', new PhoneValidator, 'unique:agents']
        ];
    }

    // update validations
    protected function updateRules()
    {
        return [
            'name' => "required|string|min:3|max:250",
            // 'code' => "required|alpha_dash|min:3|max:250|unique:agents,code,". $this->route('agent_id'),
            'country' => "required|string|min:3|max:250",
            'city' => "required|string|min:3|max:250",
            'email' => "nullable|email:filter",
            "phone" => ['required', new PhoneValidator, 'unique:agents,phone,'. $this->route('agent_id')]
        ];
    }

}
