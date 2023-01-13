<table class="table is-bordered is-narrow is-fullwidth">
    <tbody>
        <tr>
            <td><b>{{ __('labels.observations.status') }}</b></td>
            <td>{{ $fieldObservation->status_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.taxon') }}</b></td>
            <td>{{ optional($fieldObservation->observation->taxon)->name }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.date') }}</b></td>
            <td>{{ $fieldObservation->observation->day }}.{{ $fieldObservation->observation->month }}.{{ $fieldObservation->observation->year }}.</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.photos') }}</b></td>
            <td>
                <div class="columns">
                    @foreach ($fieldObservation->photos as $photo)
                        <div class="column is-one-third">
                            <img src="{{ "{$photo->url}?v={$photo->updated_at->timestamp}" }}" alt="">
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.latitude') }}</b></td>
            <td>{{ $fieldObservation->observation->latitude }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.longitude') }}</b></td>
            <td>{{ $fieldObservation->observation->longitude }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.mgrs10k') }}</b></td>
            <td>{{ preg_replace('/^[0-9]+[a-zA-Z]/', '$0 ', $fieldObservation->observation->mgrs10k) }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.accuracy_m') }}</b></td>
            <td>{{ $fieldObservation->observation->accuracy }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.elevation_m') }}</b></td>
            <td>{{ $fieldObservation->observation->elevation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.location') }}</b></td>
            <td>{{ $fieldObservation->observation->location }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.stage') }}</b></td>
            <td>{{ optional($fieldObservation->observation->stage)->name_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.sex') }}</b></td>
            <td>{{ $fieldObservation->observation->sex_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.types') }}</b></td>
            <td>{{ $fieldObservation->observation->types->pluck('name')->filter()->implode(', ') }}</td>
        </tr>


        @if (optional($fieldObservation->observation->taxon)->uses_atlas_codes)
            @php
            $atlasCode = optional($fieldObservation->atlasCode())
            @endphp
            <tr>
                <td><b>{{ __('labels.observations.atlas_code') }}</b></td>
                <td>
                    <div>{{ $atlasCode->name() }}</div>
                    <div>{{ $atlasCode->description() }}</div>
                </td>
            </tr>
        @endif

        <tr>
            <td><b>{{ __('labels.observations.number') }}</b></td>
            <td>{{ $fieldObservation->observation->number }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.number_of') }}</b></td>
            <td>{{ $fieldObservation->observation->number_of_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.data_provider') }}</b></td>
            <td>{{ $fieldObservation->observation->data_provider }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.data_limit') }}</b></td>
            <td>{{ $fieldObservation->observation->data_limit }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.fid') }}</b></td>
            <td>{{ $fieldObservation->observation->fid }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.rid') }}</b></td>
            <td>{{ $fieldObservation->observation->rid }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.note') }}</b></td>
            <td>{{ $fieldObservation->observation->note }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.habitat') }}</b></td>
            <td>{{ $fieldObservation->observation->habitat }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.time') }}</b></td>
            <td>{{ optional($fieldObservation->time)->format('H:i') }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.description') }}</b></td>
            <td>{{ $fieldObservation->observation->description }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.comment') }}</b></td>
            <td>{{ $fieldObservation->observation->comment }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.project') }}</b></td>
            <td>{{ $fieldObservation->observation->project }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.dataset') }}</b></td>
            <td>{{ $fieldObservation->observation->dataset }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.found_dead') }}</b></td>
            <td>{{ $fieldObservation->observation->found_dead ? __('Yes') : __('No') }}</td>
        </tr>

        @if ($fieldObservation->observation->found_dead)
            <tr>
                <td><b>{{ __('labels.observations.found_dead_note') }}</b></td>
                <td>{{ $fieldObservation->observation->found_dead_note }}</td>
            </tr>
        @endif

        <tr>
            <td><b>{{ __('labels.observations.observers') }}</b></td>
            <td>
                @foreach ($fieldObservation->observation->observers as $observer)
                    {{$observer->firstName}} {{$observer->lastName}}@if(!$loop->last){{";"}}@endif
                @endforeach
            </td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.identifier') }}</b></td>
            <td>{{ $fieldObservation->identifier }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.data_license') }}</b></td>
            <td>{{ $fieldObservation->license_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.submitted_using') }}</b></td>
            <td>{{ $fieldObservation->observation->client_name ?? __('Unknown') }}</td>
        </tr>
    </tbody>
</table>
