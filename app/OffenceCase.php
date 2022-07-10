<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OffenceCase extends Model
{
    const KILLING = 'killing';
    const CATCHING = 'catching';
    const POISONING = 'poisoning';
    const OWNING = 'owning';
    const TRADING = 'trading';

    protected $hidden = [
        'created_at', 'updated_at',
    ];

    protected $fillable = ['name'];

    /**
     * Labels for Validity options.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function options()
    {
        return collect([
            self::KILLING => __('labels.offence_cases.killing'),
            self::CATCHING => __('labels.offence_cases.catching'),
            self::POISONING => __('labels.offence_cases.poisoning'),
            self::OWNING => __('labels.offence_cases.owning'),
            self::TRADING => __('labels.offence_cases.trading'),
        ]);
    }

    /**
     * Get labels for cases.
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
     */
    public static function getValueFromLabel($label)
    {
        return self::options()->flip()->get($label);
    }

    /**
     * Convert the model instance to an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }

    /**
     * Serialize field observation to a flat array.
     * Mostly used for the frontend and diffing.
     *
     * @return array
     */
    public function toFlatArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
