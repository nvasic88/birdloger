<table class="table is-bordered is-narrow is-fullwidth">
    <tbody>
        <tr>
            <td><b>{{ __('labels.observations.status') }}</b></td>
            <td>{{ $electrocutionObservation->status_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.taxon') }}</b></td>
            <td>{{ optional($electrocutionObservation->observation->taxon)->name }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.date') }}</b></td>
            <td>{{ $electrocutionObservation->observation->day }}.{{ $electrocutionObservation->observation->month }}.{{ $electrocutionObservation->observation->year }}.</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.photos') }}</b></td>
            <td>
                <div class="columns">
                    @foreach ($electrocutionObservation->photos as $photo)
                        <div class="column is-one-third">
                            <img alt="" src="{{ "{$photo->url}?v={$photo->updated_at->timestamp}" }}">
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.latitude') }}</b></td>
            <td>{{ $electrocutionObservation->observation->latitude }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.longitude') }}</b></td>
            <td>{{ $electrocutionObservation->observation->longitude }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.accuracy_m') }}</b></td>
            <td>{{ $electrocutionObservation->observation->accuracy }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.elevation_m') }}</b></td>
            <td>{{ $electrocutionObservation->observation->elevation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.location') }}</b></td>
            <td>{{ $electrocutionObservation->observation->location }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.stage') }}</b></td>
            <td>{{ optional($electrocutionObservation->observation->stage)->name_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.sex') }}</b></td>
            <td>{{ $electrocutionObservation->observation->sex_translation }}</td>
        </tr>

        @if (optional($electrocutionObservation->observation->taxon)->uses_atlas_codes)
            @php
            $atlasCode = optional($electrocutionObservation->atlasCode())
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
            <td>{{ $electrocutionObservation->observation->number }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.number_of') }}</b></td>
            <td>{{ $electrocutionObservation->observation->number_of_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.data_provider') }}</b></td>
            <td>{{ $electrocutionObservation->observation->data_provider }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.data_limit') }}</b></td>
            <td>{{ $electrocutionObservation->observation->data_limit }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.note') }}</b></td>
            <td>{{ $electrocutionObservation->observation->note }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.habitat') }}</b></td>
            <td>{{ $electrocutionObservation->observation->habitat }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.project') }}</b></td>
            <td>{{ $electrocutionObservation->observation->project }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.dataset') }}</b></td>
            <td>{{ $electrocutionObservation->observation->dataset }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.electrocution_observations.death_cause') }}</b></td>
            <td> {{ __('labels.electrocution_observations.'.$electrocutionObservation->death_cause) }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.electrocution_observations.found_dead') }}</b></td>
            <td>{{ $electrocutionObservation->observation->found_dead ? __('Yes') : __('No') }}</td>
        </tr>

        @if ($electrocutionObservation->observation->found_dead)
            <tr>
                <td><b>{{ __('labels.electrocution_observations.found_dead_note') }}</b></td>
                <td>{{ $electrocutionObservation->observation->found_dead_note }}</td>
            </tr>
        @endif

        <tr>
            <td><b>{{ __('labels.electrocution_observations.time_of_corpse_found') }}</b></td>
            <td>{{ optional($electrocutionObservation->time_of_corpse_found)->format('H:i') }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.electrocution_observations.column_type') }}</b></td>
            <td>{{ $electrocutionObservation->column_type }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.electrocution_observations.console_type') }}</b></td>
            <td>{{ $electrocutionObservation->console_type }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.electrocution_observations.voltage') }}</b></td>
            <td>{{ $electrocutionObservation->voltage }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.electrocution_observations.iba') }}</b></td>
            <td>{{ $electrocutionObservation->iba }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.electrocution_observations.duration') }}</b></td>
            <td>{{ $electrocutionObservation->duration }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.electrocution_observations.distance_from_pillar') }}</b></td>
            <td>{{ $electrocutionObservation->distance_from_pillar }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.electrocution_observations.pillar_number') }}</b></td>
            <td>{{ $electrocutionObservation->pillar_number }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.electrocution_observations.age') }}</b></td>
            <td>{{ $electrocutionObservation->age }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.electrocution_observations.position') }}</b></td>
            <td>{{ $electrocutionObservation->position }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.electrocution_observations.state') }}</b></td>
            <td>{{ $electrocutionObservation->state }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.observers') }}</b></td>
            <td>
                @foreach ($electrocutionObservation->observation->observers as $observer)
                    {{$observer->firstName}} {{$observer->lastName}}@if(!$loop->last){{","}}@endif
                @endforeach
            </td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.data_license') }}</b></td>
            <td>{{ $electrocutionObservation->license_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.submitted_using') }}</b></td>
            <td>{{ $electrocutionObservation->observation->client_name ?? __('Unknown') }}</td>
        </tr>
    </tbody>
</table>
