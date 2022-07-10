<?php

namespace App\Http\Requests;

use App\Annex;
use App\ConservationDocument;
use App\ConservationLegislation;
use App\Family;
use App\Order;
use App\RedList;
use App\Rules\UniqueTaxonName;
use App\Stage;
use App\Support\Localization;
use App\Synonym;
use App\Taxon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class UpdateTaxon extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::check('update', $this->taxon);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['bail', 'required', new UniqueTaxonName($this->parent_id, $this->taxon->id)],
            'parent_id' => ['nullable', 'exists:taxa,id'],
            'rank' => ['required', Rule::in(array_keys(Taxon::RANKS))],
            'author' => ['nullable', 'string'],
            'stages_ids' => ['nullable', 'array'],
            'stages_ids.*' => ['required', Rule::in(Stage::pluck('id')->all())],
            'annexes_ids' => ['nullable', 'array'],
            'annexes_ids.*' => ['required', Rule::in(Annex::pluck('id')->all())],
            'conservation_legislations_ids' => [
                'nullable', 'array', Rule::in(ConservationLegislation::pluck('id')->all()),
            ],
            'conservation_documents_ids' => [
                'nullable', 'array', Rule::in(ConservationDocument::pluck('id')->all()),
            ],
            'red_lists_data' => ['nullable', 'array'],
            'red_lists_data.*' => ['array'],
            'red_lists_data.*.red_list_id' => [
                'required',
                Rule::in(RedList::pluck('id')->all()),
            ],
            'red_lists_data.*.category' => [
                'required',
                Rule::in(RedList::CATEGORIES),
            ],
            'reason' => ['required', 'string', 'max:255'],
            'native_name' => ['required', 'array'],
            'description' => ['required', 'array'],
            'uses_atlas_codes' => ['boolean'],

            'spid' => ['required', 'string'],
            'birdlife_seq' => ['required', 'integer'],
            'birdlife_id' => ['required', 'integer'],
            'ebba_code' => ['nullable', 'string'],
            'euring_code' => ['nullable', 'string'],
            'euring_sci_name' => ['nullable', 'string'],
            'eunis_n2000code' => ['nullable', 'string'],
            'eunis_sci_name' => ['nullable', 'string'],
            'bioras_sci_name' => ['nullable', 'string'],
            'refer' => ['boolean'],
            'prior' => ['boolean'],
            'gn_status' => ['nullable', 'string'],
            'type' => ['required', 'string'],
            'strictly_protected' => ['boolean'],
            'strictly_note' => ['nullable', 'string'],
            'protected' => ['boolean'],
            'protected_note' => ['nullable', 'string'],
            'iucn_cat' => ['nullable', 'string'],
            'full_sci_name' => ['nullable', 'string'],
            'family_name' => ['required', 'string'],
            'order_name' => ['required', 'string'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'parent_id' => 'parent',
        ];
    }

    /**
     * Update taxon using request data.
     *
     * @param  \App\Taxon  $taxon
     * @return \App\Taxon
     */
    public function save(Taxon $taxon)
    {
        return DB::transaction(function () use ($taxon) {
            $oldData = $taxon->load([
                'parent', 'stages', 'conservationLegislations', 'redLists', 'annexes',
                'conservationDocuments',
            ])->toArray();

            Family::whereId($taxon->family_id)->update(['name' => $this->input('family_name')]);
            Order::whereId($taxon->order_id)->update(['name' => $this->input('order_name')]);

            $taxon->update(array_merge(array_map('trim', $this->only(['name', 'rank'])), $this->only([
                'parent_id', 'author', 'uses_atlas_codes',
                'spid', 'birdlife_seq', 'birdlife_id', 'ebba_code', 'euring_code',
                'euring_sci_name', 'eunis_n2000code', 'eunis_sci_name', 'bioras_sci_name',
                'refer', 'prior', 'gn_status', 'type', 'family_id', 'strictly_protected', 'strictly_note',
                'protected', 'protected_note', 'iucn_cat', 'full_sci_name',
            ]), Localization::transformTranslations($this->only([
                'description', 'native_name',
            ]))));

            $this->syncRelations($taxon);
            $this->createSynonyms($taxon);

            $this->logUpdatedActivity($taxon, $oldData);

            return $taxon;
        });
    }

    /**
     * Map red list data to format required to store the value.
     *
     * @param  array  $redListsData
     * @return array
     */
    protected function mapRedListsData($redListsData = [])
    {
        return collect($redListsData)->mapWithKeys(function ($item) {
            return [$item['red_list_id'] => ['category' => $item['category']]];
        })->all();
    }

    /**
     * Sync taxon relations.
     *
     * @param  \App\Taxon  $taxon
     * @return void
     */
    protected function syncRelations(Taxon $taxon)
    {
        $taxon->stages()->sync($this->input('stages_ids', []));
        $taxon->annexes()->sync($this->input('annexes_ids', []));
    }

    protected function logUpdatedActivity(Taxon $taxon, $oldData)
    {
        activity()->performedOn($taxon)
            ->causedBy($this->user())
            ->withProperty('old', $this->getChangedData($taxon, $oldData))
            ->withProperty('reason', $this->input('reason'))
            ->log('updated');
    }

    protected function getChangedData(Taxon $taxon, $oldData)
    {
        $changed = array_keys($taxon->getChanges());

        $data = [];
        foreach ($oldData as $key => $value) {
            if ('stages' === $key && $this->stagesAreChanged($taxon, collect($value))) {
                $data[$key] = null;
            } elseif ('annexes' === $key && $this->annexesAreChanged($taxon, collect($value))) {
                $data[$key] = null;
            } elseif ('conservation_legislations' === $key && $this->conservationLegislationsAreChanged($taxon, collect($value))) {
                $data[$key] = null;
            } elseif ('conservation_documents' === $key && $this->conservationDocumentsAreChanged($taxon, collect($value))) {
                $data[$key] = null;
            } elseif ('red_lists' === $key && $this->redListsAreChanged($taxon, collect($value))) {
                $data[$key] = null;
            } elseif ('translations' === $key) {
                if ($this->translationIsChanged('description', collect($value), $taxon->translations)) {
                    $data['description'] = null;
                }

                if ($this->translationIsChanged('native_name', collect($value), $taxon->translations)) {
                    $data['native_name'] = null;
                }
            } elseif (in_array($key, $changed)) {
                if ('parent_id' === $key) {
                    $data['parent'] = $oldData['parent'] ? $oldData['parent']['name'] : $value;
                } elseif ('rank' === $key) {
                    $data[$key] = ['value' => $value, 'label' => 'taxonomy.'.$value];
                } elseif (in_array($key, ['description', 'native_name'])) {
                    $data[$key] = null;
                } elseif (in_array($key, ['restricted', 'allochthonous', 'invasive', 'uses_atlas_codes'])) {
                    $data[$key] = ['value' => $value, 'label' => $value ? 'Yes' : 'No'];
                } else {
                    $data[$key] = $value;
                }
            }
        }

        return $data;
    }

    protected function stagesAreChanged($taxon, $oldValue)
    {
        $taxon->load('stages');

        return $oldValue->count() !== $taxon->stages->count()
            || ($oldValue->isNotEmpty() && $taxon->stages->isNotEmpty()
                && $oldValue->pluck('id')->diff($taxon->stages->pluck('id'))->isNotEmpty());
    }

    protected function annexesAreChanged($taxon, $oldValue)
    {
        $taxon->load('annexes');

        return $oldValue->count() !== $taxon->annexes->count()
            || ($oldValue->isNotEmpty() && $taxon->annexes->isNotEmpty()
                && $oldValue->pluck('id')->diff($taxon->annexes->pluck('id'))->isNotEmpty());
    }

    protected function conservationLegislationsAreChanged($taxon, $oldValue)
    {
        $taxon->load('conservationLegislations');

        return $oldValue->count() !== $taxon->conservationLegislations->count()
            || ($oldValue->isNotEmpty() && $taxon->conservationLegislations->isNotEmpty()
                && $oldValue->pluck('id')->diff($taxon->conservationLegislations->pluck('id'))->isNotEmpty());
    }

    protected function conservationDocumentsAreChanged($taxon, $oldValue)
    {
        $taxon->load('conservationDocuments');

        return $oldValue->count() !== $taxon->conservationDocuments->count()
            || ($oldValue->isNotEmpty() && ! $taxon->conservationDocuments->isNotEmpty()
                && $oldValue->pluck('id')->diff($taxon->conservationDocuments->pluck('id'))->isNotEmpty());
    }

    protected function redListsAreChanged($taxon, $oldValue)
    {
        $taxon->load('redLists');

        return $oldValue->count() !== $taxon->redLists->count()
            || (! $oldValue->isEmpty() && ! $taxon->redLists->isEmpty()
                && $oldValue->pluck('id')->diff($taxon->redLists->pluck('id'))->isNotEmpty()
                || $oldValue->filter(function ($oldRedList) use ($taxon) {
                    return $taxon->redLists->contains(function ($redList) use ($oldRedList) {
                        return $redList->id === $oldRedList['id']
                            && $redList->pivot->category === Arr::get($oldRedList, 'pivot.category');
                    });
                })->count() !== $oldValue->count());
    }

    public function translationIsChanged($translatedAttribute, $oldValue, $value)
    {
        $old = $oldValue->mapWithKeys(function ($translation) use ($translatedAttribute) {
            return [$translation['locale'] => $translation[$translatedAttribute] ?? null];
        });


        $new = $value->mapWithKeys(function ($translation) use ($translatedAttribute) {
            return [$translation->locale => $translation->{$translatedAttribute}];
        });

        return ! $old->diffAssoc($new)->isEmpty() || ! $new->diffAssoc($old)->isEmpty();
    }

    private function createSynonyms(Taxon $taxon)
    {
        $synonym_names = $this->input('synonym_names');
        foreach ($synonym_names as $k => $v) {
            $synonym = Synonym::firstOrCreate([
                'name' => $v,
                'taxon_id' => $taxon->id,
            ]);
            $synonym->save();
        }
    }
}
