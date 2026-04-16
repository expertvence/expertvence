<template>
  <section class="admin-dashboard-page">
    <div class="panel-hero">
      <div class="hero-copy">
        <span class="eyebrow">Premium Admin Workspace</span>
        <h1>Welcome back, {{ user?.name || 'Admin' }}</h1>
        <p>Manage users, review stats, and control your platform from one premium dashboard.</p>
        <div class="hero-actions">
          <button @click="goToUsers" class="btn-primary">Manage users</button>
          <button @click="fetchStats" class="btn-secondary">Refresh stats</button>
        </div>
      </div>
      <div class="hero-metrics">
        <div class="metric-box">
          <span>Total users</span>
          <strong>{{ stats.total_users }}</strong>
        </div>
        <div class="metric-box">
          <span>Admin users</span>
          <strong>{{ stats.admins }}</strong>
        </div>
        <div class="metric-box">
          <span>Super admins</span>
          <strong>{{ stats.super_admins }}</strong>
        </div>
      </div>
    </div>

    <div class="stats-grid">
      <div class="stat-card gradient-card">
        <span>Total Users</span>
        <strong>{{ stats.total_users }}</strong>
      </div>
      <div class="stat-card gradient-card">
        <span>Super Admins</span>
        <strong>{{ stats.super_admins }}</strong>
      </div>
      <div class="stat-card gradient-card">
        <span>Admins</span>
        <strong>{{ stats.admins }}</strong>
      </div>
      <div class="stat-card gradient-card">
        <span>Regular Users</span>
        <strong>{{ stats.regular_users }}</strong>
      </div>
    </div>

    <div class="overview-cards">
      <div class="overview-card">
        <h3>Fast user access</h3>
        <p>Search, filter, and manage your users instantly from the users section.</p>
      </div>
      <div class="overview-card">
        <h3>Security first</h3>
        <p>Only admin and super admin access is allowed. All actions are protected.</p>
      </div>
      <div class="overview-card">
        <h3>Premium control</h3>
        <p>Set permissions, manage roles, and control the application from a dedicated module.</p>
      </div>
    </div>
  </section>
</template>

<script setup>
import { onMounted, ref, computed } from 'vue'
import { useRouter } from 'vue-router'
import { useAuthStore } from '@/stores/auth'
import api from '@/utils/axios'

const auth = useAuthStore()
const router = useRouter()
const user = computed(() => auth.user)
const stats = ref({
  total_users: 0,
  super_admins: 0,
  admins: 0,
  regular_users: 0,
})

const fetchStats = async () => {
  try {
    const response = await api.get('/admin/dashboard')
    stats.value = response.data.data
  } catch (error) {
    console.error('Failed to fetch admin dashboard stats:', error)
  }
}

const goToUsers = () => {
  router.push('/admin/users')
}

onMounted(() => {
  fetchStats()
})
</script>

<style scoped>
.admin-dashboard-page {
  display: grid;
  gap: 2rem;
}

.panel-hero {
  display: grid;
  grid-template-columns: minmax(0, 1.5fr) minmax(260px, 1fr);
  gap: 1.75rem;
  padding: 2rem;
  background: rgba(15, 23, 42, 0.85);
  border-radius: 28px;
  border: 1px solid rgba(96, 165, 250, 0.18);
  box-shadow: 0 30px 90px rgba(15, 23, 42, 0.15);
}

.eyebrow {
  display: inline-flex;
  margin-bottom: 1rem;
  font-size: 0.9rem;
  letter-spacing: 0.14em;
  text-transform: uppercase;
  color: #60a5fa;
}

.hero-copy h1 {
  font-size: 2.2rem;
  margin: 0;
}

.hero-copy p {
  color: #cbd5e1;
  max-width: 620px;
  margin: 1.25rem 0 1.75rem;
}

.hero-actions {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
}

.hero-metrics {
  display: grid;
  gap: 1rem;
}

.metric-box {
  padding: 1.4rem 1.25rem;
  border-radius: 22px;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.08);
}

.metric-box span {
  display: block;
  color: #94a3b8;
  margin-bottom: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  font-size: 0.82rem;
}

.metric-box strong {
  font-size: 2rem;
  color: #fff;
}

.btn-secondary {
  border: 1px solid rgba(96, 165, 250, 0.35);
  background: transparent;
  color: #bfdbfe;
  font-weight: 700;
  border-radius: 999px;
  padding: 1rem 1.5rem;
  cursor: pointer;
}

.btn-secondary:hover {
  background: rgba(96, 165, 250, 0.1);
}

.panel-hero p {
  color: #cbd5e1;
  max-width: 640px;
}

.btn-primary {
  border: none;
  border-radius: 999px;
  padding: 1rem 1.8rem;
  background: linear-gradient(135deg, #4f46e5 0%, #3b82f6 100%);
  color: white;
  font-weight: 700;
  cursor: pointer;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(4, minmax(0, 1fr));
  gap: 1.25rem;
}

.stat-card {
  padding: 1.8rem;
  border-radius: 24px;
  background: #111827;
  border: 1px solid rgba(255, 255, 255, 0.05);
}

.stat-card span {
  display: block;
  margin-bottom: 1rem;
  color: #94a3b8;
  font-size: 0.95rem;
}

.stat-card strong {
  font-size: 2.5rem;
  color: #fff;
}

.gradient-card {
  background: linear-gradient(135deg, #4338ca 0%, #2563eb 100%);
  box-shadow: 0 24px 60px rgba(37, 99, 235, 0.18);
}

.overview-cards {
  display: grid;
  grid-template-columns: repeat(3, minmax(0, 1fr));
  gap: 1.25rem;
}

.overview-card {
  padding: 1.75rem;
  border-radius: 24px;
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.07);
  box-shadow: 0 24px 70px rgba(15, 23, 42, 0.15);
}

.overview-card h3 {
  margin-bottom: 0.75rem;
  color: #fff;
}

.overview-card p {
  color: #cbd5e1;
  line-height: 1.8;
}

@media (max-width: 1024px) {
  .stats-grid,
  .overview-cards {
    grid-template-columns: 1fr;
  }
}

@media (max-width: 900px) {
  .panel-hero {
    grid-template-columns: 1fr;
  }
}

.overview-card h3 {
  margin-bottom: 0.75rem;
  color: #f8fafc;
}

.overview-card p {
  color: #cbd5e1;
  line-height: 1.8;
}

@media (max-width: 1024px) {
  .stats-grid,
  .overview-cards {
    grid-template-columns: 1fr;
  }
}
</style>
