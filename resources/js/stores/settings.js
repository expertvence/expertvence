import { defineStore } from 'pinia'
import axios from 'axios'

export const useSettingsStore = defineStore('settings', {
  state: () => ({
    settings: {
      site_name: 'Expertvence',
      site_tagline: 'Software',
      site_logo: '',
      site_email: 'info@expertvence.com',
      site_phone: '+880 1797488350',
      site_address: 'Dhaka, Bangladesh',
      facebook_url: 'https://www.facebook.com/profile.php?id=100079079156709',
      linkedin_url: '',
      twitter_url: '',
      whatsapp_number: '+8801797488350',
      whatsapp_consultant_number: '+8801797488350',
      footer_description: 'Web applications, digital marketing, professional page management, and ready-made software for your business.',
    },
    loaded: false,
    loading: false,
    saving: false,
    error: null,
  }),

  actions: {
    async fetchSettings() {
      if (this.loaded) return
      this.loading = true
      try {
        const res = await axios.get('/api/settings')
        if (res.data?.data) {
          this.settings = { ...this.settings, ...res.data.data }
          this.loaded = true
        }
      } catch (err) {
        console.error('Failed to load settings:', err)
      } finally {
        this.loading = false
      }
    },

    async updateSettings(formData) {
      this.saving = true
      this.error = null
      const token = localStorage.getItem('admin_token') || localStorage.getItem('token')

      try {
        const res = await axios.post('/api/admin/settings', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
            Authorization: `Bearer ${token}`,
          },
        })

        if (res.data?.data) {
          this.settings = { ...this.settings, ...res.data.data }
        }
        return res.data
      } catch (err) {
        this.error = err.response?.data?.message || 'Failed to update settings.'
        throw err
      } finally {
        this.saving = false
      }
    },
  },
})
