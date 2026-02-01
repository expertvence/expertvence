<template>
  <div class="topbar" :class="{ 'topbar-hide': hideTopbar }">
    <!-- LEFT INFO -->
    <div class="topbar-left">
      <span class="flag bd"></span> +880 1813590326

      <span class="info-item email">
        <!-- Titan Email Icon (simplified SVG) -->
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <rect x="1" y="4" width="22" height="16" rx="2" fill="#4368F0" />
          <path d="M1 4L12 13L23 4" stroke="#fff" stroke-width="2" />
          <path d="M1 20V8L12 17L23 8V20H1Z" fill="#fff" />
        </svg>
        info@expertvence.com
      </span>
    </div>

    <!-- RIGHT ACTIONS -->
    <div class="topbar-right">
      <router-link to="" @click="showModal = true" class="top-link">
        Contact
      </router-link>

        <ContactModal :show="showModal" @close="showModal = false" />

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
import ContactModal from '@/components/ContactModal.vue'
const showModal = ref(false)

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
