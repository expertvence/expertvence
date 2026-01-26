<template>
  <TopBar />
  <Navbar />

  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
/>

<link
  rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
/>


  <main>
    <router-view />
  </main>
  <Footer />
</template>

<script setup>
/* CSS */
import '../../css/app.css'
import '../../css/topbar.css'
import '../../css/navbar.css'
import '../../css/footer.css'

import '../../css/home.css'
import '../../css/about.css'
import '../../css/services.css'
import '../../css/gallery.css'
import '../../css/portfolio.css'
import '../../css/contact.css'

/* JS */
import { homeInit } from '../scripts/home'
import { servicesInit } from '../scripts/services'
import { galleryInit } from '../scripts/gallery'
import { portfolioInit } from '../scripts/portfolio'
import { contactInit } from '../scripts/contact'

import { onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'

import Navbar from '../components/Navbar.vue'
import Footer from '../components/Footer.vue'
import TopBar from '../components/TopBar.vue'

const route = useRoute()

function pageInit(path) {
  if (path === '/') homeInit()
  if (path === '/services') servicesInit()
  if (path === '/gallery') galleryInit()
  if (path === '/portfolio') portfolioInit()
  if (path === '/contact') contactInit()
}

onMounted(() => pageInit(route.path))

watch(
  () => route.path,
  (newPath) => pageInit(newPath)
)
</script>
