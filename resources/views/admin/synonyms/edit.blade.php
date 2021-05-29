@extends('layouts.dashboard', ['title' => __('navigation.edit_synonyms')])

@section('content')
    <div class="box">
        <nz-synonym-form
            action="{{ route('api.synonyms.update', $synonym) }}"
            method="PUT"
            redirect-url="{{ route('admin.synonyms.index') }}"
            cancel-url="{{ route('admin.synonyms.index') }}"
            :synonym="{{ $synonym->makeHidden('translations') }}"
            :synonyms="{{ $synonym }}"
            should-confirm-cancel
            submit-only-dirty
        ></nz-synonym-form>
    </div>
@endsection

@section('breadcrumbs')
    <div class="breadcrumb" aria-label="breadcrumbs">
        <ul>
            <li><a href="{{ route('contributor.index') }}">{{ __('navigation.dashboard') }}</a></li>
            <li><a href="{{ route('admin.synonyms.index') }}">{{ __('navigation.synonyms') }}</a></li>
            <li class="is-active"><a>{{ __('navigation.edit') }}</a></li>
        </ul>
    </div>
@endsection
<script>
    import NzSynonymForm from "../../../js/components/forms/SynonymForm";
    export default {
        components: {NzSynonymForm}
    }
</script>
