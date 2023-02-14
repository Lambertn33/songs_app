<template>
  <nav class="navbar navbar-expand-lg bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand logo" href="#">Songs Application</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav me-auto">
        <li class="nav-item" v-for="link in getLinks" :key="link.name">
          <router-link class="nav-link active" aria-current="page" :to="link.href">{{ link.name }}</router-link>
        </li>
      </ul>
      <ul v-if="isAuthenticated" class="navbar-nav">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            {{ authenticatedUser.names }}
          </a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href @click.prevent="logout">Logout</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav> 
</template>

<script>
  export default {
    data() {
      return {
        isAuthenticated: false,
        authenticatedUser: {},
        publicLinks: [
          {
            name: 'Login',
            href: '/'
          },
          {
            name: 'Register',
            href: '/register'
          },
        ],
        privateLinks: [
          {
            name: 'Albums',
            href: '/my-albums'
          },
          {
            name: 'Songs',
            href: '/all-songs'
          },
          {
            name: 'Genres',
            href: '/all-genres'
          },
        ],
      }
    },
    created() {
      this.isAuthenticated = this.$store.state.authStore.status.loggedIn;
      this.authenticatedUser = this.$store.state.authStore.user
    },

    methods: {
      async logout() {
       await this.$store.dispatch('authStore/logout');
       window.location.href="/";
      }
    },
    computed: {
      getLinks() {
        return this.isAuthenticated ? this.privateLinks : this.publicLinks;
      }
    }
  }
</script>

<style scoped>
  .navbar {
    padding: 1rem;
  }
  .navbar-brand,
  .nav-link {
    color: white !important;
    font-weight: 600;
  }
  .navbar-collapse {
    margin-left: 2.5rem;
  }

  .nav-link:hover {
    transition: .4s;
    color:turquoise;
  }
</style>