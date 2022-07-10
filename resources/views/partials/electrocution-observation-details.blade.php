<table class="table is-bordered is-narrow">
    <tbody>
        <tr>
            <td><b>{{ __('labels.field_observations.status') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->status_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.taxon') }}</b></td>
            <td class="is-fullwidth">{{ optional($electrocutionObservation->observation->taxon)->name }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.date') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->year }} {{ $electrocutionObservation->observation->month }} {{ $electrocutionObservation->observation->day }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.photos') }}</b></td>
            <td class="is-fullwidth">
                <div class="columns">
                    @foreach ($electrocutionObservation->photos as $photo)
                        <div class="column is-one-third">
                            <img src="{{ "{$photo->url}?v={$photo->updated_at->timestamp}" }}">
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.latitude') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->latitude }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.longitude') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->longitude }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.mgrs10k') }}</b></td>
            <td class="is-fullwidth">{{ preg_replace('/^[0-9]+[a-zA-Z]/', '$0 ', $electrocutionObservation->observation->mgrs10k) }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.accuracy_m') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->accuracy }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.elevation_m') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->elevation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.location') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->location }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.stage') }}</b></td>
            <td class="is-fullwidth">{{ optional($electrocutionObservation->observation->stage)->name_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.sex') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->sex_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.types') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->types->pluck('name')->filter()->implode(', ') }}</td>
        </tr>


        @if (optional($electrocutionObservation->observation->taxon)->uses_atlas_codes)
            @php
            $atlasCode = optional($electrocutionObservation->atlasCode())
            @endphp
            <tr>
                <td><b>{{ __('labels.field_observations.atlas_code') }}</b></td>
                <td class="is-fullwidth">
                    <div>{{ $atlasCode->name() }}</div>
                    <div>{{ $atlasCode->description() }}</div>
                </td>
            </tr>
        @endif

        <tr>
            <td><b>{{ __('labels.field_observations.number') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->number }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.number_of') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->number_of_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.data_provider') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->data_provider }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.data_limit') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->data_limit }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.fid') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->fid }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.rid') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->rid }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.note') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->note }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.habitat') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->habitat }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.time') }}</b></td>
            <td class="is-fullwidth">{{ optional($electrocutionObservation->time)->format('H:i') }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.description') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->description }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.comment') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->comment }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.project') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->project }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.dataset') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->dataset }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.found_dead') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->found_dead ? __('Yes') : __('No') }}</td>
        </tr>

        @if ($electrocutionObservation->observation->found_dead)
            <tr>
                <td><b>{{ __('labels.observations.found_dead_note') }}</b></td>
                <td class="is-fullwidth">{{ $electrocutionObservation->observation->found_dead_note }}</td>
            </tr>
        @endif

        <tr>
            <td><b>{{ __('labels.observations.observers') }}</b></td>
            <td class="is-fullwidth">
                @foreach ($electrocutionObservation->observation->observers as $observer)
                    {{$observer->firstName}} {{$observer->lastName}}
                    @if(!$loop->last)
                        {{";"}}
                    @endif
                @endforeach
            </td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.identifier') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->identifier }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.data_license') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->license_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.submitted_using') }}</b></td>
            <td class="is-fullwidth">{{ $electrocutionObservation->observation->client_name ?? __('Unknown') }}</td>
        </tr>
    </tbody>
</table>
