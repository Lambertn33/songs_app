<template>
  <div class="allSongs">
    <div class="row">
    <div class="col-md-12 py-4">
      <div class="header-container">
        <h2 class="text-center">All Songs</h2>
      </div>
      <the-spinner v-if="isFetching" />
      <div v-else>
        <div class="row gx-5" v-if="isSongsCountable">     
          <div class="col-md-4" v-for="song in allSongs" :key="song.id">
            <the-card>
            <template #card-image>
                <img src="../../../assets/images/song.png" class="card-img-top">
            </template>
            <template #card-body>
              <h3 class="card-title">{{ song.title }}</h3>
              <p class="card-text">Album: <b>{{ song.album }}</b></p>
              <p class="card-text">Duration: <b>{{ renderSongLength(song) }}</b></p>
            </template>
          </the-card>
          </div>
        </div>
        <div v-else class="row gx-5">
          <the-alert :hasAlert=true alertType="error" alertMessage="There is no song now..."/>
        </div>
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