<template>
  <div class="activity-log-item">
    {{ activity.created_at | formatDateTime }} {{ activity.causer.full_name }} {{ trans('activityLog.marked_unidentifiable') }}: {{ activity.properties.reason }}
  </div>
</template>

<script>
export default {
  name: 'nzActivityPoachingObservationMarkedUnidentifiable',

  props: {
    activity: {
      type: Object,
      required: true
    }
  }
}
</script>
