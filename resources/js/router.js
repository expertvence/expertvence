import { createRouter, createWebHistory } from 'vue-router'

import Home from './pages/Home.vue'
import About from './pages/About.vue'
import Services from './pages/Services.vue'
import ServiceDetail from './pages/ServiceDetail.vue'
import Portfolio from './pages/Portfolio.vue'
import Contact from './pages/Contact.vue'
import Gallery from './pages/Gallery.vue'
import CaseStudy from './pages/CaseStudy.vue'

/* Auth pages */
import Login from './pages/Auth/Login.vue'
import Register from './pages/Auth/Register.vue'
import ForgotPassword from './pages/Auth/ForgotPassword.vue'
import ResetPassword from './pages/Auth/ResetPassword.vue'

/* Routes */
const routes = [
  { path: '/', component: Home },
  { path: '/about', component: About },
  { path: '/services', component: Services },
  { path: '/services/:slug', component: ServiceDetail },
  { path: '/portfolio', component: Portfolio },
  { path: '/contact', component: Contact },
  { path: '/gallery', component: Gallery },

  {
    path: '/casestudy/:slug',
    name: 'CaseStudy',
    component: CaseStudy,
    props: true,
  },

  /* Auth routes */
  { path: '/login', component: Login },
  { path: '/register', component: Register },
  { path: '/forgot-password', component: ForgotPassword },
  { path: '/reset-password', component: ResetPassword },

  /* 🔐 Example protected route */
  {
    path: '/dashboard',
    component: () => import('./pages/Dashboard.vue'),
    meta: { auth: true },
  },
]

/* ✅ CREATE ROUTER INSTANCE */
const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,

  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition
    } else {
      return { top: 0 }
    }
  },
})


/* 🔐 AUTH GUARD */
router.beforeEach((to, from, next) => {
  const token = localStorage.getItem('token')

  if (to.meta.auth && !token) {
    next('/login')
  } else {
    next()
  }
})

export default router
