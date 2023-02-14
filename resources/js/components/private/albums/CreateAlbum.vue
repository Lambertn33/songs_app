<template>
  <div class="row">
    <div class="col-md-6 offset-md-3 py-4">
      <album-header headerTitle="Create New Album"/>
      <form v-on:submit.prevent="handleCreateNewAlbum" enctype="multipart/form-data">
          <the-alert :alertMessage="alertMessage" :alertType="alertType" :hasAlert="hasAlert"/>

          <the-input
           inputLabel="Album title"
           inputType="text"
           :inputValue="newAlbum.title" 
           @changeValue="newValue => newAlbum.title = newValue"
          />

          <the-input
           inputLabel="Album title"
           inputType="date"
           :inputValue="newAlbum.release_date" 
           @changeValue="newValue => newAlbum.release_date = newValue"
          />

          <div class="mb-3">
            <label class="form-label">Album Image</label>
            <input
              class="form-control" 
              type="file"
              name="image"
              @change="onFileChange"
              accept="image/*"
            >
          </div>

          <text-area
            inputLabel="Album description"
           :inputValue="newAlbum.description"
           @changeValue="newValue => newAlbum.description = newValue"
           />

          <button type="submit" :class="renderBtnClasses">{{ renderBtnText }}</button>
        </form>
      <router-view></router-view>
    </div>
  </div>
</template>

<script>
import TextArea from '../../reusable/Form/TextArea.vue';
  import AlbumHeader from './AlbumHeader.vue';
  export default {
    components: { AlbumHeader, TextArea },

    data() {
      return {
        isSubmitting: false,
        hasAlert: false,
        alertMessage: '',
        alertType: '',
        newAlbum: {
          title: '',
          description: '',
          release_date: '',
          image: ''
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

      onFileChange(e) {
        this.newAlbum.image = e.target.files[0];
      },

      async handleCreateNewAlbum() {
        let alertMessage = '';
        let alertType = '';
        try {
          this.isSubmitting = true;
          let response = await this.$store.dispatch('createNewAlbum', this.newAlbum);
          if (response.data.status == 'success') {
            alertType = response.data.status;
            alertMessage = response.data.message;
            this.newAlbum.title = '';
            this.newAlbum.description = '';
            this.newAlbum.image = '';
            this.newAlbum.release_date = '';
            this.showModal(alertType, alertMessage);
            setTimeout(()=>{
              window.location.href= '/my-albums';
            }, 3000);
          }
        } catch (error) {
          alertType = 'error';
          alertMessage = error.response.data.message;
          this.showModal(alertType, alertMessage);
          return;
        }
      }  
    },

    computed: {
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

<style>
  form {
    border: 0.0625rem solid #000;
    padding: 1.5rem;
    background-color: #f2f2f2;
    border-radius: 0.25rem;
  }

  form label {
    font-weight: 700;
  }

  form .btn-login {
    background-color: #80d4ff !important;
  }
  .header-container {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    padding-bottom: 2rem;
    text-align: center;
    width: 100%;
  }
</style>