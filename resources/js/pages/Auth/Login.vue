<template>
  <div class="neon-auth-wrapper">
    <div class="neon-card">
      <div class="neon-header">
        <router-link class="logo" to="/" aria-label="Expertvence">
          <span class="lw">
            Expert
            <svg viewBox="0 0 34 28" aria-hidden="true">
              <defs>
                <linearGradient id="auth-lg" x1="0" y1="0" x2="1" y2="1">
                  <stop offset="0" stop-color="#5BE7FF" />
                  <stop offset="1" stop-color="#1A9FC0" />
                </linearGradient>
              </defs>
              <path d="M1 3h13v3.5H5V11h8v3.5H5V19h9v3.5H1z" fill="url(#auth-lg)" />
              <path d="M14 3h6.5l3.5 11 6-11h4L26 25h-5.5z" fill="url(#auth-lg)" />
            </svg>
            Vence
          </span>
          <small>Software</small>
        </router-link>
        <h2>Welcome Back</h2>
        <p>Sign in to your account</p>
      </div>

      <form class="neon-form" @submit.prevent="submitLogin">
        <p v-if="verifiedMessage" class="neon-success">{{ verifiedMessage }}</p>
        <p v-if="auth.error" class="neon-error">{{ auth.error }}</p>

        <div class="neon-input">
          <input
            v-model="form.email"
            type="email"
            placeholder="Email address"
            required
            autocomplete="email"
          />
        </div>

        <div class="neon-input">
          <input
            v-model="form.password"
            type="password"
            placeholder="Password"
            required
            autocomplete="current-password"
          />
        </div>

        <div class="neon-extra">
          <label class="neon-check">
            <input type="checkbox" />
            <span>Keep me signed in</span>
          </label>
          <router-link to="/forgot-password" class="forgot-link">
            Forgot password?
          </router-link>
        </div>

        <button class="neon-btn" :disabled="auth.loading">
          {{ auth.loading ? 'Signing in...' : 'Sign In' }}
        </button>

        <div class="neon-divider">
          <span>OR</span>
        </div>

        <div class="neon-social">
          <button type="button" class="social-btn google">
            <span>G</span> Continue with Google
          </button>
          <button type="button" class="social-btn apple">
            <span></span> Continue with Apple
          </button>
        </div>

        <div class="neon-footer">
          Don't have an account?
          <router-link to="/register">Create an account</router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useRouter, useRoute } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()
const route = useRoute()

const form = reactive({
  email: '',
  password: '',
})

const verifiedMessage = ref('')

onMounted(() => {
  auth.token = null
  auth.user = null
  auth.error = null
  auth.loading = false
  localStorage.removeItem('token')

  if (route.query.verified === 'true') {
    verifiedMessage.value = '✅ Email verified! You can login now.'
  } else if (route.query.verified === 'false') {
    verifiedMessage.value = '❌ Invalid verification link.'
  }
})

const submitLogin = async () => {
  auth.loading = true
  auth.error = null

  try {
    await auth.login(form)
    if (auth.token) {
      router.push('/')
    }
  } catch (err) {
    auth.error = err.response?.data?.message || 'Login failed. Please check your credentials.'
  } finally {
    auth.loading = false
  }
}
</script>

<style scoped>
@import '../../../css/neon-auth.css';
</style>
