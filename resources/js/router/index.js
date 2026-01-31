import { createRouter, createWebHistory } from 'vue-router'

import Login from '../pages/Auth/Login.vue'
import Register from '../pages/Auth/Register.vue'

const routes = [
  { path: '/login', component: Login },
  { path: '/register', component: Register },
]

export default createRouter({
  history: createWebHistory(),
  routes,
})
