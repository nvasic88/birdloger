<?php

namespace App\Http\Controllers\Contributor;

use App\Import;
use App\Importing\ElectrocutionObservationImport;
use App\Importing\ImportStatus;
use Illuminate\Http\Request;

class ElectrocutionObservationsImportController
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('contributor.electrocution-observations-import.index', [
            'columns' => ElectrocutionObservationImport::columns($request->user()),
            'import' => Import::inProgress()->latest()->first(),
            'cancellableStatuses' => collect(ImportStatus::cancellableStatuses()),
        ]);
    }
}
