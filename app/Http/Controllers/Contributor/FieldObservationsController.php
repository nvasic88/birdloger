<?php

namespace App\Http\Controllers\Contributor;

use App\Comment;
use App\FieldObservation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Forms\NewFieldObservationForm;

class FieldObservationsController extends Controller
{
    /**
     *
     */
    public function index()
    {
        $observations = FieldObservation::paginate();

        return view('field-observations.index', [
            'observations' => $observations,
        ]);
    }

    /**
     *
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('field-observations.create');
    }
}
