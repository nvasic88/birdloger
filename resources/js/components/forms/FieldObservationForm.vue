<template>
  <form :action="action" method="POST" :lang="locale" class="field-observation-form">
    <div class="columns is-desktop">
      <div class="column is-half-desktop">
        <div class="columns">
          <div class="column is-2">
            <b-field
              :label="trans('labels.field_observations.taxon_id')"
              label-for="taxon_id"
              :type="form.errors.has('taxon_id') ? 'is-danger' : null"
              :message="form.errors.has('taxon_id') ? form.errors.first('taxon_id') : null"
              class="is-required"
              v-tooltip="trans('labels.observations.id_tooltip')"

            >
              <b-input id="taxon_id" type="number" v-model="form.taxon_id" disabled="disabled"/>
            </b-field>
          </div>
          <div class="column">
            <nz-taxon-autocomplete
              v-model="form.taxon_suggestion"
              @select="onTaxonSelect"
              :taxon="observation.taxon"
              :error="form.errors.has('taxon_id')"
              :message="form.errors.has('taxon_id') ? form.errors.first('taxon_id') : null"
              autofocus
              ref="taxonAutocomplete"
              :label="trans('labels.field_observations.taxon')"
              :placeholder="trans('labels.field_observations.search_for_taxon')"
              class="is-required"
            />
          </div>
        </div>

        <nz-date-input
          :year.sync="form.year"
          :month.sync="form.month"
          :day.sync="form.day"
          :errors="form.errors"
          :label="trans('labels.field_observations.date')"
          :placeholders="{
              year: trans('labels.field_observations.year'),
              month: trans('labels.field_observations.month'),
              day: trans('labels.field_observations.day')
          }"
        />

        <b-field :label="trans('labels.field_observations.photos')">
          <div class="columns">
            <div class="column is-one-third">
              <nz-photo-upload
                :image-url="getObservationPhotoAttribute(0, 'url')"
                :image-path="getObservationPhotoAttribute(0, 'path')"
                :image-license="getObservationPhotoAttribute(0, 'license')"
                :licenses="licenses"
                :text="trans('labels.field_observations.upload')"
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
                :text="trans('labels.field_observations.upload')"
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
                :text="trans('labels.field_observations.upload')"
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
      {{ showMoreDetails ? trans('labels.field_observations.less_details') : trans('labels.field_observations.more_details') }}
    </button>

    <div class="mt-4" v-show="showMoreDetails">

      <div class="columns">

        <div class="column">
          <b-field
            :label="trans('labels.field_observations.stage')"
            label-for="stage"
            :type="form.errors.has('stage_id') ? 'is-danger' : null"
            :message="form.errors.has('stage_id') ? form.errors.first('stage_id') : null"
          >
            <b-select id="stage" v-model="form.stage_id" :disabled="!stages.length" @input="lastStageId = $event" expanded>
              <option :value="null">{{ trans('labels.field_observations.choose_a_stage') }}</option>
              <option v-for="stage in stages" :value="stage.id" :key="stage.id" v-text="trans(`stages.${stage.name}`)"></option>
            </b-select>
          </b-field>
        </div>

        <div class="column">
          <b-field
            :label="trans('labels.field_observations.sex')"
            :type="form.errors.has('sex') ? 'is-danger' : null"
            :message="form.errors.has('sex') ? form.errors.first('sex') : null"
          >
            <b-select v-model="form.sex" expanded>
              <option :value="null">{{ trans('labels.field_observations.choose_a_value') }}</option>
              <option v-for="(label,sex) in sexes" :key="sex" :value="sex" v-text="label"></option>
            </b-select>
          </b-field>
        </div>
      </div>

      <b-field
        :label="trans('labels.field_observations.types')"
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
          :placeholder="trans('labels.field_observations.types_placeholder')"
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
        :label="trans('labels.field_observations.atlas_code')"
        label-for="atlas-code"
        :type="form.errors.has('atlas_code') ? 'is-danger' : null"
        :message="form.errors.has('atlas_code') ? form.errors.first('atlas_code') : null"
      >
        <b-select id="atlas-code" v-model="form.atlas_code" expanded>
          <option :value="null">{{ trans('labels.field_observations.choose_a_value') }}</option>
          <option v-for="atlasCode in atlasCodes" :value="atlasCode.code" v-text="atlasCode.name" :key="atlasCode.code"></option>
        </b-select>
      </b-field>

      <div class="columns">

        <div class="column">
          <b-field
            :label="trans('labels.field_observations.number')"
            label-for="number"
            :type="form.errors.has('number') ? 'is-danger' : null"
            :message="form.errors.has('number') ? form.errors.first('number') : null"
          >
            <b-input id="number" type="number" v-model="form.number" />
          </b-field>
        </div>

        <div class="column">
          <b-field
            :label="trans('labels.field_observations.number_of')"
            label-for="number_of"
            :type="form.errors.has('number_of') ? 'is-danger' : null"
            :message="form.errors.has('number_of') ? form.errors.first('number_of') : null"
          >
            <b-select v-model="form.number_of" expanded>
              <option :value="null">{{ trans('labels.field_observations.choose_a_value') }}</option>
              <option value="jedinka" >Jedinka</option>
              <option value="par">Par</option>
              <option value="pevajući mužjak">Pevajući mužjak</option>
              <option value="aktivno gnezdo">Aktivno gnezdo</option>
              <option value="porodica sa mladuncima">Porodica sa mladuncima</option>
            </b-select>
          </b-field>
        </div>
      </div>

      <div class="columns">
        <div class="column">
          <b-field
            :label="trans('labels.observations.data_provider')"
            label-for="data_provider"
            :error="form.errors.has('data_provider')"
            :message="form.errors.has('data_provider') ? form.errors.first('data_provider') : null"
          >
            <b-input id="data_provider" name="data_provider" v-model="form.data_provider" />
          </b-field>
        </div>
        <div class="column">
          <b-field
            :label="trans('labels.observations.data_limit')"
            label-for="data_limit"
            :error="form.errors.has('data_limit')"
            :message="form.errors.has('data_limit') ? form.errors.first('data_limit') : null"
          >
            <b-input id="data_limit" name="data_limit" v-model="form.data_limit" />
          </b-field>
        </div>
        <div class="column">
          <b-field
            :label="trans('labels.observations.fid')"
            label-for="fid"
            :error="form.errors.has('fid')"
            :message="form.errors.has('fid') ? form.errors.first('fid') : null"
          >
            <b-input id="fid" name="fid" v-model="form.fid" />
          </b-field>
        </div>
        <div class="column">
          <b-field
            :label="trans('labels.observations.rid')"
            label-for="rid"
            :type="form.errors.has('rid') ? 'is-danger' : null"
            :message="form.errors.has('rid') ? form.errors.first('rid') : null"
          >
            <b-input id="rid" type="number" v-model="form.rid" />
          </b-field>
        </div>

      </div>

      <b-field
        :label="trans('labels.field_observations.note')"
        label-for="note"
        :error="form.errors.has('note')"
        :message="form.errors.has('note') ? form.errors.first('note') : null"
      >
        <b-input id="note" type="textarea" v-model="form.note" />
      </b-field>


      <b-field
        :label="trans('labels.field_observations.habitat')"
        label-for="habitat"
        :error="form.errors.has('habitat')"
        :message="form.errors.has('habitat') ? form.errors.first('habitat') : null"
      >
        <b-input id="habitat" name="habitat" v-model="form.habitat" />
      </b-field>


      <b-field
        :label="trans('labels.field_observations.time')"
        label-for="time"
        :type="form.errors.has('time') ? 'is-danger' : null"
        :message="form.errors.has('time') ? form.errors.first('time') : null"
      >
        <b-timepicker
          id="time"
          :value="time"
          @input="onTimeInput"
          :placeholder="trans('labels.field_observations.click_to_select')"
          icon="clock-o"
          :mobile-native="false"
        >
          <button type="button" class="button is-danger" @click="form.time = null">
            <b-icon icon="close"></b-icon>
          </button>
        </b-timepicker>
      </b-field>

      <b-field
        :label="trans('labels.field_observations.description')"
        label-for="description"
        :error="form.errors.has('description')"
        :message="form.errors.has('description') ? form.errors.first('description') : null"
      >
        <b-input id="description" type="textarea" v-model="form.description" />
      </b-field>

      <b-field
        :label="trans('labels.field_observations.comment')"
        label-for="comment"
        :error="form.errors.has('comment')"
        :message="form.errors.has('comment') ? form.errors.first('comment') : null"
      >
        <b-input id="comment" type="textarea" v-model="form.comment" />
      </b-field>

      <div class="columns">
        <div class="column">
          <b-field
            :label="trans('labels.literature_observations.project')"
            :type="form.errors.has('project') ? 'is-danger' : null"
            :message="form.errors.has('project') ? form.errors.first('project') : null"
          >
            <label for="project" class="label" slot="label">
              <span class="is-dashed" v-tooltip="{content: trans('labels.literature_observations.project_tooltip')}">
                {{ trans('labels.literature_observations.project') }}
              </span>
            </label>

            <b-input id="project" name="project" v-model="form.project"/>
          </b-field>
        </div>

        <div class="column">
          <b-field
            :label="trans('labels.field_observations.dataset')"
            label-for="dataset"
            :type="form.errors.has('dataset') ? 'is-danger' : null"
            :message="form.errors.has('dataset') ? form.errors.first('dataset') : null"
          >
            <b-input id="dataset" name="dataset" v-model="form.dataset" />
          </b-field>
        </div>
      </div>

      <b-checkbox v-model="form.found_dead">{{ trans('labels.field_observations.found_dead') }}</b-checkbox>

      <b-field
        :label="trans('labels.field_observations.found_dead_note')"
        label-for="found_dead_note"
        v-if="form.found_dead"
        :error="form.errors.has('found_dead_note')"
        :message="form.errors.has('found_dead_note') ? form.errors.first('found_dead_note') : null"
      >
        <b-input id="found_dead_note" type="textarea" v-model="form.found_dead_note" />
      </b-field>

      <template v-if="showObserverIdentifier">
        <nz-user-autocomplete
          v-model="form.identifier"
          @select="onIdentifierSelect"
          :error="form.errors.has('identifier')"
          :message="form.errors.has('identifier') ? form.errors.first('identifier') : null"
          :user="form.identified_by"
          :label="trans('labels.field_observations.identifier')"
          :disabled="!isIdentified"
        />
      </template>

      <div class="columns">
        <div class="column">
          <b-field
            :label="trans('labels.field_observations.data_license')"
            label-for="data_license"
            :type="form.errors.has('data_license') ? 'is-danger' : null"
            :message="form.errors.has('data_license') ? form.errors.first('data_license') : null"
          >
            <b-select id="data_license" v-model="form.data_license" expanded>
              <option :value="null">{{ trans('labels.field_observations.default') }}</option>
              <option v-for="(label, value) in licenses" :value="value" v-text="label" v-bind:key="value"></option>
            </b-select>
          </b-field>
        </div>
      </div>

    <hr>
    <div><b>{{ trans('labels.observations.observers') }}</b></div>
    <div class="columns">
        <div class="column is-2"><b>{{ trans('labels.observations.firstName') }}</b></div>
        <div class="column is-2"><b>{{ trans('labels.observations.lastName') }}</b></div>
        <div class="column is-2"><b>{{ trans('labels.observations.nickName') }}</b></div>
        <div class="column is-2"><b>{{ trans('labels.observations.city') }}</b></div>
        <div class="column is-1"></div>
    </div>
    <div class="columns" v-for="(observer, index) in observers" :key="index">
        <div class="column is-2">{{observer.firstName}}</div>
        <div class="column is-2">{{observer.lastName}}</div>
        <div class="column is-2">{{observer.nickname}}</div>
        <div class="column is-2">{{observer.city}}</div>
        <div class="column is-1">
          <button type="button"
                  class="button has-text-danger"
                  @click="removeObserver(index)"
                  v-tooltip="{content: trans('labels.observervation.remove_observer_tooltip')}">
            &times;
          </button>
        </div>
    </div>
    <div class="columns" v-for="(observer, index) in fieldObservers" :key="index">
      <div class="column is-2">{{observer.firstName}}</div>
      <div class="column is-2">{{observer.lastName}}</div>
      <div class="column is-2">{{observer.nickname}}</div>
      <div class="column is-2">{{observer.city}}</div>
      <div class="column is-1"><button type="button" class="button has-text-danger" @click="removeObserver(index)">&times;
      </button></div>
    </div>
    <div class="columns">
        <div class="column is-2">
          <b-field
            :type="observerErrors.observerFirstName ? 'is-danger' : null"
            :message="observerErrors.observerFirstName ? observerErrors.observerFirstName : null"
          >
            <b-input id="observerFirstName" maxlength="50" v-model="observerFirstName"
                     v-on:keydown.native.enter.prevent="$refs.observerLastName.focus"/>
          </b-field>
        </div>
        <div class="column is-2">
          <b-field
            :type="observerErrors.observerLastName ? 'is-danger' : null"
            :message="observerErrors.observerLastName ? observerErrors.observerLastName : null"
          >
            <b-input id="observerLastName" maxlength="50" v-model="observerLastName" ref="observerLastName"
                     v-on:keydown.native.enter.prevent="$refs.observerNickname.focus"/>
          </b-field>
        </div>
        <div class="column is-2">
          <b-input maxlength="30" v-model="observerNickname" ref="observerNickname"
                   v-on:keydown.native.enter.prevent="$refs.observerCity.focus"/>
        </div>
        <div class="column is-2">
          <b-input maxlength="30" v-model="observerCity" ref="observerCity"
                   v-on:keydown.native.enter.prevent="addObserver"/>
        </div>
        <div class="column is-1">
          <button type="button" class="button is-primary" @click="addObserver">{{trans('labels.observations.add_observer')}}</button>
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
      v-tooltip="{content: trans('labels.field_observations.save_tooltip')}"
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
      v-tooltip="{content: trans('labels.field_observations.save_more_tooltip')}"
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
import NzTaxonAutocomplete from '@/components/inputs/TaxonAutocomplete'
import NzUserAutocomplete from '@/components/inputs/UserAutocomplete'

