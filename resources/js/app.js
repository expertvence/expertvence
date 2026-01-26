import './bootstrap'
import { createApp } from 'vue'
import router from './router'
import MainLayout from './layouts/MainLayout.vue'

createApp(MainLayout)
  .use(router)
  .mount('#app')
