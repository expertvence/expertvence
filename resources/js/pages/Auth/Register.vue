<template>
  <div class="neon-auth-wrapper">
    <div class="neon-card">
      <div class="neon-header">
        <div class="neon-icon">⬢</div>
        <h2>NEW_IDENTITY</h2>
        <p>[ CREATE SECURE PROFILE ]</p>
      </div>

      <form class="neon-form" @submit.prevent="submitRegister">

        <div class="neon-input">
          <span>&gt;</span>
          <input v-model="form.name" type="text" placeholder="USERNAME" required />
        </div>

        <div class="neon-input">
          <span>&gt;</span>
          <input v-model="form.email" type="email" placeholder="EMAIL_ADDRESS" required />
        </div>

        <div class="neon-input">
          <span>&gt;</span>
          <input v-model="form.password" type="password" placeholder="ACCESS_CODE" required />
        </div>

        <div class="neon-input">
          <span>&gt;</span>
          <input v-model="form.password_confirmation" type="password" placeholder="CONFIRM_ACCESS_CODE" required />
        </div>

        <button class="neon-btn neon-gradient" :disabled="auth.loading">
          {{ auth.loading ? 'CREATING PROFILE...' : 'CREATE PROFILE' }}
        </button>

        <p v-if="auth.error" class="neon-error">{{ auth.error }}</p>

        <div class="neon-footer">
          <router-link to="/login">BACK_TO_LOGIN</router-link>
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
  const success = await auth.register(form)
  if (success) router.push('/login')  // 🔥 Auto redirect to login
}
</script>

<style scoped>
@import '../../../css/neon-auth.css';
</style>
