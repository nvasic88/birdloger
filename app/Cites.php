<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cites extends Model
{
    const I = '1';
    const II = '2';
    const III = '3';

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
     * @return void
     */
    public static function getValueFromLabel($label)
    {
        return self::options()->flip()->get($label);
    }
}
