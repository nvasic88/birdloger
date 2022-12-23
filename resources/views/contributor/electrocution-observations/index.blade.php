@extends('layouts.dashboard', ['title' => __('navigation.my_electrocution_observations')])

@section('content')
    <div class="box">
        <nz-electrocution-observations-table
            list-route="api.my.electrocution-observations.index"
            view-route="contributor.electrocution-observations.show"
            edit-route="contributor.electrocution-observations.edit"
            delete-route="api.electrocution-observations.destroy"
            empty="{{ __('No data...') }}"
            show-status
            show-activity-log
            @role([
            'admin', 'electrocution'])
            show-observer
            @endrole
            export-url="{{ route('api.my.electrocution-observation-exports.store') }}"
            :export-columns="{{ $exportColumns }}"
        />
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li class="is-active"><a>{{ __('navigation.my_electrocution_observations') }}</a></li>
        </ul>
    </div>
@endsection

@section('navigationActions')
    <a href="{{ route('contributor.electrocution-observations.create') }}" class="button is-secondary is-outlined">
        @include('components.icon', ['icon' => 'plus'])
        <span>{{ __('navigation.new_observation') }}</span>
    </a>

    <a href="{{ route('contributor.electrocution-observations-import.index') }}" class="button is-secondary is-outlined ml-2">
        @include('components.icon', ['icon' => 'upload'])
        <span>{{ __('navigation.import') }}</span>
    </a>
@endsection
