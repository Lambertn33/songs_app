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
  background-color: #d9d9d9;
  height: 100vh;
}
</style>