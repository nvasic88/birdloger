<?php

namespace App\Http\Controllers\Contributor;

use App\ElectrocutionObservation;
use Illuminate\Http\Request;

class ElectrocutionObservationsController
{
    /**
     * Display a list of observations.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('contributor.electrocution-observations.index', [
            # 'exportColumns' => ContributorFieldObservationsCustomExport::availableColumnData(),
        ]);
    }

    /**
     * Show electrocution observation details.
     *
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function show(ElectrocutionObservation $electrocutionObservation, Request $request)
    {
        abort_unless($electrocutionObservation->isCreatedBy($request->user()), 403);

        return view('contributor.electrocution-observations.show', [
            'electrocutionObservation' => $electrocutionObservation->load([
                'observation.taxon', 'activity.causer',
            ]),
        ]);
    }

    /**
     * Show page to add new observation.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('contributor.electrocution-observations.create');
    }

    /**
     * Show form to edit electrocution observation.
     *
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function edit(ElectrocutionObservation $electrocutionObservation, Request $request)
    {
        abort_unless($electrocutionObservation->isCreatedBy($request->user()), 403);

        return view('contributor.electrocution-observations.edit', [
            'electrocutionObservation' => $electrocutionObservation->load([
                'observation.taxon.stages', 'observedBy', 'identifiedBy',
            ]),
        ]);
    }
}
