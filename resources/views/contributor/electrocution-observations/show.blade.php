@extends('layouts.dashboard', ['title' => __('navigation.observation_details')])

@section('content')
    <div class="box">
        @include('partials.electrocution-observation-details', compact('electrocutionObservation'))

        <a href="{{ route('contributor.electrocution-observations.edit', $electrocutionObservation) }}"
           class="button is-primary is-outlined">{{ __('buttons.edit') }}</a>

        <hr>

        <h2 class="is-size-4">{{ __('Activity Log') }}</h2>

        <nz-electrocution-observation-activity-log
            :activities="{{ $electrocutionObservation->activity }}"
        >
        </nz-electrocution-observation-activity-log>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li>
                <a href="{{ route('contributor.electrocution-observations.index') }}">{{ __('navigation.my_field_observations') }}</a>
            </li>
            <li class="is-active"><a>{{ $electrocutionObservation->id }}</a></li>
        </ul>
    </div>
@endsection
