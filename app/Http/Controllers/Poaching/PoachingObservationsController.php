<?php

namespace App\Http\Controllers\Poaching;

# use App\Exports\FieldObservations\ContributorFieldObservationsCustomExport;
use App\OffenceCase;
use App\PoachingObservation;
use Illuminate\Http\Request;

class PoachingObservationsController
{
    /**
     * Display a list of observations.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('poaching.observations.index', [
            # 'exportColumns' => ContributorFieldObservationsCustomExport::availableColumnData(),
        ]);
    }

    /**
     * Show field observation details.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function show(PoachingObservation $poachingObservation, Request $request)
    {
        abort_unless($poachingObservation->isCreatedBy($request->user()), 403);

        return view('poaching.observations.show', [
            'poachingObservation' => $poachingObservation->load([
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
        return view('poaching.observations.create');
    }

    /**
     * Show form to edit field observation.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function edit(PoachingObservation $poachingObservation, Request $request)
    {
        abort_unless($poachingObservation->isCreatedBy($request->user()), 403);

        return view('poaching.observations.edit', [
            'poachingObservation' => $poachingObservation->load([
                'observation.taxon.stages', 'observedBy', 'identifiedBy',
            ]),
            'offences' => OffenceCase::all(),
            'sources' => $poachingObservation->load(['sources']),
        ]);
    }
}
