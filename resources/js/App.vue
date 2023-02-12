<template>
  <div class="main">
    <the-navbar />
    <div class="container">
      <router-view />
    </div>
  </div>
</template>
<script>
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300&display=swap');

.main {
  font-family: 'Poppins', sans-serif;
  font-weight: 400;
  height: 100vh;
}
</style>