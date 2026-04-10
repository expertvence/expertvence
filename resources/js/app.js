import './bootstrap'
import { createApp } from 'vue'
import { createPinia } from 'pinia'  
import router from './router'
import MainLayout from './layouts/MainLayout.vue'
import '../css/app.css'
import '../css/whatsapp-float.css'


/* CSS */
import '../css/app.css'
import '../css/topbar.css'
import '../css/navbar.css'
import '../css/footer.css'

import '../css/home.css'
import '../css/about.css'
import '../css/services.css'
import '../css/gallery.css'
import '../css/portfolio.css'
import '../css/contact.css'
import '../css/service-detail.css'
import '../css/casestudy.css'

const app = createApp(MainLayout)

app.use(createPinia())   // 🔥 REGISTER PINIA
app.use(router)

app.mount('#app')
