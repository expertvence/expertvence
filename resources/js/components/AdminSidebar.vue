<template>
  <aside class="admin-sidebar">
    <div class="brand-panel">
      <div class="brand-logo">
        <svg width="32" height="32" viewBox="0 0 32 32" fill="none">
          <rect width="32" height="32" rx="8" fill="#60a5fa"/>
          <path d="M8 12L16 8L24 12V20L16 24L8 20V12Z" fill="white"/>
          <path d="M12 14L16 16L20 14" stroke="white" stroke-width="1.5" stroke-linecap="round"/>
        </svg>
      </div>
      <div class="brand-text">
        <h1>ExpertVence</h1>
        <span>Admin Suite</span>
      </div>
    </div>

    <nav class="sidebar-nav">
      <div class="nav-section">
        <div class="nav-section-title" @click="toggleSection('overview')" :class="{ expanded: expandedSections.overview }">
          <span>Overview</span>
          <svg class="chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <div class="nav-section-content" v-show="expandedSections.overview">
          <router-link to="/admin" class="nav-link" exact-active-class="active">
            <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M3 7V5C3 4.44772 3.44772 4 4 4H20C20.5523 4 21 4.44772 21 5V7M3 7V19C3 19.5523 3.44772 20 4 20H20C20.5523 20 21 19.5523 21 19V7M3 7H21M12 11V15M9 13H15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span>Dashboard</span>
          </router-link>
        </div>
      </div>

      <div class="nav-section">
        <div class="nav-section-title" @click="toggleSection('management')" :class="{ expanded: expandedSections.management }">
          <span>Management</span>
          <svg class="chevron-icon" width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path d="M6 9L12 15L18 9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </div>
        <div class="nav-section-content" v-show="expandedSections.management">
          <router-link to="/admin/users" class="nav-link" active-class="active">
            <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z" stroke="currentColor" stroke-width="2"/>
              <path d="M20.59 22C20.59 18.13 16.74 15 12 15C7.26 15 3.41 18.13 3.41 22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span>Users</span>
          </router-link>

          <router-link to="/admin/settings" class="nav-link" active-class="active">
            <svg class="nav-icon" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M10.325 4.317C10.751 2.56 13.249 2.56 13.675 4.317C13.956 5.522 15.522 5.796 16.132 4.917C16.886 3.769 18.231 4.114 18.231 5.405V5.594C18.231 6.885 16.886 7.23 16.132 6.082C15.522 5.203 13.956 5.477 13.675 6.682C13.249 8.439 10.751 8.439 10.325 6.682C10.044 5.477 8.478 5.203 7.868 6.082C7.114 7.23 5.769 6.885 5.769 5.594V5.405C5.769 4.114 7.114 3.769 7.868 4.917C8.478 5.796 10.044 5.522 10.325 4.317Z" stroke="currentColor" stroke-width="2"/>
              <path d="M12 12V22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span>Settings</span>
          </router-link>
        </div>
      </div>
    </nav>

    <div class="sidebar-footer">
      <div class="user-info">
        <div class="user-avatar">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
            <path d="M6 20C6 16.6863 8.68629 14 12 14C15.3137 14 18 16.6863 18 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <div class="user-details">
          <div class="user-name">{{ user?.name || 'Admin' }}</div>
          <div class="user-role">{{ user?.role || 'admin' }}</div>
        </div>
      </div>
      <div class="footer-text">ExpertVence Admin v2.0</div>
    </div>
  </aside>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useAuthStore } from '@/stores/auth'
import { useRoute } from 'vue-router'

const auth = useAuthStore()
const route = useRoute()
const user = computed(() => auth.user)

// Collapsible sections state
const expandedSections = ref({
  overview: true,
  management: true
})

const toggleSection = (section) => {
  expandedSections.value[section] = !expandedSections.value[section]
}

// Auto-expand section if current route is in that section
onMounted(() => {
  const currentPath = route.path
  if (currentPath.includes('/admin/users') || currentPath.includes('/admin/settings')) {
    expandedSections.value.management = true
  }
  if (currentPath === '/admin') {
    expandedSections.value.overview = true
  }
})
</script>

