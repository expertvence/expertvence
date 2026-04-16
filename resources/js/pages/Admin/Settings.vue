<template>
  <section class="admin-settings-page">
    <div class="settings-panel">
      <div class="settings-header">
        <h1>Settings</h1>
        <p>Manage high-level admin preferences and system information.</p>
      </div>

      <div class="settings-cards">
        <div class="settings-card">
          <h3>Admin Role</h3>
          <p>{{ user?.role || 'admin' }}</p>
        </div>
        <div class="settings-card">
          <h3>Current User</h3>
          <p>{{ user?.name || 'Admin' }}</p>
          <p class="muted">{{ user?.email }}</p>
        </div>
        <div class="settings-card">
          <h3>Security</h3>
          <p>Only admin users can access this module.</p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const user = computed(() => auth.user)
</script>

<style scoped>
.admin-settings-page {
  display: grid;
  gap: 2rem;
}

.settings-header h1 {
  margin-bottom: 0.5rem;
  font-size: 2rem;
}

.settings-header p {
  color: #94a3b8;
  max-width: 600px;
}

.settings-cards {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 1.25rem;
}

.settings-card {
  padding: 1.75rem;
  border-radius: 24px;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.08);
  box-shadow: 0 28px 90px rgba(15, 23, 42, 0.12);
}

.settings-card h3 {
  margin-bottom: 0.75rem;
}

.settings-card p {
  color: #cbd5e1;
  line-height: 1.8;
}

.settings-card[data-highlight="true"] {
  border-color: rgba(96, 165, 250, 0.4);
  background: linear-gradient(180deg, rgba(15, 23, 42, 0.95), rgba(15, 23, 42, 0.75));
}

.settings-card p {
  color: #cbd5e1;
  line-height: 1.8;
}

.muted {
  color: #94a3b8;
  margin-top: 0.5rem;
}

@media (max-width: 1024px) {
  .settings-cards {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 768px) {
  .admin-settings-page {
    gap: 1.5rem;
    padding: 1rem;
  }

  .settings-header h1 {
    font-size: 1.5rem;
  }

  .settings-header p {
    font-size: 0.875rem;
  }

  .settings-card {
    padding: 1.25rem;
  }

  .settings-card h3 {
    font-size: 1.125rem;
  }
}

@media (max-width: 480px) {
  .admin-settings-page {
    gap: 1rem;
    padding: 0.5rem;
  }

  .settings-header h1 {
    font-size: 1.25rem;
  }

  .settings-header p {
    font-size: 0.8125rem;
  }

  .settings-card {
    padding: 1rem;
  }

  .settings-card h3 {
    font-size: 1rem;
  }

  .settings-card p {
    font-size: 0.875rem;
  }
}
</style>
