<template>
  <div class="mb-3">
    <label class="form-label">{{ inputLabel }}</label>
    <textarea class="form-control" rows="3"
      :value="inputValue"
      @input="$emit('changeValue', $event.target.value)"
    ></textarea>
  </div>
</template>

<script>
  export default {
    props: {
      inputLabel: String,
      inputValue: String,
    },

    emits: ['changeValue']
  }
</script>