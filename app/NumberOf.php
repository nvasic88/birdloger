<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NumberOf extends Model
{
    const INDIVIDUAL = 'individual';
    const COUPLE = 'couple';
    const SINGING_MALE = 'singing_male';
    const ACTIVE_NEST = 'active_nest';
    const FAMILY_WITH_CUBS = 'family_with_cubs';

    /**
     * Labels for Validity options.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function options()
    {
        return collect([
            self::INDIVIDUAL => __('labels.number_of.individual'),
            self::COUPLE => __('labels.number_of.couple'),
            self::SINGING_MALE => __('labels.number_of.singing_male'),
            self::ACTIVE_NEST => __('labels.number_of.active_nest'),
            self::FAMILY_WITH_CUBS => __('labels.number_of.family_with_cubs'),
        ]);
    }

    /**
     * Get labels for number of.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function labels()
    {
        return self::options()->values();
    }

    /**
     * Get value based on label.
     *
     * @param  string  $label
     * @return void
     */
    public static function getValueFromLabel($label)
    {
        return self::options()->flip()->get($label);
    }
}
