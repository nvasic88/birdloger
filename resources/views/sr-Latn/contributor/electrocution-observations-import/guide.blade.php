@extends('layouts.dashboard', ['title' => __('navigation.field_observations_import')])

@section('content')
    <div class="box content">
        <h1>Uputstvo za uvoz podataka krivolova</h1>

        <div class="message mt-8">
            <div class="message-body">
                Uvoz podataka iz tablice u Birdloger je kompleksan proces. Tom prilikom
                mogu da se potkradu greške koje nije jednostavno ispraviti. Unos podataka
                na ovaj način je opravdan ukoliko se radi o velikom setu podataka, koji nije
                jednostavno prekucati unutar veb okruženja Birdloger. Ipak, pre nego što se
                odlučite za uvoz podataka iz tabele razmislite o drugim mogućnostima i dobro
                proučite ovo uputstvo kako bi izbegli neželjene komplikacije.
            </div>
        </div>

        <div>
            <p>Uputstvo je trenutno u stranju izrade.</p>
        </div>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li><a href="{{ route('contributor.field-observations.index') }}">{{ __('navigation.my_field_observations') }}</a></li>
            <li><a href="{{ route('contributor.field-observations-import.index') }}">{{ __('navigation.field_observations_import') }}</a></li>
            <li class="is-active"><a>Uputstvo za uvoz</a></li>
        </ul>
    </div>
@endsection
