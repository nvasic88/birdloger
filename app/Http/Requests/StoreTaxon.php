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
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;

class StoreTaxon extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::check('create', [Taxon::class, $this->input('parent_id')]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['bail', 'required', new UniqueTaxonName($this->parent_id)],
            'parent_id' => ['nullable', 'exists:taxa,id'],
            'rank' => ['required', Rule::in(array_keys(Taxon::RANKS))],
            'author' => ['nullable', 'string'],
            'stages_ids' => ['nullable', 'array'],
            'stages_ids.*' => ['required', Rule::in(Stage::pluck('id'))],
            'annexes_ids' => ['nullable', 'array'],
            'annexes_ids.*' => ['required', Rule::in(Annex::pluck('id')->all())],
            'conservation_legislations_ids' => [
                'nullable', 'array', Rule::in(ConservationLegislation::pluck('id')),
            ],
            'conservation_documents_ids' => [
                'nullable', 'array', Rule::in(ConservationDocument::pluck('id')),
            ],
            'red_lists_data' => ['nullable', 'array'],
            'red_lists_data.*' => ['array'],
            'red_lists_data.*.red_list_id' => [
                'required',
                Rule::in(RedList::pluck('id')),
            ],
            'red_lists_data.*.category' => [
                'required',
                Rule::in(RedList::CATEGORIES),
            ],
            'native_name' => ['required', 'array'],
            'description' => ['required', 'array'],
            'uses_atlas_codes' => ['boolean'],

            'spid' => ['required', 'string', 'unique:taxa'],
            'birdlife_seq' => ['required', 'integer', 'unique:taxa'],
            'birdlife_id' => ['required', 'integer', 'unique:taxa'],
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
            'family_id' => ['required', 'integer'],
            'strictly_protected' => ['nullable', 'boolean'],
            'strictly_note' => ['nullable', 'string'],
            'protected' => ['nullable', 'boolean'],
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
     * Create taxon using request data.
     *
     * @return \App\Taxon
     */
    protected function createTaxon()
    {
        return Taxon::create(array_merge(array_map('trim', $this->only(['name', 'rank'])),
            $this->createOrGetFamilyArray(), $this->only([
                'parent_id', 'author', 'uses_atlas_codes',
                'spid', 'birdlife_seq', 'birdlife_id', 'ebba_code', 'euring_code',
                'euring_sci_name', 'eunis_n2000code', 'eunis_sci_name', 'bioras_sci_name',
                'refer', 'prior', 'gn_status', 'type', 'strictly_protected', 'strictly_note',
                'protected', 'protected_note', 'iucn_cat', 'full_sci_name', 'order_id'
            ]), Localization::transformTranslations($this->only([
                'description', 'native_name',
            ]))));
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
        $taxon->conservationLegislations()->sync($this->input('conservation_legislations_ids', []));
        $taxon->conservationDocuments()->sync($this->input('conservation_documents_ids', []));
        $taxon->redLists()->sync(
            $this->mapRedListsData($this->input('red_lists_data', []))
        );
        $taxon->annexes()->sync($this->input('annexes_ids', []));
    }

    /**
     * @return array
     */
    protected function createOrGetFamilyArray()
    {
        $orderTrim = array_map('trim', $this->only('order_name'));
        $orderName['name'] = $orderTrim['order_name'];
        $order = Order::firstOrCreate($orderName);
        $order->save();

        $familyTrim = array_map('trim', $this->only('family_name'));
        $familyName['name'] = $familyTrim['family_name'];
        $family = Family::firstOrCreate(array_merge($familyName, ['order_id' => $order->id]));
        $family->save();

        return array_map('trim', ['family_id'=>strval($family->id), 'order_id'=>strval($order->id)]);
    }

    /**
     * Store the information.
     *
     * @return \App\Taxon
     */
    public function save()
    {
        return DB::transaction(function () {
            return tap($this->createTaxon(), function ($taxon) {
                $this->createSynonyms($taxon);
                $this->syncRelations($taxon);
                $this->logCreatedActivity($taxon);
            });
        });
    }

    /**
     * Log taxon created activity.
     *
     * @param  \App\Taxon  $taxon
     * @return void
     */
    protected function logCreatedActivity(Taxon $taxon)
    {
        activity()->performedOn($taxon)
            ->causedBy($this->user())
            ->log('created');
    }

    protected function createSynonyms(Taxon $taxon){
        $synonym_names = $this->input('synonym_names');
        foreach ($synonym_names as $k => $v){
            $synonym = Synonym::firstOrCreate([
                'name' => $v,
                'taxon_id' => $taxon->id,
                ]);
            $synonym->save();
        }
    }
}
