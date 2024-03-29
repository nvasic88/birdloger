@extends('layouts.dashboard', ['title' => __('navigation.all_field_observations')])

@section('content')
    <div class="box">
        <nz-field-observations-table
            list-route="api.field-observations.index"
            view-route="admin.field-observations.show"
            edit-route="admin.field-observations.edit"
            delete-route="api.field-observations.destroy"
            empty="{{ __('No data...') }}"
            show-activity-log
            show-observer
            markable-as-unidentifiable
            mark-as-unidentifiable-route="api.unidentifiable-field-observations-batch.store"
            movable-to-pending
            move-to-pending-route="api.pending-field-observations-batch.store"
            approvable
            approve-route="api.approved-field-observations-batch.store"
            show-status
            export-url="{{ route('api.field-observation-exports.store') }}"
            :export-columns="{{ $exportColumns }}"
        ></nz-field-observations-table>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li class="is-active"><a>{{ __('navigation.all_field_observations') }}</a></li>
        </ul>
    </div>
@endsection

@section('navigationActions')
    <a href="{{ route('contributor.field-observations.create') }}" class="button is-secondary is-outlined">
        @include('components.icon', ['icon' => 'plus'])
        <span>{{ __('navigation.new_field_observation') }}</span>
    </a>

    <a href="{{ route('contributor.field-observations-import.index') }}" class="button is-secondary is-outlined ml-2">
        @include('components.icon', ['icon' => 'upload'])
        <span>{{ __('navigation.import') }}</span>
    </a>
@endsection
