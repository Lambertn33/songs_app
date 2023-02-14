<template>
  <div class="row">
    <div class="col-md-12 py-4">
      <album-header headerTitle="My Albums"/>
      <router-view></router-view>
      <the-spinner v-if="isFetching" />
      <div v-else>
        <div class="row" v-if="isAlbumsCountable">     
         <div class="col-md-3" v-for="album in myAlbums" :key="album.id">
            <album-card :album="album" @deleteAlbum="deleteAlbum"/>
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
        isDeleting: false,
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
      },

      async deleteAlbum(albumId) {
        try {
          this.isDeleting = true;
          const response = await this.$store.dispatch('deleteAlbum', [albumId]);
          if (response.data.status == 'success') {
            this.myAlbums = this.myAlbums.filter((album) => {
              return album.id !== albumId
            });
          }
          this.isDeleting = false;
        } catch (error) {
          console.log(error);
        }
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
