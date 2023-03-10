<template>
  <div class="row">
    <div class="col-md-6 offset-md-3 py-4">
      <the-spinner v-if="isFetching" />
      <div v-else>
        <the-header :headerTitle="renderHeaderTitle" :headerType="headerType" />
          <form v-on:submit.prevent="handleEditAlbum">
              <the-alert :alertMessage="alertMessage" :alertType="alertType" :hasAlert="hasAlert" />

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

              <button type="submit" :class="renderBtnClasses">
                <edit-icon />
                <span>{{ renderBtnText }}</span>
              </button>
            </form>
          <router-view></router-view>
      </div>
    </div>
  </div>
</template>

<script>
  import EditIcon from 'vue-material-design-icons/Pencil.vue';

  export default {
    components: { EditIcon },
    data() {
      return {
        isFetching: false,
        isSubmitting: false,
        singleAlbum: {},
        albumTitle: '',
        hasAlert: false,
        alertMessage: '',
        alertType: '',
        headerType: 'Update Album',
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

      async fetchSingleAlbum(albumId) {
        this.isFetching = true;
        const response = await this.$store.dispatch('getAlbum', [albumId]);
        const { album } = await response.data;
        this.singleAlbum = album;
        this.albumTitle = album.title;
        this.isFetching = false;
      },
      async handleEditAlbum() {
        let alertMessage = '';
        let alertType = '';
        try {
          this.isSubmitting = true;
          let response = await this.$store.dispatch('editAlbum', {
            'editedAlbum': this.singleAlbum, 'albumId': this.singleAlbum.id}
          );
          if (response.data.status == 'success') {
            alertType = response.data.status;
            alertMessage = response.data.message;
            this.singleAlbum.title = '';
            this.singleAlbum.description = '';
            this.singleAlbum.image = '';
            this.singleAlbum.release_date = '';
            this.showModal(alertType, alertMessage);
            setTimeout(()=>{
              this.$router.push(`/my-albums/`);
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
    mounted() {
      const albumId = this.$route.params.id;
      this.fetchSingleAlbum(albumId);
    },
    computed: {
      renderHeaderTitle() {
        return `Edit Album Entitled ${this.albumTitle}`;
      },
      renderBtnText() {
        return this.isSubmitting ? 
          'Please wait......' :
          'Update Album'
      },
      renderBtnClasses() {
        let initialClasses = 'btn btn-success'
        let classes = this.isSubmitting ? 
          `${initialClasses} btn-update` :
          initialClasses;
        return classes;
      }
    }
  }
</script>

<style scoped>
  .btn-update {
    background:  #00e600 !important;
  }
</style>