<template>
  <div class="neon-auth-wrapper">
    <div class="neon-card">
      <div class="neon-header">
        <div class="neon-icon">⬢</div>
        <h2>NEW_ACCESS_CODE</h2>
        <p>[ RESET PASSWORD ]</p>
      </div>

      <form class="neon-form" @submit.prevent="submitReset">
        <!-- EMAIL -->
        <div class="neon-input">
          <span>&gt;</span>
          <input
            type="email"
            placeholder="EMAIL_ADDRESS"
            v-model="form.email"
          />
        </div>

        <!-- OTP -->
        <div class="neon-input">
          <span>&gt;</span>
          <input
            type="text"
            placeholder="OTP_CODE"
            v-model="form.otp"
          />
        </div>

        <!-- NEW PASSWORD -->
        <div class="neon-input">
          <span>&gt;</span>
          <input
            type="password"
            placeholder="NEW_PASSWORD"
            v-model="form.password"
          />
        </div>

        <!-- CONFIRM PASSWORD -->
        <div class="neon-input">
          <span>&gt;</span>
          <input
            type="password"
            placeholder="CONFIRM_PASSWORD"
            v-model="form.password_confirmation"
          />
        </div>

        <button class="neon-btn neon-gradient" :disabled="loading">
          {{ loading ? 'UPDATING...' : 'UPDATE ACCESS' }}
        </button>

        <div class="neon-footer">
          <router-link to="/login">LOGIN</router-link>
        </div>

        <p v-if="error" class="neon-error">{{ error }}</p>
        <p v-if="success" class="neon-success">{{ success }}</p>
      </form>
    </div>
  </div>
</template>


<script setup>
import { reactive, ref } from 'vue'
import api from '@/utils/axios'
import { useRouter } from 'vue-router'

const router = useRouter()

const loading = ref(false)
const error = ref(null)
const success = ref(null)

const form = reactive({
  email: '',
  otp: '',
  password: '',
  password_confirmation: '',
})

const submitReset = async () => {
  loading.value = true
  error.value = null
  success.value = null

  try {
    await api.post('/auth/reset-password', form)

    success.value = 'Password reset successful'

    // 🔥 redirect to login
    setTimeout(() => {
      router.push('/login')
    }, 1500)
  } catch (err) {
    error.value =
      err.response?.data?.message ||
      'Password reset failed'
  } finally {
    loading.value = false
  }
}
</script>


<style scoped>
@import '../../../css/neon-auth.css';
</style>
