<?php

namespace App\Http\Requests;

use App\Rules\PhoneValidator;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'first_name' => ['required', 'string', 'max:20'],
            'last_name' => ['required', 'string', 'max:20'],
            'username' => ['required', 'unique:users', 'alpha_num', 'min:3', 'max:15'],
            'email' => ['required', 'unique:users', "email:filter"],
            'phone' => ['required', 'unique:users', new PhoneValidator],
            'password' => ['required', 'string'],
        ];
    }

    // update validations
    protected function updateRules()
    {
        $today = today()->format('Y-m-d');
        return [
            'first_name' => ['required', 'string', 'max:20'],
            'last_name' => ['required', 'string', 'max:20'],
            'email' => ['required', 'unique:users,email,'. $this->route('userId'), "email:filter"],
            'phone' => ['required', 'unique:users,phone,'. $this->route('userId'), new PhoneValidator],
        ];
    }

}
