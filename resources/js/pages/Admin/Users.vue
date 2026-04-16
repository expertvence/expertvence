<template>
  <section class="admin-users-page">
    <div class="page-top">
      <div>
        <h1>Users</h1>
        <p>Manage platform users with search, role editing, and deletion.</p>
      </div>
      <div class="top-actions">
        <span class="user-count">Total users: {{ users.length }}</span>
        <input
          v-model="searchQuery"
          @input="filterUsers"
          type="search"
          placeholder="Search users"
          class="search-input"
        />
      </div>
    </div>

    <div v-if="loading" class="loading-block">Loading users...</div>

    <div v-else class="users-content">
      <!-- Desktop Table View -->
      <div class="users-table-wrap desktop-only">
        <table class="users-table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Email</th>
              <th>Role</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in filteredUsers" :key="user.id">
              <td>{{ user.id }}</td>
              <td>{{ user.name }}</td>
              <td>{{ user.email }}</td>
              <td>
                <span :class="['role-pill', `role-${user.role}`]">{{ user.role }}</span>
              </td>
              <td>
                <button
                  v-if="auth.user?.role === 'super_admin' && user.id !== auth.user.id"
                  @click="openRoleModal(user)"
                  class="action-btn edit"
                >
                  Edit
                </button>
                <button
                  v-if="auth.user?.role === 'super_admin' && user.id !== auth.user.id && user.role !== 'super_admin'"
                  @click="removeUser(user.id)"
                  class="action-btn delete"
                >
                  Delete
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Mobile Card View -->
      <div class="users-cards mobile-only">
        <div v-for="user in filteredUsers" :key="user.id" class="user-card">
          <div class="user-card-header">
            <div class="user-avatar">
              <span>{{ user.name.charAt(0).toUpperCase() }}</span>
            </div>
            <div class="user-info">
              <h3>{{ user.name }}</h3>
              <span :class="['role-pill', `role-${user.role}`]">{{ user.role }}</span>
            </div>
          </div>
          <div class="user-card-body">
            <div class="user-detail">
              <span class="label">ID:</span>
              <span class="value">{{ user.id }}</span>
            </div>
            <div class="user-detail">
              <span class="label">Email:</span>
              <span class="value">{{ user.email }}</span>
            </div>
          </div>
          <div class="user-card-actions">
            <button
              v-if="auth.user?.role === 'super_admin' && user.id !== auth.user.id"
              @click="openRoleModal(user)"
              class="action-btn edit"
            >
              Edit Role
            </button>
            <button
              v-if="auth.user?.role === 'super_admin' && user.id !== auth.user.id && user.role !== 'super_admin'"
              @click="removeUser(user.id)"
              class="action-btn delete"
            >
              Delete
            </button>
          </div>
        </div>
      </div>

      <div v-if="!filteredUsers.length && !loading" class="no-results">No users found. Try another search term.</div>
    </div>

    <div v-if="showModal" class="modal-overlay" @click.self="closeModal">
      <div class="modal-card">
        <h3>Update Role</h3>
        <p>{{ activeUser?.name }}</p>
        <select v-model="newRole">
          <option value="user">User</option>
          <option value="admin">Admin</option>
          <option value="super_admin">Super Admin</option>
        </select>
        <div class="modal-actions">
          <button class="modal-save" @click="updateRole">Save</button>
          <button class="modal-cancel" @click="closeModal">Cancel</button>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import api from '@/utils/axios'
import { useAuthStore } from '@/stores/auth'

const auth = useAuthStore()
const users = ref([])
const filteredUsers = ref([])
const searchQuery = ref('')
const loading = ref(false)
const showModal = ref(false)
const activeUser = ref(null)
const newRole = ref('user')

const fetchUsers = async () => {
  loading.value = true
  try {
    const response = await api.get('/admin/users')
    users.value = response.data.data.data
    filteredUsers.value = response.data.data.data
  } catch (error) {
    console.error('Failed to fetch users:', error)
  } finally {
    loading.value = false
  }
}

const filterUsers = () => {
  const query = searchQuery.value.toLowerCase().trim()
  filteredUsers.value = users.value.filter((user) =>
    user.name.toLowerCase().includes(query) || user.email.toLowerCase().includes(query)
  )
}

const openRoleModal = (user) => {
  activeUser.value = user
  newRole.value = user.role
  showModal.value = true
}

const closeModal = () => {
  showModal.value = false
  activeUser.value = null
}

