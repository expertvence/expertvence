<template>
  <div class="neon-auth-wrapper">
    <div class="neon-card">
      <div class="neon-header">
        <router-link class="logo" to="/" aria-label="Expertvence"><span class="lw">Expert<span class="mark">V</span>Vence</span><small>Software</small></router-link>
        <h2>Create your account</h2>
        <p>Continue securely with your Google account.</p>
      </div>
      <div class="neon-form">
        <p v-if="error" class="neon-error">{{ error }}</p>
        <button class="neon-btn google-button" type="button" @click="startGoogleLogin">Sign up with Google</button>
        <p class="privacy-note">If you already have an account, Google will sign you in. New accounts are created automatically.</p>
        <div class="neon-footer"><router-link to="/login">Back to Google sign-in</router-link></div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useRoute } from 'vue-router'
const route = useRoute()
const startGoogleLogin = () => {
  const value = String(route.query.redirect || '/')
  const returnTo = value.startsWith('/') && !value.startsWith('//') && !value.includes('\\') ? value : '/'
  window.location.assign(`/auth/google/redirect?return_to=${encodeURIComponent(returnTo)}`)
}
const error = String(route.query.error || '') ? 'Google sign-in could not be completed. Please try again.' : ''
</script>

<style scoped>
@import '../../../css/neon-auth.css';
.logo{display:inline-flex;flex-direction:column;align-items:center;text-decoration:none;color:inherit}.lw{font-size:20px;font-weight:800}.mark{color:#21c6de}.logo small{font-size:10px;letter-spacing:2px}.google-button{width:100%}.privacy-note{text-align:center;color:#94a3b8;font-size:13px;line-height:1.6;margin:18px 0}.neon-footer{text-align:center;margin-top:22px}.neon-footer a{color:#5be7ff}
</style>