@extends('layouts.dashboard', ['title' => __('navigation.field_observations_import')])

@section('content')
    <div class="box content">
        <h1>Field observations import guide</h1>

        <div class="message mt-8">
            <div class="message-body">
                Importing data into Birdloger from a table is complex process.
                Some errors that are not easy to handle could appear during this task.
                Entering observations this way is justified if you have a large set of data,
                which is not easy to type into Birdloger web interface. However, before
                you choose to import data from the table, think about all other options
                and study this manual in details, so we can avoid unnecessary complications.
            </div>
        </div>

        <div>
            <p>To be completed</p>
        </div>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li><a href="{{ route('contributor.field-observations.index') }}">{{ __('navigation.my_field_observations') }}</a></li>
            <li><a href="{{ route('contributor.field-observations-import.index') }}">{{ __('navigation.field_observations_import') }}</a></li>
            <li class="is-active"><a>Import Guide</a></li>
        </ul>
    </div>
@endsection
