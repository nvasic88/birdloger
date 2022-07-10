<?php

namespace App\Http\Requests;

use App\Observer;
use Illuminate\Foundation\Http\FormRequest;

class StoreObserver extends FormRequest
{
    public function rules()
    {
        return [
            'observation_id' => ['required', 'exists:observations,id'],
            'firstName' => ['required', 'string'],
            'lastName' => ['required', 'string'],
        ];
    }

    public function save(Observer $observer)
    {
        $observer->fill(array_merge(
            array_map(
                'trim',
                $this->only(['firstName', 'lastName', 'nickname', 'city', 'observation_id'])
            )
        ))->save();
        $observer->observations()->sync($this->only(['observation_id']));

        return $observer;
    }

    public function store()
    {
        $observer = Observer::create(
            array_merge(
                array_map(
                    'trim',
                    $this->only(['firstName', 'lastName', 'nickname', 'city', 'observation_id'])
                )
            )
        );
        $observer->observations()->sync($this->only(['observation_id']));

        return $observer;
    }
}
