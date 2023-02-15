<template>
  <div class="row">
    <div class="col-md-12 py-4">
      <album-header headerTitle="My Albums"/>
      <router-view></router-view>
      <the-spinner v-if="isFetching" />
      <div v-else>
        <div class="row" v-if="isAlbumsCountable">     
         <div class="col-md-3" v-for="album in myAlbums" :key="album.id">
            <album-card :renderBtnObjects="{renderDeleteClasses, renderDeleteText}" :album="album" @deleteAlbum="deleteAlbum"/>
         </div>          
       </div>
       <div v-else class="row gx-5">
          <the-alert :hasAlert=true alertType="error" alertMessage="You have no albums yet... please create one"/>
       </div>
       </div>
    </div>
  </div>
  <Modal v-model:visible="isModalVisible" title="Success!">
    <p><b>{{ deletingMessage }}</b></p>
  </Modal>
</template>

<script>
  import AlbumCard from './AlbumCard.vue';
  import AlbumHeader from './AlbumHeader.vue';
  import { Modal } from 'usemodal-vue3';

  export default {
    components: { AlbumCard, AlbumHeader, Modal },
    data() {
      return {
        isFetching: false,
        isDeleting: false,
        isModalVisible: false,
        deletingMessage: '',
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
          const { status, message } = response.data;
          if (status == 'success') {
            this.isModalVisible = true;
            this.deletingMessage = message
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
      },
      renderDeleteText() {
        return this.isDeleting ? 
          'Please wait......' :
          'Delete Album'
      },
      renderDeleteClasses() {
        let initialClasses = 'btn btn-danger'
        let classes = this.isDeleting ? 
          `${initialClasses} btn-delete` :
          initialClasses;
        return classes;
      }
    },
    mounted() {
      this.fetchAlbums();
    }
  }
</script>

<style scoped>
  .btn-delete {
    background-color: #ffb3b3 !important;
  }
</style>
