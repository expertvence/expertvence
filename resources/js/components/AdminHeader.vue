<template>
  <header class="admin-header">
    <div class="header-left">
      <button v-if="isMobile" class="hamburger-btn" @click="$emit('toggle-sidebar')" title="Toggle Menu">
        <span></span>
        <span></span>
        <span></span>
      </button>
      <div class="header-breadcrumb">
        <span class="breadcrumb-item">Admin</span>
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
          <path d="M9 6L15 12L9 18" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        <span class="breadcrumb-item active">{{ pageTitle }}</span>
      </div>
      <h2>{{ pageTitle }}</h2>
      <p>Manage your platform with powerful admin tools and insights.</p>
    </div>
    <div class="header-right">
      <div class="header-actions">
        <button class="action-btn" title="Notifications">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <path d="M15 17H20L18.5951 15.5951C18.2141 15.2141 18 14.6973 18 14.1585V11C18 8.38757 16.3304 6.16509 14 5.34142V5C14 3.89543 13.1046 3 12 3C10.8954 3 10 3.89543 10 5V5.34142C7.66962 6.16509 6 8.38757 6 11V14.1585C6 14.6973 5.78595 15.2141 5.40493 15.5951L4 17H9M15 17V18C15 19.6569 13.6569 21 12 21C10.3431 21 9 19.6569 9 18V17M15 17H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
        <button class="action-btn" title="Search">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <path d="M21 21L16.5 16.5M19 11C19 15.4183 15.4183 19 11 19C6.58172 19 3 15.4183 3 11C3 6.58172 6.58172 3 11 3C15.4183 3 19 6.58172 19 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>
      <div class="user-chip">
        <div class="user-avatar">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
            <circle cx="12" cy="8" r="4" stroke="currentColor" stroke-width="2"/>
            <path d="M6 20C6 16.6863 8.68629 14 12 14C15.3137 14 18 16.6863 18 20" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
          </svg>
        </div>
        <div class="user-info">
          <div class="user-name">{{ user?.name || 'Admin' }}</div>
          <div class="user-role">{{ user?.role || 'admin' }}</div>
        </div>
        <button class="logout-btn" @click="$emit('logout')" title="Logout">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
            <path d="M9 21H5C4.46957 21 3.96086 20.7893 3.58579 20.4142C3.21071 20.0391 3 19.5304 3 19V5C3 4.46957 3.21071 3.96086 3.58579 3.58579C3.96086 3.21071 4.46957 3 5 3H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M16 17L21 12L16 7" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M21 12H9" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </button>
      </div>
    </div>
  </header>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'
import { useAuthStore } from '@/stores/auth'

const props = defineProps({
  isMobile: {
    type: Boolean,
    default: false
  }
})

const route = useRoute()
const auth = useAuthStore()
const user = computed(() => auth.user)
const pageTitle = computed(() => route.meta.title || 'Admin Panel')
</script>

<style scoped>
.admin-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.75rem 2.5rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
  gap: 1rem;
  background: rgba(15, 23, 42, 0.72);
  backdrop-filter: blur(18px);
}

.header-left {
  flex: 1;
}

.header-breadcrumb {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.75rem;
  font-size: 0.875rem;
  color: #94a3b8;
}

.breadcrumb-item {
  color: #94a3b8;
  transition: color 0.25s ease;
}

.breadcrumb-item.active {
  color: #60a5fa;
  font-weight: 500;
}

.header-left h2 {
  font-size: 1.85rem;
  margin-bottom: 0.3rem;
  color: #e2e8f0;
  font-weight: 700;
}

.header-left p {
  color: #94a3b8;
  margin: 0;
  font-size: 0.95rem;
}

.header-right {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.header-actions {
  display: flex;
  gap: 0.5rem;
}

.action-btn {
  width: 44px;
  height: 44px;
  border: none;
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.05);
  color: #cbd5e1;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.25s ease;
  border: 1px solid rgba(255, 255, 255, 0.08);
}

.action-btn:hover {
  background: rgba(96, 165, 250, 0.1);
  color: #60a5fa;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(96, 165, 250, 0.15);
}

