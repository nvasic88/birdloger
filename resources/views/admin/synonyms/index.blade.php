@extends('layouts.dashboard', ['title' => __('navigation.synonyms')])

@section('content')

    <div class="box">

        <nz-synonyms-table
            list-route="api.synonyms.index"
            edit-route="admin.synonyms.edit"
            delete-route="api.synonyms.destroy"
            empty="{{ __('No data...') }}">
        </nz-synonyms-table>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li class="is-active"><a>{{ __('navigation.synonyms') }}</a></li>
        </ul>
    </div>
@endsection

@section('navigationActions')
    <a href="{{ route('admin.synonyms.create') }}" class="button is-secondary is-outlined">
        @include('components.icon', ['icon' => 'plus'])
        <span>{{ __('navigation.add') }}</span>
    </a>
@endsection
