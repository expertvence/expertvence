<template>
  <div class="admin-panel">
    <!-- Navigation Bar -->
    <nav class="admin-navbar">
      <div class="navbar-container">
        <h1 class="logo">Admin Panel</h1>
        <div class="nav-right">
          <span class="user-info">{{ currentUser?.name }} ({{ currentUser?.role }})</span>
          <button @click="logout" class="logout-btn">Logout</button>
        </div>
      </div>
    </nav>

    <!-- Sidebar Menu -->
    <div class="admin-container">
      <aside class="sidebar">
        <ul class="menu">
          <li :class="{ active: activeTab === 'dashboard' }">
            <a @click="activeTab = 'dashboard'">📊 Dashboard</a>
          </li>
          <li :class="{ active: activeTab === 'users' }">
            <a @click="activeTab = 'users'">👥 Users</a>
          </li>
          <li v-if="currentUser?.role === 'super_admin'" :class="{ active: activeTab === 'settings' }">
            <a @click="activeTab = 'settings'">⚙️ Settings</a>
          </li>
        </ul>
      </aside>

      <!-- Main Content -->
      <main class="admin-content">
        <!-- Dashboard Tab -->
        <div v-if="activeTab === 'dashboard'" class="tab-content">
          <h2>Dashboard</h2>
          <div class="stats-grid">
            <div class="stat-card">
              <h3>Total Users</h3>
              <p class="stat-value">{{ dashboard.total_users }}</p>
            </div>
            <div class="stat-card">
              <h3>Super Admins</h3>
              <p class="stat-value">{{ dashboard.super_admins }}</p>
            </div>
            <div class="stat-card">
              <h3>Admins</h3>
              <p class="stat-value">{{ dashboard.admins }}</p>
            </div>
            <div class="stat-card">
              <h3>Regular Users</h3>
              <p class="stat-value">{{ dashboard.regular_users }}</p>
            </div>
          </div>
        </div>

        <!-- Users Tab -->
        <div v-if="activeTab === 'users'" class="tab-content">
          <h2>Manage Users</h2>
          
          <div class="search-bar">
            <input 
              v-model="searchQuery" 
              type="text" 
              placeholder="Search users by name or email..."
              @input="filterUsers"
            />
          </div>

          <div v-if="loading" class="loading">Loading users...</div>

          <table v-else class="users-table">
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
                  <span 
                    :class="['role-badge', `role-${user.role}`]"
                  >
                    {{ user.role }}
                  </span>
                </td>
                <td>
                  <div class="action-buttons">
                    <button 
                      v-if="currentUser?.role === 'super_admin' && user.id !== currentUser.id"
                      @click="editUserRole(user)" 
                      class="btn btn-edit"
                    >
                      Edit
                    </button>
                    <button 
                      v-if="currentUser?.role === 'super_admin' && user.id !== currentUser.id && user.role !== 'super_admin'"
                      @click="deleteUser(user.id)" 
                      class="btn btn-delete"
                    >
                      Delete
                    </button>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Settings Tab (Super Admin Only) -->
        <div v-if="activeTab === 'settings' && currentUser?.role === 'super_admin'" class="tab-content">
          <h2>Admin Settings</h2>
          <div class="settings-section">
            <p>Configure admin panel settings here.</p>
            <p>Current user role: <strong>{{ currentUser?.role }}</strong></p>
          </div>
        </div>
      </main>
    </div>

    <!-- Edit Role Modal -->
    <div v-if="showEditModal" class="modal-overlay" @click.self="closeEditModal">
      <div class="modal">
        <h3>Update User Role</h3>
        <p>User: <strong>{{ editingUser?.name }}</strong></p>
        
        <div class="form-group">
          <label>Select Role:</label>
          <select v-model="newRole">
            <option value="user">User</option>
            <option value="admin">Admin</option>
            <option value="super_admin">Super Admin</option>
          </select>
        </div>

        <div class="modal-actions">
          <button @click="saveUserRole" class="btn btn-primary">Save Changes</button>
          <button @click="closeEditModal" class="btn btn-secondary">Cancel</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted, ref, computed } from 'vue';
import { useAuthStore } from '../stores/auth';

