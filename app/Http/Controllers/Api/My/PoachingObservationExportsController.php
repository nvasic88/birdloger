<?php

namespace App\Http\Controllers\Api\My;

use App\Exports\PoachingObservations\ContributorPoachingObservationsCustomExport;
use App\Exports\PoachingObservations\ContributorPoachingObservationsExport;
use App\Http\Controllers\Api\PoachingObservationExportsController as BaseController;

class PoachingObservationExportsController extends BaseController
{
    public function __construct(ContributorPoachingObservationsExport $poachingObservationsExport)
    {
        parent::__construct($poachingObservationsExport);
    }

    /**
     * Columns that can be exported.
     *
     * @return string
     */
    protected function columns()
    {
        return ContributorPoachingObservationsCustomExport::availableColumns();
    }
}