const updateRole = async () => {
  if (!activeUser.value) return

  try {
    await api.put(`/admin/users/${activeUser.value.id}/role`, {
      role: newRole.value,
    })
    await fetchUsers()
    closeModal()
    alert('Role updated successfully')
  } catch (error) {
    console.error('Failed to update role:', error)
    alert('Update failed')
  }
}

const removeUser = async (userId) => {
  if (!confirm('Are you sure?')) return

  try {
    await api.delete(`/admin/users/${userId}`)
    await fetchUsers()
    alert('User deleted')
  } catch (error) {
    console.error('Failed to delete user:', error)
    alert('Delete failed')
  }
}

onMounted(() => {
  fetchUsers()
})
</script>

<style scoped>
.admin-users-page {
  display: grid;
  gap: 1.75rem;
}

.page-top {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 1rem;
  flex-wrap: wrap;
}

.top-actions {
  display: flex;
  align-items: center;
  gap: 0.85rem;
  flex-wrap: wrap;
}

.user-count {
  display: inline-flex;
  align-items: center;
  padding: 0.8rem 1rem;
  border-radius: 999px;
  background: rgba(96, 165, 250, 0.15);
  color: #bfdbfe;
  font-weight: 600;
}

.page-top h1 {
  margin: 0;
  font-size: 2rem;
}

.page-top p {
  color: #94a3b8;
  margin-top: 0.5rem;
}

.search-input {
  min-width: 280px;
  padding: 0.95rem 1rem;
  border-radius: 999px;
  border: 1px solid rgba(148, 163, 184, 0.18);
  background: #111827;
  color: #e2e8f0;
}

.users-table-wrap {
  overflow-x: auto;
  border-radius: 24px;
  background: rgba(255, 255, 255, 0.05);
  border: 1px solid rgba(255, 255, 255, 0.1);
  box-shadow: 0 30px 80px rgba(15, 23, 42, 0.12);
}

.users-table {
  width: 100%;
  border-collapse: collapse;
}

.users-table th,
.users-table td {
  padding: 1rem 1.2rem;
  text-align: left;
  color: #cbd5e1;
}

.users-table th {
  position: sticky;
  top: 0;
  background: rgba(15, 23, 42, 0.95);
  color: #94a3b8;
  font-weight: 600;
  border-bottom: 1px solid rgba(255, 255, 255, 0.08);
}

.users-table tr:hover {
  background: rgba(255, 255, 255, 0.04);
}

.role-pill {
  display: inline-flex;
  padding: 0.4rem 0.8rem;
  border-radius: 999px;
  font-size: 0.85rem;
  font-weight: 700;
  text-transform: capitalize;
}

.role-user {
  background: rgba(59, 130, 246, 0.15);
  color: #93c5fd;
}

.role-admin {
  background: rgba(245, 158, 11, 0.15);
  color: #fbbf24;
}

.role-super_admin {
  background: rgba(248, 113, 113, 0.15);
  color: #fda4af;
}

.action-btn {
  border: none;
  border-radius: 999px;
  padding: 0.55rem 1rem;
  cursor: pointer;
  color: #fff;
  font-weight: 600;
}

.edit {
  background: #2563eb;
  margin-right: 0.5rem;
}

.delete {
  background: #ef4444;
}

.loading-block {
  padding: 2rem;
  text-align: center;
  color: #cbd5e1;
  background: rgba(255, 255, 255, 0.04);
  border-radius: 24px;
}