export default {
  name: 'AdminPanel',
  setup() {
    const activeTab = ref('dashboard');
    const users = ref([]);
    const filteredUsers = ref([]);
    const dashboard = ref({
      total_users: 0,
      super_admins: 0,
      admins: 0,
      regular_users: 0
    });

    const loading = ref(false);
    const searchQuery = ref('');
    const showEditModal = ref(false);
    const editingUser = ref(null);
    const newRole = ref('user');

    const auth = useAuthStore();
    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api';

    const headers = computed(() => ({
      'Authorization': `Bearer ${auth.token}`,
      'Content-Type': 'application/json'
    }));

    const currentUser = computed(() => auth.user);

    const fetchDashboard = async () => {
      try {
        const response = await fetch(`${apiUrl}/admin/dashboard`, { headers: headers.value });
        if (response.ok) {
          const data = await response.json();
          dashboard.value = data.data;
        } else if (response.status === 401) {
          // Token expired, redirect will be handled by axios interceptor
          return;
        }
      } catch (error) {
        console.error('Error fetching dashboard:', error);
      }
    };

    const fetchUsers = async () => {
      loading.value = true;
      try {
        const response = await fetch(`${apiUrl}/admin/users`, { headers: headers.value });
        if (response.ok) {
          const data = await response.json();
          users.value = data.data.data;
          filteredUsers.value = data.data.data;
        } else if (response.status === 401) {
          // Token expired, redirect will be handled by axios interceptor
          return;
        }
      } catch (error) {
        console.error('Error fetching users:', error);
      } finally {
        loading.value = false;
      }
    };

    const filterUsers = () => {
      if (!searchQuery.value) {
        filteredUsers.value = users.value;
      } else {
        const query = searchQuery.value.toLowerCase();
        filteredUsers.value = users.value.filter(user =>
          user.name.toLowerCase().includes(query) ||
          user.email.toLowerCase().includes(query)
        );
      }
    };

    const editUserRole = (user) => {
      editingUser.value = user;
      newRole.value = user.role;
      showEditModal.value = true;
    };

    const saveUserRole = async () => {
      if (!editingUser.value) return;

      try {
        const response = await fetch(
          `${apiUrl}/admin/users/${editingUser.value.id}/role`,
          {
            method: 'PUT',
            headers: headers.value,
            body: JSON.stringify({ role: newRole.value })
          }
        );

        if (response.ok) {
          alert('User role updated successfully!');
          closeEditModal();
          fetchUsers();
          fetchDashboard();
        } else if (response.status === 401) {
          // Token expired, redirect will be handled by axios interceptor
          return;
        } else {
          alert('Error updating user role');
        }
      } catch (error) {
        console.error('Error updating user role:', error);
      }
    };

    const deleteUser = async (userId) => {
      if (!confirm('Are you sure you want to delete this user?')) return;

      try {
        const response = await fetch(`${apiUrl}/admin/users/${userId}`, {
          method: 'DELETE',
          headers: headers.value
        });

        if (response.ok) {
          alert('User deleted successfully!');
          fetchUsers();
          fetchDashboard();
        } else if (response.status === 401) {
          // Token expired, redirect will be handled by axios interceptor
          return;
        } else {
          alert('Error deleting user');
        }
      } catch (error) {
        console.error('Error deleting user:', error);
      }
    };

    const closeEditModal = () => {
      showEditModal.value = false;
      editingUser.value = null;
    };

    const logout = async () => {
      try {
        await fetch(`${apiUrl}/auth/logout`, {
          method: 'POST',
          headers: headers.value
        });
        auth.logout(); // Use auth store logout
      } catch (error) {
        console.error('Error logging out:', error);
        auth.logout(); // Fallback to auth store logout
      }
    };

    onMounted(() => {
      // Check if user is authenticated
      if (!auth.isLoggedIn) {
        window.location.href = '/login';
        return;
      }

      // Check if user has admin role
      if (!auth.user || !['admin', 'super_admin'].includes(auth.user.role)) {
        window.location.href = '/';
        return;
      }

      fetchDashboard();
      fetchUsers();
    });

    return {
      activeTab,
      currentUser,
      dashboard,
      users,
      filteredUsers,
      loading,
      searchQuery,
      showEditModal,
      editingUser,
      newRole,
      filterUsers,
      editUserRole,
      saveUserRole,
      deleteUser,
      closeEditModal,
      logout
    };
  }
};
</script>

<style scoped>
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.admin-panel {
  display: flex;
  flex-direction: column;
  min-height: 100vh;
  background: #f5f5f5;
}

