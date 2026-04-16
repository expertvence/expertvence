import './bootstrap'
import { createApp } from 'vue'
import { createPinia } from 'pinia'   // 🔥 ADD THIS
import router from './router'
import MainLayout from './layouts/MainLayout.vue'
import '../css/app.css'
import '../css/whatsapp-float.css'

const app = createApp(MainLayout)

const pinia = createPinia()
app.use(pinia)   // 🔥 REGISTER PINIA
app.use(router)

// ✅ Initialize auth store
import { useAuthStore } from './stores/auth'
const authStore = useAuthStore(pinia)
authStore.init()

app.mount('#app')
