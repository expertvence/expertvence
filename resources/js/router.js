import { createRouter, createWebHistory } from 'vue-router'

import Home from './pages/Home.vue'
import About from './pages/About.vue'
import Services from './pages/Services.vue'
import Portfolio from './pages/Portfolio.vue'
import Contact from './pages/Contact.vue'
import Gallery from './pages/Gallery.vue'

/* Auth pages */

import Login from './pages/Auth/Login.vue'
import Register from './pages/Auth/Register.vue'
import ForgotPassword from './pages/Auth/ForgotPassword.vue'
import ResetPassword from './pages/Auth/ResetPassword.vue'


const routes = [
  { path: '/', component: Home },
  { path: '/about', component: About },
  { path: '/services', component: Services },
  { path: '/portfolio', component: Portfolio },
  { path: '/contact', component: Contact },
  { path: '/gallery', component: Gallery },

  /* Auth routes */
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/forgot-password', component: ForgotPassword },
  { path: '/reset-password', component: ResetPassword },
  
]

export default createRouter({
  // 🔥 THIS IS THE FIX
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})
