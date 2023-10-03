<template>
  <form :action="action" method="POST" :lang="locale" class="poaching-observation-form">
    <div class="columns is-desktop">
      <div class="column is-half-desktop">
        <nz-taxon-species-autocomplete
          v-model="form.taxon_suggestion"
          @select="onTaxonSelect"
          :taxon="observation.taxon"
          :error="form.errors.has('taxon_id')"
          :message="form.errors.has('taxon_id') ? form.errors.first('taxon_id') : null"
          autofocus
          ref="taxonAutocomplete"
          :label="trans('labels.observations.taxon')"
          :placeholder="trans('labels.observations.search_for_taxon')"
        />

        <nz-date-input
          :year.sync="form.year"
          :month.sync="form.month"
          :day.sync="form.day"
          :errors="form.errors"
          :label="trans('labels.observations.date')"
          :placeholders="{
              year: trans('labels.observations.year'),
              month: trans('labels.observations.month'),
              day: trans('labels.observations.day')
          }"
        />

        <b-field :label="trans('labels.observations.photos')">
          <div class="columns">
            <div class="column is-one-third">
              <nz-photo-upload
                :image-url="getObservationPhotoAttribute(0, 'url')"
                :image-path="getObservationPhotoAttribute(0, 'path')"
                :image-license="getObservationPhotoAttribute(0, 'license')"
                :licenses="licenses"
                :text="trans('labels.observations.upload')"
                @uploaded="onPhotoUploaded"
                @removed="onPhotoRemoved"
                @cropped="onPhotoCropped"
                @license-changed="onLicenseChanged(0, $event)"
                :errors="form.errors"
                ref="photoUpload-1"
              />
            </div>

            <div class="column is-one-third">
              <nz-photo-upload
                :image-url="getObservationPhotoAttribute(1, 'url')"
                :image-path="getObservationPhotoAttribute(1, 'path')"
                :image-license="getObservationPhotoAttribute(1, 'license')"
                :licenses="licenses"
                :text="trans('labels.observations.upload')"
                @uploaded="onPhotoUploaded"
                @removed="onPhotoRemoved"
                @cropped="onPhotoCropped"
                @license-changed="onLicenseChanged(1, $event)"
                :errors="form.errors"
                ref="photoUpload-2"
              />
            </div>

            <div class="column is-one-third">
              <nz-photo-upload
                :image-url="getObservationPhotoAttribute(2, 'url')"
                :image-path="getObservationPhotoAttribute(2, 'path')"
                :image-license="getObservationPhotoAttribute(2, 'license')"
                :licenses="licenses"
                :text="trans('labels.observations.upload')"
                @uploaded="onPhotoUploaded"
                @removed="onPhotoRemoved"
                @cropped="onPhotoCropped"
                @license-changed="onLicenseChanged(2, $event)"
                :errors="form.errors"
                ref="photoUpload-3"
              />
            </div>
          </div>
        </b-field>
      </div>

      <div class="column is-half-desktop">
        <nz-spatial-input
          :latitude.sync="form.latitude"
          :longitude.sync="form.longitude"
          :location.sync="form.location"
          :accuracy.sync="form.accuracy"
          :elevation.sync="form.elevation"
          :errors="form.errors"
        />
      </div>
    </div>

    <button
      type="button"
      class="button is-text"
      @click="showMoreDetails = !showMoreDetails"
    >
      {{
        showMoreDetails ? trans('labels.observations.less_details') : trans('labels.observations.more_details')
      }}
    </button>

    <div class="mt-4" v-show="showMoreDetails">

      <div>
        <b-field
          :label="trans('labels.poaching_observations.case_name')"
          label-for="case_name"
          :type="form.errors.has('case_name') ? 'is-danger' : null"
          :message="form.errors.has('case_name') ? form.errors.first('case_name') : null"
        >
          <b-input id="case_name" name="case_name" v-model="form.case_name"/>
        </b-field>
      </div>

      <div class="columns">

        <div class="column">
          <b-field
            :label="trans('labels.observations.stage')"
            label-for="stage"
            :type="form.errors.has('stage_id') ? 'is-danger' : null"
            :message="form.errors.has('stage_id') ? form.errors.first('stage_id') : null"
          >
            <b-select id="stage" v-model="form.stage_id" :disabled="!stages.length" @input="lastStageId = $event"
                      expanded>
              <option :value="null">{{ trans('labels.observations.choose_a_stage') }}</option>
              <option v-for="stage in stages" :value="stage.id" :key="stage.id"
                      v-text="trans(`stages.${stage.name}`)"></option>
            </b-select>
          </b-field>
        </div>

        <div class="column">
          <b-field
            :label="trans('labels.observations.sex')"
            :type="form.errors.has('sex') ? 'is-danger' : null"
            :message="form.errors.has('sex') ? form.errors.first('sex') : null"
          >
            <b-select v-model="form.sex" expanded>
              <option :value="null">{{ trans('labels.observations.choose_a_value') }}</option>
              <option v-for="(label,sex) in sexes" :key="sex" :value="sex" v-text="label"></option>
            </b-select>
          </b-field>
        </div>
      </div>

      <b-field
        :label="trans('labels.observations.types')"
        :error="form.errors.has('observation_types_ids')"
        :message="form.errors.has('observation_types_ids') ? form.errors.first('observation_types_ids') : null"
      >
        <b-taginput
          v-model="selectedObservationTypes"
          :data="availableObservationTypes"
          autocomplete
          :allowNew="false"
          field="name"
          icon="tag"
          :placeholder="trans('labels.observations.types_placeholder')"
          @typing="onTypeTyping"
          @keyup.native.delete="onTypeBackspace"
          open-on-focus
        >
          <template v-slot:default="props">
            <span>{{ props.option.name }}</span>
          </template>
        </b-taginput>
      </b-field>

      <b-field
        :label="trans('labels.observations.atlas_code')"
        label-for="atlas-code"
        :type="form.errors.has('atlas_code') ? 'is-danger' : null"
        :message="form.errors.has('atlas_code') ? form.errors.first('atlas_code') : null"
      >
        <b-select id="atlas-code" v-model="form.atlas_code" expanded>
          <option :value="null">{{ trans('labels.observations.choose_a_value') }}</option>
          <option v-for="atlasCode in atlasCodes" :value="atlasCode.code" v-text="atlasCode.name"
                  :key="atlasCode.code"></option>
        </b-select>
      </b-field>


      <div class="columns">
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.total')"
            label-for="total"
            :type="form.errors.has('total') ? 'is-danger' : null"
            :message="form.errors.has('total') ? form.errors.first('total') : null"
          >
            <b-input id="total" name="total" type="number" v-model="form.total"/>
          </b-field>
        </div>
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.dead_from_total')"
            label-for="dead_from_total"
            :type="form.errors.has('dead_from_total') ? 'is-danger' : null"
            :message="form.errors.has('dead_from_total') ? form.errors.first('dead_from_total') : null"
          >
            <b-input id="dead_from_total" name="dead_from_total" type="number" v-model="form.dead_from_total"/>
          </b-field>
        </div>
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.alive_from_total')"
            label-for="alive_from_total"
            :type="form.errors.has('alive_from_total') ? 'is-danger' : null"
            :message="form.errors.has('alive_from_total') ? form.errors.first('alive_from_total') : null"
          >
            <b-input id="alive_from_total" name="alive_from_total" type="number" v-model="form.alive_from_total"/>
          </b-field>
        </div>
        <div class="column">
          <b-field :label="trans('labels.poaching_observations.exact_number')">
            <b-switch v-model="form.exact_number">
              {{ form.exact_number ? trans("Yes") : trans("No") }}
            </b-switch>
          </b-field>
        </div>
        <div class="column">
          <b-field :label="trans('labels.poaching_observations.indigenous')">
            <b-switch v-model="form.indigenous">
              {{ form.indigenous ? trans("Yes") : trans("No") }}
            </b-switch>
          </b-field>
        </div>
      </div>

      <b-field :label="trans('labels.poaching_observations.offences')">
        <div class="block">
          <b-checkbox
            v-for="offence in offences"
            :key="offence.id"
            v-model="form.offences_ids"
            :native-value="offence.id"
          >
            {{ trans('labels.offence_cases.' + offence.name) }}
          </b-checkbox>
        </div>
      </b-field>

      <div class="columns">
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.locality')"
            label-for="locality"
            :type="form.errors.has('locality') ? 'is-danger' : null"
            :message="form.errors.has('locality') ? form.errors.first('locality') : null"
          >
            <b-input id="locality" name="locality" v-model="form.locality"/>
          </b-field>
        </div>
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.place')"
            label-for="place"
            :type="form.errors.has('place') ? 'is-danger' : null"
            :message="form.errors.has('place') ? form.errors.first('place') : null"
          >
            <b-input id="place" name="place" v-model="form.place"/>
          </b-field>
        </div>
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.municipality')"
            label-for="municipality"
            :type="form.errors.has('municipality') ? 'is-danger' : null"
            :message="form.errors.has('municipality') ? form.errors.first('municipality') : null"
          >
            <b-input id="municipality" name="municipality" v-model="form.municipality"/>
          </b-field>
        </div>
      </div>


      <div class="columns">
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.data_id')"
            label-for="data_id"
            :type="form.errors.has('data_id') ? 'is-danger' : null"
            :message="form.errors.has('data_id') ? form.errors.first('data_id') : null"
          >
            <b-input id="data_id" name="data_id" v-model="form.data_id"/>
          </b-field>
        </div>
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.folder_id')"
            label-for="municipality"
            :type="form.errors.has('folder_id') ? 'is-danger' : null"
            :message="form.errors.has('folder_id') ? form.errors.first('folder_id') : null"
          >
            <b-input id="folder_id" name="folder_id" v-model="form.folder_id"/>
          </b-field>
        </div>
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.file')"
            label-for="file"
            :type="form.errors.has('file') ? 'is-danger' : null"
            :message="form.errors.has('file') ? form.errors.first('file') : null"
          >
            <b-input id="file" name="file" v-model="form.file"/>
          </b-field>
        </div>
      </div>

      <b-field :label="trans('labels.poaching_observations.in_report')">
        <b-switch v-model="form.in_report">
          {{ form.in_report ? trans("Yes") : trans("No") }}
        </b-switch>
      </b-field>

      <b-field
        :label="trans('labels.poaching_observations.offence_details')"
        label-for="offence_details"
        :error="form.errors.has('offence_details')"
        :message="form.errors.has('offence_details') ? form.errors.first('offence_details') : null"
      >
        <b-input id="offence_details" type="textarea" v-model="form.offence_details"/>
      </b-field>

      <b-checkbox v-model="form.case_reported">{{ trans('labels.poaching_observations.case_reported') }}</b-checkbox>

      <div class="columns" v-if="form.case_reported">
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.case_reported_by')"
            label-for="case_reported_by"
            :type="form.errors.has('case_reported_by') ? 'is-danger' : null"
            :message="form.errors.has('case_reported_by') ? form.errors.first('case_reported_by') : null"
          >
            <b-input id="case_reported_by" name="case_reported_by" v-model="form.case_reported_by"/>
          </b-field>
        </div>
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.verdict')"
            label-for="verdict"
            :type="form.errors.has('verdict') ? 'is-danger' : null"
            :message="form.errors.has('verdict') ? form.errors.first('verdict') : null"
          >
            <b-select v-model="form.verdict" expanded>
              <option :value="null">{{ trans("labels.verdicts.unknown") }}</option>
              <option value="yes">{{ trans("labels.verdicts.yes") }}</option>
              <option value="no">{{ trans("labels.verdicts.no") }}</option>
              <option value="rejected">{{ trans("labels.verdicts.rejected") }}</option>
              <option value="declined">{{ trans("labels.verdicts.declined") }}</option>
              <option value="in_progress">{{ trans("labels.verdicts.in_progress") }}</option>
            </b-select>
          </b-field>
        </div>
        <div class="column">
          <b-field :label="trans('labels.poaching_observations.verdict_date')">
            <b-datepicker
              v-model="form.verdict_date"
              :locale="locale"
              :placeholder="trans('labels.poaching_observations.select_date')"
              icon="calendar-today"
              trap-focus>
            </b-datepicker>
          </b-field>
        </div>
      </div>

      <div class="columns" v-if="form.case_reported">
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.sanction_rsd')"
            label-for="sanction_rsd"
            :type="form.errors.has('sanction_rsd') ? 'is-danger' : null"
            :message="form.errors.has('sanction_rsd') ? form.errors.first('sanction_rsd') : null"
          >
            <b-input id="sanction_rsd" name="sanction_rsd" type="int" v-model="form.sanction_rsd"/>
          </b-field>
        </div>
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.sanction_eur')"
            label-for="sanction_eur"
            :type="form.errors.has('sanction_eur') ? 'is-danger' : null"
            :message="form.errors.has('sanction_eur') ? form.errors.first('sanction_eur') : null"
          >
            <b-input id="sanction_eur" name="sanction_eur" type="int" v-model="form.sanction_eur"/>
          </b-field>
        </div>
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.community_sentence')"
            label-for="community_sentence"
            :type="form.errors.has('community_sentence') ? 'is-danger' : null"
            :message="form.errors.has('community_sentence') ? form.errors.first('community_sentence') : null"
          >
            <b-input id="community_sentence" name="community_sentence" type="int" v-model="form.community_sentence"/>
          </b-field>
        </div>
      </div>

      <div class="columns" v-if="form.case_reported">
        <div class="column is-one-third">
          <b-field
            :label="trans('labels.poaching_observations.case_submitted_to')"
            label-for="case_submitted_to"
            :type="form.errors.has('case_submitted_to') ? 'is-danger' : null"
            :message="form.errors.has('case_submitted_to') ? form.errors.first('case_submitted_to') : null"
          >
            <b-input id="case_submitted_to" name="case_submitted_to" v-model="form.case_submitted_to"/>
          </b-field>
        </div>
        <div class="column is-one-third">
          <b-field
            :label="trans('labels.poaching_observations.case_against')"
            label-for="case_against"
            :type="form.errors.has('case_against') ? 'is-danger' : null"
            :message="form.errors.has('case_against') ? form.errors.first('case_against') : null"
          >
            <b-select v-model="form.case_against" expanded>
              <option :value="null">{{ trans('labels.observations.choose_a_value') }}</option>
              <option value="individual">{{ trans("labels.poaching_observations.individual") }}</option>
              <option value="legal_entity">{{ trans("labels.poaching_observations.legal_entity") }}</option>
            </b-select>
          </b-field>
        </div>
        <div class="column is-one-third" v-if="form.case_against === 'individual'">
          <b-field
            :label="trans('labels.poaching_observations.case_against_mb')"
            label-for="case_against_mb"
            :type="form.errors.has('case_against_mb') ? 'is-danger' : null"
            :message="form.errors.has('case_against_mb') ? form.errors.first('case_against_mb') : null"
          >
            <b-input id="case_against_mb" name="case_against_mb" v-model="form.case_against_mb"/>
          </b-field>
        </div>
        <div class="column is-one-third" v-if="form.case_against === 'legal_entity'">
          <b-field
            :label="trans('labels.poaching_observations.case_against_pib')"
            label-for="case_against_pib"
            :type="form.errors.has('case_against_pib') ? 'is-danger' : null"
            :message="form.errors.has('case_against_pib') ? form.errors.first('case_against_pib') : null"
          >
            <b-input id="case_against_pib" name="case_against_pib" v-model="form.case_against_pib"/>
          </b-field>
        </div>
      </div>
      <div class="columns" v-if="form.case_reported">
        <div class="column">
          <b-field
            :label="trans('labels.poaching_observations.proceeding')"
            label-for="proceeding"
            :type="form.errors.has('proceeding') ? 'is-danger' : null"
            :message="form.errors.has('proceeding') ? form.errors.first('proceeding') : null"
          >
            <b-select v-model="form.proceeding" expanded>
              <option :value="null">{{ trans('labels.observations.choose_a_value') }}</option>
              <option value="misdemeanor">{{ trans("labels.proceedings.misdemeanor") }}</option>
              <option value="criminal">{{ trans("labels.proceedings.criminal") }}</option>
            </b-select>
          </b-field>
        </div>
        <div class="column">
          <b-field :label="trans('labels.poaching_observations.opportunity')">
            <b-switch v-model="form.opportunity">
              {{ form.opportunity ? trans("Yes") : trans("No") }}
            </b-switch>
          </b-field>
        </div>
      </div>

      <b-field
        :label="trans('labels.poaching_observations.annotation')"
        label-for="annotation"
        :error="form.errors.has('annotation')"
        :message="form.errors.has('annotation') ? form.errors.first('annotation') : null"
      >
        <b-input id="annotation" type="textarea" v-model="form.annotation"/>
      </b-field>

      <b-field
        :label="trans('labels.poaching_observations.cites')"
        label-for="cites"
        :type="form.errors.has('cites') ? 'is-danger' : null"
        :message="form.errors.has('cites') ? form.errors.first('cites') : null"
      >
        <b-select v-model="form.cites" expanded>
          <option :value="null">{{ trans('labels.observations.choose_a_value') }}</option>
          <option value="appendix_I">{{ trans("labels.cites.appendix_I") }}</option>
          <option value="appendix_II">{{ trans("labels.cites.appendix_II") }}</option>
          <option value="appendix_III">{{ trans("labels.cites.appendix_III") }}</option>
        </b-select>
      </b-field>

      <b-field
        :label="trans('labels.poaching_observations.origin_of_individuals')"
        label-for="origin_of_individuals"
        :type="form.errors.has('origin_of_individuals') ? 'is-danger' : null"
        :message="form.errors.has('origin_of_individuals') ? form.errors.first('origin_of_individuals') : null"
      >
        <b-input id="origin_of_individuals" name="origin_of_individuals"
                 v-model="form.origin_of_individuals"/>
      </b-field>

      <hr>

      <b-field
        :label="trans('labels.poaching_observations.suspects')"
        :type="form.errors.has('suspects') ? 'is-danger' : null"
        :message="form.errors.has('suspects') ? form.errors.first('suspects') : null"
        :addons="false"
      >
        <b-field
          v-for="(_,i) in suspects"
          :key="i"
          expanded
          :addons="false"
        >
          <b-field expanded>
            <b-input
              :name="`suspects[${i}][name]`"
              v-model="form.suspects[i].name"
              :placeholder="trans('labels.poaching_observations.suspect_name')"
              expanded
              required
            />

            <b-input
              :name="`suspects[${i}][place]`"
              v-model="form.suspects[i].place"
              :placeholder="trans('labels.poaching_observations.suspect_place')"
              expanded
            />

            <b-input
              :name="`suspects[${i}][profile]`"
              v-model="form.suspects[i].profile"
              :placeholder="trans('labels.poaching_observations.suspect_profile')"
              expanded
            />

            <b-input
              :name="`suspects[${i}][phone]`"
              v-model="form.suspects[i].phone"
              :placeholder="trans('labels.poaching_observations.suspect_phone')"
              expanded
            />

            <b-input
              :name="`suspects[${i}][email]`"
              v-model="form.suspects[i].email"
              :placeholder="trans('labels.poaching_observations.suspect_email')"
              expanded
            />
          </b-field>

          <b-field>
            <b-input
              :name="`suspects[${i}][social_media]`"
              v-model="form.suspects[i].social_media"
              :placeholder="trans('labels.poaching_observations.suspect_social_media')"
              type="textarea" rows="1"
            />
          </b-field>

          <b-field>
            <b-input
              :name="`suspects[${i}][note]`"
              v-model="form.suspects[i].note"
              :placeholder="trans('labels.poaching_observations.suspect_note')"
              type="textarea" rows="1"
            />
          </b-field>
          <b-field>
            <p class="control">
              <button type="button" class="button is-danger is-outlined" @click="removeSuspect(i)">
                <b-icon icon="times" size="is-small"/>
                &nbsp {{ trans('labels.poaching_observations.remove_suspect') }}
              </button>
            </p>
            <hr>
          </b-field>

        </b-field>
      </b-field>

      <b-field
        :label="trans('labels.poaching_observations.new_suspect_details')"
        :type="suspectErrors ? 'is-danger' : null"
        :message="suspectErrors ? trans(suspectErrors) : null"
        :addons="false"
      >
        <b-field>
          <b-input id="suspect_name" maxlength="50" v-model="suspect_name"
                   :placeholder="trans('labels.poaching_observations.suspect_name')"
                   v-on:keydown.native.enter.prevent="addSuspect"
          />

          <b-input id="suspect_place" maxlength="50" v-model="suspect_place"
                   :placeholder="trans('labels.poaching_observations.suspect_place')"
                   v-on:keydown.native.enter.prevent="addSuspect"
          />

          <b-input id="suspect_profile" maxlength="50" v-model="suspect_profile"
                   :placeholder="trans('labels.poaching_observations.suspect_profile')"
                   v-on:keydown.native.enter.prevent="addSuspect"
          />

          <b-input id="suspect_phone" maxlength="50" v-model="suspect_phone"
                   :placeholder="trans('labels.poaching_observations.suspect_phone')"
                   v-on:keydown.native.enter.prevent="addSuspect"
          />

          <b-input id="suspect_phone" maxlength="50" v-model="suspect_email"
                   :placeholder="trans('labels.poaching_observations.suspect_email')"
                   v-on:keydown.native.enter.prevent="addSuspect"
          />
        </b-field>

        <b-field>
          <b-input id="suspect_social_media"
                   v-model="suspect_social_media"
                   :placeholder="trans('labels.poaching_observations.suspect_social_media')"
                   type="textarea" rows="1"
          />
        </b-field>

        <b-field>
          <b-input id="suspect_note"
                   v-model="suspect_note"
                   :placeholder="trans('labels.poaching_observations.suspect_note')"
                   type="textarea" rows="1"
          />
        </b-field>

        <b-field>
          <p class="control">
            <button type="button" class="button is-secondary is-outlined" @click="addSuspect">
              {{ trans('labels.poaching_observations.add_suspect') }}
            </button>
          </p>
        </b-field>

      </b-field>

      <hr>

      <b-field
        :label="trans('labels.poaching_observations.sources')"
        :type="sourceErrors ? 'is-danger' : null"
        :message="sourceErrors ? trans(sourceErrors) : null"
        :addons="false"
      >
        <b-field
          v-for="(_,i) in sources"
          :key="i"
          expanded
          :addons="false"
        >
          <b-field expanded>
            <b-select
              :name="`sources[${i}][name]`"
              v-model="form.sources[i].name"
              expanded
              required
            >
              <option :value="null">{{ trans('labels.poaching_observations.insert_source') }}</option>
              <option value="social_media">{{ trans("labels.poaching_observations.social_media") }}</option>
              <option value="media">{{ trans("labels.poaching_observations.media") }}</option>
              <option value="ads">{{ trans("labels.poaching_observations.ads") }}</option>
              <option value="institutions">{{ trans("labels.poaching_observations.institutions") }}</option>
              <option value="associates">{{ trans("labels.poaching_observations.associates") }}</option>
              <option value="youtube">{{ trans("labels.poaching_observations.youtube") }}</option>
            </b-select>

            <b-input
              :name="`sources[${i}][description]`"
              v-model="form.sources[i].description"
              :placeholder="trans('labels.poaching_observations.source_description')"
              :maxlength="50"
              expanded
            />

            <b-input
              :name="`sources[${i}][link]`"
              v-model="form.sources[i].link"
              :placeholder="trans('labels.poaching_observations.source_link')"
              :maxlength="255"
              expanded
            />

            <b-input
              :name="`sources[${i}][ytid]`"
              v-model="form.sources[i].ytid"
              :maxlength="11"
              type="hidden"
            />

            <p class="control">
              <button type="button" class="button is-danger is-outlined" @click="removeSource(i)">
                <b-icon icon="times" size="is-small"/>
              </button>
            </p>

          </b-field>
        </b-field>

        <b-field>
          <b-select v-model="form.source" expanded>
            <option :value="null">{{ trans('labels.poaching_observations.insert_source') }}</option>
            <option value="social_media">{{ trans("labels.poaching_observations.social_media") }}</option>
            <option value="media">{{ trans("labels.poaching_observations.media") }}</option>
            <option value="ads">{{ trans("labels.poaching_observations.ads") }}</option>
            <option value="institutions">{{ trans("labels.poaching_observations.institutions") }}</option>
            <option value="associates">{{ trans("labels.poaching_observations.associates") }}</option>
            <option value="youtube">{{ trans("labels.poaching_observations.youtube") }}</option>
          </b-select>

          <b-input id="sourceDescription" maxlength="50" v-model="sourceDescription"
                   :placeholder="trans('labels.poaching_observations.insert_source_description')"
                   expanded
                   v-on:keydown.native.enter.prevent="addSource"
          />

          <b-input id="sourceLink" maxlength="50" v-model="sourceLink"
                   :placeholder="trans('labels.poaching_observations.insert_source_link')"
                   expanded
                   :maxlength="255"
                   v-on:keydown.native.enter.prevent="addSource"
          />

          <p class="control">
            <button type="button" class="button is-secondary is-outlined" @click="addSource">
              {{ trans('labels.poaching_observations.add_source') }}
            </button>
          </p>
        </b-field>
      </b-field>

      <hr>

      <b-field
        :label="trans('labels.observations.observers')"
        :type="form.errors.has('observers') ? 'is-danger' : null"
        :message="form.errors.has('observers') ? form.errors.first('observers') : null"
        :addons="false"
      >
        <b-field
          v-for="(_,i) in observers"
          :key="i"
          expanded
          :addons="false"
        >
          <b-field
            expanded
          >
            <b-input
              :name="`observers[${i}][name]`"
              v-model="form.observers[i].name"
              :placeholder="trans('labels.observations.observer_name')"
              expanded
              required
            />

            <p class="control">
              <button type="button" class="button is-danger is-outlined" @click="removeObserver(i)">
                <b-icon icon="times" size="is-small"/>
              </button>
            </p>

          </b-field>
        </b-field>

        <b-field
          :type="observerErrors ? 'is-danger' : null"
          :message="observerErrors ? trans(observerErrors) : null"
        >
          <b-input id="observerName" maxlength="50" v-model="observerName"
                   :placeholder="trans('labels.observations.insert_observer_name')"
                   expanded
                   v-on:keydown.native.enter.prevent="addObserver"
          />

          <p class="control">
            <button type="button" class="button is-secondary is-outlined" @click="addObserver">
              {{ trans('labels.observations.add_observer') }}
            </button>
          </p>
        </b-field>
      </b-field>

      <hr>
      <template v-if="showObserverIdentifier">
        <nz-user-autocomplete
          v-model="form.identifier"
          @select="onIdentifierSelect"
          :error="form.errors.has('identifier')"
          :message="form.errors.has('identifier') ? form.errors.first('identifier') : null"
          :user="form.identified_by"
          :label="trans('labels.observations.identifier')"
          :disabled="!isIdentified"
        />
      </template>

      <div class="columns">
        <div class="column">
          <b-field
            :label="trans('labels.observations.data_license')"
            label-for="data_license"
            :type="form.errors.has('data_license') ? 'is-danger' : null"
            :message="form.errors.has('data_license') ? form.errors.first('data_license') : null"
          >
            <b-select id="data_license" v-model="form.data_license" expanded>
              <option :value="null">{{ trans('labels.observations.default') }}</option>
              <option v-for="(label, value) in licenses" :value="value" v-text="label" v-bind:key="value"></option>
            </b-select>
          </b-field>
        </div>
      </div>
      <hr>
    </div>

    <button
      type="submit"
      class="button is-primary"
      :class="{
          'is-loading': submittingWithRedirect
      }"
      @click.prevent="submitWithRedirect"
      v-tooltip="{content: trans('labels.observations.save_tooltip')}"
    >
      {{ trans('buttons.save') }}
    </button>

    <button
      type="submit"
      class="button is-primary"
      :class="{
          'is-outlined': !submittingWithoutRedirect,
          'is-loading': submittingWithoutRedirect
      }"
      @click.prevent="submitWithoutRedirect"
      v-if="submitMore"
      v-tooltip="{content: trans('labels.observations.save_more_tooltip')}"
    >
      {{ trans('buttons.save_more') }}
    </button>

    <a :href="cancelUrl" class="button is-text" @click="onCancel">{{ trans('buttons.cancel') }}</a>
  </form>
