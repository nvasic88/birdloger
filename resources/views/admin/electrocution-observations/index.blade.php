@extends('layouts.dashboard', ['title' => __('navigation.all_electrocution_observations')])

@section('content')
    <div class="box">
        <nz-electrocution-observations-table
            list-route="api.electrocution-observations.index"
            view-route="admin.electrocution-observations.show"
            edit-route="admin.electrocution-observations.edit"
            delete-route="api.electrocution-observations.destroy"
            empty="{{ __('No data...') }}"
            show-activity-log
            show-observer
            markable-as-unidentifiable
            mark-as-unidentifiable-route="api.unidentifiable-electrocution-observations-batch.store"
            movable-to-pending
            move-to-pending-route="api.pending-electrocution-observations-batch.store"
            approvable
            approve-route="api.approved-electrocution-observations-batch.store"
            show-status
            export-url="{{ route('api.electrocution-observation-exports.store') }}"
            :export-columns="{{ $exportColumns }}"
        ></nz-electrocution-observations-table>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li class="is-active"><a>{{ __('navigation.all_electrocution_observations') }}</a></li>
        </ul>
    </div>
@endsection

@section('navigationActions')
    <a href="{{ route('contributor.electrocution-observations.create') }}" class="button is-secondary is-outlined">
        @include('components.icon', ['icon' => 'plus'])
        <span>{{ __('navigation.new_electrocution_observation') }}</span>
    </a>

    <a href="{{ route('contributor.electrocution-observations-import.index') }}" class="button is-secondary is-outlined ml-2">
        @include('components.icon', ['icon' => 'upload'])
        <span>{{ __('navigation.import') }}</span>
    </a>
@endsection
