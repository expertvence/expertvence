<template>
  <nav class="navbar" :class="{ 'navbar-scrolled': isScrolled }">

    <!-- LEFT -->
    <div class="nav-left">
      <router-link to="/" class="logo-link" @click="open = false">
        <img :src="logo" alt="ExpertVence Logo" class="logo-img" />
      </router-link>
    </div>

    <!-- DESKTOP MENU -->
    <ul class="menu desktop-menu">
      <li><router-link to="/">Home</router-link></li>
      <li><router-link to="/about">About</router-link></li>

      <!-- Services Dropdown -->
      <li class="dropdown-parent">
        <a href="#" class="dropdown-toggle">Services</a>
        <div class="services-dropdown">
          <div class="dropdown-grid">
            <!-- Row 1: 3 items -->
            <div class="dropdown-column">
              <div class="dropdown-category">
                <h3>Software Development</h3>
                <ul>
                  <li><span class="dropdown-icon">💻</span><a href="#">Custom Software Development</a></li>
                  <li><span class="dropdown-icon">⛓️</span><a href="#">Blockchain Development</a></li>
                </ul>
              </div>
            </div>

            <div class="dropdown-column">
              <div class="dropdown-category">
                <h3>Web & App Development</h3>
                <ul>
                  <li><span class="dropdown-icon">☕</span><a href="#">Java Development</a></li>
                  <li><span class="dropdown-icon">🐘</span><a href="#">PHP Development</a></li>
                </ul>
              </div>
            </div>

            <div class="dropdown-column">
              <div class="dropdown-category">
                <h3>Design</h3>
                <ul>
                  <li><span class="dropdown-icon">🎨</span><a href="#">UI/UX Design</a></li>
                </ul>
              </div>
            </div>

            <!-- Row 2: 3 items -->
            <div class="dropdown-column">
              <div class="dropdown-category">
                <h3>Marketing & Advertising</h3>
                <ul>
                  <li><span class="dropdown-icon">📈</span><a href="#">Digital Marketing</a></li>
                  <li><span class="dropdown-icon">🐍</span><a href="#">Python Development</a></li>
                </ul>
              </div>
            </div>

            <div class="dropdown-column">
              <div class="dropdown-category">
                <h3>Latest Tech</h3>
                <ul>
                  <li><span class="dropdown-icon">⚛️</span><a href="#">React Development</a></li>
                  <li><span class="dropdown-icon">🅰️</span><a href="#">AngularJS Development</a></li>
                  <li><span class="dropdown-icon">🟢</span><a href="#">NodeJS Development</a></li>
                </ul>
              </div>
            </div>

            <div class="dropdown-column">
              <div class="dropdown-category">
                <h3>Business & IT Services</h3>
                <ul>
                  <li><span class="dropdown-icon">🔵</span><a href="#">.Net Development</a></li>
                  <li><span class="dropdown-icon">🧪</span><a href="#">Software Testing</a></li>
                </ul>
              </div>
            </div>
            <div class="dropdown-category explore-all">
              <a href="#" class="explore-link">
                Explore all categories →
              </a>
            </div>
          </div>
        </div>
      </li>

      <li><router-link to="/portfolio">Portfolio</router-link></li>
      <li><router-link to="/gallery">Gallery</router-link></li>
      <li>
        <button class="cta-btn" @click="showModal = true">
          Get Started
        </button>
        <ContactModal :show="showModal" @close="showModal = false" />
      </li>
    </ul>

    <!-- MOBILE TOGGLE -->
    <div class="menu-toggle" @click="open = !open">
      <span></span>
      <span></span>
      <span></span>
    </div>

    <!-- MOBILE MENU -->
    <transition name="slide">
      <ul v-if="open" class="menu mobile-menu">
        <li @click="open = false"><router-link to="/">Home</router-link></li>
        <li @click="open = false"><router-link to="/about">About</router-link></li>

        <!-- Mobile Services Submenu -->
        <li class="mobile-dropdown-parent" @click="toggleMobileServices">
          <a href="#" class="dropdown-toggle">Services</a>
          <transition name="slide">
            <ul v-if="mobileServicesOpen" class="mobile-services-submenu">
              <li><a href="#">Custom Software Development</a></li>
              <li><a href="#">Blockchain Development</a></li>
              <li><a href="#">Java Development</a></li>
              <li><a href="#">PHP Development</a></li>
              <li><a href="#">UI/UX Design</a></li>
              <li><a href="#">Digital Marketing</a></li>
              <li><a href="#">Python Development</a></li>
              <li><a href="#">React Development</a></li>
              <li><a href="#">AngularJS Development</a></li>
              <li><a href="#">NodeJS Development</a></li>
              <li><a href="#">.Net Development</a></li>
              <li><a href="#">Software Testing</a></li>
              <li><a href="#" class="explore-link-mobile">Explore all categories →</a></li>
            </ul>
          </transition>
        </li>

        <li @click="open = false"><router-link to="/portfolio">Portfolio</router-link></li>
        <li @click="open = false"><router-link to="/gallery">Gallery</router-link></li>
        <button class="cta-btn" @click="showModal = true">
          Get Started →
        </button>
        <ContactModal :show="showModal" @close="showModal = false" />
      </ul>
    </transition>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import ContactModal from '@/components/ContactModal.vue'

const showModal = ref(false)
const open = ref(false)
const logo = '/images/logo.png'
const isScrolled = ref(false)
const mobileServicesOpen = ref(false)

const handleScroll = () => {
  const scrolled = window.scrollY > 44
  isScrolled.value = scrolled
  document.body.classList.toggle('scrolled', scrolled)
}

const toggleMobileServices = () => {
  mobileServicesOpen.value = !mobileServicesOpen.value
}

onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})
</script>