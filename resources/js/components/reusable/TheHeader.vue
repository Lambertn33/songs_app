<template>
  <div class="header-container">
    <nav aria-label="breadcrumb">
      <ol class="breadcrumb">
        <li class="breadcrumb-item" v-for="link in renderLinks" :key="link.to">
          <router-link :to="link.to" active-class="active">{{ link.label }}</router-link>
        </li>
      </ol>
    </nav>
    <h4 class="text-center pb-2">{{ headerTitle }}</h4>
  </div>
</template>

<script>
  export default {
    data() {
      return {
        albumId: null,
      }
    },
    props: {
      headerTitle: String,
      headerType: String,
    },
    data() {
      return {
        createAndReadAlbumsLinks: [
          {
            to: "/my-albums",
            label: "My Albums"
          },
          {
            to: "/my-albums/create",
            label: "Create New"
          },          
        ],
        
        updateAlbumLinks: [
          {
            to: "/my-albums",
            label: "My Albums"
          },
          {
            to: `/my-albums/${this.$route.params.id}/edit`,
            label: "Edit Album"
          },          
        ],
        viewAlbumSongsLinks: [
          {
            to: "/my-albums",
            label: "My Albums"
          },
          {
            to: `/my-albums/${this.$route.params.id}/songs`,
            label: "Album Songs"
          },  
        ],
        createAndReadAlbumSongsLink: [
          {
            to: "/my-albums",
            label: "My Albums"
          },
          {
            to: `/my-albums/${this.$route.params.id}/songs`,
            label: "Album Songs"
          }, 
          {
            to: `/my-albums/${this.$route.params.id}/songs/create`,
            label: "Create New"
          },  
        ],
      }
    },
    computed: {
      renderLinks() {
        const createAndReadAlbumsLabel = "Create/ Read Albums";
        const updateAlbumLabel = 'Update Album';
        const viewAlbumSongsLabel = 'View Album Songs';
        const createAndReadAlbumSongsLabel = 'Create/ Read Songs';
        let links = [];
        if (this.headerType == createAndReadAlbumsLabel) {
          links = [...this.createAndReadAlbumsLinks];
        }
        else if (this.headerType == updateAlbumLabel) {
          links = [...this.updateAlbumLinks];
        }
        else if (this.headerType == viewAlbumSongsLabel) {
          links = [...this.viewAlbumSongsLinks];
        }
        else if (this.headerType == createAndReadAlbumSongsLabel) {
          links = [...this.createAndReadAlbumSongsLink];
        }
        return links;
      },
    },
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