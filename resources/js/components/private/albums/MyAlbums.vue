<template>
  <div class="row">
    <div class="col-md-12 py-4">
      <div class="header-container">
        <h2 class="text-center">My Albums</h2>
        <button class="btn btn-primary"> Add New Album</button>
      </div>
      <the-spinner v-if="isFetching" />
      <div v-else>
        <div class="row gx-5" v-if="isAlbumsCountable">     
         <div class="col-md-6" v-for="album in myAlbums" :key="album.id">
            <single-album :album="album"/>
         </div>          
       </div>
       <div v-else class="row gx-5">
        <div class="alert alert-danger" role="alert">
          <b class="tet-center">You have no albums yet... please create one</b>
        </div>
       </div>
       </div>
    </div>
  </div>
</template>

<script>
  import SingleAlbum from './SingleAlbum.vue';
  export default {
    components: { SingleAlbum },
    data() {
      return {
        isFetching: false,
        myAlbums: []
      }
    },
    methods: {
      async fetchAlbums() {
        this.isFetching = true;
        const response = await this.$store.dispatch('fetchMyAlbums');
        const { albums } = response.data;
        this.myAlbums = albums;
        this.isFetching = false;
      }
    },

    computed: {
      isAlbumsCountable() {
        return this.myAlbums.length > 0 ? true : false
      }
    },
    mounted() {
      this.fetchAlbums();
    }
  }
</script>

<style>
  .header-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    padding-bottom: 2rem;
    text-align: center;
    width: 100%;
  }
</style>