/* Mobile Card Layout */
.users-cards {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.user-card {
  background: rgba(255, 255, 255, 0.04);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 16px;
  padding: 1.25rem;
  transition: all 0.25s ease;
}

.user-card:hover {
  background: rgba(255, 255, 255, 0.06);
  border-color: rgba(96, 165, 250, 0.2);
  transform: translateY(-2px);
  box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
}

.user-card-header {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}

.user-avatar {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  background: linear-gradient(135deg, #60a5fa, #3b82f6);
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: 700;
  font-size: 1.125rem;
  color: white;
  flex-shrink: 0;
}

.user-info {
  flex: 1;
  min-width: 0;
}

.user-info h3 {
  margin: 0 0 0.25rem 0;
  font-size: 1.125rem;
  font-weight: 600;
  color: #f8fafc;
}

.user-card-body {
  margin-bottom: 1rem;
}

.user-detail {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.5rem 0;
  border-bottom: 1px solid rgba(255, 255, 255, 0.06);
}

.user-detail:last-child {
  border-bottom: none;
}

.user-detail .label {
  font-size: 0.875rem;
  color: #94a3b8;
  font-weight: 500;
}

.user-detail .value {
  font-size: 0.875rem;
  color: #cbd5e1;
  font-weight: 600;
  text-align: right;
  word-break: break-all;
}

.user-card-actions {
  display: flex;
  gap: 0.5rem;
  flex-wrap: wrap;
}

/* Responsive Visibility */
.desktop-only {
  display: block;
}

.mobile-only {
  display: none;
}

@media (max-width: 768px) {
  .desktop-only {
    display: none;
  }

  .mobile-only {
    display: block;
  }
}

.modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.84);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-card {
  width: min(420px, calc(100% - 2rem));
  padding: 2rem;
  border-radius: 28px;
  background: #0f172a;
  border: 1px solid rgba(255, 255, 255, 0.08);
  box-shadow: 0 35px 120px rgba(15, 23, 42, 0.35);
}

.modal-card h3 {
  margin-bottom: 1rem;
}

.modal-card p {
  color: #cbd5e1;
  margin-bottom: 1.25rem;
}

.modal-card select {
  width: 100%;
  padding: 0.9rem 1rem;
  border-radius: 18px;
  border: 1px solid rgba(148, 163, 184, 0.18);
  background: #111827;
  color: #e2e8f0;
  margin-bottom: 1.5rem;
}

.no-results {
  padding: 2rem;
  text-align: center;
  color: #cbd5e1;
  background: rgba(255, 255, 255, 0.04);
  border-radius: 24px;
}

@media (max-width: 900px) {
  .page-top {
    flex-direction: column;
    align-items: stretch;
    gap: 1rem;
  }

  .top-actions {
    flex-direction: column;
    gap: 0.75rem;
  }

  .search-input {
    width: 100%;
  }

  .users-table-wrap {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
  }

  .users-table {
    min-width: 600px;
  }

  .users-table th,
  .users-table td {
    padding: 0.5rem;
    font-size: 0.875rem;
  }

  .modal-card {
    margin: 1rem;
    width: calc(100vw - 2rem);
    max-width: none;
  }
}

@media (max-width: 768px) {
  .admin-users-page {
    padding: 1rem;
  }

  .page-top h1 {
    font-size: 1.5rem;
  }

  .page-top p {
    font-size: 0.875rem;
  }

  .users-table th,
  .users-table td {
    padding: 0.375rem;
    font-size: 0.8125rem;
  }

  .action-btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
  }

  .role-pill {
    padding: 0.25rem 0.5rem;
    font-size: 0.75rem;
  }

  /* Mobile card styles */
  .user-card {
    padding: 1rem;
  }

  .user-card-header {
    gap: 0.75rem;
    margin-bottom: 0.75rem;
  }

  .user-avatar {
    width: 40px;
    height: 40px;
    font-size: 1rem;
  }

  .user-info h3 {
    font-size: 1rem;
  }

  .user-detail {
    padding: 0.375rem 0;
  }

  .user-detail .label,
  .user-detail .value {
    font-size: 0.8125rem;
  }

  .user-card-actions {
    gap: 0.375rem;
  }

  .user-card-actions .action-btn {
    flex: 1;
    min-width: 0;
  }
}

@media (max-width: 480px) {
  .admin-users-page {
    padding: 0.5rem;
  }

  .page-top {
    gap: 0.75rem;
  }

  .page-top h1 {
    font-size: 1.25rem;
  }

  .users-table {
    font-size: 0.75rem;
  }

  .users-table th,
  .users-table td {
    padding: 0.25rem;
  }

  .modal-card {
    margin: 0.5rem;
    padding: 1rem;
  }

  .modal-card h3 {
    font-size: 1.125rem;
  }

  /* Mobile card styles for small screens */
  .user-card {
    padding: 0.875rem;
  }

  .user-card-header {
    gap: 0.625rem;
    margin-bottom: 0.625rem;
  }

  .user-avatar {
    width: 36px;
    height: 36px;
    font-size: 0.875rem;
  }

  .user-info h3 {
    font-size: 0.9375rem;
  }

  .user-detail {
    padding: 0.3125rem 0;
  }

  .user-detail .label,
  .user-detail .value {
    font-size: 0.75rem;
  }

  .user-card-actions {
    gap: 0.25rem;
  }
}
</style>
