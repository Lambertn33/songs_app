<template>
  <div class="card">
    <img :src="album.image" class="card-img-top">
    <div class="card-body">
      <h3 class="card-title">{{ album.title }}</h3>
      <p class="card-text">{{ album.description }}</p>
      <p class="card-text">Released on {{ album.release_date }}</p>
      <div class="card-buttons">
        <router-link :to="renderAlbumSongs">
          <button class="btn btn-info btn-flat">
            View Songs
          </button>
        </router-link>
        <router-link :to="renderEditLink">
          <button class="btn btn-warning btn-flat">
            Edit Album
          </button>
          </router-link>
        <button :class="renderBtnObjects.renderDeleteClasses" @click="$emit('deleteAlbum', album.id)">{{ renderBtnObjects.renderDeleteText }}</button>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      album: Object,
      renderBtnObjects: Object
    },
    emits: ['deleteAlbum'],
    computed: {
      renderEditLink() {
        return `/my-albums/${this.album.id}/edit`;
      },
      renderAlbumSongs() {
        return `/my-albums/${this.album.id}/songs`;
      }
    }
  }
</script>

<style scoped>

  .btn-flat {
    width: 100%;
  }
  .card-text {
    font-weight: 600;
  }
  .card-title {
    font-weight: 800;
  }

  .card {
    width: 18rem;
  }

  .card-buttons {
    display: flex;
    flex-direction: column;
    gap: 1rem;
  }

  .card-img-top {
    object-fit: cover;
    width: 100%;
  }
</style>