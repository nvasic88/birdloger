<?php

namespace App\Exports\Taxa;

use App\Export;
use App\Exports\BaseExport;
use App\Taxon;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CustomTaxaExport extends BaseExport
{
    /**
     * Column labels and names.
     *
     * @return \Illuminate\Support\Collection
     */
    public static function columnData()
    {
        $locales = collect(LaravelLocalization::getSupportedLocales())->reverse();

        return collect()->concat([
            [
                'label' => trans('labels.id'),
                'value' => 'id',
            ],
            [
                'label' => trans('labels.taxa.type'),
                'value' => 'type',
            ],
            [
                'label' => trans('labels.taxa.spid'),
                'value' => 'spid',
            ],
            [
                'label' => trans('labels.taxa.name'),
                'value' => 'name',
            ],
            [
                'label' => trans('taxonomy.order'),
                'value' => 'order',
            ],
            [
                'label' => trans('taxonomy.family'),
                'value' => 'family',
            ],
            [
                'label' => trans('labels.taxa.synonyms'),
                'value' => 'synonyms',
            ],
        ])->concat($locales->map(function ($locale, $localeCode) {
            $nativeName = trans('labels.taxa.native_name');
            $localeTranslation = trans('languages.'.$locale['name']);

            return [
                'label' => "{$nativeName} - {$localeTranslation}",
                'value' => 'native_name_'.Str::snake($localeCode),
            ];
        }))->concat([
            [
                'label' => trans('labels.taxa.strictly_protected'),
                'value' => 'strictly_protected',
            ],
            [
                'label' => trans('labels.taxa.strictly_note'),
                'value' => 'strictly_note',
            ],
            [
                'label' => trans('labels.taxa.protected'),
                'value' => 'protected',
            ],
            [
                'label' => trans('labels.taxa.protected_note'),
                'value' => 'protected_note',
            ],
            [
                'label' => trans('labels.taxa.iucn_cat'),
                'value' => 'iucn_cat',
            ],
            [
                'label' => trans('labels.taxa.birdlife_seq'),
                'value' => 'birdlife_seq',
            ],
            [
                'label' => trans('labels.taxa.birdlife_id'),
                'value' => 'birdlife_id',
            ],
            [
                'label' => trans('labels.taxa.ebba_code'),
                'value' => 'ebba_code',
            ],
            [
                'label' => trans('labels.taxa.euring_code'),
                'value' => 'euring_code',
            ],
            [
                'label' => trans('labels.taxa.euring_sci_name'),
                'value' => 'euring_sci_name',
            ],
            [
                'label' => trans('labels.taxa.eunis_n2000code'),
                'value' => 'eunis_n2000code',
            ],
            [
                'label' => trans('labels.taxa.eunis_sci_name'),
                'value' => 'eunis_sci_name',
            ],
            [
                'label' => trans('labels.taxa.refer'),
                'value' => 'refer',
            ],
            [
                'label' => trans('labels.taxa.prior'),
                'value' => 'prior',
            ],
            [
                'label' => trans('labels.taxa.annex'),
                'value' => 'annexes',
            ],
            [
                'label' => trans('labels.taxa.gn_status'),
                'value' => 'gn_status',
            ],
            [
                'label' => trans('labels.taxa.bioras_sci_name'),
                'value' => 'bioras_sci_name',
            ],
            [
                'label' => trans('labels.taxa.full_sci_name'),
                'value' => 'full_sci_name',
            ],
            [
                'label' => trans('labels.taxa.author'),
                'value' => 'author',
            ],
        ]);
    }

    /**
     * Database query to get the data for export.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function query(Export $export)
    {
        return Taxon::where(['rank' => 'species'])->with(['parent', 'ancestors'])->filter($export->filter)->orderBy('id');
    }

    /**
     * Extract needed data from item.
     *
     * @param  \App\Taxon  $item
     * @return array
     */
    protected function transformItem($item)
    {
        $transformed = [
            'id' => $item->id,
            'type' => $item->type,
            'spid' => $item->spid,
            'name' => $item->name,

            'order' => $this->getAncestorByRank($item, 'order'),
            'family' => $this->getAncestorByRank($item, 'family'),
            'synonyms' => $item->synonyms->map->name->implode('; '),
            'strictly_protected' => $item->strictly_protected ? __('Yes') : __('No'),
            'strictly_note' => $item->strictly_note,
            'protected' => $item->protected ? __('Yes') : __('No'),
            'protected_note' => $item->protected_note,
            'iucn_cat' => $item->iucn_cat,
            'birdlife_seq' => $item->birdlife_seq,
            'birdlife_id' => $item->birdlife_id,
            'ebba_code' => $item->ebba_code,
            'euring_code' => $item->euring_code,
            'euring_sci_name' => $item->euring_sci_name,
            'eunis_n2000code' => $item->eunis_n2000code,
            'eunis_sci_name' => $item->eunis_sci_name,
            'refer' => $item->refer ? __('Yes') : __('No'),
            'prior' => $item->prior ? __('Yes') : __('No'),
            'annexes' => $item->annexes->map->name->implode('; '),
            'gn_status' => $item->gn_status,
            'bioras_sci_name' => $item->bioras_sci_name,
            'full_sci_name' => $item->full_sci_name,
            'author' => $item->author,

        ];

        foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $locale) {
            $translation = $item->translateOrNew($localeCode);
            $transformed['native_name_'.Str::snake($localeCode)] = $translation->native_name;
        }

        return $transformed;
    }

    /**
     * Extract ancestor by rank.
     *
     * @param Taxon $item
     * @param $rank
     * @return string
     */
    private function getAncestorByRank(Taxon $item, $rank)
    {
        foreach ($item->ancestors()->get() as $ancestor) {
            if ($ancestor->rank == $rank) {
                return $ancestor->name;
            }
        }

        return '';
    }
}
