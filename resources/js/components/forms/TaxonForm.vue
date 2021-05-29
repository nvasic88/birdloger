<template>
  <form
    :action="action"
    method="POST"
    @submit.prevent="submitWithRedirect"
  >
    <div class="columns">
      <div class="column is-6">
        <b-field
          :label="trans('labels.taxa.name')"
          class="is-required"
          :type="form.errors.has('name') ? 'is-danger' : ''"
          :message="form.errors.has('name') ? form.errors.first('name') : ''"
        >
          <b-input v-model="form.name" />
        </b-field>
      </div>

      <div class="column is-3">
        <b-field
          :label="trans('taxonomy.order')"
          class="is-required"
          :type="form.errors.has('order') ? 'is-danger' : ''"
          :message="form.errors.has('order') ? form.errors.first('order') : ''"
        >
          <b-input v-model="form.order_name" />
        </b-field>
      </div>

      <div class="column is-3">
        <b-field
          :label="trans('taxonomy.family')"
          class="is-required"
          :type="form.errors.has('family') ? 'is-danger' : ''"
          :message="
            form.errors.has('family') ? form.errors.first('family') : ''
          "
        >
          <b-input v-model="form.family_name">A</b-input>
        </b-field>
      </div>
    </div>

    <b-field
      :label="trans('labels.taxa.author')"
      :type="form.errors.has('author') ? 'is-danger' : ''"
      :message="form.errors.has('author') ? form.errors.first('author') : ''"
    >
      <b-input v-model="form.author" />
    </b-field>

    <hr />

    <b-field :label="trans('labels.taxa.native_name')">
      <b-tabs
        size="is-small"
        class="block"
        @change="index => focusOnTranslation(index, 'native_name')"
      >
        <b-tab-item
          :label="trans('languages.' + data.name)"
          v-for="(data, locale) in supportedLocales"
          :key="locale"
        >
          <b-input
            v-model="form.native_name[locale]"
            :ref="`native_name-${locale}`"
          />
        </b-tab-item>
      </b-tabs>
    </b-field>

    <b-field :label="trans('labels.taxa.description')">
      <b-tabs
        size="is-small"
        class="block"
        @change="index => focusOnTranslation(index, 'description')"
      >
        <b-tab-item
          :label="trans('languages.' + data.name)"
          v-for="(data, locale) in supportedLocales"
          :key="locale"
        >
          <nz-wysiwyg
            v-model="form.description[locale]"
            :ref="`description-${locale}`"
          />
        </b-tab-item>
      </b-tabs>
    </b-field>

    <hr>
    <div>
      <b-field :label="trans('labels.taxa.annex')">
        <div class="block">
          <b-checkbox
            v-for="annex in annexes"
            :key="annex.id"
            v-model="form.annexes_ids"
            :native-value="annex.id"
          >
            {{ annex.name }}
          </b-checkbox>
        </div>
      </b-field>
    </div>

    <div class="columns">
      <div class="column">
        <b-field :label="trans('labels.taxa.restricted')">
          <div class="field">
            <b-switch v-model="form.restricted">
              {{ form.restricted ? trans("Yes") : trans("No") }}
            </b-switch>
          </div>
        </b-field>
      </div>
      <div class="column">
        <b-field :label="trans('labels.taxa.allochthonous')">
          <b-switch v-model="form.allochthonous">
            {{ form.allochthonous ? trans("Yes") : trans("No") }}
          </b-switch>
        </b-field>
      </div>
      <div class="column">
        <b-field :label="trans('labels.taxa.invasive')">
          <b-switch v-model="form.invasive">
            {{ form.invasive ? trans("Yes") : trans("No") }}
          </b-switch>
        </b-field>
      </div>
      <div class="column">
        <b-field :label="trans('labels.taxa.refer')">
          <b-switch v-model="form.refer">
            {{ form.refer ? trans("Yes") : trans("No") }}
          </b-switch>
        </b-field>
      </div>
      <div class="column">
        <b-field :label="trans('labels.taxa.prior')">
          <b-switch v-model="form.prior">
            {{ form.prior ? trans("Yes") : trans("No") }}
          </b-switch>
        </b-field>
      </div>
    </div>

    <hr />

    <div class="columns">
      <div class="column">
        <b-field
          :label="trans('labels.taxa.spid')"
          class="is-required"
          :type="form.errors.has('spid') ? 'is-danger' : ''"
          :message="form.errors.has('spid') ? form.errors.first('spid') : ''"
        >
          <b-input maxlength="10" v-model="form.spid" />
        </b-field>
      </div>

      <div class="column">
        <b-field
          :label="trans('labels.taxa.birdlife_seq')"
          class="is-required"
          :type="form.errors.has('birdlife_seq') ? 'is-danger' : ''"
          :message="
            form.errors.has('birdlife_seq')
              ? form.errors.first('birdlife_seq')
              : ''
          "
        >
          <b-input type="number" v-model="form.birdlife_seq" />
        </b-field>
      </div>

      <div class="column">
        <b-field
          :label="trans('labels.taxa.birdlife_id')"
          class="is-required"
          :type="form.errors.has('birdlife_id') ? 'is-danger' : ''"
          :message="
            form.errors.has('birdlife_id')
              ? form.errors.first('birdlife_id')
              : ''
          "
        >
          <b-input type="number" v-model="form.birdlife_id" />
        </b-field>
      </div>

      <div class="column">
        <b-field
          :label="trans('labels.taxa.ebba_code')"
          :type="form.errors.has('ebba_code') ? 'is-danger' : ''"
          :message="
            form.errors.has('ebba_code') ? form.errors.first('ebba_code') : ''
          "
        >
          <b-input type="number" v-model="form.ebba_code" />
        </b-field>
      </div>
    </div>

    <div class="columns">
      <div class="column">
        <b-field
          :label="trans('labels.taxa.euring_code')"
          :type="form.errors.has('euring_code') ? 'is-danger' : ''"
          :message="
            form.errors.has('euring_code')
              ? form.errors.first('euring_code')
              : ''
          "
        >
          <b-input type="number" v-model="form.euring_code" />
        </b-field>
      </div>

      <div class="column">
        <b-field
          :label="trans('labels.taxa.euring_sci_name')"
          :type="form.errors.has('euring_sci_name') ? 'is-danger' : ''"
          :message="
            form.errors.has('euring_sci_name')
              ? form.errors.first('euring_sci_name')
              : ''
          "
        >
          <b-input maxlength="100" v-model="form.euring_sci_name" />
        </b-field>
      </div>

      <div class="column">
        <b-field :label="trans('labels.taxa.eunis_n2000code')">
          <b-input maxlength="10" v-model="form.eunis_n2000code" />
        </b-field>
      </div>

      <div class="column">
        <b-field :label="trans('labels.taxa.eunis_sci_name')">
          <b-input maxlength="100" v-model="form.eunis_sci_name" />
        </b-field>
      </div>


    </div>

    <div class="columns">
      <div class="column">
        <b-field :label="trans('labels.taxa.bioras_sci_name')">
          <b-input maxlength="200" v-model="form.bioras_sci_name" />
        </b-field>
      </div>

      <div class="column">
        <b-field :label="trans('labels.taxa.full_sci_name')">
          <b-input maxlength="200" v-model="form.full_sci_name" />
        </b-field>
      </div>
      <div class="column">
        <b-field
          :label="trans('labels.taxa.gn_status')"
          label-for="gn_status"
          :type="form.errors.has('gn_status') ? 'is-danger' : null"
          :message="form.errors.has('gn_status') ? form.errors.first('gn_status') : null"
        >
          <b-select v-model="form.gn_status" expanded>
            <option :value="null">{{ trans('labels.field_observations.choose_a_value') }}</option>
            <option value="I" >Negnezdarica - iščezla vrsta</option>
            <option value="IG">Negnezdarica - iščezla gnezdeća populacija</option>
            <option value="NG">Negnezdarica</option>
            <option value="G0">Gnezdarica - bez gnezdećih datuma</option>
            <option value="G">Gnezdarica</option>
            <option value="G*">Gnezdarica - sa uslovnim gnezdećim datumima</option>
          </b-select>
        </b-field>
      </div>

      <div class="column">
        <b-field
          :label="trans('labels.taxa.iucn_cat')"
          label-for="iucn_cat"
          :type="form.errors.has('iucn_cat') ? 'is-danger' : null"
          :message="form.errors.has('iucn_cat') ? form.errors.first('iucn_cat') : null"
        >
          <b-select v-model="form.iucn_cat" expanded>
            <option :value="null">{{ trans('labels.field_observations.choose_a_value') }}</option>
            <option value="EX" >Extinct</option>
            <option value="EW">Extinct in the wild</option>
            <option value="CR">Critically endangered</option>
            <option value="EN">Endangered</option>
            <option value="VU">Vulnerable</option>
            <option value="NT">Near threatened</option>
            <option value="LC">Least concern</option>
            <option value="DD">Data deficient</option>
            <option value="NE">Not evaluated</option>
          </b-select>
        </b-field>
      </div>
    </div>

    <div class="columns">
      <div class="column">
        <b-field
          :label="trans('labels.taxa.type')"
          class="is-required"
          :type="form.errors.has('type') ? 'is-danger' : ''"
          :message="form.errors.has('type') ? form.errors.first('type') : ''"
        >
          <b-select v-model="form.type" expanded>
            <option value="RS" selected>RS</option>
            <option value="WP">WP</option>
          </b-select>
        </b-field>
      </div>

    </div>

    <div class="columns">
      <div class="column is-half">
        <div class="columns">
          <div class="column is-half">
            <b-field :label="trans('labels.taxa.strictly_protected')">
              <b-switch v-model="form.strictly_protected">
                {{ form.strictly_protected ? trans("Yes") : trans("No") }}
              </b-switch>
            </b-field>
          </div>
          <div class="column is-half">
            <b-field :label="trans('labels.taxa.strictly_note')">
              <b-input :disabled="form.strictly_protected === false"
                       maxlength="100" v-model="form.strictly_note" />
            </b-field>
          </div>
        </div>
      </div>
      <div class="column is-half">
        <div class="columns">

          <div class="column is-half">
            <b-field :label="trans('labels.taxa.protected')">
              <b-switch v-model="form.protected">
                {{ form.protected ? trans("Yes") : trans("No") }}
              </b-switch>
            </b-field>
          </div>
          <div class="column is-half">
            <b-field :label="trans('labels.taxa.protected_note')"
                     >
              <b-input :disabled="form.protected === false"
                       maxlength="100" v-model="form.protected_note" />
            </b-field>
          </div>
        </div>
      </div>
    </div>

    <hr>
    <label class="label">{{ trans("labels.taxa.synonyms") }}</label>
    <div v-if="taxon.id != null">
      <div v-if="synonyms.length > 0">
        <b-field v-for="(synonym, index) in synonyms" :key="index">
          <div class="columns">
            <div class="column is-half">
              <p>{{ synonym.name }}</p>
            </div>
            <div class="column">
              <button
                type="button"
                class="button has-text-danger"
                @click="removeSynonym(index)"
              >
                &times;
              </button>
            </div>
          </div>
        </b-field>
      </div>
    </div>
    <b-field v-for="(synonym, index) in synonymNames" :key="index">
      <div class="columns">
        <div class="column is-half">
          <p>{{ synonym }}</p>
        </div>
        <div class="column">
          <button
            type="button"
            class="button has-text-danger"
            @click="removeSynonymName(index)"
          >
            &times;
          </button>
        </div>
      </div>
    </b-field>

    <div class="columns">
      <div class="column">
        <b-input maxlength="100" v-model="synonym_name" v-on:keydown.native.enter.prevent="addSynonym"/>
      </div>
      <div class="column">
        <button type="button" class="button is-primary" @click="addSynonym">
          {{ trans("labels.taxa.addSynonym") }}
        </button>
      </div>
    </div>

    <hr>

    <button
      type="submit"
      class="button is-primary"
      :class="{
        'is-loading': form.processing
      }"
      @click.prevent="submitWithRedirect"
    >
      {{ trans("buttons.save") }}
    </button>
    <button
      type="submit"
      class="button is-primary"
      :class="{
        'is-loading': form.processing
      }"
      @click="submitWithoutRedirect"
    >
      {{ trans("buttons.save_edit") }}
    </button>

    <a :href="cancelUrl" class="button is-text" @click="onCancel">{{
      trans("buttons.cancel")
    }}</a>
  </form>
