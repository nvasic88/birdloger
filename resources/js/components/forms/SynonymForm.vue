<template>
  <div class="synonym-form">
    <form :action="action" method="POST" @submit.prevent="submitWithRedirect">
         <nz-taxon-autocomplete
          v-model="form.taxon_suggestion"
          @select="onTaxonSelect"
          :taxon="synonym.taxon"
          :error="form.errors.has('taxon_id')"
          :message="form.errors.has('taxon_id') ? form.errors.first('taxon_id') : null"
          autofocus
          ref="taxonAutocomplete"
          :label="trans('labels.synonyms.taxon')"
          :placeholder="trans('labels.synonyms.search_for_taxon')"
        />
      
          <b-field :label="trans('labels.synonyms.name')" class="is-required">
            <b-input v-model="form.name" />
          </b-field>

      <hr>

      <button
      type="submit"
      class="button is-primary"
      :class="{
          'is-loading': form.processing
      }"
      @click="submitWithRedirect"
    >
      {{ trans('buttons.save') }}
    </button>
    </form>
  </div>
</template>

<script>
import Form from 'form-backend-validation'
import _get from 'lodash/get'
import NzTaxonAutocomplete from '@/components/inputs/TaxonAutocomplete'
import FormMixin from '@/mixins/FormMixin'

export default {
  name: 'nzSynonymForm',

  mixins: [FormMixin],

  components: {
    NzTaxonAutocomplete
  },

  props: {
    action: String,
    method: {
      type: String,
      default: 'post'
    },
    roles: Array,
    synonym: {
      type: Object,
      default() {
        return {
          name: '',
          taxon_id: null,
          taxon: '',
          taxon_suggestion: '',
        }
      }
    },
    redirect: String
  },

  data() {
    return {
        form: this.newForm()
    }
  },

  methods: {
      newForm(){
          return new Form({
              ...this.synonym,
              taxon_id: this.synonym.taxon.id,
              taxon: this.synonym.taxon,
              taxon_suggestion: this.synonym.taxon.name,
              name: this.synonym.name
          }, {
        resetOnSuccess: false
        })
      },

    /**
     * Handle successful form submit.
     */
    onSuccessfulSubmit() {
      this.form.processing = true

      this.$buefy.toast.open({
        message: this.trans('Saved successfully'),
        type: 'is-success'
      })

      // We want to wait a bit before we send the user to redirect route
      // so we can show the message that the action was successful.
      setTimeout(() => {
        this.form.processing = false

        window.location.href = this.redirect
      }, 500)
    },

    /**
     * Handle taxon being selected.
     *
     * @param {Object} value
     */
    onTaxonSelect(taxon) {
      this.form.taxon = taxon || null
      this.form.taxon_id = taxon ? taxon.id : null
      this.form.taxon_suggestion = taxon ? taxon.name : null

      if (!this.usesAtlasCodes) {
        this.form.atlas_code = null;
      }
    },

    /**
     * Handle failed form submit.
     *
     * @param {Error} error
     */
    onFailedSubmit(error) {
      this.$buefy.toast.open({
        duration: 2500,
        message: _get(error, 'response.data.message', error.message),
        type: 'is-danger'
      })
    }
  }
}
</script>
