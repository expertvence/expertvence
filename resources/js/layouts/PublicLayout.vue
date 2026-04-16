<template>
  <div class="public-layout">
    <TopBar />
    <Navbar />
    <main class="page-content">
      <router-view />
    </main>
    <Footer />
    <WhatsAppFloat />
  </div>
</template>

<script setup>
import TopBar from '@/components/TopBar.vue'
import Navbar from '@/components/Navbar.vue'
import Footer from '@/components/Footer.vue'
import WhatsAppFloat from '@/components/WhatsAppFloat.vue'
</script>
