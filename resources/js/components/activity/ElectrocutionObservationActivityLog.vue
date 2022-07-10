<template>
  <div class="activity-log">
    <component
      v-for="activity in activities"
      :key="activity.id"
      :is="chooseActivityComponent(activity)"
      :activity="activity"
    />
  </div>
</template>

<script>
import ActivityElectrocutionObservationApproved from './ElectrocutionObservationApproved'
import ActivityElectrocutionObservationCreated from './ElectrocutionObservationCreated'
import ActivityElectrocutionObservationMarkedUnidentifiable from './ElectrocutionObservationMarkedUnidentifiable'
import ActivityElectrocutionObservationMovedToPending from './ElectrocutionObservationMovedToPending'
import ActivityElectrocutionObservationUpdated from './ElectrocutionObservationUpdated'

export default {
  name: 'nzElectrocutionObservationActivityLog',

  components: {
    [ActivityElectrocutionObservationApproved.name]: ActivityElectrocutionObservationApproved,
    [ActivityElectrocutionObservationCreated.name]: ActivityElectrocutionObservationCreated,
    [ActivityElectrocutionObservationMarkedUnidentifiable.name]: ActivityElectrocutionObservationMarkedUnidentifiable,
    [ActivityElectrocutionObservationMovedToPending.name]: ActivityElectrocutionObservationMovedToPending,
    [ActivityElectrocutionObservationUpdated.name]: ActivityElectrocutionObservationUpdated
  },

  props: {
    activities: {
      type: Array,
      default: () => []
    }
  },

  methods: {
    chooseActivityComponent(activity) {
      return `nz-activity-electrocution-observation-${activity.description.split('_').join('-')}`
    }
  }
}
</script>
