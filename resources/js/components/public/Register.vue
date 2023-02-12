<template>
  <div class="row">
    <div class="col-md-6 offset-md-3">
      <div class="login-div">
        <div class="login-header">
          <h2>{{ registerTitle }}</h2>
          <h5>{{ registerSubtitle }}</h5>
        </div>
        <form v-on:submit.prevent="handleRegister">
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="text" class="form-control" v-model="user.names">
          </div>
          <div class="mb-3">
            <label class="form-label">Email address</label>
            <input type="email" class="form-control" v-model="user.email">
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" v-model="user.password">
          </div>
          <div class="mb-3">
            <label class="form-label">Password Confirmation</label>
            <input type="password" class="form-control" v-model="user.passwordConfirm">
          </div>
          <button type="submit" class="btn btn-primary">Register</button>
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
        user: {
          names: '',
          email: '',
          password: '',
          passwordConfirm: ''
        }
      }
    },
    methods: {
      async handleRegister() {
        try {
          this.isSubmitting = true;
          let response = await this.$store.dispatch('authStore/register', this.user);
          console.log(response.data);
        } catch (error) {
          this.isSubmitting = false;
          console.log(error);
        }
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