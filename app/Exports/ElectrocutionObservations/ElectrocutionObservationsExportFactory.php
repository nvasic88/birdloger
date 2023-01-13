<?php

namespace App\Exports\ElectrocutionObservations;

use App\FieldObservation;
use Illuminate\Http\Request;

class ElectrocutionObservationsExportFactory
{
    /**
     * Custom columns exporter for all electrocution observations.
     *
     * @return string
     */
    protected function customType()
    {
        return ElectrocutionObservationsExport::class;
    }

    /**
     * Create export instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Export
     */
    public function createFromRequest(Request $request)
    {
        $type = $this->customType();

        return $type::create(
            $request->input('columns'),
            $this->getFiltersFromRequest($request),
            $request->input('with_header', false)
        );
    }

    /**
     * Extract filters from request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    private function getFiltersFromRequest(Request $request)
    {
        return $request->only(array_keys(FieldObservation::filters()));
    }
}
