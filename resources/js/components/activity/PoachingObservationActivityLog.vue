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
import ActivityPoachingObservationApproved from './PoachingObservationApproved'
import ActivityPoachingObservationCreated from './PoachingObservationCreated'
import ActivityPoachingObservationMarkedUnidentifiable from './PoachingObservationMarkedUnidentifiable'
import ActivityPoachingObservationMovedToPending from './PoachingObservationMovedToPending'
import ActivityPoachingObservationUpdated from './PoachingObservationUpdated'

export default {
  name: 'nzPoachingObservationActivityLog',

  components: {
    [ActivityPoachingObservationApproved.name]: ActivityPoachingObservationApproved,
    [ActivityPoachingObservationCreated.name]: ActivityPoachingObservationCreated,
    [ActivityPoachingObservationMarkedUnidentifiable.name]: ActivityPoachingObservationMarkedUnidentifiable,
    [ActivityPoachingObservationMovedToPending.name]: ActivityPoachingObservationMovedToPending,
    [ActivityPoachingObservationUpdated.name]: ActivityPoachingObservationUpdated
  },

  props: {
    activities: {
      type: Array,
      default: () => []
    }
  },

  methods: {
    chooseActivityComponent(activity) {
      return `nz-activity-poaching-observation-${activity.description.split('_').join('-')}`
    }
  }
}
</script>
