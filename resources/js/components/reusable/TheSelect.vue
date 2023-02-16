<template>
  <div class="mb-3">
      <label class="form-label">{{ inputLabel }}</label>
      <select class="form-select" @change="$emit('changeValue', $event.target.value)">
        <option value="" selected disabled>Select...</option>
        <option v-for="genre in genres" :key="genre.id" :value="genre.id">{{ genre.name }}</option>
      </select>
    </div>
</template>

<script>
  export default {
    props: {
      genres: Array,
      inputLabel: String,     
    },
    emits: ['changeValue'],
  }
</script>