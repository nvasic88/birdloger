<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Stevebauman\Purify\Facades\Purify;

class TaxonTranslation extends Model
{
    public $timestamps = false;

    protected $fillable = ['native_name', 'description'];

    public function getDescriptionAttribute($value)
    {
        return Purify::clean($value);
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'locale' => $this->locale,
            'native_name' => $this->native_name,
            'description' => $this->description,
        ];
    }
}
