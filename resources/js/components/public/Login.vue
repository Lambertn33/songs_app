<template>
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="login-div">
        <div class="login-header">
          <h2>{{ loginTitle }}</h2>
          <h5>{{ loginSubtitle }}</h5>
        </div>
        <form v-on:submit.prevent="handleLogin">
          <the-alert :alertMessage="alertMessage" :alertType="alertType" :hasAlert="hasAlert"/>

          <the-input
           inputLabel="Email"
           inputType="email"
           :inputValue="loginData.email" 
           @changeValue="newValue => loginData.email = newValue"
          />

          <the-input
           inputLabel="Password"
           inputType="password"
           :inputValue="loginData.password" 
           @changeValue="newValue => loginData.password = newValue"
          />
          <button type="submit" :class="renderBtnClasses">
            <login-icon />
            <span>{{ renderBtnText }}</span>
          </button>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
  import LoginIcon from 'vue-material-design-icons/Login.vue';
  export default { 
    components: { LoginIcon },
    data() {
      return {
        loginTitle: 'Welcome To movies App',
        loginSubtitle: 'Login to your account',
        isSubmitting: false,
        hasAlert: false,
        alertMessage: '',
        alertType: '',
        loginData: {
          email: '',
          password: ''
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

      async handleLogin() {
        let alertMessage = '';
        let alertType = '';
        try {
          this.isSubmitting = true;
          let response = await this.$store.dispatch('authStore/login', this.loginData);
          if (response.status == 200) {
            this.loginData.email = '';
            this.loginData.password = '';
            window.location.href= '/my-albums';
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
          'Login'
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

<style scoped>
  .btn-primary {
    display: flex;
    gap: 0.5rem;
    justify-content: center;
    align-items: center;
  }
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

  .login-div {
    position: relative;
    top: 50%;
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