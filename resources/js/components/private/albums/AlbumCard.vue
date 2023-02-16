<template>
  <the-card>
     <template #card-image>
        <img :src="album.image" class="card-img-top">
     </template>
     <template #card-body>
      <h3 class="card-title">{{ album.title }}</h3>
      <p class="card-text">{{ album.description }}</p>
      <p class="card-text">Released on {{ album.release_date }}</p>
     </template>
     <template #card-footer>
      <div class="card-footer">
        <router-link :to="renderAlbumSongs">
          <span data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="top" title="View Album Songs">
            <span class=" card-icon icon-view">
              <view-icon />
            </span>
          </span>
        </router-link>
        <router-link :to="renderEditLink">
          <span data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="top" title="Edit Album">
            <span class=" card-icon icon-edit">
              <edit-icon />
            </span>
          </span>
        </router-link>
        <span data-bs-toggle="tooltip" data-bs-custom-class="custom-tooltip" data-bs-placement="top" title="Delete Album">
          <span class=" card-icon icon-delete"  @click="$emit('deleteAlbum', album.id)">
            <delete-icon />
          </span>
        </span>
      </div>
     </template>
  </the-card>
</template>

<script>
  import ViewIcon from 'vue-material-design-icons/MusicNoteEighth.vue';
  import EditIcon from 'vue-material-design-icons/Pencil.vue';
  import DeleteIcon from 'vue-material-design-icons/Delete.vue';

  export default {
    components: { ViewIcon, EditIcon, DeleteIcon },
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

<style>
  .card-icon {
    color: #fff;
    padding: 0.125rem;
    border-radius: 0.25rem;
  }
  .card-icon:hover {
    padding: 0.25rem;
    transition: .01s;
    cursor: pointer;
  }
  .card-footer {
    display: flex;
    justify-content: space-around;
    align-items: center;
    padding: 1rem;
  }
  .icon-view {
    background: #0dcaf0;
  }
  .icon-edit {
    background: #ffc107;
  }
  .icon-delete {
    background: #dc3545;
  }
</style>