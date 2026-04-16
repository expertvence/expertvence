<template>
  <div class="admin-layout">
    <AdminSidebar :class="{ show: showSidebar }" />

    <!-- Mobile overlay -->
    <div v-if="isMobile && showSidebar" class="mobile-overlay" @click="showSidebar = false"></div>

    <div class="admin-main">
      <AdminHeader @logout="logout" @toggle-sidebar="toggleSidebar" :is-mobile="isMobile" />

      <main class="admin-content">
        <router-view />
      </main>

      <footer class="admin-footer">
        <p>© 2026 ExpertVence • Powered by your premium admin module</p>
      </footer>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, onUnmounted } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import AdminSidebar from '@/components/AdminSidebar.vue'
import AdminHeader from '@/components/AdminHeader.vue'

const router = useRouter()
const auth = useAuthStore()

const isMobile = ref(false)
const showSidebar = ref(false)

const checkMobile = () => {
  isMobile.value = window.innerWidth <= 1100
  if (!isMobile.value) {
    showSidebar.value = false
  }
}

const toggleSidebar = () => {
  showSidebar.value = !showSidebar.value
}

const logout = () => {
  auth.logout()
}

onMounted(() => {
  if (!auth.token || !auth.user || !['admin', 'super_admin'].includes(auth.user.role)) {
    router.push('/')
  }
  checkMobile()
  window.addEventListener('resize', checkMobile)
})

onUnmounted(() => {
  window.removeEventListener('resize', checkMobile)
})
</script>

<style scoped>
.admin-layout {
  display: flex;
  min-height: 100vh;
  background: #0f172a;
  color: #e2e8f0;
}

.admin-sidebar {
  width: 280px;
  background: linear-gradient(180deg, #111827 0%, #1f2937 100%);
  border-right: 1px solid rgba(255, 255, 255, 0.08);
  display: flex;
  flex-direction: column;
  padding: 2rem 1.5rem;
}

.brand-panel {
  margin-bottom: 3rem;
}

.brand-panel h1 {
  font-size: 1.6rem;
  letter-spacing: 0.15em;
  text-transform: uppercase;
  margin-bottom: 0.25rem;
}

.brand-panel span {
  color: #60a5fa;
  font-size: 0.9rem;
}

.brand-panel::after {
  content: '';
  display: block;
  margin-top: 1.7rem;
  width: 100%;
  height: 1px;
  background: rgba(255, 255, 255, 0.08);
}

.sidebar-nav {
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  flex: 1;
}

.nav-link {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  padding: 1rem 1.15rem;
  border-radius: 16px;
  color: #cbd5e1;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.25s ease;
}

.nav-link:hover,
.nav-link.active {
  background: rgba(96, 165, 250, 0.12);
  color: #fff;
  box-shadow: 0 12px 30px rgba(59, 130, 246, 0.08);
}

.sidebar-footer {
  margin-top: auto;
  padding-top: 1.5rem;
  border-top: 1px solid rgba(255, 255, 255, 0.06);
  font-size: 0.85rem;
  color: #94a3b8;
}

.admin-main {
  flex: 1;
  display: flex;
  flex-direction: column;
  background: linear-gradient(180deg, #020617 0%, #0f172a 100%);
}


.admin-content {
  flex: 1;
  padding: 2rem 2.5rem 1.5rem;
}

.admin-footer {
  padding: 1.25rem 2.5rem;
  text-align: center;
  color: #94a3b8;
  border-top: 1px solid rgba(255, 255, 255, 0.06);
  background: rgba(15, 23, 42, 0.88);
}

@media (max-width: 1100px) {
  .admin-layout {
    position: relative;
  }

  .admin-sidebar {
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    width: 280px !important;
    height: 100vh !important;
    z-index: 1000 !important;
    transform: translateX(-100%) !important;
    transition: transform 0.3s ease !important;
    flex-direction: column !important;
    box-shadow: 2px 0 20px rgba(0, 0, 0, 0.3) !important;
  }

  .admin-sidebar.show {
    transform: translateX(0) !important;
  }

  .admin-main {
    width: 100% !important;
  }

  .admin-header {
    padding: 1rem 1.5rem !important;
  }

  .admin-content {
    padding: 1.5rem 1.5rem 1rem !important;
  }

  .admin-footer {
    display: none !important;
  }
}

@media (max-width: 768px) {
  .admin-layout {
    min-height: 100vh;
  }

  .admin-sidebar {
    padding: 0.75rem 1rem !important;
  }

  .brand-panel {
    margin-right: 1rem !important;
  }

  .brand-logo {
    width: 28px !important;
    height: 28px !important;
  }

  .brand-text h1 {
    font-size: 1.2rem !important;
  }

  .sidebar-nav {
    gap: 0.125rem !important;
  }

  .nav-link {
    padding: 0.625rem !important;
    min-width: 44px !important;
  }

  .admin-header {
    padding: 0.875rem 1rem !important;
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 0.75rem !important;
  }

  .header-left h2 {
    font-size: 1.25rem !important;
  }

  .header-right {
    width: 100% !important;
    justify-content: space-between !important;
  }

  .admin-content {
    padding: 1rem !important;
  }
}

@media (max-width: 480px) {
  .admin-sidebar {
    padding: 0.5rem 0.75rem !important;
  }

  .brand-panel {
    margin-right: 0.5rem !important;
  }

  .brand-text h1 {
    font-size: 1rem !important;
  }

  .sidebar-nav {
    gap: 0.1rem !important;
  }

  .nav-link {
    padding: 0.5rem !important;
    min-width: 40px !important;
  }

  .admin-header {
    padding: 0.75rem 0.75rem !important;
  }

  .header-left h2 {
    font-size: 1.1rem !important;
  }

  .admin-content {
    padding: 0.75rem !important;
  }

  .admin-footer {
    padding: 0.75rem !important;
  }
}

/* Mobile overlay for sidebar */
.mobile-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.5);
  z-index: 999;
  backdrop-filter: blur(2px);
}
</style>
