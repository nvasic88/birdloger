@extends('layouts.dashboard', ['title' => __('navigation.my_poaching_observations')])

@section('content')
    <div class="box">
        <nz-poaching-observations-table
            list-route="api.my.poaching-observations.index"
            view-route="contributor.poaching-observations.show"
            edit-route="contributor.poaching-observations.edit"
            delete-route="api.poaching-observations.destroy"
            empty="{{ __('No data...') }}"
            show-status
            show-activity-log
            @role(['admin', 'curator', 'poaching'])
            show-observer
            @endrole
            export-url="{{ route('api.my.poaching-observation-exports.store') }}"
            :export-columns="{{ $exportColumns }}"
        />
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li class="is-active"><a>{{ __('navigation.my_poaching_observations') }}</a></li>
        </ul>
    </div>
@endsection

@section('navigationActions')
    <a href="{{ route('contributor.poaching-observations.create') }}" class="button is-secondary is-outlined">
        @include('components.icon', ['icon' => 'plus'])
        <span>{{ __('navigation.new_observation') }}</span>
    </a>
    <a href="{{ route('contributor.poaching-observations-import.index') }}" class="button is-secondary is-outlined ml-2">
        @include('components.icon', ['icon' => 'upload'])
        <span>{{ __('navigation.import') }}</span>
    </a>
@endsection