/* Navbar */
.admin-navbar {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 1rem 2rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.navbar-container {
  max-width: 1400px;
  margin: 0 auto;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo {
  font-size: 1.8rem;
  font-weight: bold;
}

.nav-right {
  display: flex;
  align-items: center;
  gap: 2rem;
}

.user-info {
  font-size: 0.95rem;
}

.logout-btn {
  background: rgba(255, 255, 255, 0.2);
  color: white;
  border: 1px solid white;
  padding: 0.5rem 1rem;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.3s;
}

.logout-btn:hover {
  background: rgba(255, 255, 255, 0.3);
}

/* Container */
.admin-container {
  display: flex;
  flex: 1;
  max-width: 1400px;
  margin: 0 auto;
  width: 100%;
  gap: 2rem;
  padding: 2rem;
}

/* Sidebar */
.sidebar {
  width: 250px;
  background: white;
  border-radius: 8px;
  padding: 1rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  height: fit-content;
  position: sticky;
  top: 20px;
}

.menu {
  list-style: none;
}

.menu li {
  margin-bottom: 0.5rem;
}

.menu a {
  display: block;
  padding: 0.875rem 1rem;
  color: #333;
  text-decoration: none;
  border-radius: 4px;
  cursor: pointer;
  transition: all 0.3s;
}

.menu a:hover {
  background: #f0f0f0;
}

.menu li.active a {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
}

/* Main Content */
.admin-content {
  flex: 1;
  background: white;
  border-radius: 8px;
  padding: 2rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.tab-content h2 {
  margin-bottom: 1.5rem;
  color: #333;
}

/* Stats Grid */
.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1.5rem;
  margin-bottom: 2rem;
}

.stat-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 2rem;
  border-radius: 8px;
  text-align: center;
  box-shadow: 0 4px 12px rgba(102, 126, 234, 0.2);
}

.stat-card h3 {
  font-size: 0.95rem;
  font-weight: 500;
  opacity: 0.9;
  margin-bottom: 1rem;
}

.stat-value {
  font-size: 2.5rem;
  font-weight: bold;
}

/* Search Bar */
.search-bar {
  margin-bottom: 2rem;
}

.search-bar input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 0.95rem;
}

.search-bar input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

/* Table */
.users-table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 1rem;
}

.users-table thead {
  background: #f9f9f9;
}

.users-table th,
.users-table td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid #eee;
}

.users-table th {
  font-weight: 600;
  color: #333;
}

.users-table tbody tr:hover {
  background: #f5f5f5;
}

/* Role Badge */
.role-badge {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 500;
}

.role-badge.role-super_admin {
  background: #ff6b6b;
  color: white;
}

.role-badge.role-admin {
  background: #ffa94d;
  color: white;
}

.role-badge.role-user {
  background: #74c0fc;
  color: white;
}

/* Buttons */
.action-buttons {
  display: flex;
  gap: 0.5rem;
}

.btn {
  padding: 0.5rem 1rem;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  font-size: 0.85rem;
  transition: all 0.3s;
}

.btn-edit {
  background: #667eea;
  color: white;
}

.btn-edit:hover {
  background: #5568d3;
}

.btn-delete {
  background: #ff6b6b;
  color: white;
}

.btn-delete:hover {
  background: #ee5a52;
}

.btn-primary {
  background: #667eea;
  color: white;
}

.btn-primary:hover {
  background: #5568d3;
}

.btn-secondary {
  background: #ddd;
  color: #333;
}

.btn-secondary:hover {
  background: #ccc;
}

/* Modal */
.modal-overlay {
  display: flex;
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  justify-content: center;
  align-items: center;
  z-index: 1000;
}

.modal {
  background: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
  max-width: 400px;
  width: 90%;
}

.modal h3 {
  margin-bottom: 1rem;
  color: #333;
}

.modal p {
  margin-bottom: 1rem;
  color: #666;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #333;
}

.form-group select {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 0.95rem;
}

.modal-actions {
  display: flex;
  gap: 1rem;
  justify-content: flex-end;
}

/* Loading */
.loading {
  text-align: center;
  padding: 2rem;
  color: #666;
}

/* Settings */
.settings-section {
  background: #f9f9f9;
  padding: 2rem;
  border-radius: 8px;
  line-height: 1.6;
}

@media (max-width: 768px) {
  .admin-container {
    flex-direction: column;
    gap: 1rem;
    padding: 1rem;
  }

  .sidebar {
    width: 100%;
    position: sticky;
    top: unset;
  }

  .stats-grid {
    grid-template-columns: 1fr;
  }

  .users-table {
    font-size: 0.85rem;
  }

  .users-table th,
  .users-table td {
    padding: 0.75rem 0.5rem;
  }

  .navbar-container {
    flex-direction: column;
    gap: 1rem;
  }
}
</style>
