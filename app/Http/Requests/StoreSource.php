<?php

namespace App\Http\Requests;

use App\Source;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSource extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', Rule::in(['social_media', 'media', 'ads', 'institutions', 'associates'])],
            'description' => ['nullable', 'string'],
            'link' => ['required', 'string'],
        ];
    }

    public function save(Source $source)
    {
        $source->fill(array_merge(
            array_map(
                'trim',
                $this->only(['name', 'description', 'link', 'poaching_observation_id'])
            )
        ))->save();
        return $source;
    }

    public function store()
    {
        $source = Source::create(
            array_merge(
                array_map(
                    'trim',
                    $this->only(['name', 'description', 'link', 'poaching_observation_id'])
                )
            )
        );
        return $source;
    }
}
