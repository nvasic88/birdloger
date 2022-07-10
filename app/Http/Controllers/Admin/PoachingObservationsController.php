<?php

namespace App\Http\Controllers\Admin;

# use App\Exports\FieldObservations\CustomFieldObservationsExport;
use App\ObservationType;
use App\OffenceCase;
use App\PoachingObservation;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class PoachingObservationsController
{
    use AuthorizesRequests;

    /**
     * Display list of all field observations.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.poaching-observations.index', [
            # 'exportColumns' => CustomFieldObservationsExport::availableColumnData(),
        ]);
    }

    /**
     * Show field observation details.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(PoachingObservation $poachingObservation)
    {
        $this->authorize('view', $poachingObservation);

        return view('admin.poaching-observations.show', [
            'poachingObservation' => $poachingObservation->load([
                'observation.taxon', 'activity.causer',
            ]),
        ]);
    }

    /**
     * Display form to edit pending observations.
     *
     * @param \App\PoachingObservation $poachingObservation
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(PoachingObservation $poachingObservation)
    {
        $this->authorize('update', $poachingObservation);

        return view('admin.poaching-observations.edit', [
            'poachingObservation' => $poachingObservation->load([
                'observation.taxon.curators',
                'observedBy', 'identifiedBy',
            ]),
            'observationTypes' => ObservationType::all(),
            'offences' => OffenceCase::all(),
            'sources' => $poachingObservation->load(['sources']),
        ]);
    }
}
