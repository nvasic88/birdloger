<?php

namespace App\Http\Controllers\Api;

use App\Importing\ElectrocutionObservationImport;

class ElectrocutionObservationImportsController extends BaseImportController
{
    /**
     * Import type.
     *
     * @return string
     */
    protected function type()
    {
        return ElectrocutionObservationImport::class;
    }
}
