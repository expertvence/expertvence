<template>
  <router-view />
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
import '../../css/service-detail.css'
import '../../css/casestudy.css'

/* JS */
import { homeInit } from '../scripts/home'
import { servicesInit } from '../scripts/services'
import { galleryInit } from '../scripts/gallery'
import { portfolioInit } from '../scripts/portfolio'
import { contactInit } from '../scripts/contact'

import { onMounted, watch } from 'vue'
import { useRoute } from 'vue-router'

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
