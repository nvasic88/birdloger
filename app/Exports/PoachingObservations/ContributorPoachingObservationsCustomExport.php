<?php

namespace App\Exports\PoachingObservations;

use App\Export;

class ContributorPoachingObservationsCustomExport extends PoachingObservationsExport
{
    /**
     * Database query to get the data for export.
     *
     * @param  \App\Export  $export
     * @return \Illuminate\Database\Query\Builder
     */
    protected function query(Export $export)
    {
        return parent::query($export)->createdBy($export->user);
    }
}
