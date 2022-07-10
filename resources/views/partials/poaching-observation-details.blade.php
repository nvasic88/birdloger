<table class="table is-bordered is-narrow">
    <tbody>
        <tr>
            <td><b>{{ __('labels.field_observations.status') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->status_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.taxon') }}</b></td>
            <td class="is-fullwidth">{{ optional($poachingObservation->observation->taxon)->name }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.date') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->year }} {{ $poachingObservation->observation->month }} {{ $poachingObservation->observation->day }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.photos') }}</b></td>
            <td class="is-fullwidth">
                <div class="columns">
                    @foreach ($poachingObservation->photos as $photo)
                        <div class="column is-one-third">
                            <img src="{{ "{$photo->url}?v={$photo->updated_at->timestamp}" }}">
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.latitude') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->latitude }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.longitude') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->longitude }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.mgrs10k') }}</b></td>
            <td class="is-fullwidth">{{ preg_replace('/^[0-9]+[a-zA-Z]/', '$0 ', $poachingObservation->observation->mgrs10k) }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.accuracy_m') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->accuracy }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.elevation_m') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->elevation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.dataset') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->dataset }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.data_id') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->data_id}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.folder_id') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->folder_id}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.file') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->file}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.in_report') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->in_report ? __('Yes') : __('No') }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.locality') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->locality}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.municipality') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->municipality}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.place') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->place}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.indigenous') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->indigenous ? __('Yes') : __('No') }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.total') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->total}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.dead_from_total') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->dead_from_total}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.alive_from_total') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->alive_from_total}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.exact_number') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->exact_number ? __('Yes') : __('No') }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.offences') }}</b></td>
            <td class="is-fullwidth">
                @foreach ($poachingObservation->offences as $offence)
                    {{__('labels.offence_cases.'.$offence->name)}}
                    @if(!$loop->last)
                        {{";"}}
                    @endif
                @endforeach
            </td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.case_reported') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->case_reported ? __('Yes') : __('No') }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.case_reported_by') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->case_reported_by}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.verdict') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->verdict}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.verdict_date') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->verdict_date}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.proceeding') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->proceeding}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.sanction_rsd') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->sanction_rsd}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.sanction_eur') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->sanction_eur}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.community_sentence') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->community_sentence}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.opportunity') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->opportunity ? __('Yes') : __('No') }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.annotation') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->annotation}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.suspect_name') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->suspect_name}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.suspect_place') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->suspect_place}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.suspects_number') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->suspects_number}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.suspect_profile') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->suspect_profile}}</td>
        </tr>

        <tr>
            <td colspan="2"><b>{{ __('labels.poaching_observations.sources') }}</b></td>
        </tr>
        @foreach ($poachingObservation->sources as $source)
            <tr>
                <td>{{ __('labels.poaching_observations.source') }}</td>
                <td class="is-fullwidth">{{__('labels.poaching_observations.'.$source->name)}}</td>
            </tr>
            <tr>
                <td>{{ __('labels.poaching_observations.source_description') }}</td>
                <td class="is-fullwidth">{{$source->description}}</td>
            </tr>
            <tr>
                <td>{{ __('labels.poaching_observations.source_link') }}</td>
                <td class="is-fullwidth"><a href="{{$source->link}}">{{$source->link}}</a></td>
            </tr>
        @endforeach

        <tr>
            <td><b>{{ __('labels.observations.observers') }}</b></td>
            <td class="is-fullwidth">
                @foreach ($poachingObservation->observation->observers as $observer)
                    {{$observer->firstName}} {{$observer->lastName}}
                    @if(!$loop->last)
                        {{";"}}
                    @endif
                @endforeach
            </td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.cites') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->cites}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.origin_of_individuals') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->origin_of_individuals}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.identifier') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->identifier }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.data_license') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->license_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.field_observations.submitted_using') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->client_name ?? __('Unknown') }}</td>
        </tr>
    </tbody>
</table>
