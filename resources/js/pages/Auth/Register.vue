<template>
  <div class="neon-auth-wrapper">
    <div class="neon-card">
      <div class="neon-header">
        <router-link class="logo" to="/" aria-label="Expertvence">
          <span class="lw">
            Expert
            <svg viewBox="0 0 34 28" aria-hidden="true">
              <defs>
                <linearGradient id="reg-lg" x1="0" y1="0" x2="1" y2="1">
                  <stop offset="0" stop-color="#5BE7FF" />
                  <stop offset="1" stop-color="#1A9FC0" />
                </linearGradient>
              </defs>
              <path d="M1 3h13v3.5H5V11h8v3.5H5V19h9v3.5H1z" fill="url(#reg-lg)" />
              <path d="M14 3h6.5l3.5 11 6-11h4L26 25h-5.5z" fill="url(#reg-lg)" />
            </svg>
            Vence
          </span>
          <small>Software</small>
        </router-link>
        <h2>Create Account</h2>
        <p>Join ExpertVence and start building</p>
      </div>

      <form class="neon-form" @submit.prevent="submitRegister">
        <p v-if="auth.error" class="neon-error">{{ auth.error }}</p>

        <div class="neon-input">
          <input v-model="form.name" type="text" placeholder="Full name" required />
        </div>

        <div class="neon-input">
          <input v-model="form.email" type="email" placeholder="Email address" required />
        </div>

        <div class="neon-input">
          <input v-model="form.password" type="password" placeholder="Password" required />
        </div>

        <div class="neon-input">
          <input v-model="form.password_confirmation" type="password" placeholder="Confirm password" required />
        </div>

        <button class="neon-btn" :disabled="auth.loading">
          {{ auth.loading ? 'Creating account...' : 'Create Account' }}
        </button>

        <div class="neon-footer">
          Already have an account?
          <router-link to="/login">Sign in</router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { reactive } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useRouter } from 'vue-router'

const auth = useAuthStore()
const router = useRouter()

const form = reactive({
  name: '',
  email: '',
  password: '',
  password_confirmation: '',
})

const submitRegister = async () => {
  auth.loading = true
  auth.error = null

  try {
    await auth.register(form)
    router.push('/login?registered=true')
  } catch (err) {
    auth.error = err.response?.data?.message || 'Registration failed'
  } finally {
    auth.loading = false
  }
}
</script>

<style scoped>
@import '../../../css/neon-auth.css';
</style>
