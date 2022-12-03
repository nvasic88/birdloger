<template>
  <div class="activity-log-item">
    {{ activity.created_at | formatDateTime }} {{ activity.causer.full_name }} {{ trans('activityLog.changed') }} {{ formatedChanges }}. {{ trans('activityLog.reason') }}: {{ activity.properties.reason }}
  </div>
</template>

<script>
export default {
  name: 'nzActivityPoachingObservationUpdated',

  props: {
    activity: {
      type: Object,
      required: true
    }
  },

  computed: {
    formatedChanges() {
      const old = this.activity.properties.old
      const poaching = ['indigenous', 'dead_from_total', 'alive_from_total', 'total', 'exact_number', 'offences',
        'locality', 'place', 'municipality', 'data_id', 'folder_id', 'file', 'in_report', 'input_date',
        'offence_details', 'case_reported', 'case_reported_by', 'verdict', 'verdict_date', 'proceeding', 'sanction_rsd',
        'sanction_eur', 'community_sentence', 'opportunity', 'annotation', 'sources', 'source', 'source_description',
        'source_link', 'social_media','media', 'ads', 'institutions', 'associates', 'cites', 'origin_of_individuals',
        'rejected', 'youtube', 'facebook', 'case_against', 'case_against_pib', 'case_against_mb', 'case_submitted_to',
        'case_name']

      return Object.keys(old).map(key => {
        const val = this.oldValue(old, key)
        if (poaching.includes(key))
          return `${this.trans('labels.poaching_observations.'+key)}` + (val ? ` (${val})` : '')
        else
          return `${this.trans('labels.observations.'+key)}` + (val ? ` (${val})` : '')
      }).join(', ')
    }
  },

  methods: {
    oldValue(old, key) {
      const value = old[key]

      if (value === null || value === undefined) {
        return null
      }

      if (typeof value === 'object') {
        return value.label ? this.trans(value.label) : null
      }

      return value
    }
  }
}
</script>
