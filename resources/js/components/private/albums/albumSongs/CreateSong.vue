<template>
  <div class="row">
    <div class="col-md-6 offset-md-3 py-4">
      <the-spinner v-if="isFetching" />
      <div v-else>
        <the-header :headerTitle="renderHeaderTitle" :headerType="headerType"/>
          <form v-on:submit.prevent="createNewSong">
            <the-alert :alertMessage="alertMessage" :alertType="alertType" :hasAlert="hasAlert"/>

            <the-input
              inputLabel="Song title"
              inputType="text"
              :inputValue="newSong.title" 
              @changeValue="newValue => newSong.title = newValue"
            />
            <the-input
              inputLabel="Song Length (in seconds)"
              inputType="number"
              :inputValue="newSong.length" 
              @changeValue="newValue => newSong.length = newValue"
            />

            <the-select
              inputLabel="Select Genre"
              @changeValue="newValue => newSong.genreId = newValue"
             :genres="allGenres"/>

             <button type="submit" :class="renderBtnClasses">
              <plus-icon />
              {{ renderBtnText }}
             </button>
          </form>
        <router-view />
      </div>
    </div>
  </div>
</template>

<script>
import PlusIcon from 'vue-material-design-icons/Plus.vue';

export default { 
  components: { PlusIcon },
  data() {
    return {
      headerType: "Create/ Read Songs",
      allGenres: [],
      isFetching: false,
      albumTitle: '',
      isSubmitting: false,
      hasAlert: false,
      alertMessage: '',
      alertType: '',
      newSong: {
        title: '',
        length: '',
        genreId: '',
        albumId: this.$route.params.id
      }
    }
  },

  methods: {
    hideModal() {
      this.hasAlert = false;
      this.alertMessage = '';
      this.alertType = '';
    },

    showModal(alertType, alertMessage) {
      this.isSubmitting = false;
      this.hasAlert = true;
      this.alertType = alertType;
      this.alertMessage = alertMessage;
      setTimeout(() => {
        this.hideModal();
      }, 4000);
    },

    async fetchAllGenres() {
      this.isFetching = true;
      const response = await this.$store.dispatch('fetchAllGenres');
      const { genres } = response.data;
      this.albumTitle = this.$store.getters.getAlbumTitle;
      this.allGenres = genres;
      this.isFetching = false;
    },
    async createNewSong() {
      let alertMessage = '';
        let alertType = '';
        try {
          this.isSubmitting = true;
          let response = await this.$store.dispatch('createAlbumSong', {
            'newSong': this.newSong, 'albumId': this.newSong.albumId}
          );
          if (response.data.status == 'success') {
            alertType = response.data.status;
            alertMessage = response.data.message;
            this.newSong.title = '';
            this.newSong.length = '';
            this.newSong.genreId = '';
            this.newSong.albumId = '';
            this.showModal(alertType, alertMessage);
            setTimeout(()=>{
              this.$router.push(`/my-albums/${this.$route.params.id}/songs/`);
            }, 1000);
          }
        } catch (error) {
          alertType = 'error';
          alertMessage = error.response.data.message;
          this.showModal(alertType, alertMessage);
          return;
        }
    }
  },
  beforeRouteLeave() {
    this.$store.dispatch('setAlbumTitle', ['']);
  },
  mounted() {
    this.fetchAllGenres();
  },

  computed: {
    renderHeaderTitle() {
      return `Create New Song under ${this.albumTitle} Album`;
    },
    renderBtnText() {
      return this.isSubmitting ? 
        'Please wait......' :
        'Save'
    },
    renderBtnClasses() {
      let initialClasses = 'btn btn-primary'
      let classes = this.isSubmitting ? 
        `${initialClasses} btn-login` :
        initialClasses;
      return classes;
    }
  }
}
</script>