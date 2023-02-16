<template>
  <div class="row">
    <div class="col-md-12 py-4">
      <album-header :headerTitle="headerType" :headerType="headerType"/>
      <router-view></router-view>
      <the-spinner v-if="isFetching" />
      <div v-else>
        <div class="text-center">
          <div class="jumbotron">
            <h3>{{ albumTitle }}</h3>  
            <p>{{ albumDescription }}</p>  
            <button class="btn btn-primary">
              Add New Song
            </button>
          </div>
          <div class="row pt-4" v-if="isSongsCountable">
            <div class="col-md-4">
              <div class="card" style="width: 18rem;">
                <img src="../../../../assets/images/song.png" class="card-img-top" alt="...">
                <div class="card-body">
                  <h5 class="card-title">Card title</h5>
                  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                  <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
              </div>
            </div>
          </div>
          <div v-else>
            songs empty
          </div>
        </div>
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
        albumTitle: '',
        albumDescription: '',
        isFetching: false,
        headerType: "View Album Songs",
      }
    },
    methods: {
      async getAlbumSongs(albumId) {
        this.isFetching = true;
        const response = await this.$store.dispatch('getAlbumSongs', [albumId]);
        const { album, songs, description } = response.data;
        this.albumTitle = album;
        this.albumSongs = songs;
        this.albumDescription = description;
        this.isFetching = false;
      },
    },
    mounted() {
      const albumId = this.$route.params.id;
      this.getAlbumSongs(albumId);
    },

    computed: {
      isSongsCountable() {
        return this.albumSongs.length > 0 ? true : false;
      }
    }
  };
</script>

<style scoped>
  .jumbotron {
    background: aliceblue;
    padding: 3rem;
  }
</style>