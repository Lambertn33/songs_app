<template>
  <div class="header-container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item" v-for="link in albumLinks" :key="link.to">
          <router-link :to="link.to" active-class="active">{{ link.label }}</router-link>
        </li>
      </ol>
    </nav>
    <h4 class="text-center pb-2">{{ headerTitle }}</h4>
  </div>
</template>

<script>
  export default {
    props: {
      headerTitle: String
    },
    data() {
      return {
        albumLinks: [
          {
            to: "/my-albums",
            label: "My Albums"
          },
          {
            to: "/my-albums/create",
            label: "Create New"
          },          
        ],

      }
    }
  }
</script>

<style scoped>
  nav {
    padding: 0;
  }
  .header-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    text-align: center;
    width: 100%;
  }
  .breadcrumb-item {
    font-weight: bold;
  }
  .breadcrumb-item a {
    text-decoration: none;
  }

  .router-link-exact-active {
    color: black;
  }
</style>