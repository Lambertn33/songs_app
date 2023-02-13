<template>
  <div class="mb-3">
    <label class="form-label">{{ inputLabel }}</label>
    <input
      class="form-control" 
     :type="inputType"
     :value="inputValue"
     @input="$emit('changeValue', $event.target.value)"
    >
  </div>
</template>

<script>
  export default {
    props: {
      inputLabel: String,
      inputType: String,
      inputValue: String,
    },

    emits: ['changeValue']
  }
</script>