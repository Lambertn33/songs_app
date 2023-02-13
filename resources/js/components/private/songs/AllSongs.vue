<template>
  <div class="row">
    <div class="col-md-12 py-4">
      <div class="header-container">
        <h2 class="text-center">All Songs</h2>
      </div>
      <the-spinner v-if="isFetching" />
      <div v-else>
        <div class="row gx-5" v-if="isSongsCountable">     
          <div class="col-md-6 offset-md-3">
            <ul class="list-group">
              <li class="list-group-item" v-for="song in allSongs" :key="song.id">
                <p>Title: <span>{{ song.title }}</span></p>
                <p>Album: <span>{{ song.album }}</span></p>
                <p>Genre: <span>{{ song.genre }}</span></p>
                <p>Length: <span>{{ renderSongLength(song) }}</span></p>
              </li>
            </ul> 
          </div>    
       </div>
       <div v-else class="row gx-5">
          <the-alert :hasAlert=true alertType="error" alertMessage="There is no song now..."/>
       </div>
       </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        isFetching: false,
        allSongs: []
      }
    },

    methods: {
      async fetchAllSongs() {
        this.isFetching = true;
        const response = await this.$store.dispatch('fetchAllSongs');
        const { songs } = response.data;
        this.allSongs = songs;
        this.isFetching = false;
      },
      renderSongLength(song) {
        let length = song.length;
        let mins = Math.floor((length / 60)).toFixed();
        let secs = length % 60;
        let songLength = `${mins} minutes and ${secs} seconds`;
        return songLength;
      }
    },

    computed: {
      isSongsCountable() {
        return this.allSongs.length > 0 ? true : false
      }
    },

    mounted() {
      this.fetchAllSongs();
    }
  }
</script>

<style scoped>
  .list-group-item span {
    font-weight: 800;
  }
</style>