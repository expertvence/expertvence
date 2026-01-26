<template>
  <nav class="navbar" :class="{ 'navbar-scrolled': isScrolled }">


    <!-- LEFT -->
    <div class="nav-left">
      <img :src="logo" alt="ExpertVence Logo" class="logo-img" />
    </div>

    <!-- DESKTOP MENU -->
    <ul class="menu desktop-menu">
      <li><router-link to="/">Home</router-link></li>
      <li><router-link to="/about">About</router-link></li>
      <li><router-link to="/services">Services</router-link></li>
      <li><router-link to="/portfolio">Portfolio</router-link></li>
      <li><router-link to="/gallery">Gallery</router-link></li>
      <li>
        <router-link to="/contact" class="cta">Get Started</router-link>
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
        <li @click="open=false"><router-link to="/">Home</router-link></li>
        <li @click="open=false"><router-link to="/about">About</router-link></li>
        <li @click="open=false"><router-link to="/services">Services</router-link></li>
        <li @click="open=false"><router-link to="/portfolio">Portfolio</router-link></li>
        <li @click="open=false"><router-link to="/gallery">Gallery</router-link></li>
        <li @click="open=false">
          <router-link to="/contact" class="cta">Get Started</router-link>
        </li>
      </ul>
    </transition>
  </nav>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'

const open = ref(false)
const logo = '/images/logo.png'
const isScrolled = ref(false)

const handleScroll = () => {
  const scrolled = window.scrollY > 44
  isScrolled.value = scrolled

  document.body.classList.toggle('scrolled', scrolled)
}


onMounted(() => {
  window.addEventListener('scroll', handleScroll)
})

onUnmounted(() => {
  window.removeEventListener('scroll', handleScroll)
})

</script>
