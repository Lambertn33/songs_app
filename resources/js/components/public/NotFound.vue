<template>
  <div class="col-md-8 offset-md-2">
    <div class="p-5 mb-4 bg-light rounded-3 jumbotron">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Ooops!!</h1>
        <p class="col-md-8 fs-4">it looks like the page you are trying to navigate to, doesn't exist</p>
        <button class="btn btn-primary btn-lg" type="button">
          <router-link class="linkToHome" :to="renderRedirectionUrl">Back Home</router-link>
        </button>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    computed: {
      renderRedirectionUrl() {
        return this.$store.state.authStore.status.loggedIn ?
          "/my-albums" : "/";
      }
    }
  }
</script>

<style scoped>
  .linkToHome {
    color: #fff;
    text-decoration: none;
  }
</style>