.user-chip {
  display: flex;
  align-items: center;
  gap: 0.875rem;
  padding: 0.75rem 1rem;
  border-radius: 16px;
  background: rgba(255, 255, 255, 0.08);
  border: 1px solid rgba(255, 255, 255, 0.12);
  transition: all 0.25s ease;
}

.user-chip:hover {
  background: rgba(255, 255, 255, 0.12);
  transform: translateY(-1px);
  box-shadow: 0 4px 16px rgba(255, 255, 255, 0.08);
}

.user-avatar {
  width: 36px;
  height: 36px;
  border-radius: 10px;
  background: rgba(96, 165, 250, 0.1);
  display: flex;
  align-items: center;
  justify-content: center;
  border: 2px solid rgba(96, 165, 250, 0.2);
}

.user-info {
  flex: 1;
  min-width: 0;
}

.user-name {
  font-size: 0.9rem;
  font-weight: 600;
  color: #e2e8f0;
  margin-bottom: 0.125rem;
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

.logout-btn {
  width: 32px;
  height: 32px;
  border: none;
  border-radius: 8px;
  background: rgba(239, 68, 68, 0.1);
  color: #f87171;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.25s ease;
  border: 1px solid rgba(239, 68, 68, 0.2);
}

.logout-btn:hover {
  background: rgba(239, 68, 68, 0.2);
  color: #ef4444;
  transform: translateY(-1px);
  box-shadow: 0 4px 12px rgba(239, 68, 68, 0.15);
}

@media (max-width: 1100px) {
  .admin-header {
    padding: 1rem 1.5rem !important;
  }

  .header-content {
    flex-direction: column !important;
    align-items: flex-start !important;
    gap: 1rem !important;
  }

  .header-left {
    width: 100% !important;
  }

  .header-right {
    width: 100% !important;
    justify-content: space-between !important;
  }

  .breadcrumb {
    font-size: 0.875rem !important;
  }

  .page-title {
    font-size: 1.25rem !important;
  }

  .header-actions {
    display: flex !important;
    gap: 0.5rem !important;
  }

  .user-info {
    display: block !important;
  }

  .user-chip {
    padding: 0.5rem 0.75rem !important;
  }
}

@media (max-width: 768px) {
  .admin-header {
    padding: 0.75rem 1rem !important;
  }

  .header-content {
    gap: 0.75rem !important;
  }

  .breadcrumb {
    font-size: 0.8125rem !important;
  }

  .page-title {
    font-size: 1.125rem !important;
  }

  .header-actions {
    gap: 0.375rem !important;
  }

  .action-btn {
    padding: 0.5rem !important;
  }

  .user-chip {
    padding: 0.375rem 0.625rem !important;
  }
}

@media (max-width: 480px) {
  .admin-header {
    padding: 0.5rem 0.75rem !important;
  }

  .header-content {
    gap: 0.5rem !important;
  }

  .breadcrumb {
    font-size: 0.75rem !important;
  }

  .page-title {
    font-size: 1rem !important;
  }

  .header-actions {
    flex-wrap: wrap !important;
    gap: 0.25rem !important;
  }

  .action-btn {
    padding: 0.375rem !important;
    font-size: 0.875rem !important;
  }

  .user-chip {
    padding: 0.25rem 0.5rem !important;
    font-size: 0.8125rem !important;
  }
}

/* Hamburger Menu Button */
.hamburger-btn {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  width: 44px;
  height: 44px;
  background: rgba(96, 165, 250, 0.1);
  border: 1px solid rgba(96, 165, 250, 0.2);
  border-radius: 10px;
  cursor: pointer;
  transition: all 0.25s ease;
  margin-right: 1rem;
}

.hamburger-btn:hover {
  background: rgba(96, 165, 250, 0.2);
  transform: translateY(-1px);
  box-shadow: 0 4px 16px rgba(96, 165, 250, 0.15);
}

.hamburger-btn span {
  width: 20px;
  height: 2px;
  background: #60a5fa;
  margin: 2px 0;
  transition: all 0.25s ease;
  border-radius: 1px;
}

.hamburger-btn:hover span {
  background: #93c5fd;
}
</style>
