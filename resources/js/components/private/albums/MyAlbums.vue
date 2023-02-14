<template>
  <div class="row">
    <div class="col-md-12 py-4">
      <album-header headerTitle="My Albums"/>
      <router-view></router-view>
      <the-spinner v-if="isFetching" />
      <div v-else>
        <div class="row" v-if="isAlbumsCountable">     
         <div class="col-md-3" v-for="album in myAlbums" :key="album.id">
            <album-card :album="album"/>
         </div>          
       </div>
       <div v-else class="row gx-5">
          <the-alert :hasAlert=true alertType="error" alertMessage="You have no albums yet... please create one"/>
       </div>
       </div>
    </div>
  </div>
</template>

<script>
  import AlbumCard from './AlbumCard.vue';
  import AlbumHeader from './AlbumHeader.vue';
  export default {
    components: { AlbumCard, AlbumHeader },
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
