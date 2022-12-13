<?php

namespace App\Importing;

use App\Annex;
use App\DEM\Reader as DEMReader;
use App\Support\Localization;
use App\Synonym;
use App\Taxon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class TaxonImport extends BaseImport
{
    /**
     * @var \App\DEM\Reader
     */
    protected $demReader;

    /**
     * Create new importer instance.
     *
     * @param  \App\Import  $import
     * @param  \App\DEM\Reader  $demReader
     * @return void
     */
    public function __construct($import, DEMReader $demReader)
    {
        parent::__construct($import);

        $this->setDEMReader($demReader);
    }

    /**
     * Set DEM reader instance to get missing elevation.
     *
     * @param  \App\DEM\Reader  $demReader
     * @return self
     */
    public function setDEMReader(DEMReader $demReader)
    {
        $this->demReader = $demReader;

        return $this;
    }

    /**
     * Definition of all calumns with their labels.
     *
     * @param  \App\User|null  $user
     * @return \Illuminate\Support\Collection
     */
    public static function columns($user = null)
    {
        $locales = collect(LaravelLocalization::getSupportedLocales())->reverse();

        return collect([
            [
                'label' => trans('labels.id'),
                'value' => 'id',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.type'),
                'value' => 'type',
                'required' => true,
            ],
            [
                'label' => trans('labels.taxa.spid'),
                'value' => 'spid',
                'required' => true,
            ],
            [
                'label' => trans('labels.taxa.name'),
                'value' => 'name',
                'required' => true,
            ],
            [
                'label' => trans('taxonomy.order'),
                'value' => 'order',
                'required' => true,
            ],
            [
                'label' => trans('taxonomy.family'),
                'value' => 'family',
                'required' => true,
            ],
            [
                'label' => trans('labels.taxa.synonyms'),
                'value' => 'synonyms',
                'required' => false,
            ],
        ])->concat($locales->map(function ($locale, $localeCode) {
            $nativeName = trans('labels.taxa.native_name');
            $localeTranslation = trans('languages.'.$locale['name']);

            return [
                'label' => "{$nativeName} - {$localeTranslation}",
                'value' => 'native_name_'.Str::snake($localeCode),
                'required' => false,
            ];
        }))->concat([
            [
                'label' => trans('labels.taxa.strictly_protected'),
                'value' => 'strictly_protected',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.strictly_note'),
                'value' => 'strictly_note',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.protected'),
                'value' => 'protected',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.protected_note'),
                'value' => 'protected_note',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.iucn_cat'),
                'value' => 'iucn_cat',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.birdlife_seq'),
                'value' => 'birdlife_seq',
                'required' => true,
            ],
            [
                'label' => trans('labels.taxa.birdlife_id'),
                'value' => 'birdlife_id',
                'required' => true,
            ],
            [
                'label' => trans('labels.taxa.ebba_code'),
                'value' => 'ebba_code',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.euring_code'),
                'value' => 'euring_code',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.euring_sci_name'),
                'value' => 'euring_sci_name',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.eunis_n2000code'),
                'value' => 'eunis_n2000code',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.eunis_sci_name'),
                'value' => 'eunis_sci_name',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.refer'),
                'value' => 'refer',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.prior'),
                'value' => 'prior',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.annex'),
                'value' => 'annexes',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.gn_status'),
                'value' => 'gn_status',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.bioras_sci_name'),
                'value' => 'bioras_sci_name',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.full_sci_name'),
                'value' => 'full_sci_name',
                'required' => false,
            ],
            [
                'label' => trans('labels.taxa.author'),
                'value' => 'author',
                'required' => false,
            ],
        ])->pipe(function ($columns) use ($user) {
            if (! $user || optional($user)->hasAnyRole(['admin', 'curator'])) {
                return $columns;
            }
        });
    }

    public function generateErrorsRoute()
    {
        return route('api.taxon-imports.errors', $this->model());
    }

    /**
     * Make validator instance.
     *
     * @param  array  $data
     */
    protected function makeValidator(array $data)
    {
        $locales = collect(LaravelLocalization::getSupportedLocales())->reverse();

        return Validator::make($data, [
            'type' => [
                'required',
                Rule::in(['RS', 'WP']),
            ],
            'spid' => ['required', 'string', Rule::unique('taxa', 'spid')],
            'name' => ['required', 'string'],
            'order' => ['required', 'string'],
            'family' => ['required', 'string'],
            'synonyms' => ['nullable', 'string'],
            $locales->map(function ($locale) {
                $nativeName = trans('labels.taxa.native_name');
                $localeTranslation = trans('languages.'.$locale['name']);

                return [
                    "{$nativeName} - {$localeTranslation}" => ['nullable', 'string'],
                ];
            }),
            'strictly_protected' => ['nullable', 'string', Rule::in($this->yesNo())],
            'strictly_note' => ['nullable', 'string'],
            'protected' => ['nullable', 'string', Rule::in($this->yesNo())],
            'protected_note' => ['nullable', 'string'],
            'iucn_cat' => ['nullable', 'string', Rule::in(['EX', 'EW', 'CR', 'EN', 'VU', 'NT', 'LC', 'DD', 'NE', 'NR'])],
            'birdlife_seq' => ['required', 'integer', 'min:1'],
            'birdlife_id' => ['required', 'integer', 'min:1'],
            'ebba_code' => ['nullable'],
            'euring_code' => ['nullable'],
            'euring_sci_name' => ['nullable', 'string'],
            'eunis_n2000code' => ['nullable', 'string'],
            'eunis_sci_name' => ['nullable', 'string'],
            'bioras_sci_name' => ['nullable', 'string'],
            'refer' => ['nullable', 'string', Rule::in($this->yesNo())],
            'prior' => ['nullable', 'string', Rule::in($this->yesNo())],
            'annexes' => ['nullable'],
            'gn_status' => ['nullable', 'string', Rule::in(['I', 'IG', 'NG', 'G0', 'G', 'G*'])],
            'full_sci_name' => ['nullable', 'string'],
            'author' => ['nullable', 'string'],
        ], [
            'type' => trans('labels.taxa.type'),
            'spid' => trans('labels.taxa.spid'),
            'order' => trans('taxonomy.order'),
            'family' => trans('taxonomy.family'),
            'synonyms' => trans('labels.taxa.synonyms'),

            'strictly_protected' => trans('labels.taxa.strictly_protected'),
            'strictly_note' => trans('labels.taxa.strictly_note'),
            'protected' => trans('labels.taxa.protected'),
            'protected_note' => trans('labels.taxa.protected_note'),
            'iucn_cat' => trans('labels.taxa.iucn_cat'),
            'birdlife_seq' => trans('labels.taxa.birdlife_seq'),
            'birdlife_id' => trans('labels.taxa.birdlife_id'),
            'ebba_code' => trans('labels.taxa.ebba_code'),
            'euring_code' => trans('labels.taxa.euring_code'),
            'euring_sci_name' => trans('labels.taxa.euring_sci_name'),
            'eunis_n2000code' => trans('labels.taxa.eunis_n2000code'),
            'eunis_sci_name' => trans('labels.taxa.eunis_sci_name'),
            'refer' => trans('labels.taxa.refer'),
            'prior' => trans('labels.taxa.prior'),
            'annex' => trans('labels.taxa.annex'),
            'gn_status' => trans('labels.taxa.gn_status'),
            'bioras_sci_name' => trans('labels.taxa.bioras_sci_name'),
            'full_sci_name' => trans('labels.taxa.full_sci_name'),
            'author' => trans('labels.taxa.author'),
        ]);
    }

    /**
     * "Yes" and "No" options translated in language the import is using.
     *
     * @return array
     */
    protected function yesNo()
    {
        $lang = $this->model()->lang;

        return [__('Yes', [], $lang), __('No', [], $lang)];
    }

    /**
     * Store data from single CSV row.
     *
     * @param  array  $item
     * @return void
     */
    protected function storeSingleItem(array $item)
    {
        $taxon = Taxon::create(
            array_merge(
                $this->getTaxonData($item),
                Localization::transformTranslations($this->getLocaleData($item))
            )
        );
        $this->createSynonyms($item, $taxon);
        $taxon->annexes()->sync($this->getAnnexes($item), []);
    }

    /**
     * Get general observation data from the request.
     *
     * @param  array  $item
     * @return array
     */
    protected function getTaxonData(array $item)
    {
        return [
            'name' => ucwords(strtolower(Arr::get($item, 'name'))),
            'spid' => Arr::get($item, 'spid'),
            'type' => Arr::get($item, 'type'),
            'parent_id' => $this->getOrCreateParentID($item),
            'strictly_protected' => $this->getBoolean($item, 'strictly_protected'),
            'strictly_note' => Arr::get($item, 'strictly_note') ?: null,
            'protected' => $this->getBoolean($item, 'protected'),
            'protected_note' => Arr::get($item, 'protected_note') ?: null,
            'iucn_cat' => Arr::get($item, 'iucn_cat') ?: null,
            'birdlife_seq' => Arr::get($item, 'birdlife_seq'),
            'birdlife_id' => Arr::get($item, 'birdlife_id'),
            'ebba_code' => Arr::get($item, 'ebba_code') ?: null,
            'euring_code' => Arr::get($item, 'euring_code') ?: null,
            'euring_sci_name' => Arr::get($item, 'euring_sci_name') ?: null,
            'eunis_n2000code' => Arr::get($item, 'eunis_n2000code') ?: null,
            'eunis_sci_name' => Arr::get($item, 'eunis_sci_name') ?: null,
            'refer' => $this->getBoolean($item, 'refer'),
            'prior' => $this->getBoolean($item, 'prior'),
            'gn_status' => Arr::get($item, 'gn_status') ?: null,
            'bioras_sci_name' => Arr::get($item, 'bioras_sci_name') ?: null,
            'full_sci_name' => Arr::get($item, 'full_sci_name') ?: null,
            'author' => Arr::get($item, 'author') ?: null,
            'rank' => 'species',
        ];
    }

    /**
     * Check if the value matches with "Yes" translation.
     *
     * @param string $value
     * @return bool
     */
    protected function isTranslatedYes($value)
    {
        if (! is_string($value)) {
            return false;
        }

        $yes = __('Yes', [], $this->model()->lang);

        return strtolower($yes) === strtolower($value);
    }

    private function getOrCreateParentID(array $item)
    {
        $oname = trim(Arr::get($item, 'order'));
        $order = Taxon::firstOrCreate(
            ['name' => ucwords(strtolower($oname))],
            [
                'name' => ucwords(strtolower($oname)),
                'rank' => 'order',
                'rank_level' => 40,
                'parent_id' => 5, # 5 is Aves class by TaxaSeeder
                'author' => null,
                'type' => null,
                'spid' => null,
            ]
        );
        $order->save();

        $fname = trim(Arr::get($item, 'family'));
        $family = Taxon::firstOrCreate(
            ['name' => ucwords(strtolower($fname))],
            [
                'name' => ucwords(strtolower($fname)),
                'rank' => 'family',
                'rank_level' => 30,
                'parent_id' => $order->id,
                'author' => null,
                'type' => null,
                'spid' => null,
            ]
        );
        $family->save();

        return $family->id;
    }

    private function createSynonyms(array $item, $taxon)
    {
        $synonym_names = Arr::get($item, 'synonyms');
        if (! $synonym_names) {
            return;
        }

        foreach (explode('; ', $synonym_names) as $name) {
            $synonym = Synonym::firstOrCreate([
                'name' => $name,
                'taxon_id' => $taxon->id,
            ]);
            $synonym->save();
        }
    }

    private function getLocaleData($item)
    {
        $locales = collect(LaravelLocalization::getSupportedLocales())->reverse();
        $localesData['native_name'] = [];
        foreach ($locales as $localeCode => $locale) {
            $localesData['native_name'][$localeCode] = Arr::get($item, 'native_name_'.Str::snake($localeCode));
        }

        return $localesData;
    }

    private function getAnnexes(array $item)
    {
        $annexes = Arr::get($item, 'annexes');
        $annexes_ids = [];
        if (! $annexes) {
            return;
        }
        foreach (explode('; ', $annexes) as $annex) {
            $annexes_ids[] = Annex::where('name', $annex)->first()->id;
        }

        return $annexes_ids;
    }

    private function getBoolean(array $item, string $key)
    {
        $value = Arr::get($item, $key, false);

        return $this->isTranslatedYes($value) || filter_var($value, FILTER_VALIDATE_BOOLEAN);
    }

    private function getAuthorOnly(array $item)
    {
        // trimming year after comma if exists
        $author = Arr::get($item, 'author');
        if (! $author) {
            return;
        }
        $author = explode(', ', $author);

        return $author[0];
    }
}