</template>

<script>
import Form from 'form-backend-validation'
import dayjs from '@/dayjs'
import _get from 'lodash/get'
import _find from 'lodash/find'
import _includes from 'lodash/includes'
import _findIndex from 'lodash/findIndex'
import _remove from 'lodash/remove'
import _cloneDeep from 'lodash/cloneDeep'
import FormMixin from '@/mixins/FormMixin'
import UserMixin from '@/mixins/UserMixin'
import NzDateInput from '@/components/inputs/DateInput'
import NzPhotoUpload from '@/components/inputs/PhotoUpload'
import NzSpatialInput from '@/components/inputs/SpatialInput'
import NzTaxonSpeciesAutocomplete from '@/components/inputs/TaxonSpeciesAutocomplete'
import NzUserAutocomplete from '@/components/inputs/UserAutocomplete'

export default {
  name: 'nzPoachingObservationForm',

  mixins: [FormMixin, UserMixin],

  components: {
    NzDateInput,
    NzPhotoUpload,
    NzSpatialInput,
    NzTaxonSpeciesAutocomplete,
    NzUserAutocomplete
  },

  props: {
    observation: {
      type: Object,
      default() {
        return {
          taxon: null,
          taxon_id: null,
          taxon_suggestion: '',
          year: dayjs().year(),
          month: dayjs().month() + 1,
          day: dayjs().date(),
          latitude: null,
          longitude: null,
          accuracy: null,
          elevation: null,
          location: '',
          photos: [],
          observer: '',
          identifier: '',
          note: '',
          sex: null,
          number: null,
          number_of: 'individual',
          project: null,
          habitat: null,
          found_on: null,
          stage_id: null,
          found_dead: false,
          found_dead_note: '',
          data_license: null,
          image_license: null,
          types: [],
          observers: [],
          observed_by_id: null,
          observed_by: null,
          identified_by_id: null,
          identified_by: null,
          dataset: null,
          atlas_code: null,
          description: '',
          comment: '',
          data_provider: null,
          data_limit: '',
          indigenous: false,
          exact_number: false,
          locality: null,
          place: null,
          municipality: null,
          data_id: null,
          folder_id: null,
          file: null,
          offence_details: '',
          in_report: false,
          case_reported: false,
          case_reported_by: null,
          opportunity: false,
          annotation: '',
          associates: null,
          origin_of_individuals: null,
          cites: null,
          proceeding: null,
          verdict: null,
          verdict_date: null,
          source: null,
          total: null,
          dead_from_total: null,
          alive_from_total: null,
          suspects_number: null,
          sanction_eur: null,
          sanction_rsd: null,
          community_sentence: null,
          case_name: null,
          case_against: null,
          case_against_mb: null,
          case_against_pib: null,
          case_submitted_to: null,
          sources: [],
          offences: [],
        }
      }
    },

    licenses: {
      type: Object,
      default: () => ({})
    },

    sexes: {
      type: Object,
      default: () => ({})
    },

    observationTypes: {
      type: Array,
      default: () => []
    },

    stages: {
      type: Array,
      default: () => []
    },

    showObserverIdentifier: Boolean,

    atlasCodes: Array,

    offences: Array,

    removedSources: {
      type: Array,
      default() {
        return [];
      }
    },

    newSuspects: {
      type: Array,
      default() {
        return [];
      }
    },

    removedSuspects: {
      type: Array,
      default() {
        return [];
      }
    },

  },

  data() {
    return {
      keepAfterSubmit: this.getAttributesToKeep(),
      showMoreDetails: true,
      locale: window.App.locale,
      observationTypeSearch: '',
      shouldClearType: false,
      exifExtracted: false,
      lastStageId: this.observation.stage_id,
      observers: this.observation.observers,
      observerName: null,
      sources: this.observation.sources,
      sourceDescription: null,
      sourceLink: null,
      suspect_name: null,
      suspect_place: null,
      suspect_profile: null,
      suspect_phone: null,
      suspect_email: null,
      suspect_social_media: null,
      suspect_note: null,
      suspects: this.observation.suspects,

      suspectErrors: null,
      sourceErrors: null,
      observerErrors: null,
    }
  },

  computed: {
    selectedObservationTypes: {
      get() {
        return this.observationTypes.filter(type =>
          _includes(this.form.observation_types_ids, type.id)
        )
      },

      set(value) {
        this.form.observation_types_ids = value.map(type => type.id)
      }
    },

    availableObservationTypes() {
      return this.observationTypes.filter(type => {
        return !_includes(this.form.observation_types_ids, type.id) &&
          type.name.toLowerCase().includes(this.observationTypeSearch.toLowerCase())
      })
    },

    isIdentified() {
      return !!(this.form.taxon_id || this.form.taxon_suggestion)
    },

    /**
     * Check if identification is changed compared to the original observation.
     * @return {Boolean}
     */
    identificationChanged() {
      return this.form.taxon_id !== this.observation.taxon_id ||
        this.form.taxon_suggestion !== this.observation.taxon_suggestion
    },

  },

  created() {
    this.setDefaultObservationType()
  },

  methods: {
    /**
     * Create new form instance.
     *
     * @return {Form}
     */
    newForm() {
      const observation = this.observation

      // If crop is not set on existing photos, we can't crop them.
      observation.photos.forEach(photo => {
        photo.crop = null
      })

      return new Form({
        ...observation,
        observation_types_ids: observation.types.map(type => type.id),
        offences_ids: this.observation.offences.map(offence => offence.id),
        observers: this.observation.observers,
        reason: null,
        sources: this.observation.sources,
        removed_sources: this.removedSources,
        verdict_date: this.observation.verdict_date ? new Date(this.observation.verdict_date) : null,

        new_suspects: this.newSuspects,
        removed_suspects: this.removedSuspects,
      }, {
        resetOnSuccess: false
      })
    },

    /**
     * Performa after submit without redirect is successful.
     */
    hookAfterSubmitWithoutRedirect() {
      this.setDefaultObservationType()
      this.clearPhotos()
      // Focus on taxon autocomplete input.
      this.$refs.taxonAutocomplete.focusOnInput()
    },

    /**
     * Clear all photos.
     */
    clearPhotos() {
      [1, 2, 3].forEach(number => {
        this.$refs[`photoUpload-${number}`].clearPhoto()
      })
    },

    /**
     * Handle taxon veing selected.
     *
     * @param {Object} value
     */
    onTaxonSelect(taxon) {
      this.form.taxon = taxon || null
      this.form.taxon_id = taxon ? taxon.id : null
      this.form.taxon_suggestion = taxon ? taxon.name : null

      const invalidStage = this.lastStageId && !_find(this.stages, stage => stage.id === this.lastStageId)

      this.form.stage_id = invalidStage ? null : this.lastStageId

      this.updateIdentifier()
    },

    /**
     * Add uploaded photo's filename to array.
     *
     * @param {String} file name
     */
    onPhotoUploaded(image) {
      this.form.photos.push({
        path: image.path,
        crop: image.crop,
        license: image.license
      })

      const availableType = _find(this.availableObservationTypes, {slug: 'photographed'})

      if (availableType) {
        this.pushSelectedObservationType(availableType)
      }

      this.promptToExtractExifData(image)
    },

    /**
     * Remove photo from form.
     *
     * @param {Object} image
     */
    onPhotoRemoved(image) {
      _remove(this.form.photos, {path: image.path})

      const selectedTypeIndex = _findIndex(this.selectedObservationTypes, {slug: 'photographed'})

      if (!this.form.photos.length && selectedTypeIndex >= 0) {
        const selectedObservationTypes = this.selectedObservationTypes

        selectedObservationTypes.splice(selectedTypeIndex, 1)

        this.selectedObservationTypes = selectedObservationTypes
      }
    },

    /**
     * Add/remove cropping information.
     *
     * @param {Object} image
     */
    onPhotoCropped(croppedImage) {
      const photoIndex = _findIndex(this.form.photos, {path: croppedImage.path})

      if (photoIndex >= 0) {
        const photo = _cloneDeep(this.form.photos[photoIndex])

        photo.crop = croppedImage.crop

        this.form.photos.splice(photoIndex, 1, photo)
      }
    },

    /**
     * Get observation photo attribute.
     *
     * @param  {Number} [photoIndex=0]
     * @param  {String} [attribute='url']
     * @return {String}
     */
    getObservationPhotoAttribute(photoIndex = 0, attribute = 'url') {
      let value = _get(this.observation, `photos.${photoIndex}.${attribute}`, '')

      if (attribute === 'url' && value) {
        const updated = dayjs(_get(this.observation, `photos.${photoIndex}.updated_at`, null))

        value += updated.isValid() ? `?v=${updated.format('X')}` : ''
      }

      return value
    },

    /**
     * Attributes to keep after submit without redirect.
     *
     * @return {Array}
     */
    getAttributesToKeep() {
      return [
        'location', 'accuracy', 'elevation', 'latitude', 'longitude',
        'year', 'month', 'day', 'project', 'observer', 'observed_by',
        'observed_by_id', 'data_license', 'image_license',
      ]
    },

    /**
     * Set tag search.
     * @param {String} value
     */
    onTypeTyping(value) {
      this.observationTypeSearch = value
    },

    /**
     * Handle removing tags with backspace.
     */
    onTypeBackspace() {
      if (this.shouldClearType) {
        this.form.observation_types_ids.splice(-1, 1)
        this.shouldClearType = false
      } else if (!this.observationTypeSearch) {
        this.shouldClearType = true
      }
    },

    /**
     * Add observation type to selections.
     *
     * @param  {Object} type
     */
    pushSelectedObservationType(type) {
      const selectedObservationTypes = this.selectedObservationTypes

      selectedObservationTypes.push(type)

      this.selectedObservationTypes = selectedObservationTypes
    },

    /**
     * Ask the user to use EXIF data to populate the fields.
     *
     * @param  {Object} image
     */
    promptToExtractExifData(image) {
      if (this.exifExtracted || !image.exif) return

      this.$buefy.dialog.confirm({
        message: this.extractExifMessage(image).replace(/\n/g, '<br>'),
        cancelText: this.trans('No'),
        confirmText: this.trans('Yes'),
        onConfirm: () => {
          this.fillFromExif(image)
        },
        onCancel: () => {
          this.exifExtracted = true
        }
      })
    },

    /**
     * Format message to use EXIF data from image.
     */
    extractExifMessage(image) {
      const data = this.extractExifData(image)

      return [
        this.trans('Use data from photo to fill the form?') + "\n",
        ...Object.keys(data).map(key => `${this.trans('labels.observations.' + key)}: ${data[key]}`)
      ].join("\n")
    },

    /**
     * Extract EXIF data from image.
     */
    extractExifData(image) {
      const data = {}

      for (let exif in image.exif) {
        let value = image.exif[exif]

        if (value) {
          data[exif] = value
        }
      }

      return data
    },

    /**
     * Fill the fields with EXIF data.
     *
     * @param  {Object} image
     */
    fillFromExif(image) {
      const data = this.extractExifData(image)

      for (const exif in data) {
        this.form[exif] = data[exif]
      }

      this.exifExtracted = true
    },

    /**
     * Select observer.
     */
    onObserverSelect(user) {
      this.form.observed_by = user || null
      this.form.observed_by_id = user ? user.id : null
      this.form.observer = user ? user.full_name : null
    },

    /**
     * Select identifier.
     */
    onIdentifierSelect(user) {
      this.form.identified_by = user || null
      this.form.identified_by_id = user ? user.id : null
      this.form.identifier = user ? user.full_name : null
    },

    /**
     * Set default observation type.
     */
    setDefaultObservationType() {
      if (!this.selectedObservationTypes.length) {
        this.pushSelectedObservationType(
          _find(this.availableObservationTypes, {slug: 'observed'})
        )
      }
    },

    /**
     * Update identifier based on identification change.
     */
    updateIdentifier() {
      let identifier = this.observation.identified_by

      if (this.identificationChanged) {
        identifier = this.isIdentified ? window.App.User : null
      }

      this.onIdentifierSelect(identifier)
    },

    /**
     * Change photo license.
     *
     * @param {Number} photoIndex
     * @param {Number} license
     */
    onLicenseChanged(photoIndex, license) {
      const photo = _cloneDeep(this.form.photos[photoIndex])

      photo.license = license

      this.form.photos[photoIndex] = photo
    },

    /**
     * Add source for poaching observation
     *
     */
    addSource() {
      if (this.form.source) {
        this.form.sources.push({
          name: this.form.source,
          description: this.sourceDescription,
          link: this.sourceLink,
          ytid: this.getIdFromString(this.sourceLink),
        });
        this.form.source = null;
        this.sourceDescription = null;
        this.sourceLink = null;
        this.sourceErrors = null;
      } else {
        this.sourceErrors = 'labels.poaching_observations.must_select_source';
      }
      this.$forceUpdate();
    },

    removeSource(index) {
      this.removedSources.push(this.sources[index]);
      this.$delete(this.sources, index);
    },

    /**
     * Add observer for poaching observation
     *
     */
    addObserver() {
      let pass = true;
      if (this.observerName) {
        this.form.observers.forEach((item, index) => {
          if (this.observerName === item.name) {
            pass = false;
            this.observerErrors = "labels.observations.duplicate_value";
          }
        });
        if (pass) {
          this.form.observers.push({name: this.observerName});
          this.observerName = null;
          this.observerErrors = null;
        }
      } else {
        this.observerErrors = "labels.observations.field_is_required";
      }
      this.$forceUpdate();
    },

    removeObserver(index) {
      this.$delete(this.observers, index);
    },

    /**
     * Add observer for poaching observation
     *
     */
    addSuspect() {
      if (this.suspect_name || this.suspect_place || this.suspect_profile || this.suspect_phone || this.suspect_email || this.suspect_social_media || this.suspect_note) {
        this.form.suspects.push({
          name: this.suspect_name,
          place: this.suspect_place,
          profile: this.suspect_profile,
          phone: this.suspect_phone,
          email: this.suspect_email,
          social_media: this.suspect_social_media,
          note: this.suspect_note,
        });
        this.suspect_name = null;
        this.suspect_place = null;
        this.suspect_profile = null;
        this.suspect_phone = null;
        this.suspect_email = null;
        this.suspect_social_media = null;
        this.suspect_note = null;

        this.suspectErrors = null;
      } else {
        this.suspectErrors = "labels.poaching_observations.any_field_is_required";
      }
      this.$forceUpdate();
    },

    removeSuspect(index) {
      this.removedSuspects.push(this.suspects[index]);
      this.$delete(this.suspects, index);
    },

    /**
     * Get ID from URL
     *
     * source: https://github.com/kaorun343/vue-youtube-embed/blob/master/src/utils.js
     */
    getIdFromString(url = ""){
      const ytRegex = /https?:\/\/(?:[0-9A-Z-]+\.)?(?:youtu\.be\/|youtube(?:-nocookie)?\.com\S*[^\w\s-])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:['"][^<>]*>|<\/a>))[?=&+%\w.-]*/ig
      let id = ""
      if (!url.match(ytRegex)){
        return id
      }
      id = url.replace(ytRegex, '$1');
      if (id.includes(';')) {
        const pieces = id.split(';')

        if (pieces[1].includes('%')) {
          const uriComp = decodeURIComponent(pieces[1])
          id = 'https://youtube.com${uriComp}'.replace(ytRegex, '$1')
        } else {
          id = pieces[0]
        }
      } else if (id.includes('#')) {
        id = id.split("#")[0]
      }
      return id
    }

  }
}
</script>
