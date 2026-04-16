<template>
  <div class="neon-auth-wrapper">
    <div class="neon-card">
      <div class="neon-header">
        <div class="neon-icon">⬢</div>
        <h2>ExpertVence</h2>
        <p>[ SECURE TERMINAL ACCESS ]</p>
      </div>

      <form class="neon-form" @submit.prevent="submitLogin">

       <p v-if="verifiedMessage" class="neon-success">{{ verifiedMessage }}</p>


        <div class="neon-input">
          <span>&gt;</span>
          <input v-model="form.email" type="email" placeholder="EMAIL_ADDRESS" />
        </div>

        <div class="neon-input">
          <span>&gt;</span>
          <input v-model="form.password" type="password" placeholder="ACCESS_CODE" />
        </div>


<div class="neon-extra">
  <label class="neon-check">
    <input type="checkbox" />
    <span>Keep me signed in</span>
  </label>

  <a href="/forgot-password" class="forgot-link">
  Forgot password?
</a>

</div>

<!-- SIGN IN BUTTON -->
 
        <button class="neon-btn neon-gradient" :disabled="auth.loading">
          {{ auth.loading ? 'LOGGING IN...' : 'LOGIN' }}
        </button>


<!-- OR DIVIDER -->
<div class="neon-divider">
  <span>OR</span>
</div>

<!-- SOCIAL LOGIN -->
<div class="neon-social">
  <button class="social-btn google">
    <span>G</span> Continue with Google
  </button>

  <button class="social-btn apple">
    <span>A</span> Continue with Apple
  </button>
</div>

<!-- REGISTER LINK -->
<div class="neon-footer">
  New here?
  <router-link to="/register">CREATE_PROFILE</router-link>
</div>

 <p v-if="auth.error" class="neon-error">
    {{ auth.error }}
  </p>

  

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

// 🔹 Check query params on mount
onMounted(() => {
  // Only clear auth state if user is not logged in
  if (!auth.isLoggedIn) {
    auth.token = null
    auth.user = null
    auth.error = null
    auth.loading = false
    localStorage.removeItem('token')
    localStorage.removeItem('user')
  }

  if (route.query.verified === 'true') {
    verifiedMessage.value = '✅ Email verified! You can login now.'
  } else if (route.query.verified === 'false') {
    verifiedMessage.value = '❌ Invalid verification link.'
  }
})


// 🔹 LOGIN
const submitLogin = async () => {
  auth.loading = true
  auth.error = null

  try {
    await auth.login(form)
    // auth.login handles redirect based on role
  } catch (err) {
    auth.error =
      err.response?.data?.message || 'Login failed'
  } finally {
    auth.loading = false
  }
}
</script>



<style scoped>
@import '../../../css/neon-auth.css';
</style>
