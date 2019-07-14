@extends('layouts.dashboard', ['title' => __('navigation.observation_details')])

@section('content')
    <div class="box">
        @include('partials.field-observation-details', compact('fieldObservation'))

        <a href="{{ route('contributor.field-observations.edit', $fieldObservation) }}" class="button is-primary is-outlined">{{ __('buttons.edit') }}</a>

        <hr>

        <h2 class="is-size-4">{{ __('Activity Log') }}</h2>

        <nz-field-observation-activity-log :activities="{{ $fieldObservation->activity }}"/>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li><a href="{{ route('contributor.field-observations.index') }}">{{ __('navigation.my_field_observations') }}</a></li>
            <li class="is-active"><a>{{ $fieldObservation->id }}</a></li>
        </ul>
    </div>
@endsection
