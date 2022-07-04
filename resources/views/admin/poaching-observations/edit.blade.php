@extends('layouts.dashboard', ['title' => __('navigation.edit_observation')])

@section('content')
    <div class="box">
        <nz-poaching-observation-form
            action="{{ route('api.poaching-observations.update', $poachingObservation) }}"
            method="PUT"
            redirect-url="{{ route('admin.poaching-observations.index') }}"
            cancel-url="{{ route('admin.poaching-observations.index') }}"
            :licenses="{{ json_encode(\App\License::getOptions()) }}"
            :sexes="{{ \App\Sex::options() }}"
            :observation-types="{{ $observationTypes }}"
            :atlas-codes="{{ \App\AtlasCode::all() }}"
            :observation="{{ $poachingObservation }}"
            :stages="{{ \App\Stage::all() }}"
            :offences="{{ $offences }}"
            should-confirm-submit
            confirm-submit-message="{{ __('Reason for changing data. Please try to be precise in order to keep the track of changes and ensure data verification.') }}"
            should-ask-reason
            should-confirm-cancel
            submit-only-dirty
            show-observer-identifier
        ></nz-poaching-observation-form>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li>
                <a href="{{ route('admin.poaching-observations.index') }}">{{ __('navigation.all_poaching_observations') }}</a>
            </li>
            <li>
                <a href="{{ route('admin.poaching-observations.show', $poachingObservation) }}">{{ $poachingObservation->id }}</a>
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
