<?php

namespace App;

use Closure;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class License implements Arrayable
{
    const CC_BY_SA = 10;
    const OPEN = 11;
    const CC_BY_NC_SA = 20;
    const PARTIALLY_OPEN = 30;
    const CLOSED_FOR_A_PERIOD = 35;
    const CLOSED = 40;

    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $link;

    /**
     * @var Closure|bool
     */
    private $shouldHideRealCoordinates;

    /**
     * Constraint the query for field observations when this license is applied.
     *
     * @var Closure
     */
    private $fieldObservationConstraint;

    /**
     * List of attributes of the License object that can be set.
     *
     * @var array
     */
    protected $fillable = ['id', 'name', 'link', 'shouldHideRealCoordinates', 'fieldObservationConstraint'];

    /**
     * Constructor.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->fill($attributes);
    }

    /**
     * Fill the object attributes.
     *
     * @param array $attributes
     * @return void
     */
    public function fill(array $attributes)
    {
        collect($attributes)->filter(function ($value, $attribute) {
            return $this->isFillable($attribute);
        })->each(function ($value, $attribute) {
            $this->{$attribute} = $value;
        });
    }

    /**
     * Check if attribute is fillable.
     *
     * @param string $attribute
     * @return bool
     */
    protected function isFillable($attribute)
    {
        return in_array($attribute, $this->fillable);
    }

    /**
     * Get all licenses.
     *
     * @return Collection
     */
    public static function all()
    {
        return collect([
            new static([
                'id' => self::CC_BY_SA,
                'name' => 'CC BY-SA 4.0',
                'link' => 'https://creativecommons.org/licenses/by-sa/4.0/',
                'shouldHideRealCoordinates' => false,
                'fieldObservationConstraint' => function ($query) {
                    $query->where('license', static::CC_BY_SA);
                },
            ]),
            new static([
                'id' => self::OPEN,
                'name' => 'Open',
                'link' => 'https://creativecommons.org/licenses/by-sa/4.0/',
                'shouldHideRealCoordinates' => false,
                'fieldObservationConstraint' => function ($query) {
                    $query->where('license', static::OPEN);
                },
            ]),
            new static([
                'id' => self::CC_BY_NC_SA,
                'name' => 'CC BY-NC-SA 4.0',
                'link' => 'https://creativecommons.org/licenses/by-nc-sa/4.0/',
                'shouldHideRealCoordinates' => false,
                'fieldObservationConstraint' => function ($query) {
                    $query->where('license', static::CC_BY_NC_SA);
                },
            ]),
            new static([
                'id' => self::PARTIALLY_OPEN,
                'name' => 'Partially open',
                'link' => config('app.url').'/licenses/partially-open-license',
                'shouldHideRealCoordinates' => true,
                'fieldObservationConstraint' => function ($query) {
                    $query->where('license', static::PARTIALLY_OPEN);
                },
            ]),
            new static([
                'id' => self::CLOSED_FOR_A_PERIOD,
                'name' => 'Closed for a period',
                'link' => '',
                'shouldHideRealCoordinates' => true,
                'fieldObservationConstraint' => function ($query) {
                    $query->where('license', static::CLOSED_FOR_A_PERIOD)
                        ->where('field_observations.created_at', '<', now()->subYear(config('biologer.license_closed_period')));
                },
            ]),
            new static([
                'id' => self::CLOSED,
                'name' => 'Closed',
                'link' => config('app.url').'/licenses/closed-license',
                'shouldHideRealCoordinates' => true,
                'fieldObservationConstraint' => function ($query) {
                    $query->where('license', static::CLOSED)->whereRaw('0=1');
                },
            ]),
        ]);
    }

    /**
     * Get all active licenses.
     *
     * @return Collection
     */
    public static function allActive()
    {
        return self::all()->whereIn('id', config('biologer.active_licenses'))->values();
    }

    /**
     * List of available licenses.
     *
     * @return array
     */
    public static function getOptions()
    {
        return self::allActive()->mapWithKeys(function ($license) {
            return [$license->id => $license->name()];
        })->all();
    }

    /**
     * Get license IDs.
     *
     * @return Collection
     */
    public static function ids()
    {
        return self::all()->pluck('id');
    }

    /**
     * Get active license IDs.
     *
     * @return Collection
     */
    public static function activeIds()
    {
        return self::allActive()->pluck('id');
    }

    /**
     * Get ID of the first license.
     *
     * @return int
     */
    public static function firstId()
    {
        return self::activeIds()->first();
    }

    /**
     * Get first license info.
     *
     * @return self
     */
    public static function first()
    {
        return self::allActive()->first();
    }

    /**
     * Find license by given ID.
     *
     * @param int $id
     * @return self|null
     */
    public static function findById($id)
    {
        return self::allActive()->where('id', $id)->first();
    }

    /**
     * Find license by given name.
     *
     * @param string $name
     * @return self|null
     */
    public static function findByName($name)
    {
        return self::allActive()->where('name', $name)->first();
    }

    /**
     * Get name translation.
     *
     * @return string
     */
    public function name()
    {
        return trans('licenses.'.$this->id);
    }

    /**
     * Check if real coordinates should be hidden based on license.
     *
     * @return bool
     */
    public function shouldHideRealCoordinates()
    {
        return $this->shouldHideRealCoordinates;
    }

    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name(),
            'link' => $this->link,
        ];
    }

    /**
     * Check if license is enabled.
     *
     * @param int $licenseId
     * @return bool
     */
    public static function isEnabled($licenseId)
    {
        return self::activeIds()->contains($licenseId);
    }

    /**
     * Apply constraints to field observations query depending on the license.
     *
     * @param Builder $query
     * @return Builder
     */
    public static function applyConstraintsToFieldObservations($query)
    {
        return $query->where(function ($query) {
            foreach (static::all() as $license) {
                $query->orWhere($license->fieldObservationConstraint);
            }
        });
    }

    /**
     * Labels for Validity options.
     *
     * @return Collection
     */
    public static function options()
    {
        return collect([
            self::CC_BY_SA => __('licenses.'.self::CC_BY_SA),
            self::OPEN => __('licenses.'.self::OPEN),
            self::CC_BY_NC_SA => __('licenses.'.self::CC_BY_NC_SA),
            self::PARTIALLY_OPEN => __('licenses.'.self::PARTIALLY_OPEN),
            self::CLOSED_FOR_A_PERIOD => __('licenses.'.self::CLOSED_FOR_A_PERIOD),
            self::CLOSED => __('licenses.'.self::CLOSED),
        ]);
    }

    /**
     * Get labels for licenses.
     *
     * @return Collection
     */
    public static function labels()
    {
        return self::options()->values();
    }

    /**
     * Get value based on label.
     *
     * @param string $label
     * @return int
     */
    public static function getValueFromLabel($label)
    {
        return self::options()->flip()->get($label);
    }
}
