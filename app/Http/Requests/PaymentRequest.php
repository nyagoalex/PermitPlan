<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PaymentRequest extends FormRequest
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
            "amount" => ["required", "numeric", "gte:0"],
            'date' => "required|date_format:Y-m-d|before_or_equal:$today",
            "method" => 'required|in:cash,bank_transfer,credit_card,cheque,complementary',
            "cheque_no" => "nullable|required_if:method,cheque|unique:payments|digits_between:0,20",
            "ref_no" => "nullable|required_if:method,bank_transfer|digits_between:0,20",
        ];
    }
}