<style scoped>
.admin-sidebar {
  width: 280px;
  background: linear-gradient(180deg, #111827 0%, #1f2937 100%);
  border-right: 1px solid rgba(255, 255, 255, 0.08);
  display: flex;
  flex-direction: column;
  padding: 2rem 1.5rem;
  box-shadow: 4px 0 20px rgba(0, 0, 0, 0.15);
}

.brand-panel {
  margin-bottom: 3rem;
  display: flex;
  align-items: center;
  gap: 1rem;
}

.brand-logo {
  flex-shrink: 0;
}

.brand-text h1 {
  font-size: 1.4rem;
  letter-spacing: 0.1em;
  text-transform: uppercase;
  margin-bottom: 0.25rem;
  font-weight: 700;
}

.brand-text span {
  color: #60a5fa;
  font-size: 0.85rem;
  font-weight: 500;
}

.sidebar-nav {
  display: flex;
  flex-direction: column;
  gap: 2rem;
  flex: 1;
}

.nav-section {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.nav-section-title {
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: #94a3b8;
  margin-bottom: 0.5rem;
  padding: 0.5rem 1rem;
  display: flex;
  align-items: center;
  justify-content: space-between;
  cursor: pointer;
  border-radius: 8px;
  transition: all 0.25s ease;
  user-select: none;
}

.nav-section-title:hover {
  background: rgba(96, 165, 250, 0.08);
  color: #cbd5e1;
}

.nav-section-title.expanded .chevron-icon {
  transform: rotate(180deg);
}

.chevron-icon {
  transition: transform 0.25s ease;
  color: #64748b;
}

.nav-section-content {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  overflow: hidden;
  transition: all 0.3s ease;
}

.nav-link {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  padding: 0.875rem 1rem;
  border-radius: 12px;
  color: #cbd5e1;
  font-weight: 500;
  text-decoration: none;
  transition: all 0.25s ease;
  position: relative;
  overflow: hidden;
}

.nav-link::before {
  content: '';
  position: absolute;
  left: 0;
  top: 0;
  width: 4px;
  height: 100%;
  background: #60a5fa;
  transform: scaleY(0);
  transition: transform 0.25s ease;
  border-radius: 0 4px 4px 0;
}

.nav-link:hover {
  background: rgba(96, 165, 250, 0.08);
  color: #fff;
  transform: translateX(4px);
}

.nav-link.active {
  background: rgba(96, 165, 250, 0.15);
  color: #fff;
  box-shadow: 0 4px 20px rgba(96, 165, 250, 0.15);
}

.nav-link.active::before {
  transform: scaleY(1);
}

.nav-link:hover::before {
  transform: scaleY(1);
}

.nav-icon {
  flex-shrink: 0;
  opacity: 0.8;
  transition: opacity 0.25s ease;
}

.nav-link:hover .nav-icon,
.nav-link.active .nav-icon {
  opacity: 1;
}

.sidebar-footer {
  margin-top: auto;
  padding-top: 2rem;
  border-top: 1px solid rgba(255, 255, 255, 0.08);
}

.user-info {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin-bottom: 1rem;
  padding: 1rem;
  background: rgba(255, 255, 255, 0.03);
  border-radius: 12px;
  border: 1px solid rgba(255, 255, 255, 0.05);
}

.user-avatar {
  width: 40px;
  height: 40px;
  border-radius: 10px;
  background: rgba(96, 165, 250, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid rgba(96, 165, 250, 0.2);
}

.user-details {
  flex: 1;
  min-width: 0;
}

.user-name {
  font-size: 0.9rem;
  font-weight: 600;
  color: #e2e8f0;
  margin-bottom: 0.25rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.user-role {
  font-size: 0.75rem;
  color: #60a5fa;
  text-transform: capitalize;
  font-weight: 500;
}

.footer-text {
  font-size: 0.75rem;
  color: #64748b;
  text-align: center;
  padding-top: 0.5rem;
}

@media (max-width: 1100px) {
  .admin-sidebar {
    /* Reset mobile styles since we now use overlay */
  }

  .brand-text {
    display: block !important;
  }

  .sidebar-nav {
    flex-direction: column !important;
    gap: 0.5rem !important;
  }

  .nav-section {
    display: block !important;
  }

  .nav-section-title {
    display: flex !important;
    align-items: center !important;
    justify-content: space-between !important;
    cursor: pointer !important;
    padding: 0.75rem 1rem !important;
    margin-bottom: 0.25rem !important;
    font-size: 0.8rem !important;
    text-transform: uppercase !important;
    letter-spacing: 0.1em !important;
    color: #94a3b8 !important;
  }

  .nav-section-content {
    display: flex !important;
    flex-direction: column !important;
    gap: 0.125rem !important;
  }

  .nav-link {
    padding: 0.875rem 1.15rem !important;
    justify-content: flex-start !important;
  }

  .nav-link span {
    display: inline-block !important;
    margin-left: 0.75rem !important;
  }

  .sidebar-footer {
    display: block !important;
  }
}

@media (max-width: 768px) {
  .admin-sidebar {
    padding: 0.75rem 1rem !important;
  }

  .brand-panel {
    margin-right: 0.75rem !important;
  }

  .brand-logo svg {
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
}
</style>
