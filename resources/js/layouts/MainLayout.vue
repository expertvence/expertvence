<template>
  <!-- <TopBar v-if="!isAdminRoute" /> -->
  <Navbar v-if="!isAdminRoute" />
  <main :class="isAdminRoute ? 'admin-main-wrapper' : 'page-content'">
    <router-view />
  </main>
  <Footer v-if="!isAdminRoute" />
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

import { onMounted, watch, computed } from 'vue'
import { useRoute } from 'vue-router'
import { useSettingsStore } from '@/stores/settings'

import Navbar from '../components/Navbar.vue'
import Footer from '../components/Footer.vue'
import TopBar from '../components/TopBar.vue'

const route = useRoute()
const settingsStore = useSettingsStore()

const isAdminRoute = computed(() => route.path.startsWith('/admin'))

function pageInit(path) {
  if (path.startsWith('/admin')) return
  if (path === '/') homeInit()
  if (path === '/services') servicesInit()
  if (path === '/gallery') galleryInit()
  if (path === '/portfolio') portfolioInit()
  if (path === '/contact') contactInit()
}

onMounted(() => {
  settingsStore.fetchSettings()
  pageInit(route.path)
})

watch(
  () => route.path,
  (newPath) => pageInit(newPath)
)
</script>

<style>
.admin-main-wrapper {
  min-height: 100vh;
  width: 100%;
}
</style>
