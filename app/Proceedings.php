<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proceedings extends Model
{
    const MISDEMEANOR = 'misdemeanor';
    const CRIMINAL = 'criminal';

    /**
     * Labels for Validity options.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function options()
    {
        return collect([
            self::MISDEMEANOR => __('labels.proceedings.misdemeanor'),
            self::CRIMINAL => __('labels.proceedings.criminal'),
        ]);
    }

    /**
     * Get labels for sexes.
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
     * @param string $label
     * @return string
     */
    public static function getValueFromLabel($label)
    {
        return self::options()->flip()->get($label);
    }

    /**
     * @param string $name
     * @return string
     */
    public static function getNameTranslationAttribute($name)
    {
        return trans('labels.proceedings.'.$name);
    }
}
