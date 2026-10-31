<template>
  <div class="neon-auth-wrapper">
    <div class="neon-card">
      <div class="neon-header">
        <router-link class="logo" to="/" aria-label="Expertvence"><span class="lw">Expert<span class="mark">V</span>Vence</span><small>Software</small></router-link>
        <h2>Sign in with Google</h2>
        <p>Use your Google account to continue to Expertvence.</p>
      </div>
      <div class="neon-form">
        <p v-if="message" class="neon-success">{{ message }}</p>
        <p v-if="error" class="neon-error">{{ error }}</p>
        <button class="neon-btn google-button" type="button" @click="startGoogleLogin"><svg class="google-icon" viewBox="0 0 48 48" aria-hidden="true"><path fill="#4285F4" d="M43.6 24.5c0-1.4-.1-2.8-.4-4.1H24v7.8h11a9.5 9.5 0 0 1-4.1 6.2v5h6.6c3.9-3.6 6.1-8.8 6.1-14.9Z"/><path fill="#34A853" d="M24 44c5.5 0 10.1-1.8 13.5-4.8l-6.6-5c-1.8 1.2-4.1 2-6.9 2-5.3 0-9.8-3.6-11.4-8.4H5.8v5.2A20 20 0 0 0 24 44Z"/><path fill="#FBBC05" d="M12.6 27.8a12 12 0 0 1 0-7.6V15H5.8a20 20 0 0 0 0 18l6.8-5.2Z"/><path fill="#EA4335" d="M24 11.8c3 0 5.7 1 7.8 3l5.9-5.9A19.6 19.6 0 0 0 24 4 20 20 0 0 0 5.8 15l6.8 5.2c1.6-4.8 6.1-8.4 11.4-8.4Z"/></svg><span>Continue with Google</span></button>
        <p class="privacy-note">Your account will be created automatically the first time you continue with Google.</p>
        <div class="neon-footer"><router-link to="/">Return to website</router-link></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const safeReturnPath = () => {
  const value = String(route.query.redirect || '/')
  return value.startsWith('/') && !value.startsWith('//') && !value.includes('\\') ? value : '/'
}
const error = computed(() => ({
  google_not_configured: 'Google sign-in is not configured yet.',
  google_cancelled: 'Google sign-in was cancelled. Try again to continue.',
  google_unverified: 'Google could not confirm this email address.',
  google_admin_account: 'Admin accounts must sign in through the admin login page.',
  google_state: 'Your sign-in session expired. Please try again.',
  google_failed: 'Google sign-in failed. Please try again.',
}[String(route.query.error || '')] || ''))
const message = computed(() => route.query.demoExpired === 'true' ? 'Your 30-second demo preview has ended. Sign in with Google to continue viewing this demo.' : '')
const startGoogleLogin = () => {
  const returnTo = encodeURIComponent(safeReturnPath())
  window.location.assign(`/auth/google/redirect?return_to=${returnTo}`)
}
</script>

<style scoped>
@import '../../../css/neon-auth.css';
.logo{display:inline-flex;flex-direction:column;align-items:center;text-decoration:none;color:inherit}.lw{font-size:20px;font-weight:800}.mark{color:#21c6de}.logo small{font-size:10px;letter-spacing:2px}.google-button{width:100%}.google-icon{width:20px;height:20px;flex:none}.privacy-note{text-align:center;color:#94a3b8;font-size:13px;line-height:1.6;margin:18px 0}.neon-footer{text-align:center;margin-top:22px}.neon-footer a{color:#5be7ff}
</style>