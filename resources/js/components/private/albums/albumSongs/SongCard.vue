<template>
  <the-card>
    <template #card-image>
      <img src="../../../../assets/images/song.png" class="card-img-top">
    </template>
    <template #card-body>
      <h3 class="card-title"><b>{{ song.title }}</b></h3>
      <p class="card-text">Genre: <b>{{ song.genre }}</b></p>
      <p class="card-text">Length: <b>{{ renderSongLength(song) }}</b></p>
    </template>
    <template #card-footer>
      <div class="card-footer">
        <span data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="top" title="Delete Album">
          <span class=" card-icon icon-delete">
            <delete-icon />
          </span>
        </span>
      </div>
     </template>
    
  </the-card>
</template>
<script>
  import ViewIcon from 'vue-material-design-icons/MusicNoteEighth.vue';
  import EditIcon from 'vue-material-design-icons/Pencil.vue';
  import DeleteIcon from 'vue-material-design-icons/Delete.vue';

  export default {
    components: { ViewIcon, EditIcon, DeleteIcon },
    props: {
      song: Object
    },
    methods: {
      renderSongLength(song) {
        let length = song.length;
        let mins = Math.floor((length / 60)).toFixed();
        let secs = length % 60;
        let songLength = `${mins} minutes ${secs} seconds`;
        return songLength;
      }
    }
  }
</script>