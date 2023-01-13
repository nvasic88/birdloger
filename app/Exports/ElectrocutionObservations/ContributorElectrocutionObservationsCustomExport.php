<?php

namespace App\Exports\ElectrocutionObservations;

use App\Export;

class ContributorElectrocutionObservationsCustomExport extends ElectrocutionObservationsExport
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
