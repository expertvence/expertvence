import './bootstrap'
import { createApp } from 'vue'
import router from './router'
import MainLayout from './layouts/MainLayout.vue'
import '../css/app.css'
import '../css/whatsapp-float.css'


createApp(MainLayout)
  .use(router)
  .mount('#app')
