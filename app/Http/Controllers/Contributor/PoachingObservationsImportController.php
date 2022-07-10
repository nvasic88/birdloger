<?php

namespace App\Http\Controllers\Contributor;

use App\Import;
use App\Importing\ImportStatus;
use App\Importing\PoachingObservationImport;
use Illuminate\Http\Request;

class PoachingObservationsImportController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('contributor.poaching-observations-import.index', [
            'columns' => PoachingObservationImport::columns($request->user()),
            'import' => Import::inProgress()->latest()->first(),
            'cancellableStatuses' => collect(ImportStatus::cancellableStatuses()),
        ]);
    }
}
