<?php

namespace App\Http\Controllers\Api\My;

use App\Exports\ElectrocutionObservations\ContributorElectrocutionObservationsCustomExport;
use App\Exports\ElectrocutionObservations\ContributorElectrocutionObservationsExport;
use App\Http\Controllers\Api\ElectrocutionObservationExportsController as BaseController;

class ElectrocutionObservationExportsController extends BaseController
{
    public function __construct(ContributorElectrocutionObservationsExport $electrocutionObservationsExport)
    {
        parent::__construct($electrocutionObservationsExport);
    }

    /**
     * Columns that can be exported.
     *
     * @return string
     */
    protected function columns()
    {
        return ContributorElectrocutionObservationsCustomExport::availableColumns();
    }
}
