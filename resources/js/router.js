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

/* Layouts */
import PublicLayout from './layouts/PublicLayout.vue'
import AdminLayout from './pages/Admin/AdminLayout.vue'

/* Store */
import { useAuthStore } from './stores/auth'

/* Routes */
const routes = [
  {
    path: '/',
    component: PublicLayout,
    children: [
      { path: '', component: Home },
      { path: 'about', component: About },
      { path: 'services', component: Services },
      { path: 'services/:slug', component: ServiceDetail },
      { path: 'portfolio', component: Portfolio },
      { path: 'contact', component: Contact },
      { path: 'gallery', component: Gallery },
      { path: 'casestudy/:slug', component: CaseStudy, props: true },
      { path: 'login', component: Login },
      { path: 'register', component: Register },
      { path: 'forgot-password', component: ForgotPassword },
      { path: 'reset-password', component: ResetPassword },
      {
        path: 'dashboard',
        component: () => import('./pages/Dashboard.vue'),
        meta: { auth: true },
      },
    ],
  },

  {
    path: '/admin',
    component: AdminLayout,
    meta: { auth: true, admin: true },
    children: [
      {
        path: '',
        component: () => import('./pages/Admin/Dashboard.vue'),
        meta: { title: 'Dashboard' },
      },
      {
        path: 'users',
        component: () => import('./pages/Admin/Users.vue'),
        meta: { title: 'Users' },
      },
      {
        path: 'settings',
        component: () => import('./pages/Admin/Settings.vue'),
        meta: { title: 'Settings' },
      },
    ],
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
  // Get auth store instance
  const authStore = useAuthStore()

  if (to.meta.auth && !authStore.isLoggedIn) {
    next('/login')
  } else if (to.meta.admin && (!authStore.user || !['admin', 'super_admin'].includes(authStore.user.role))) {
    next('/') // Redirect to home if not admin
  } else {
    next()
  }
})

export default router
