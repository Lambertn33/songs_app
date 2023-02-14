<template>
  <div class="card">
    <img :src="album.image" class="card-img-top">
    <div class="card-body">
      <h3 class="card-title">{{ album.title }}</h3>
      <p class="card-text">{{ album.description }}</p>
      <p class="card-text">Released on {{ album.release_date }}</p>
      <div class="card-buttons">
        <a href="#" class="btn btn-primary">View Songs</a>
        <a href="#" class="btn btn-primary">Add New Song</a>
      </div>
    </div>
  </div>
</template>

<script>
  export default {
    props: {
      album: Object
    }
  }
</script>

<style scoped>
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