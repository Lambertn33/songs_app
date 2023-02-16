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
          <component :is="link.icon" class="icon"/>
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
  import AccountPlus from 'vue-material-design-icons/AccountPlus.vue';
  import LoginIcon from 'vue-material-design-icons/Login.vue';
  import AlbumIcon from 'vue-material-design-icons/Album.vue';
  import SongsIcon from 'vue-material-design-icons/MusicNoteEighth.vue';
  import GenresIcon from 'vue-material-design-icons/Tune.vue';
  export default {
    components: { AccountPlus, LoginIcon, AlbumIcon, SongsIcon, GenresIcon },
    data() {
      return {
        isAuthenticated: false,
        authenticatedUser: {},
        publicLinks: [
          {
            name: 'Login',
            href: '/',
            icon: 'login-icon'
          },
          {
            name: 'Register',
            href: '/register',
            icon: 'account-plus'
          },
        ],
        privateLinks: [
          {
            name: 'Albums',
            href: '/my-albums',
            icon: 'album-icon'
          },
          {
            name: 'Songs',
            href: '/all-songs',
            icon: 'songs-icon'
          },
          {
            name: 'Genres',
            href: '/all-genres',
            icon: 'genres-icon'
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

  .icon {
    color: #fff;
  }
  .navbar {
    padding: 1rem;
  }
  .navbar-nav {
    display: flex;
    gap: 1.5rem;
  }
  .navbar-brand,
  .nav-link {
    color: white !important;
    font-weight: 600;
  }
  .nav-item {
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .navbar-collapse {
    margin-left: 2.5rem;
  }

  .nav-link:hover {
    transition: .4s;
    color:turquoise;
  }

  a.router-link-exact-active {
    color: black !important;
  }
</style>