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
    
  </the-card>
</template>
<script>
  export default {
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