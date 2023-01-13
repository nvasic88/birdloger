<?php

namespace App\Exports\ElectrocutionObservations;

class ContributorElectrocutionObservationsExport extends ElectrocutionObservationsExportFactory
{
    /**
     * Custom columns exporter for contributor's field observations.
     *
     * @return string
     */
    protected function customType()
    {
        return ContributorElectrocutionObservationsCustomExport::class;
    }
}
