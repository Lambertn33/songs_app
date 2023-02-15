<template>
  <div class="row">
    <div class="col-md-12 py-4">
      <album-header :headerTitle="headerType" :headerType="headerType"/>
      <router-view></router-view>
      <the-spinner v-if="isFetching" />
      <div v-else>
          <h2>Album Songs</h2>
        <!-- <div class="row" v-if="isAlbumsCountable">     
         <div class="col-md-3" v-for="album in myAlbums" :key="album.id">
            <album-card :renderBtnObjects="{renderDeleteClasses, renderDeleteText}" :album="album" @deleteAlbum="deleteAlbum"/>
         </div>          
       </div>
       <div v-else class="row gx-5">
          <the-alert :hasAlert=true alertType="error" alertMessage="You have no albums yet... please create one"/>
       </div> -->
       </div>
    </div>
  </div>
</template>

<script>
import AlbumHeader from '../AlbumHeader.vue';
  export default {
    components: { AlbumHeader },
    data() {
      return {
        albumSongs: [],
        isFetching: false,
        headerType: "View Album Songs",
      }
    },
    methods: {
      async getAlbumSongs(albumId) {
        this.isFetching = true;
        const response = await this.$store.dispatch('getAlbumSongs', [albumId]);
        console.log(response);
        this.isFetching = false;
      },
    },
    mounted() {
      const albumId = this.$route.params.id;
      this.getAlbumSongs(albumId);
    },
  };
</script>