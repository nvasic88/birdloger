<?php

namespace App\Rules;

use App\PoachingObservation;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Arr;

class ApprovablePoachingObservation implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return PoachingObservation::approvable()
            ->whereIn('id', Arr::wrap($value))
            ->count() > 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.field_observation_cannot_be_approved');
    }
}
