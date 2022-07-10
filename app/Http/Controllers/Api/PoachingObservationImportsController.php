<?php

namespace App\Http\Controllers\Api;

use App\Importing\PoachingObservationImport;

class PoachingObservationImportsController extends BaseImportController
{
    /**
     * Import type.
     *
     * @return string
     */
    protected function type()
    {
        return PoachingObservationImport::class;
    }
}
