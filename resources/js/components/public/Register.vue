<template>
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="login-div">
        <div class="login-header">
          <h2>{{ registerTitle }}</h2>
          <h5>{{ registerSubtitle }}</h5>
        </div>
        <form v-on:submit.prevent="handleRegister">
          <the-alert :alertMessage="alertMessage" :alertType="alertType" :hasAlert="hasAlert"/>

          <the-input
           inputLabel="Names"
           inputType="text"
           :inputValue="user.names" 
           @changeValue="newValue => user.names = newValue"
          />

          <the-input
           inputLabel="Email"
           inputType="email"
           :inputValue="user.email" 
           @changeValue="newValue => user.email = newValue"
          />

          <the-input
           inputLabel="Password"
           inputType="password"
           :inputValue="user.password" 
           @changeValue="newValue => user.password = newValue"
          />

          <the-input
           inputLabel="Password Confirmation"
           inputType="password"
           :inputValue="user.passwordConfirm" 
           @changeValue="newValue => user.passwordConfirm = newValue"
          />

          <button type="submit" :class="renderBtnClasses">{{ renderBtnText }}</button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        registerTitle: 'Welcome To movies App',
        registerSubtitle: 'Create Account',
        isSubmitting: false,
        hasAlert: false,
        alertMessage: '',
        alertType: '',
        user: {
          names: '',
          email: '',
          password: '',
          passwordConfirm: ''
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

      async handleRegister() {
        let alertMessage = '';
        let alertType = '';
        try {
          this.isSubmitting = true;
          if (this.user.password !== this.user.passwordConfirm) {
            alertType = 'error';
            alertMessage = 'password confirmation does not match';
            this.showModal(alertType, alertMessage);
            return;
          }
          let response = await this.$store.dispatch('authStore/register', this.user);
          if (response.status == 'success') {
            alertType = response.status;
            alertMessage = 'Sign up made successfully... please go to login page';
            this.user.email = '';
            this.user.names = '';
            this.user.password = '';
            this.user.passwordConfirm = '';
            this.showModal(alertType, alertMessage);
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
          'Register'
      },
      renderBtnClasses() {
        let initialClasses = 'btn btn-primary'
        let classes = this.isSubmitting ? 
          `${initialClasses} btn-register` :
          initialClasses;
        return classes;
      }
    }
  }
</script>

<style scoped>
  form {
    border: 0.0625rem solid #000;
    padding: 1.5rem;
    background-color: #f2f2f2;
    border-radius: 0.25rem;
  }

  form label {
    font-weight: 700;
  }

  form .btn-register {
    background-color: #80d4ff !important;
  }

  .login-div {
    position: relative;
    top: 10%;
  }

  .login-header {
    text-align: center;
    padding-bottom: 0.5rem;
  }

  .login-header h2,
  .login-header h5 {
    font-weight: 700;
  }
</style>