export default {
  name: 'nzFieldObservationForm',

  mixins: [FormMixin, UserMixin],

  components: {
    NzDateInput,
    NzPhotoUpload,
    NzSpatialInput,
    NzTaxonAutocomplete,
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
          number_of: 'jedinka',
          project: null,
          habitat: null,
          found_on: null,
          stage_id: null,
          found_dead: false,
          found_dead_note: '',
          data_license: null,
          image_license: null,
          time: null,
          types: [],
          observers: [],
          field_observers: [],
          observed_by_id: null,
          observed_by: null,
          identified_by_id: null,
          identified_by: null,
          dataset: null,
          atlas_code: null,
          description: '',
          comment: '',
          fid: '',
          rid: null,
          data_provider: null,
          data_limit: '',
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

    fieldObservers: {
      type: Array,
      default: () => []
    },

    atlasCodes: Array,
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
      observerFirstName: '',
      observerLastName: '',
      observerNickname: '',
      observerCity: '',
      observerErrors: {
        type: Array,
        default: () => []
      },
    }
  },

  computed: {
    time() {
      return this.form.time ? dayjs(this.form.time, 'HH:mm').toDate() : null
    },

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

    usesAtlasCodes() {
      return this.form.taxon ? this.form.taxon.uses_atlas_codes : false;
    }
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
        observers: this.observation.observers,
        reason: null,
        field_observers: this.fieldObservers,
      }, {
        resetOnSuccess: false
      })
    },

    checkForm() {

      if (this.observerFirstName && this.observerLastName) return true;

    },

    addObserver() {
      if (this.observerFirstName && this.observerLastName) {
        this.fieldObservers.push({
          'firstName': this.observerFirstName,
          'lastName': this.observerLastName,
          'nickname': this.observerNickname,
          'city': this.observerCity,
        })
        this.observerFirstName = null;
        this.observerLastName = null;
        this.observerNickname = null;
        this.observerCity = null;
        this.observerErrors = [];
      } else {

        if (!this.observerFirstName) {
          this.observerErrors.observerFirstName = "This field is required";
          this.$forceUpdate();
        }
        if (!this.observerLastName) {
          this.observerErrors.observerLastName = "This field is required";
          this.$forceUpdate();
        }
      }

    },

    removeObserver(index) {
        axios.delete(route('api.observers.destroy', this.observers[index]));
        this.$delete(this.observers, index);
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

      if (!this.usesAtlasCodes) {
        this.form.atlas_code = null;
      }

      this.updateIdentifier()
    },

    /**
     * Set time.
     */
    onTimeInput(value) {
      this.form.time = value ? dayjs(value).format('HH:mm') : null
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

      const availableType = _find(this.availableObservationTypes, { slug: 'photographed' })

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
      _remove(this.form.photos, { path: image.path })

      const selectedTypeIndex = _findIndex(this.selectedObservationTypes, { slug: 'photographed' })

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
      const photoIndex = _findIndex(this.form.photos, { path: croppedImage.path })

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
        onConfirm: () => { this.fillFromExif(image) },
        onCancel: () => { this.exifExtracted = true }
      })
    },

    /**
     * Format message to use EXIF data from image.
     */
    extractExifMessage(image) {
      const data = this.extractExifData(image)

      return [
        this.trans('Use data from photo to fill the form?') + "\n",
        ...Object.keys(data).map(key => `${this.trans('labels.field_observations.'+key)}: ${data[key]}`)
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
          _find(this.availableObservationTypes, { slug: 'observed' })
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
    }
  }
}
</script>
