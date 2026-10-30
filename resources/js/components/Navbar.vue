<template>
  <header class="site-header">
    <div class="w">
      <!-- LOGO -->
      <router-link class="logo" to="/" aria-label="Expertvence" @click="closeMenu">
        <span class="lw">
          Expert
          <svg viewBox="0 0 34 28" aria-hidden="true">
            <defs>
              <linearGradient id="header-lg" x1="0" y1="0" x2="1" y2="1">
                <stop offset="0" stop-color="#5BE7FF" />
                <stop offset="1" stop-color="#1A9FC0" />
              </linearGradient>
            </defs>
            <path d="M1 3h13v3.5H5V11h8v3.5H5V19h9v3.5H1z" fill="url(#header-lg)" />
            <path d="M14 3h6.5l3.5 11 6-11h4L26 25h-5.5z" fill="url(#header-lg)" />
          </svg>
          Vence
        </span>
        <small>Software</small>
      </router-link>

      <!-- MOBILE TOGGLE -->
      <button class="tg" @click="isMobileOpen = !isMobileOpen" aria-label="Toggle Menu">
        {{ isMobileOpen ? '✕' : '☰' }}
      </button>

      <!-- NAV -->
      <nav class="site-nav" :class="{ show: isMobileOpen }">
        <a href="#home" @click.prevent="navigate('#home', '/')">Home</a>
        <a href="#about" @click.prevent="navigate('#about', '/about')">About Us</a>

        <!-- SERVICES DROPDOWN -->
        <div
          class="dd"
          :class="{ open: isDropdownOpen }"
          @mouseenter="onDropdownEnter"
          @mouseleave="onDropdownLeave"
        >
          <button type="button" @click.stop="isDropdownOpen = !isDropdownOpen" :aria-expanded="isDropdownOpen">
            Our Services
            <svg viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M2 4l4 4 4-4" />
            </svg>
          </button>
          <ul>
            <li>
              <a href="#services" @click.prevent="navigate('#services', '/services/web-app-development')">
                Web Applications
              </a>
            </li>
            <li>
              <a href="#services" @click.prevent="navigate('#services', '/services')">
                Digital Marketing
              </a>
            </li>
            <li>
              <a href="#plans" @click.prevent="navigate('#plans', '/services')">
                Page Management
              </a>
            </li>
            <li>
              <a href="#solutions" @click.prevent="navigate('#solutions', '/services')">
                Ready Solutions
              </a>
            </li>
            <li>
              <a href="#audit" @click.prevent="navigate('#audit', '/')">
                Free Page Audit
              </a>
            </li>
          </ul>
        </div>

        <a href="#solutions" @click.prevent="navigate('#solutions', '/services')">Ready Software</a>
        <a href="#audit" @click.prevent="navigate('#audit', '/')">Free Audit</a>
        <a href="#contact" @click.prevent="navigate('#contact', '/contact')">Contact Us</a>

        <button class="nav-cta" @click="openModal">
          Book a Meeting
          <svg viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">
            <path d="M2 8h12M9 3l5 5-5 5" />
          </svg>
        </button>
      </nav>
    </div>

    <!-- Contact Modal -->
    <ContactModal :show="showModal" @close="showModal = false" />
  </header>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import ContactModal from '@/components/ContactModal.vue'

const route = useRoute()
const router = useRouter()

const isMobileOpen = ref(false)
const isDropdownOpen = ref(false)
const showModal = ref(false)

const openModal = () => {
  showModal.value = true
  closeMenu()
}

const closeMenu = () => {
  isMobileOpen.value = false
  isDropdownOpen.value = false
}

const onDropdownEnter = () => {
  if (window.innerWidth > 980) {
    isDropdownOpen.value = true
  }
}

const onDropdownLeave = () => {
  if (window.innerWidth > 980) {
    isDropdownOpen.value = false
  }
}

const navigate = (hash, fallbackPath) => {
  closeMenu()
  if (route.path === '/') {
    const el = document.querySelector(hash)
    if (el) {
      el.scrollIntoView({ behavior: 'smooth' })
      return
    }
  }
  router.push(fallbackPath)
}

const handleOutsideClick = (e) => {
  if (!e.target.closest('.dd')) {
    isDropdownOpen.value = false
  }
}

onMounted(() => {
  document.addEventListener('click', handleOutsideClick)
})

onUnmounted(() => {
  document.removeEventListener('click', handleOutsideClick)
})
</script>