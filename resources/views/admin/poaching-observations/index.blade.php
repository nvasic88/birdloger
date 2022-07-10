@extends('layouts.dashboard', ['title' => __('navigation.all_poaching_observations')])

@section('content')
    <div class="box">
        <nz-poaching-observations-table
            list-route="api.poaching-observations.index"
            view-route="admin.poaching-observations.show"
            edit-route="admin.poaching-observations.edit"
            delete-route="api.poaching-observations.destroy"
            empty="{{ __('No data...') }}"
            show-activity-log
            show-observer
            markable-as-unidentifiable
            mark-as-unidentifiable-route="api.unidentifiable-poaching-observations-batch.store"
            movable-to-pending
            move-to-pending-route="api.pending-poaching-observations-batch.store"
            approvable
            approve-route="api.approved-poaching-observations-batch.store"
            show-status
        ></nz-poaching-observations-table>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li class="is-active"><a>{{ __('navigation.all_poaching_observations') }}</a></li>
        </ul>
    </div>
@endsection

@section('navigationActions')
    <a href="{{ route('contributor.poaching-observations.create') }}" class="button is-secondary is-outlined">
        @include('components.icon', ['icon' => 'plus'])
        <span>{{ __('navigation.new_poaching_observation') }}</span>
    </a>

    <a href="{{ route('contributor.poaching-observations-import.index') }}" class="button is-secondary is-outlined ml-2">
        @include('components.icon', ['icon' => 'upload'])
        <span>{{ __('navigation.import') }}</span>
    </a>
@endsection
