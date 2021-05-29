@extends('layouts.dashboard', ['title' => __('navigation.new_synonym')])

@section('content')
    <div class="box">
        <nz-synonym-form
            action="{{ route('api.synonyms.create') }}"
            method="POST"
            redirect-url="{{ route('admin.synonyms.index') }}"
            cancel-url="{{ route('admin.synonyms.index') }}"
            should-confirm-cancel
        ></nz-synonym-form>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li><a href="{{ route('admin.synonyms.index') }}">{{ __('navigation.synonyms') }}</a></li>
            <li class="is-active"><a>{{ __('navigation.new') }}</a></li>
        </ul>
    </div>
@endsection
