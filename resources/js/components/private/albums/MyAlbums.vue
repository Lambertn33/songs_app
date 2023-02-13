<template>
  <div class="row">
    <div class="col-md-12 py-4">
       <h2 class="text-center">My Albums</h2>
       <div class="row gx-5">     
         <div class="col-md-6">
            <single-album />
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
        console.log(this.myAlbums);
        this.isFetching = false;
      }
    },
    mounted() {
      this.fetchAlbums();
    }
  }
</script>