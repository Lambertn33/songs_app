<template>
  <div class="row">
    <div class="col-md-6">
      <div class="genreContainer">
        <div class="header-container py-4">
        <h3 class="text-center"><b>All Genres With Respective songs</b></h3>
      </div>
      <the-spinner v-if="isFetching" />
      <div v-else>
        <div class="row gx-5" v-if="isGenresCountable">     
          <div class="col-md-12">
            <div class="accordion">
              <div class="accordion-item" v-for="(genre, i) in allGenres" :key="genre.id" :id="genre.id">
                <h2 class="accordion-header" id="headingOne">
                  <button class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    :data-bs-target="renderAccordionGenreId(genre)"
                    aria-controls="collapseOne"
                    :class="{ collapsed: i > 0 }"
                    :aria-expanded="i === 0"
                    >
                    <b>{{ genre.name }}</b>
                  </button>
                </h2>
                <div :id="renderGenreId(genre)" class="accordion-collapse collapse" :class="{ show: i === 0 }" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    <strong>{{ genre.name }} has <span class="text text-danger">{{ genre.songs.length }}</span> song(s)</strong>
                    <ul class="list-group py-4" v-show="genre.songs.length > 0">
                      <li class="list-group-item" v-for="song in genre.songs" :key="song.id">
                          # {{ i }}
                          <hr>
                          Title: <b>{{ song.title }}</b>
                          <hr>
                          Length: <b>{{ renderSongLength(song) }}</b>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>    
        </div>
        <div v-else class="row gx-5">
          <the-alert :hasAlert=true alertType="error" alertMessage="There is no Genre now..."/>
        </div>
        
      </div>
      </div>
    </div>
    <div class="col-md-6">
      <img class="music-img" src="../../../assets/images/musicBanner.jpg" alt="" srcset="">
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        isFetching: false,
        allGenres: []
      }
    },

    methods: {
      async fetchAllGenres() {
        this.isFetching = true;
        const response = await this.$store.dispatch('fetchAllGenres');
        const { genres } = response.data;
        this.allGenres = genres;
        this.isFetching = false;
      },
      renderAccordionGenreId(genre) {
        return `#album-${genre.id}`;
      },
      renderGenreId(genre) {
        return `album-${genre.id}`;
      },
      renderSongLength(song) {
        let length = song.length;
        let mins = Math.floor((length / 60)).toFixed();
        let secs = length % 60;
        let songLength = `${mins} minutes and ${secs} seconds`;
        return songLength;
      }
    },

    mounted() {
      this.fetchAllGenres();
    },

    computed: {
      isGenresCountable() {
        return this.allGenres.length > 0 ? true : false
      },
    },
  }
</script>

<style scoped>
  .accordion-item {
    border: 0.0625rem solid gray;
  }
  .genreContainer {
    position: relative;
    top: 20%;
  }
  .list-group-item span {
    font-weight: 800;
  }

  .music-img {
    width: 100vh;
    height: 95vh;
  }
</style>