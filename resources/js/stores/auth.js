import { defineStore } from 'pinia'
import api from '@/utils/axios'
import router from '@/router'

export const useAuthStore = defineStore('auth', {
  state: () => ({
    user: null,
    token: null,
    loading: false,
    error: null,
  }),

  getters: {
    isLoggedIn: (state) => !!state.token,
  },

  actions: {
    // ✅ Initialize auth state from localStorage
    init() {
      const token = localStorage.getItem('token')
      const user = localStorage.getItem('user')

      if (token) {
        this.token = token
      }

      if (user) {
        try {
          this.user = JSON.parse(user)
        } catch (e) {
          // Invalid JSON, clear it
          localStorage.removeItem('user')
        }
      }
    },
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
        localStorage.setItem('user', JSON.stringify(this.user))

        // 🔥 Check if user should be redirected to admin panel
        if (res.data.should_redirect_to_admin) {
          // Admin or Super Admin → Admin Panel
          router.push('/admin')
        } else {
          // Regular user → Home/Dashboard
          router.push('/')
        }
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
      localStorage.removeItem('user')
      this.token = null
      this.user = null

      // 🔥 LOGOUT → LOGIN
      router.push('/')
    },
  },
})
