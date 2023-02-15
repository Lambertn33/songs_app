<template>
  <h2>Album Songs</h2>
</template>

<script>
  export default {
    data() {
      return {
        albumSongs: [],
        isFetching: false,
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