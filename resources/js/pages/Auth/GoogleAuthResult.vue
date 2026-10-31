<template><main class="callback"><p>{{ message }}</p></main></template>
<script setup>
import { onMounted, ref } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'
const router = useRouter()
const auth = useAuthStore()
const message = ref('Completing Google sign-in…')
onMounted(() => {
  const values = new URLSearchParams(window.location.hash.slice(1))
  const token = values.get('token')
  const destination = values.get('redirect') || '/'
  if (!token) {
    message.value = 'Google sign-in could not be completed.'
    router.replace('/login?error=google_failed')
    return
  }
  localStorage.setItem('token', token)
  localStorage.setItem('demo_viewer', 'true')
  auth.token = token
  auth.error = null
  const safeDestination = destination.startsWith('/') && !destination.startsWith('//') && !destination.includes('\\') ? destination : '/'
  router.replace(safeDestination)
})
</script>
<style scoped>.callback{min-height:70vh;display:grid;place-items:center;color:#103d49;font:600 18px Inter,Arial,sans-serif}</style>