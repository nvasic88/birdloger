<template>
  <div class="activity-log-item">
    {{ activity.created_at | formatDateTime }} {{ activity.causer.full_name }} {{ trans('activityLog.approved') }}
  </div>
</template>

<script>
export default {
  name: 'nzActivityElectrocutionObservationApproved',

  props: {
    activity: {
      type: Object,
      required: true
    }
  }
}
</script>
