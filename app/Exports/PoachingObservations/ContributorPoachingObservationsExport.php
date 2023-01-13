<?php

namespace App\Exports\PoachingObservations;

class ContributorPoachingObservationsExport extends PoachingObservationsExportFactory
{
    /**
     * Custom columns exporter for contributor's field observations.
     *
     * @return string
     */
    protected function customType()
    {
        return ContributorPoachingObservationsCustomExport::class;
    }
}
