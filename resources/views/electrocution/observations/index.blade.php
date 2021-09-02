@extends('layouts.dashboard', ['title' => __('navigation.my_electrocution_observations')])

@section('content')
    <div class="box">
        <nz-electrocution-observations-table
            list-route="api.my.electrocution-observations.index"
            view-route="electrocution.observations.show"
            edit-route="electrocution.observations.edit"
            delete-route="api.electrocution-observations.destroy"
            empty="{{ __('No data...') }}"
            show-status
            show-activity-log
            @role([
        'admin', 'electrocution'])
        show-observer
        @endrole
        />
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('electrocution.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li class="is-active"><a>{{ __('navigation.my_electrocution_observations') }}</a></li>
        </ul>
    </div>
@endsection

@section('navigationActions')
    <a href="{{ route('electrocution.observations.create') }}" class="button is-secondary is-outlined">
        @include('components.icon', ['icon' => 'plus'])
        <span>{{ __('navigation.new_observation') }}</span>
    </a>
@endsection
