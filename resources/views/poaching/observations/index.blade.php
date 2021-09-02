@extends('layouts.dashboard', ['title' => __('navigation.my_poaching_observations')])

@section('content')
    <div class="box">
        <nz-poaching-observations-table
            list-route="api.my.poaching-observations.index"
            view-route="poaching.observations.show"
            edit-route="poaching.observations.edit"
            delete-route="api.poaching-observations.destroy"
            empty="{{ __('No data...') }}"
            show-status
            show-activity-log
            @role([
        'admin', 'poaching'])
        show-observer
        @endrole
        />
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('poaching.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li class="is-active"><a>{{ __('navigation.my_poaching_observations') }}</a></li>
        </ul>
    </div>
@endsection

@section('navigationActions')
    <a href="{{ route('poaching.observations.create') }}" class="button is-secondary is-outlined">
        @include('components.icon', ['icon' => 'plus'])
        <span>{{ __('navigation.new_observation') }}</span>
    </a>
@endsection
