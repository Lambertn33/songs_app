<template>
  <div class="row">
    <div class="col-md-6 offset-md-3 py-4">
      <the-spinner v-if="isFetching" />
      <div v-else>
        <album-header :headerTitle="renderHeaderTitle"/>
          <form v-on:submit.prevent="handleCreateNewAlbum" enctype="multipart/form-data">
              <the-alert :alertMessage="alertMessage" :alertType="alertType" :hasAlert="hasAlert"/>

              <the-input
              inputLabel="Album title"
              inputType="text"
              :inputValue="singleAlbum.title" 
              @changeValue="newValue => singleAlbum.title = newValue"
              />

              <the-input
              inputLabel="Album released date"
              inputType="date"
              :inputValue="singleAlbum.release_date"
              />

              <text-area
                inputLabel="Album description"
                :inputValue="singleAlbum.description"
                @changeValue="newValue => singleAlbum.description = newValue"
              />

              <button type="submit" class="btn btn-success">Update Album</button>
            </form>
          <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
import TheSpinner from '../../reusable/Spinner/TheSpinner.vue';
  import AlbumHeader from './AlbumHeader.vue';
  export default {
    components: { AlbumHeader, TheSpinner },
    data() {
      return {
        isFetching: false,
        isSubmitting: false,
        singleAlbum: {},
        hasAlert: false,
        alertMessage: '',
        alertType: '',
      }
    },
    methods: {
      async fetchSingleAlbum(albumId) {
        this.isFetching = true;
        const response = await this.$store.dispatch('getSingleAlbum', [albumId]);
        const { album } = await response.data;
        this.singleAlbum = album;
        this.isFetching = false;
      }
    },
    mounted() {
      const albumId = this.$route.params.id;
      this.fetchSingleAlbum(albumId);
    },
    computed: {
      renderHeaderTitle() {
        return `Edit Album Entitled ${this.singleAlbum.title}`;
      }
    }
  }
</script>