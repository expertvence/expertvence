import './bootstrap'
import { createApp } from 'vue'
import { createPinia } from 'pinia'   // 🔥 ADD THIS
import router from './router'
import MainLayout from './layouts/MainLayout.vue'
import '../css/app.css'
import '../css/whatsapp-float.css'

const app = createApp(MainLayout)

app.use(createPinia())   // 🔥 REGISTER PINIA
app.use(router)

app.mount('#app')
