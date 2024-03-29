<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cites extends Model
{
    const I = 'appendix_I';
    const II = 'appendix_II';
    const III = 'appendix_III';

    /**
     * Labels for Validity options.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function options()
    {
        return collect([
            self::I => __('labels.cites.appendix_I'),
            self::II => __('labels.cites.appendix_II'),
            self::III => __('labels.cites.appendix_III'),
        ]);
    }

    /**
     * Get labels for cites.
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
        return trans('labels.cites.'.$name);
    }
}
