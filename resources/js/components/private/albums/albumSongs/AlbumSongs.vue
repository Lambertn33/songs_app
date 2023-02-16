<template>
  <div class="row">
    <div class="col-md-12 py-4">
      <the-header :headerTitle="headerType" :headerType="headerType"/>
      <router-view></router-view>
      <the-spinner v-if="isFetching" />
      <div v-else>
        <div class="text-center">
          <div class="jumbotron">
            <h4><b>{{ albumTitle }} - <span class="text text-danger">{{ albumSongs.length }} songs</span></b></h4>  
            <p>{{ albumDescription }}</p>  
            <button class="btn btn-primary" @click=" renderCreateNewSongPage">
              <plus-icon />
              Add New Song
            </button>
          </div>
          <div class="row pt-4" v-if="isSongsCountable">
            <div class="col-md-4" v-for="song in albumSongs" :key="song.id">
              <song-card  :song="song" @deleteSong="deleteSong"/>
            </div>
          </div>
          <div v-else class="row pt-5">
            <the-alert :hasAlert=true alertType="error" alertMessage="No songs available now...."/>
          </div>
        </div>
      </div>
    </div>
  </div>
  <Modal v-model:visible="isModalVisible" title="Success!">
    <p><b>{{ deletingMessage }}</b></p>
  </Modal>
</template>

<script>
import PlusIcon from 'vue-material-design-icons/Plus.vue';
import SongCard from './SongCard.vue';
import { Modal } from 'usemodal-vue3';

export default {
  components: { SongCard, PlusIcon, Modal },
  data() {
    return {
      albumSongs: [],
      albumTitle: '',
      albumDescription: '',
      isFetching: false,
      isDeleting: false,
      isModalVisible: false,
      deletingMessage: '',
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

    renderCreateNewSongPage() {
      this.$store.dispatch('setAlbumTitle', [this.albumTitle]);
      this.$router.push(`/my-albums/${this.$route.params.id}/songs/create`);
    },

    async deleteSong(songId) {
      try {
        this.isDeleting = true;
        const response = await this.$store.dispatch('deleteAlbumSong', {
          'albumId': this.$route.params.id, 'songId': songId
        });
        const { status, message } = response.data;
        if (status == 'success') {
          this.isModalVisible = true;
          this.deletingMessage = message;
          this.albumSongs = this.albumSongs.filter((song) => {
            return song.id !== songId
          });
        }
        this.isDeleting = false;
      } catch (error) {
        this.deletingMessage = error.response.data.message;
        this.isDeleting = true;
      }
    }
  },
  mounted() {
    const albumId = this.$route.params.id;
    this.getAlbumSongs(albumId);
  },

  computed: {
    isSongsCountable() {
      return this.albumSongs.length > 0 ? true : false;
    },

    renderNewSongLink() {
      return { name: 'createSong', params: { id: this.$route.params.id }}
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