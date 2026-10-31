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

/* Admin pages */
import AdminLogin from './pages/Admin/AdminLogin.vue'
import AdminDashboard from './pages/Admin/AdminDashboard.vue'
import DemoAccess from './pages/DemoAccess.vue'
import GoogleAuthResult from './pages/Auth/GoogleAuthResult.vue'

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
  { path: '/auth/google/result', component: GoogleAuthResult },
  { path: '/demo-access/:id', component: DemoAccess },

  /* 🔐 Example protected route */
  {
    path: '/dashboard',
    component: () => import('./pages/Dashboard.vue'),
    meta: { auth: true },
  },

  /* 🛡️ Admin Routes */
  {
    path: '/admin',
    redirect: () => {
      const adminToken = localStorage.getItem('admin_token')
      return adminToken ? '/admin/dashboard' : '/admin/login'
    },
  },
  {
    path: '/admin/login',
    name: 'AdminLogin',
    component: AdminLogin,
  },
  {
    path: '/admin/dashboard',
    name: 'AdminDashboard',
    component: AdminDashboard,
    meta: { requiresAdmin: true },
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
  const adminToken = localStorage.getItem('admin_token')

  // Check admin protected route
  if (to.matched.some((record) => record.meta.requiresAdmin)) {
    if (!adminToken) {
      next('/admin/login')
      return
    }
  }

  // If already logged in as admin and trying to visit /admin/login
  if (to.path === '/admin/login' && adminToken) {
    next('/admin/dashboard')
    return
  }

  // Standard user auth
  const token = localStorage.getItem('token')
  if (to.meta.auth && !token) {
    next('/login')
    return
  }
  if (to.meta.auth) {
    next('/')
    return
  }

  next()
})

export default router
