<script setup>
// This starter template is using Vue 3 <script setup> SFCs
// Check out https://vuejs.org/api/sfc-script-setup.html#script-setup
import { ref, onMounted } from 'vue'
const isOnline = ref(navigator.onLine)
onMounted(() => {
  window.addEventListener('online', () => {
    isOnline.value = true
  })

  window.addEventListener('offline', () => {
    isOnline.value = false
  })
})
</script>

<template>
  <div>
    <div v-if="isOnline"><router-view :key="$route.path"></router-view></div>
    <div v-else>You are currently offline</div>
  </div>
</template>

<style></style>
