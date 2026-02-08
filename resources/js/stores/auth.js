import { defineStore } from 'pinia'
import api from '@/utils/axios'
import router from '@/router'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: localStorage.getItem('token'),
    loading: false,
    error: null,
  }),

  getters: {
    isLoggedIn: (state) => !!state.token,
  },

  actions: {
    // ✅ Login action
    async login(form) {
      this.loading = true
      this.error = null

      try {
        const res = await api.post('/auth/login', {
          email: form.email,
          password: form.password,
        })

        this.token = res.data.token
        this.user = res.data.user

        localStorage.setItem('token', this.token)

        // 🔥 LOGIN SUCCESS → HOME
        router.push('/')
      } catch (err) {
        this.error =
          err.response?.data?.message || 'Login failed'
      } finally {
        this.loading = false
      }
    },

    // ✅ Register action
    async register(form) {
      this.loading = true
      this.error = null

      try {
        await api.post('/auth/register', {
          name: form.name,
          email: form.email,
          password: form.password,
          password_confirmation: form.password_confirmation,
        })

        // 🔥 Register success → Login page
        router.push('/login')
      } catch (err) {
        this.error =
          err.response?.data?.message || 'Registration failed'
      } finally {
        this.loading = false
      }
    },

    // ✅ Logout action
    logout() {
      localStorage.removeItem('token')
      this.token = null
      this.user = null

      // 🔥 LOGOUT → LOGIN
      router.push('/')
    },
  },
})
