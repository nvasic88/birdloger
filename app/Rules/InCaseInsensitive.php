<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class InCaseInsensitive implements Rule
{
    /**
     * The name of the rule.
     */
    protected string $rule = 'inCaseInsensitive';

    /**
     * The accepted values.
     *
     * @var array
     */
    protected array $values;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $value = strtolower($value);

        $values = array_map(function ($rule_value) {
            return strtolower($rule_value);
        }, $this->values);

        return in_array($value, $values);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Value not allowed.';
    }
}
