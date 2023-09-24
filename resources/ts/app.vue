<template>
  <Navbar />
  <Suspense>
    <RouterView />
  </Suspense>
</template>

<script setup lang="ts">
import Navbar from './components/Navbar.vue'
</script>

<style scoped></style>
