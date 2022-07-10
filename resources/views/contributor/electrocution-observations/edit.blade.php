@extends('layouts.dashboard', ['title' => __('navigation.edit_observation')])

@section('content')
    <div class="box">
        <nz-electrocution-observation-form
            action="{{ route('api.electrocution-observations.update', $electrocutionObservation) }}"
            method="PUT"
            redirect-url="{{ route('contributor.electrocution-observations.index') }}"
            cancel-url="{{ route('contributor.electrocution-observations.index') }}"
            :licenses="{{ json_encode(\App\License::getOptions()) }}"
            :sexes="{{ \App\Sex::options() }}"
            :observation-types="{{ App\ObservationType::all() }}"
            :atlas-codes="{{ \App\AtlasCode::all() }}"
            :observation="{{ $electrocutionObservation }}"
            :stages="{{\App\Stage::all()}}"
            should-confirm-submit
            confirm-submit-message="{{ __('Reason for changing data. Please try to be precise in order to keep the track of changes and ensure data verification.') }}"
            should-ask-reason
            should-confirm-cancel
            submit-only-dirty
            @role([
            'admin', 'electrocution'])
            show-observer-identifier
            @endrole
        />
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li>
                <a href="{{ route('contributor.electrocution-observations.index') }}">{{ __('navigation.my_electrocution_observations') }}</a>
            </li>
            <li>
                <a href="{{ route('contributor.electrocution-observations.show', $electrocutionObservation) }}">{{ $electrocutionObservation->id }}</a>
            </li>
            <li class="is-active"><a>{{ __('navigation.edit') }}</a></li>
        </ul>
    </div>
@endsection

@push('headerScripts')
    <script>
        window.App.gmaps.load = true;
    </script>
@endpush
