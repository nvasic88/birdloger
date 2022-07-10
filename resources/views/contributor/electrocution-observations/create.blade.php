@extends('layouts.dashboard', ['title' => __('navigation.new_observation')])

@section('content')
    <div class="box">
        <nz-electrocution-observation-form
            action="{{ route('api.electrocution-observations.store') }}"
            method="POST"
            redirect-url="{{ route('contributor.electrocution-observations.index') }}"
            cancel-url="{{ route('contributor.electrocution-observations.index') }}"
            :licenses="{{ json_encode(\App\License::getOptions()) }}"
            :sexes="{{ \App\Sex::options() }}"
            :observation-types="{{ \App\ObservationType::all() }}"
            :atlas-codes="{{ \App\AtlasCode::all() }}"
            :stages="{{\App\Stage::all()}}"
            submit-more
            should-confirm-cancel
            @role([
            'admin', 'electrocution'])
            show-observer-identifier
            @endrole
        />
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li>
                <a href="{{ route('contributor.electrocution-observations.index') }}">{{ __('navigation.my_electrocution_observations') }}</a>
            </li>
            <li class="is-active"><a>{{ __('navigation.new') }}</a></li>
        </ul>
    </div>
@endsection

@push('headerScripts')
    <script>
        window.App.gmaps.load = true;
    </script>
@endpush
