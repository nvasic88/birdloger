<template>
  <div class="activity-log-item">
    {{ activity.created_at | formatDateTime }} {{ activity.causer.full_name }} {{ trans('activityLog.changed') }} {{ formatedChanges }}. {{ trans('activityLog.reason') }}: {{ activity.properties.reason }}
  </div>
</template>

<script>
export default {
  name: 'nzActivityElectrocutionObservationUpdated',

  props: {
    activity: {
      type: Object,
      required: true
    }
  },

  computed: {
    formatedChanges() {
      const old = this.activity.properties.old
      const electrocution = ['duration', 'distance_from_pillar', 'pillar_number', 'age', 'position', 'state',
        'annotation', 'found_dead', 'found_dead_note', 'death_cause', 'column_type', 'console_type', 'voltage', 'iba',
        'time_of_corpse_found', 'electrocution', 'collision', 'unknown', ]

      return Object.keys(old).map(key => {
        const val = this.oldValue(old, key)
        if (electrocution.includes(key))
          return `${this.trans('labels.electrocution_observations.'+key)}` + (val ? ` (${val})` : '')
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
