<template>
  <div class="site-topbar">
    <div class="w">
      <div class="top-left">
        <span>🇧🇩</span>
        <a href="tel:+8801797488350">+880 1797488350</a>
        <span class="top-divider">·</span>
        <a href="mailto:info@expertvence.com">
          <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <rect x="2" y="4" width="20" height="16" rx="2" />
            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
          </svg>
          info@expertvence.com
        </a>
      </div>

      <div class="top-right">
        <template v-if="isLoggedIn">
          <span>Hi, {{ auth.user?.name }}</span>
          <span class="top-divider">|</span>
          <a href="#" @click.prevent="auth.logout">Logout</a>
        </template>
        <template v-else>
          <router-link to="/login">Login</router-link>
          <span class="top-divider">|</span>
          <router-link to="/register">Register</router-link>
        </template>

        <div class="top-socials">
          <a href="https://www.facebook.com/profile.php?id=100079079156709" target="_blank" rel="noopener noreferrer" aria-label="Facebook">f</a>
          <a href="#" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn">in</a>
          <a href="#" target="_blank" rel="noopener noreferrer" aria-label="X">x</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const isLoggedIn = computed(() => !!auth.token)
</script>
