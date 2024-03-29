<?php

namespace App\Exports\FieldObservations;

class ContributorFieldObservationsExport extends FieldObservationsExportFactory
{
    /**
     * Custom columns exporter for contributor's field observations.
     *
     * @return string
     */
    protected function customType()
    {
        return ContributorFieldObservationsCustomExport::class;
    }
}
