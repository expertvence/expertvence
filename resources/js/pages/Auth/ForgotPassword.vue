<template>
  <div class="neon-auth-wrapper">
    <div class="neon-card">
      <div class="neon-header">
        <div class="neon-icon">⬢</div>
        <h2>RECOVER_ACCESS</h2>
        <p>[ PASSWORD RECOVERY ]</p>
      </div>

      <form class="neon-form" @submit.prevent="submitForgot">
  <div class="neon-input">
    <span>&gt;</span>
    <input
      type="email"
      placeholder="EMAIL_ADDRESS"
      v-model="email"
    />
  </div>

  <button class="neon-btn neon-gradient" :disabled="loading">
    {{ loading ? 'SENDING...' : 'SEND RESET LINK' }}
  </button>

  <div class="neon-footer">
    <router-link to="/login">BACK_TO_LOGIN</router-link>
  </div>

  <p v-if="error" class="neon-error">{{ error }}</p>
  <p v-if="success" class="neon-success">{{ success }}</p>
</form>

    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue'
import api from '@/utils/axios'
import { useRouter } from 'vue-router'

const email = ref('')
const loading = ref(false)
const error = ref(null)
const success = ref(null)

const router = useRouter()

const submitForgot = async () => {
  loading.value = true
  error.value = null
  success.value = null

  try {
    await api.post('/auth/forgot-password', {
      email: email.value,
    })

    success.value = 'OTP sent to your email'

    // 🔥 optional redirect after 1.5s
    setTimeout(() => {
      router.push('/reset-password')
    }, 1500)
  } catch (err) {
    error.value =
      err.response?.data?.message ||
      'Failed to send OTP'
  } finally {
    loading.value = false
  }
}
</script>


<style scoped>
@import '../../../css/neon-auth.css';
</style>
