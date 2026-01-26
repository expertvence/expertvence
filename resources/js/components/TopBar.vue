<template>
  <div class="topbar" :class="{ 'topbar-hide': hideTopbar }">
    <!-- LEFT INFO -->
    <div class="topbar-left">
      <span class="info-item">
        🇧🇩 <strong>+880 1813590326</strong>
      </span>


      <span class="dot"></span>

      <span class="info-item email">
        ✉ contact@expertvence.com
      </span>
    </div>

    <!-- RIGHT ACTIONS -->
    <div class="topbar-right">
      <router-link to="/contact" class="top-link">
        Contact
      </router-link>

      <span class="divider">|</span>

      <router-link to="/login" class="top-link">
        Login
      </router-link>

      <div class="socials">
        <a href="#" class="linkedin">in</a>
        <a href="#" class="facebook">f</a>
        <a href="#" class="twitter">x</a>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const hideTopbar = ref(false)

const onScroll = () => {
  hideTopbar.value = window.scrollY > 60
}

onMounted(() => {
  window.addEventListener('scroll', onScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', onScroll)
})
</script>
