<?php

namespace App\Http\Controllers\Admin;

# use App\Exports\FieldObservations\CustomFieldObservationsExport;
use App\ElectrocutionObservation;
use App\ObservationType;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ElectrocutionObservationsController
{
    use AuthorizesRequests;

    /**
     * Display list of all electrocution observations.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('admin.electrocution-observations.index', [
            # 'exportColumns' => CustomFieldObservationsExport::availableColumnData(),
        ]);
    }

    /**
     * Show electrocution observation details.
     *
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(ElectrocutionObservation $electrocutionObservation)
    {
        $this->authorize('view', $electrocutionObservation);

        return view('admin.electrocution-observations.show', [
            'electrocutionObservation' => $electrocutionObservation->load([
                'observation.taxon', 'activity.causer',
            ]),
        ]);
    }

    /**
     * Display form to edit pending observations.
     *
     * @param \App\ElectrocutionObservation $electrocutionObservation
     * @return \Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(ElectrocutionObservation $electrocutionObservation)
    {
        $this->authorize('update', $electrocutionObservation);

        return view('admin.electrocution-observations.edit', [
            'electrocutionObservation' => $electrocutionObservation->load([
                'observation.taxon.curators',
                'observedBy', 'identifiedBy',
            ]),
            'observationTypes' => ObservationType::all(),
        ]);
    }
}
