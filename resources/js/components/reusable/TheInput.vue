<template>
  <div class="mb-3">
    <label class="form-label">{{ inputLabel }}</label>
    <input
      class="form-control" 
     :type="inputType"
     :value="inputValue"
     v-bind="inputProps"
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
      inputFileAccepts: {
        type: String,
        default: "image/*"
      },
    },

    emits: ['changeValue'],
    methods: {
      onFileChange($event) {
        console.log($event.target);
      },
    },
    computed: {
      inputProps() {
        let inputProps;
        if (this.inputType == "file") {
          inputProps = { accept: this.inputFileAccepts, onchange: this.onFileChange }
        }
        else if(this.inputType == "date") {
          inputProps = { max: new Date().toISOString().split('T')[0] }
        }

        else if(this.inputType == "number") {
          inputProps = { min: 0 }
        }
        return inputProps;
      }
    }
  }
</script>