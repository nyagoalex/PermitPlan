<?php

namespace App\Rules;

use App\Models\Agent;
use Illuminate\Contracts\Validation\Rule;

class AgentStatusValidator implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // Validates status
        #Validate rule if exsist
        $rule_value = Agent::find($value);
        if (!$rule_value) {
            return false;
        }
        return $rule_value->active;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return   "Agent Not Active";
    }
}
