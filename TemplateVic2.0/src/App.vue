<script setup>
 import { RouterLink, RouterView } from 'vue-router'
</script>

<template>
  <div class="app-container">
    <RouterView />
  </div>
</template>

<style scoped>
.app-container {
  height: 100vh; /* Prend toute la hauteur de la fenêtre */
  width: 100%; /* Prend toute la largeur */
}
</style>
