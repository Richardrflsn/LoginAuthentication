<script setup>
  import { RouterView } from 'vue-router';
import Navbar from './components/Navbar.vue';
import { Notifications } from '@kyvg/vue3-notification';
</script>

<template>
  <Navbar />
  <RouterView></RouterView>
  <Notifications />
</template>

<style scoped>

</style>
