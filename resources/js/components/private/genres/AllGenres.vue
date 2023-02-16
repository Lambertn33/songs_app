<template>
  <div class="row">
    <div class="col-md-12 py-4">
      <div class="header-container">
        <h2 class="text-center">All Genres</h2>
      </div>
      <the-spinner v-if="isFetching" />
      <div v-else>
        <div class="row gx-5" v-if="isGenresCountable">     
          <div class="col-md-6 offset-md-3">
            <ul class="list-group">
              <li class="list-group-item" v-for="genre in allGenres" :key="genre.id">
                <p>Title: <span>{{ genre.name }}</span></p>
              </li>
            </ul> 
          </div>    
        </div>
        <div v-else class="row gx-5">
          <the-alert :hasAlert=true alertType="error" alertMessage="There is no Genre now..."/>
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
    },

    mounted() {
      this.fetchAllGenres();
    },

    computed: {
      isGenresCountable() {
        return this.allGenres.length > 0 ? true : false
      }
    },
  }
</script>

<style scoped>
  .list-group-item span {
    font-weight: 800;
  }
</style>