<table class="table is-bordered is-narrow">
    <tbody>

        <tr>
            <td><b>{{ __('labels.poaching_observations.case_name') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->case_name }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.date') }}</b></td>
            <td>{{ $poachingObservation->observation->day }}.{{ $poachingObservation->observation->month }}.{{ $poachingObservation->observation->year }}.</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.folder_id') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->folder_id}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.data_id') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->data_id}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.file') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->file}}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.offences') }}</b></td>
            <td>
                @foreach ($poachingObservation->offences as $offence){{__('labels.offence_cases.'.$offence->name)}}@if(!$loop->last){{","}}@endif
                @endforeach
            </td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.taxon') }}</b></td>
            <td class="is-fullwidth">{{ optional($poachingObservation->observation->taxon)->name }}</td>
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
            <td><b>{{ __('labels.observations.latitude') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->latitude }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.longitude') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->longitude }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.accuracy_m') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->accuracy }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.elevation_m') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->elevation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.offence_details') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->offence_details}}</td>
        </tr>

        @if ($poachingObservation->suspects != "[]")
            <tr>
                <td colspan="2" class="has-text-centered"><b>{{ __('labels.poaching_observations.suspects') }}</b></td>
            </tr>
            @foreach ($poachingObservation->suspects as $suspect)
                <tr>
                    <td><b>{{ __('labels.poaching_observations.suspect_name') }}</b></td>
                    <td class="is-fullwidth">{{$suspect->name}}</td>
                </tr>
                <tr>
                    <td><b>{{ __('labels.poaching_observations.suspect_place') }}</b></td>
                    <td class="is-fullwidth">{{$suspect->place}}</td>
                </tr>
                <tr>
                    <td><b>{{ __('labels.poaching_observations.suspect_profile') }}</b></td>
                    <td class="is-fullwidth">{{$suspect->profile}}</td>
                </tr>
                <tr>
                    <td><b>{{ __('labels.poaching_observations.suspect_phone') }}</b></td>
                    <td class="is-fullwidth">{{$suspect->phone}}</td>
                </tr>
                <tr>
                    <td><b>{{ __('labels.poaching_observations.suspect_email') }}</b></td>
                    <td class="is-fullwidth">{{$suspect->email}}</td>
                </tr>
                <tr>
                    <td><b>{{ __('labels.poaching_observations.suspect_social_media') }}</b></td>
                    <td class="is-fullwidth">{{$suspect->social_media}}</td>
                </tr>
                <tr>
                    <td><b>{{ __('labels.poaching_observations.suspect_note') }}</b></td>
                    <td class="is-fullwidth">{{$suspect->note}}</td>
                </tr>
                <tr><td colspan="2"></td></tr>
            @endforeach
        @endif

        <tr>
            <td><b>{{ __('labels.observations.photos') }}</b></td>
            <td>
                <div class="columns">
                    @foreach ($poachingObservation->photos as $photo)
                        <div class="column is-one-third">
                            <img alt="" src="{{ "{$photo->url}?v={$photo->updated_at->timestamp}" }}">
                        </div>
                    @endforeach
                </div>
            </td>
        </tr>

        @if ($poachingObservation->sources != "[]")
            <tr>
                <td colspan="2" class="has-text-centered"><b>{{ __('labels.poaching_observations.sources') }}</b></td>
            </tr>
            @foreach ($poachingObservation->sources as $source)
                <tr>
                    <td><b>{{ __('labels.poaching_observations.source') }}</b></td>
                    <td class="is-fullwidth">{{__('labels.poaching_observations.'.$source->name)}}</td>
                </tr>
                <tr>
                    <td><b>{{ __('labels.poaching_observations.source_description') }}</b></td>
                    <td class="is-fullwidth">{{$source->description}}</td>
                </tr>
                <tr>
                    <td><b>{{ __('labels.poaching_observations.source_link') }}</b></td>
                    @if ( preg_match( '@https?:\/\/(?:[0-9A-Z-]+\.)?(?:youtu\.be\/|youtube(?:-nocookie)?\.com\S*[^\w\s-]).*@i', $source->link ) )
                        <td>
                            <object width="425" height="350" data="http://www.youtube.com/v/{{ $source->ytid }}" type="application/x-shockwave-flash"></object>
                        </td>
                    @else
                        <td><a href="{{$source->link}}">{{$source->link}}</a></td>
                    @endif
                </tr>
                <tr><td colspan="2"></td> </tr>
            @endforeach
        @endif

        <tr>
            <td><b>{{ __('labels.poaching_observations.in_report') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->in_report ? __('Yes') : __('No') }}</td>
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
            <td class="is-fullwidth">
                @isset ( $poachingObservation->verdict )
                {{ __('labels.verdicts.'.$poachingObservation->verdict) }}
                @endisset
            </td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.verdict_date') }}</b></td>
            <td class="is-fullwidth">{{ date('d.m.Y.', strtotime($poachingObservation->verdict_date)) }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.proceeding') }}</b></td>
            <td class="is-fullwidth">
                @isset ( $poachingObservation->proceeding )
                    {{ __('labels.proceedings.'.$poachingObservation->proceeding) }}
                @endisset
            </td>
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
            <td><b>{{ __('labels.poaching_observations.case_submitted_to') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->case_submitted_to }}</td>
        </tr>

        @if( $poachingObservation->case_against )
        <tr>
            <td><b>{{ __('labels.poaching_observations.case_against') }}</b></td>
            <td class="is-fullwidth">{{ __('labels.poaching_observations.'.$poachingObservation->case_against) }}</td>
        </tr>

            @if( $poachingObservation->case_against === 'individual' )
                <tr>
                    <td><b>{{ __('labels.poaching_observations.case_against_mb') }}</b></td>
                    <td class="is-fullwidth">{{ $poachingObservation->case_against_mb }}</td>
                </tr>
            @elseif( $poachingObservation->case_against === 'legal_entity' )
                <tr>
                    <td><b>{{ __('labels.poaching_observations.case_against_pib') }}</b></td>
                    <td class="is-fullwidth">{{ $poachingObservation->case_against_pib }}</td>
                </tr>
            @endif
        @endif

        <tr>
            <td><b>{{ __('labels.poaching_observations.annotation') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->annotation}}</td>
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
            <td><b>{{ __('labels.observations.status') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->status_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.dataset') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->dataset }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.poaching_observations.indigenous') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->indigenous ? __('Yes') : __('No') }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.observers') }}</b></td>
            <td>
                @foreach ($poachingObservation->observation->observers as $observer)
                    {{$observer->name}}@if(!$loop->last){{","}}@endif
                @endforeach
            </td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.identifier') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->identifier }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.data_license') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->license_translation }}</td>
        </tr>

        <tr>
            <td><b>{{ __('labels.observations.submitted_using') }}</b></td>
            <td class="is-fullwidth">{{ $poachingObservation->observation->client_name ?? __('Unknown') }}</td>
        </tr>
    </tbody>
</table>
