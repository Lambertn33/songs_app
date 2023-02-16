<template>
  <div class="card">
    <slot name="card-image"></slot>
    <div class="card-body">
      <slot name="card-body"></slot>
    </div>
    <slot name="card-footer"></slot>
  </div>
</template>
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
  .card-img-top {
    object-fit: cover;
    width: 100%;
  }
</style>