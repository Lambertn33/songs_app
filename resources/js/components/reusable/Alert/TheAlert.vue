<template>
  <div v-show="hasAlert" :class="renderAlertClasses" role="alert">
    <strong>{{ renderAlertPrefix }}</strong> {{ alertMessage }}
  </div>
</template>

<script>
  export default {
    props: {
      hasAlert: Boolean,
      alertMessage: String,
      alertType: String
    },

    computed: {
      renderAlertClasses() {
        let classes = 'alert ';
        classes += this.alertType == 'error' ? 'alert-danger' : 'alert-success';
        return classes;
      },
      renderAlertPrefix() {
        return this.alertType == 'error' ? 'Error!' : 'Success';
      }
    }    
  }
</script>