</template>

<script>
import Form from "form-backend-validation";
import _keys from "lodash/keys";
import _find from "lodash/find";
import _first from "lodash/first";
import _get from "lodash/get";
import FormMixin from "@/mixins/FormMixin";
import NzWysiwyg from "@/components/inputs/Wysiwyg";
import NzTaxonAutocomplete from "@/components/inputs/TaxonAutocomplete";

function defaultTranslations() {
  const value = {};

  _keys(window.App.supportedLocales).forEach(locale => {
    value[locale] = null;
  });

  return value;
}

export default {
  name: "nzTaxonForm",

  mixins: [FormMixin],

  components: {
    NzWysiwyg,
    NzTaxonAutocomplete
  },

  props: {
    taxon: {
      type: Object,
      default() {
        return {
          name: null,
          parent_id: null,
          rank: "species",
          rank_level: 10,
          author: null,
          fe_id: null,
          conservation_legislations: [],
          conservation_documents: [],
          red_lists: [],
          stages: [],
          synonyms: [],
          annexes: [],
          restricted: false,
          allochthonous: false,
          invasive: false,
          refer: false,
          uses_atlas_codes: true,
          strictly_protected: false,
          strictly_note: null,
          protected: false,
          protected_note: null,
          spid: null,
          birdlife_seq: null,
          birdlife_id: null,
          ebba_code: null,
          euring_code: null,
          euring_sci_name: null,
          eunis_n2000code: null,
          eunis_sci_name: null,
          bioras_sci_name: null,
          prior: null,
          gn_status: null,
          type: "RS",
          iucn_cat: null,
          sp: null,
          full_sci_name: null,
          family_id: null,

        };
      }
    },
    ranks: Array,
    conservationLegislations: Array,
    conservationDocuments: Array,
    redListCategories: Array,
    redLists: {
      type: Array,
      default() {
        return [];
      }
    },
    stages: Array,
    annexes: Array,
    nativeNames: {
      type: Object,
      default: () => defaultTranslations()
    },
    descriptions: {
      type: Object,
      default: () => defaultTranslations()
    },
    synonymNames: {
      type: Array,
      default() {
        return [];
      }
    },
  },

  data() {
    return {
      form: this.newForm(),
      parentName: _get(this.taxon, "parent.name"),
      selectedParent: null,
      chosenRedList: null,
      synonym_name: null,
      synonyms: this.taxon.synonyms,
    };
  },

  computed: {
    rankOptions() {
      if (this.selectedParent) {
        return this.ranks.filter(
          rank => rank.level < this.selectedParent.rank_level
        );
      }

      return this.ranks;
    },

    supportedLocales() {
      return window.App.supportedLocales;
    },

  },

  watch: {
    selectedParent(value) {
      if (this.shouldResetRank(value)) {
        this.form.rank = null;
      }
    }
  },

  methods: {
    newForm() {
      return new Form(
        {
          ...this.taxon,
          stages_ids: this.taxon.stages.map(stage => stage.id),
          annexes_ids: this.taxon.annexes.map(annex => annex.id),
          conservation_legislations_ids: this.taxon.conservation_legislations.map(
            conservationLegislation => conservationLegislation.id
          ),
          conservation_documents_ids: this.taxon.conservation_documents.map(
            conservationDocument => conservationDocument.id
          ),
          red_lists_data: this.taxon.red_lists.map(redList => {
            return {
              red_list_id: redList.id,
              category: redList.pivot.category
            };
          }),
          synonyms: this.taxon.synonyms,
          native_name: this.nativeNames,
          description: this.descriptions,
          reason: null,
          uses_atlas_codes: this.taxon.uses_atlas_codes,
          spid: this.taxon.spid,
          birdlife_seq: this.taxon.birdlife_seq,
          birdlife_id: this.taxon.birdlife_id,
          ebba_code: this.taxon.ebba_code,
          euring_code: this.taxon.euring_code,
          euring_sci_name: this.taxon.euring_sci_name,
          eunis_n2000code: this.taxon.eunis_n2000code,
          eunis_sci_name: this.taxon.eunis_sci_name,
          bioras_sci_name: this.taxon.bioras_sci_name,
          prior: this.taxon.prior,
          gn_status: this.taxon.gn_status,
          type: this.taxon.type,
          family_name: this.taxon.family_id ? this.taxon.family.name : "",
          order_name: this.taxon.family_id ? this.taxon.family.order.name : "",
          strictly_note: this.taxon.strictly_note,
          protected_note: this.taxon.protected_note,
          iucn_cat: this.taxon.iucn_cat,
          sp: this.taxon.sp,
          full_sci_name: this.taxon.full_sci_name,
          family_id: this.taxon.family_id ? this.taxon.family_id : 0,
          synonym_names: this.synonymNames,
        },
        {
          resetOnSuccess: false
        }
      );
    },

    loadAsyncData() {
      this.loading = true;
      return axios
        .get(
          route(this.listRoute).withQuery({
            sort_by: `${this.sortField}.${this.sortOrder}`,
            page: this.page,
            per_page: this.perPage
          })
        )
        .then(
          ({ data: response }) => {
            this.data = [];
            this.total = response.meta.total;
            response.data.forEach(item => this.data.push(item));
            this.loading = false;
          },
          response => {
            this.data = [];
            this.total = 0;
            this.loading = false;
          }
        );
    },

    removeSynonym(index) {
      axios.delete(route("api.synonyms.destroy", this.synonyms[index]));
      this.$delete(this.synonyms, index);
    },

    removeSynonymName(index) {
      this.$delete(this.synonymNames, index);
    },

    addSynonym(){
      if (!this.synonym_name) return;
      this.synonymNames.push(this.synonym_name)
      this.synonym_name = null;
    },

    /**
     * Add field to the form.
     */
    addRedList() {
      if (!this.chosenRedList) return;

      this.form.red_lists_data.push({
        red_list_id: this.chosenRedList.id,
        category: _first(this.redListCategories)
      });

      this.chosenRedList = null;
    },

    /**
     * Handle taxon being selected.
     *
     * @param {Object} taxon
     */
    onTaxonSelect(taxon) {
      this.selectedParent = taxon;
      this.form.parent_id = taxon ? taxon.id : null;

      // Inherit parent's stages
      if (taxon && taxon.stages.length) {
        this.form.stages_ids = taxon.stages.map(stage => stage.id);
      }
    },

    shouldResetRank(selectedParent) {
      return (
        selectedParent &&
        this.getRankLevel(this.form.rank) >= selectedParent.rank_level
      );
    },

    /**
     * Get rank level.
     * @param {Object} rank
     * @return {Number}
     */
    getRankLevel(rank) {
      return _get(_find(this.ranks, { value: rank }), "level");
    },

    focusOnTranslation(index, attribute) {
      const locales = _keys(this.supportedLocales);
      const selector = `${attribute}-${locales[index]}`;

      setTimeout(() => {
        _first(this.$refs[selector]).focus();
      }, 500);
    }
  },
  loadSynonyms: function() {
    console.log(this.taxon.synonyms);
    if (!this.taxon.synonyms) return [];
    let names = [];
    this.taxon.synonyms.forEach(item => names.push(item.name));
    console.log(names);
    return names;
  }
};
</script>
