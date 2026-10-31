<template>
  <div class="admin-auth-container">
    <div class="admin-auth-card">
      <div class="admin-auth-header">
        <div class="admin-badge">ADMIN PORTAL</div>
        <h2>Expertvence Control Panel</h2>
        <p>Sign in to manage site logo, address & settings</p>
      </div>

      <div v-if="errorMessage" class="admin-alert-error">
        <svg viewBox="0 0 20 20" fill="currentColor" width="18" height="18">
          <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <span>{{ errorMessage }}</span>
      </div>

      <form @submit.prevent="handleLogin" class="admin-form">
        <div class="form-group">
          <label for="admin-email">Email Address</label>
          <div class="input-wrap">
            <svg class="input-icon" viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
              <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"/>
              <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"/>
            </svg>
            <input
              id="admin-email"
              v-model="form.email"
              type="email"
              placeholder="test@example.com"
              required
              autocomplete="email"
            />
          </div>
        </div>

        <div class="form-group">
          <label for="admin-password">Password</label>
          <div class="input-wrap">
            <svg class="input-icon" viewBox="0 0 20 20" fill="currentColor" width="16" height="16">
              <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/>
            </svg>
            <input
              id="admin-password"
              v-model="form.password"
              :type="showPassword ? 'text' : 'password'"
              placeholder="••••••••"
              required
              autocomplete="current-password"
            />
            <button
              type="button"
              class="toggle-pw-btn"
              @click="showPassword = !showPassword"
              tabindex="-1"
            >
              {{ showPassword ? 'Hide' : 'Show' }}
            </button>
          </div>
        </div>

        <!-- <div class="admin-credential-hint">
          <span class="hint-title">Default Admin:</span>
          <code>admin@expertvence.com</code> / <code>12345678</code>
        </div> -->

        <button type="submit" class="admin-submit-btn" :disabled="isLoading">
          <span v-if="isLoading" class="spinner"></span>
          <span>{{ isLoading ? 'Authenticating...' : 'Sign In to Admin Panel' }}</span>
        </button>
      </form>

      <div class="admin-footer-links">
        <router-link to="/" class="back-link">
          ← Return to Website
        </router-link>
      </div>
    </div>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'

const router = useRouter()

const form = reactive({
  email: 'admin@expertvence.com',
  password: '',
})

const showPassword = ref(false)
const isLoading = ref(false)
const errorMessage = ref('')

const handleLogin = async () => {
  isLoading.value = true
  errorMessage.value = ''

  try {
    const res = await axios.post('/api/admin/login', {
      email: form.email,
      password: form.password,
    })

    if (res.data?.token) {
      localStorage.setItem('admin_token', res.data.token)
      localStorage.setItem('token', res.data.token)
      localStorage.setItem('admin_user', JSON.stringify(res.data.user || {}))
      router.push('/admin/dashboard')
    }
  } catch (err) {
    errorMessage.value = err.response?.data?.message || 'Login failed. Please check your credentials.'
  } finally {
    isLoading.value = false
  }
}
</script>

<style scoped>
.admin-auth-container {
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: radial-gradient(circle at 50% 20%, #0d2238 0%, #040914 100%);
  padding: 24px 16px;
  font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
  color: #fff;
}

.admin-auth-card {
  width: 100%;
  max-width: 440px;
  background: rgba(13, 23, 42, 0.85);
  backdrop-filter: blur(16px);
  border: 1px solid rgba(91, 231, 255, 0.2);
  box-shadow: 0 20px 50px rgba(0, 0, 0, 0.5), 0 0 40px rgba(26, 159, 192, 0.15);
  border-radius: 20px;
  padding: 40px 32px;
}

.admin-auth-header {
  text-align: center;
  margin-bottom: 28px;
}

.admin-badge {
  display: inline-block;
  padding: 4px 12px;
  font-size: 11px;
  font-weight: 700;
  letter-spacing: 1.5px;
  color: #5be7ff;
  background: rgba(91, 231, 255, 0.1);
  border: 1px solid rgba(91, 231, 255, 0.3);
  border-radius: 999px;
  margin-bottom: 12px;
}

.admin-auth-header h2 {
  font-size: 24px;
  font-weight: 700;
  color: #ffffff;
  margin: 0 0 8px;
}

.admin-auth-header p {
  font-size: 14px;
  color: #94a3b8;
  margin: 0;
}

.admin-alert-error {
  display: flex;
  align-items: center;
  gap: 10px;
  background: rgba(239, 68, 68, 0.15);
  border: 1px solid rgba(239, 68, 68, 0.4);
  color: #fca5a5;
  padding: 12px 14px;
  border-radius: 10px;
  font-size: 13px;
  margin-bottom: 20px;
}

.admin-form {
  display: flex;
  flex-direction: column;
  gap: 18px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-size: 13px;
  font-weight: 500;
  color: #cbd5e1;
}

.input-wrap {
  position: relative;
  display: flex;
  align-items: center;
}

.input-icon {
  position: absolute;
  left: 14px;
  color: #64748b;
  pointer-events: none;
}

.input-wrap input {
  width: 100%;
  padding: 12px 14px 12px 42px;
  background: rgba(15, 23, 42, 0.6);
  border: 1px solid rgba(255, 255, 255, 0.12);
  border-radius: 10px;
  color: #fff;
  font-size: 14px;
  outline: none;
  transition: all 0.2s ease;
}

.input-wrap input:focus {
  border-color: #5be7ff;
  box-shadow: 0 0 0 3px rgba(91, 231, 255, 0.15);
  background: rgba(15, 23, 42, 0.9);
}

.toggle-pw-btn {
  position: absolute;
  right: 12px;
  background: none;
  border: none;
  color: #94a3b8;
  font-size: 12px;
  cursor: pointer;
  padding: 4px;
}

.toggle-pw-btn:hover {
  color: #5be7ff;
}

.admin-credential-hint {
  font-size: 12px;
  color: #94a3b8;
  background: rgba(91, 231, 255, 0.05);
  border: 1px dashed rgba(91, 231, 255, 0.2);
  padding: 10px 12px;
  border-radius: 8px;
}

.hint-title {
  color: #5be7ff;
  font-weight: 600;
  margin-right: 6px;
}

.admin-credential-hint code {
  background: rgba(0, 0, 0, 0.3);
  padding: 2px 6px;
  border-radius: 4px;
  color: #e2e8f0;
}

.admin-submit-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 8px;
  padding: 13px;
  background: linear-gradient(135deg, #1a9fc0 0%, #0d7088 100%);
  border: 1px solid #5be7ff;
  border-radius: 10px;
  color: #ffffff;
  font-size: 14px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.25s ease;
  margin-top: 6px;
}

.admin-submit-btn:hover:not(:disabled) {
  background: linear-gradient(135deg, #22b8dc 0%, #1a9fc0 100%);
  box-shadow: 0 6px 20px rgba(91, 231, 255, 0.3);
  transform: translateY(-1px);
}

.admin-submit-btn:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.spinner {
  width: 16px;
  height: 16px;
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-top-color: #fff;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

.admin-footer-links {
  text-align: center;
  margin-top: 24px;
}

.back-link {
  font-size: 13px;
  color: #94a3b8;
  text-decoration: none;
  transition: color 0.2s ease;
}

.back-link:hover {
  color: #5be7ff;
}
</style>
