import { createRouter, createWebHistory } from 'vue-router'

import Home from './pages/Home.vue'
import About from './pages/About.vue'
import Services from './pages/Services.vue'
import Portfolio from './pages/Portfolio.vue'
import Contact from './pages/Contact.vue'
import Gallery from './pages/Gallery.vue'

const routes = [
  { path: '/', component: Home },
  { path: '/about', component: About },
  { path: '/services', component: Services },
  { path: '/portfolio', component: Portfolio },
  { path: '/contact', component: Contact },
  { path: '/gallery', component: Gallery },
]

export default createRouter({
  // 🔥 THIS IS THE FIX
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})
