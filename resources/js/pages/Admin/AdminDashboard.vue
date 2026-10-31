<template>
  <div class="admin-layout">
    <header class="mobile-header">
      <button class="menu-toggle" type="button" @click="sidebarOpen = !sidebarOpen" aria-label="Toggle menu">?</button>
      <strong>Expertvence Admin</strong>
      <router-link to="/" target="_blank">Live site</router-link>
    </header>

    <aside class="sidebar" :class="{ open: sidebarOpen }">
      <div class="brand"><span class="badge">ADMIN</span><div><strong>Expertvence</strong><small>Management Panel</small></div></div>
      <nav>
        <button v-for="item in navItems" :key="item.id" :class="{ active: tab === item.id }" @click="selectTab(item.id)">
          <span>{{ item.icon }}</span>{{ item.label }}
          <small v-if="item.id === 'projects' && stats.projects_count">{{ stats.projects_count }}</small>
          <small v-if="item.id === 'members' && stats.members_count">{{ stats.members_count }}</small>
        </button>
      </nav>
      <div class="sidebar-footer">
        <router-link to="/" target="_blank">View live website</router-link>
        <button class="logout" @click="logout">Log out</button>
      </div>
    </aside>

    <main class="main-content">
      <header class="page-header">
        <h1>{{ currentTitle }}</h1>
        <div class="user-pill"><i></i>{{ user?.email || 'admin@expertvence.com' }}</div>
      </header>
      <div v-if="toast.message" class="toast" :class="toast.type">{{ toast.message }}<button @click="toast.message = ''">�</button></div>

      <section v-if="tab === 'dashboard'">
        <div class="stats-grid">
          <article class="stat"><span>Total Income</span><strong>{{ money(stats.total_income) }}</strong></article>
          <article class="stat"><span>Total Expenses</span><strong>{{ money(stats.total_expense) }}</strong></article>
          <article class="stat"><span>Net Profit</span><strong>{{ money(stats.net_profit) }}</strong></article>
          <article class="stat"><span>Profit Distributed</span><strong>{{ money(stats.total_distributed) }}</strong></article>
        </div>
        <article class="panel">
          <div class="panel-heading"><div><h2>Profit by Partner</h2><p>Summary of total profit distributed to each partner.</p></div><button class="primary" @click="openModal('distribution')">Distribute Profit</button></div>
          <div v-if="stats.members_summary?.length" class="partner-summary">
            <div v-for="member in stats.members_summary" :key="member.id" class="partner-chip"><img v-if="member.image" :src="member.image" :alt="member.name"><span v-else class="avatar">{{ member.name?.charAt(0) }}</span><div><strong>{{ member.name }}</strong><small>{{ member.designation }}</small></div><b>{{ money(member.total_received) }}</b></div>
          </div>
          <p v-else class="empty">No partners yet. Add one in the Partners section.</p>
        </article>
        <div class="two-col">
          <article class="panel"><div class="panel-heading"><h2>Recent Transactions</h2><button class="secondary" @click="selectTab('transactions')">View all</button></div><div class="table-wrap"><table><thead><tr><th>Type</th><th>Project</th><th>Amount</th><th>Date</th></tr></thead><tbody><tr v-for="row in stats.recent_transactions || []" :key="row.id"><td>{{ titleCase(row.type) }}</td><td>{{ row.project?.name || 'General' }}</td><td>{{ money(row.amount) }}</td><td>{{ row.transaction_date }}</td></tr><tr v-if="!stats.recent_transactions?.length"><td colspan="4" class="empty">No transactions found.</td></tr></tbody></table></div></article>
          <article class="panel"><div class="panel-heading"><h2>Recent Projects</h2><button class="secondary" @click="selectTab('projects')">View all</button></div><div class="table-wrap"><table><thead><tr><th>Project</th><th>Client</th><th>Budget</th><th>Status</th></tr></thead><tbody><tr v-for="row in stats.recent_projects || []" :key="row.id"><td>{{ row.name }}</td><td>{{ row.client_name }}</td><td>{{ money(row.budget) }}</td><td>{{ titleCase(row.status) }}</td></tr><tr v-if="!stats.recent_projects?.length"><td colspan="4" class="empty">No projects found.</td></tr></tbody></table></div></article>
        </div>
      </section>

      <section v-else-if="tab === 'projects'" class="panel">
        <div class="panel-heading"><div><h2>Software Projects</h2><p>Manage projects, client details, links, and budgets.</p></div><button class="primary" @click="openModal('project')">Add Project</button></div>
        <div class="table-wrap"><table><thead><tr><th>Project</th><th>Client</th><th>Address / Phone</th><th>Live link</th><th>Budget</th><th>Income / Expense</th><th>Status</th><th>Actions</th></tr></thead><tbody>
          <tr v-for="p in projects" :key="p.id"><td><strong>{{ p.name }}</strong></td><td>{{ p.client_name }}</td><td>{{ p.client_address || '�' }}<small>{{ p.client_phone }}</small></td><td><a v-if="p.project_url" :href="p.project_url" target="_blank" rel="noopener">Visit link</a><span v-else>�</span></td><td>{{ money(p.budget) }}</td><td><span class="income">{{ money(p.income_total) }}</span><small class="expense">{{ money(p.expense_total) }}</small></td><td><span class="status">{{ titleCase(p.status) }}</span></td><td class="actions"><button @click="openModal('project', p)" aria-label="Edit project">Edit</button><button class="danger-text" @click="deleteProject(p)" aria-label="Delete project">Delete</button></td></tr>
          <tr v-if="!projects.length"><td colspan="8" class="empty">No projects yet. Add your first project.</td></tr>
        </tbody></table></div>
      </section>

      <section v-else-if="tab === 'transactions'" class="panel">
        <div class="panel-heading"><div><h2>Income & Expenses</h2><p>Track client payments and project expenses.</p></div><button class="primary" @click="openModal('transaction')">Add Transaction</button></div>
        <div class="filter-row"><button v-for="f in ['all','income','expense']" :key="f" :class="{ chosen: transactionFilter === f }" @click="transactionFilter = f">{{ titleCase(f) }}</button></div>
        <div class="table-wrap"><table><thead><tr><th>Type</th><th>Project</th><th>Amount</th><th>Date</th><th>Description</th><th>Actions</th></tr></thead><tbody>
          <tr v-for="t in filteredTransactions" :key="t.id"><td>{{ titleCase(t.type) }}</td><td>{{ t.project_name }}</td><td>{{ money(t.amount) }}</td><td>{{ t.transaction_date }}</td><td>{{ t.description || '�' }}</td><td class="actions"><button @click="openModal('transaction', t)">Edit</button><button class="danger-text" @click="deleteTransaction(t)">Delete</button></td></tr><tr v-if="!filteredTransactions.length"><td colspan="6" class="empty">No transactions found.</td></tr>
        </tbody></table></div>
      </section>

      <section v-else-if="tab === 'members'" class="panel">
        <div class="panel-heading"><div><h2>Partners</h2><p>Manage partner names, roles, and contact details.</p></div><button class="primary" @click="openModal('member')">Add Partner</button></div>
        <div class="table-wrap"><table><thead><tr><th>Partner</th><th>Role</th><th>Contact</th><th>Total Received</th><th>Actions</th></tr></thead><tbody>
          <tr v-for="m in members" :key="m.id"><td class="person"><img v-if="m.image" :src="m.image" :alt="m.name"><span v-else class="avatar">{{ m.name?.charAt(0) }}</span><strong>{{ m.name }}</strong></td><td>{{ m.designation }}</td><td>{{ m.phone || '�' }}<small>{{ m.email }}</small></td><td>{{ money(m.total_received) }}</td><td class="actions"><button @click="openModal('member', m)">Edit</button><button class="danger-text" @click="deleteMember(m)">Delete</button></td></tr><tr v-if="!members.length"><td colspan="5" class="empty">No partners have been added yet.</td></tr>
        </tbody></table></div>
      </section>

      <section v-else-if="tab === 'profit'" class="panel">
        <div class="panel-heading"><div><h2>Profit Distributions</h2><p>Record and manage partner profit distributions.</p></div><button class="primary" @click="openModal('distribution')">Distribute Profit</button></div>
        <div class="table-wrap"><table><thead><tr><th>Partner</th><th>Role</th><th>Amount</th><th>Date</th><th>Note</th><th>Actions</th></tr></thead><tbody>
          <tr v-for="d in distributions" :key="d.id"><td>{{ d.member_name }}</td><td>{{ d.member_designation }}</td><td>{{ money(d.amount) }}</td><td>{{ d.distribution_date }}</td><td>{{ d.comment || '�' }}</td><td class="actions"><button @click="openModal('distribution', d)">Edit</button><button class="danger-text" @click="deleteDistribution(d)">Delete</button></td></tr><tr v-if="!distributions.length"><td colspan="6" class="empty">No profit distributions have been recorded.</td></tr>
        </tbody></table></div>
      </section>

            <section v-else-if="tab === 'demo_views'" class="panel">
        <div class="panel-heading"><div><h2>Demo Views</h2><p>Recent visitor activity for software demos (up to 500 records).</p></div></div>
        <div class="table-wrap"><table><thead><tr><th>Demo project</th><th>Visitor</th><th>IP address</th><th>Viewed at</th><th>Browser</th></tr></thead><tbody>
          <tr v-for="view in demoViews" :key="view.id"><td>{{ view.demo_title }}</td><td>{{ view.viewer_name }}<small>{{ view.viewer_email || 'Not signed in' }}</small></td><td>{{ view.visitor_ip || 'Unknown' }}</td><td>{{ view.viewed_at ? new Date(view.viewed_at).toLocaleString() : '' }}</td><td>{{ view.user_agent || 'Unknown' }}</td></tr>
          <tr v-if="!demoViews.length"><td colspan="5" class="empty">No demo views have been recorded yet.</td></tr>
        </tbody></table></div>
      </section>
<section v-else-if="tab === 'demos'" class="panel">
        <div class="panel-heading"><div><h2>Software Demo Projects</h2><p>Add a homepage demo project with separate Website, Admin, and User URLs and demo login details.</p></div><button class="primary" @click="openModal('demo')">Add Demo Project</button></div>
        <div class="demo-admin-grid">
          <article v-for="demo in demos" :key="demo.id" class="demo-admin-card">
            <div class="demo-admin-top"><span class="demo-icon">{{ demo.icon }}</span><span class="status" :class="{ inactive: !demo.is_active }">{{ demo.is_active ? 'Visible' : 'Hidden' }}</span></div>
            <small>{{ demo.tag }}</small><h3>{{ demo.title }}</h3><p>{{ demo.description }}</p>
            <ul><li v-for="(feature, index) in demo.features" :key="index">{{ feature }}</li></ul>
            <a v-if="demo.demo_url" :href="demo.demo_url" target="_blank" rel="noopener noreferrer">Open demo</a><span v-else class="no-demo">No demo URL set</span>
            <div class="demo-admin-actions"><button class="secondary" @click="openModal('demo', demo)">Edit</button><button class="danger-text" @click="deleteDemo(demo)">Delete</button></div>
          </article>
          <p v-if="!demos.length" class="empty">No software cards have been added yet.</p>
        </div>
      </section>
      <section v-else class="settings-grid">
        <article class="panel settings-panel"><div class="panel-heading"><div><h2>Brand Logo & Site Details</h2><p>Update your website branding and contact information.</p></div></div>
          <form class="form-grid" @submit.prevent="saveSettings"><label>Site name<input v-model="siteForm.site_name"></label><label>Tagline<input v-model="siteForm.site_tagline"></label><label>Primary email<input v-model="siteForm.site_email" type="email"></label><label>Primary phone<input v-model="siteForm.site_phone"></label><label class="wide">Office address<input v-model="siteForm.site_address"></label><label>Expertvence WhatsApp number<input v-model="siteForm.whatsapp_number" placeholder="+8801XXXXXXXXX"></label><label>Consultant WhatsApp number<input v-model="siteForm.whatsapp_consultant_number" placeholder="+8801XXXXXXXXX"></label><label>Facebook URL<input v-model="siteForm.facebook_url"></label><label>LinkedIn URL<input v-model="siteForm.linkedin_url"></label><label>X / Twitter URL<input v-model="siteForm.twitter_url"></label><label class="wide">Footer description<textarea v-model="siteForm.footer_description" rows="3"></textarea></label><label class="wide">Upload logo<input type="file" accept="image/*,.svg" @change="selectLogo"></label><div class="wide logo-preview-wrap"><span class="logo-preview-label">Logo preview</span><div v-if="logoPreview || siteForm.site_logo" class="logo-preview"><img :src="logoPreview || siteForm.site_logo" alt="Website logo preview"><span>{{ logoFile ? logoFile.name : "" }}</span></div><p v-else class="logo-preview-empty">No logo uploaded yet.</p></div><div class="wide settings-actions"><button type="button" class="secondary" @click="resetLogo">Use default logo</button><button class="primary" :disabled="savingSettings">{{ savingSettings ? 'Saving�' : 'Save Settings' }}</button></div></form>
        </article>
      </section>
    </main>

    <div v-if="modal" class="modal-backdrop" @click.self="modal = null">
      <form class="modal" @submit.prevent="saveModal">
        <h2>{{ modalTitle }}</h2>
        <template v-if="modal.type === 'demo'"><label>Icon / emoji<input v-model="demoForm.icon" maxlength="30"></label><label>Category tag<input v-model="demoForm.tag" required></label><label class="wide">Card title<input v-model="demoForm.title" required></label><label class="wide">Description<textarea v-model="demoForm.description" rows="3" required></textarea></label><label class="wide">Features (one per line)<textarea v-model="demoForm.featuresText" rows="5" required></textarea></label><label class="wide">Website URL<input v-model="demoForm.website_url" type="url" placeholder="https://example.com"></label><label class="wide demo-form-heading">Admin panel demo</label><label class="wide">Admin panel URL<input v-model="demoForm.admin_demo_url" type="url" placeholder="https://example.com/admin"></label><label>Admin demo Gmail<input v-model="demoForm.admin_demo_email" type="email" placeholder="admin-demo@example.com"></label><label>Admin demo password<input v-model="demoForm.admin_demo_password" type="text" autocomplete="off"></label><label class="wide demo-form-heading">User panel demo</label><label class="wide">User panel URL<input v-model="demoForm.user_demo_url" type="url" placeholder="https://example.com/login"></label><label>User demo Gmail<input v-model="demoForm.user_demo_email" type="email" placeholder="user-demo@example.com"></label><label>User demo password<input v-model="demoForm.user_demo_password" type="text" autocomplete="off"></label><label>Display order<input v-model.number="demoForm.sort_order" type="number" min="0"></label><label class="check-label"><input v-model="demoForm.is_active" type="checkbox"> Show on homepage</label></template>        <template v-else-if="modal.type === 'project'"><label>Project name<input v-model="projectForm.name" required></label><label>Client name<input v-model="projectForm.client_name" required></label><label>Client address<input v-model="projectForm.client_address"></label><label>Client phone<input v-model="projectForm.client_phone"></label><label>Project URL<input v-model="projectForm.project_url" type="url"></label><label>Budget (BDT)<input v-model.number="projectForm.budget" type="number" min="0" step="0.01"></label><label>Status<select v-model="projectForm.status"><option value="active">Active</option><option value="completed">Completed</option><option value="on_hold">On hold</option></select></label></template>
        <template v-else-if="modal.type === 'transaction'"><label>Type<select v-model="transactionForm.type"><option value="income">Income</option><option value="expense">Expense</option></select></label><label>Project<select v-model="transactionForm.project_id"><option value="">General / Direct</option><option v-for="p in projects" :key="p.id" :value="p.id">{{ p.name }}</option></select></label><label>Amount (BDT)<input v-model.number="transactionForm.amount" type="number" min="0.01" step="0.01" required></label><label>Date<input v-model="transactionForm.transaction_date" type="date" required></label><label class="wide">Description<textarea v-model="transactionForm.description" rows="3"></textarea></label></template>
        <template v-else-if="modal.type === 'member'"><label>Partner name<input v-model="memberForm.name" required></label><label>Role<input v-model="memberForm.designation" required></label><label>Phone<input v-model="memberForm.phone"></label><label>Email<input v-model="memberForm.email" type="email"></label><label class="wide">Profile photo<input type="file" accept="image/*" @change="selectMemberImage"></label></template>
        <template v-else><label>Partner<select v-model="distributionForm.member_id" required><option value="">Select a partner</option><option v-for="m in members" :key="m.id" :value="m.id">{{ m.name }}</option></select></label><label>Amount (BDT)<input v-model.number="distributionForm.amount" type="number" min="0.01" step="0.01" required></label><label>Date<input v-model="distributionForm.distribution_date" type="date" required></label><label class="wide">Comment<textarea v-model="distributionForm.comment" rows="3"></textarea></label></template>
        <div class="modal-actions"><button type="button" class="secondary" @click="modal = null">Cancel</button><button class="primary" :disabled="modalLoading">{{ modalLoading ? 'Saving�' : 'Save' }}</button></div>
      </form>
    </div>
  </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
import { useSettingsStore } from '@/stores/settings'

const router = useRouter()
const settingsStore = useSettingsStore()
const token = ref(localStorage.getItem('admin_token'))
const user = ref(null)
const tab = ref('dashboard')
const sidebarOpen = ref(false)
const stats = ref({})
const projects = ref([])
const demos = ref([])
const demoViews = ref([])
const transactions = ref([])
const members = ref([])
const distributions = ref([])
const transactionFilter = ref('all')
const modal = ref(null)
const modalLoading = ref(false)
const savingSettings = ref(false)
const logoFile = ref(null)
const logoPreview = ref('')
const memberImageFile = ref(null)
const toast = reactive({ message: '', type: 'success' })
const siteForm = reactive({ ...settingsStore.settings })
const projectForm = reactive({ id: null, name: '', client_name: '', client_address: '', client_phone: '', project_url: '', budget: '', status: 'active' })
const transactionForm = reactive({ id: null, type: 'income', project_id: '', amount: '', transaction_date: new Date().toISOString().slice(0, 10), description: '' })
const memberForm = reactive({ id: null, name: '', designation: '', phone: '', email: '' })
const distributionForm = reactive({ id: null, member_id: '', amount: '', distribution_date: new Date().toISOString().slice(0, 10), comment: '' })
const demoForm = reactive({ id: null, icon: 'SW', tag: '', title: '', description: '', featuresText: '', demo_url: '', website_url: '', admin_demo_url: '', admin_demo_email: '', admin_demo_password: '', user_demo_url: '', user_demo_email: '', user_demo_password: '', sort_order: 0, is_active: true })
const navItems = [
  { id: 'dashboard', label: 'Dashboard', icon: 'D' },
  { id: 'projects', label: 'Projects', icon: 'P' },
  { id: 'demos', label: 'Software Demo Projects', icon: 'S' },
  { id: 'demo_views', label: 'Demo Views', icon: 'V' },
  { id: 'transactions', label: 'Income & Expenses', icon: 'T' },
  { id: 'members', label: 'Partners', icon: 'M' },
  { id: 'profit', label: 'Profit Sharing', icon: 'F' },
  { id: 'settings', label: 'Website Settings', icon: 'S' },
]
const titles = { dashboard: 'Dashboard Overview', projects: 'Project Management', demos: 'Software Demo Projects', demo_views: 'Demo Views', transactions: 'Income & Expenses', members: 'Partners', profit: 'Profit Distributions', settings: 'Website Settings' }
const currentTitle = computed(() => titles[tab.value])
const modalTitle = computed(() => {
  if (!modal.value) return ''
  const editing = Boolean(modal.value.data?.id)
  const names = { demo: editing ? 'Edit Demo Project' : 'Add Demo Project', project: editing ? 'Edit Project' : 'Add Project', transaction: editing ? 'Edit Transaction' : 'Add Transaction', member: editing ? 'Edit Partner' : 'Add Partner', distribution: editing ? 'Edit Distribution' : 'Distribute Profit' }
  return names[modal.value.type]
})
const filteredTransactions = computed(() => transactionFilter.value === 'all' ? transactions.value : transactions.value.filter(t => t.type === transactionFilter.value))
const money = value => `BDT ${Number(value || 0).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`
const titleCase = value => String(value || '').replace(/_/g, ' ').replace(/\b\w/g, char => char.toUpperCase())
const headers = () => ({ headers: { Authorization: `Bearer ${token.value}` } })
const showToast = (message, type = 'success') => { toast.message = message; toast.type = type }
const selectTab = id => { tab.value = id; sidebarOpen.value = false }
const logout = () => { localStorage.removeItem('admin_token'); localStorage.removeItem('admin_user'); router.push('/admin/login') }

const load = async (url) => (await axios.get(url, headers())).data?.data
const fetchStats = async () => { try { stats.value = await load('/api/admin/dashboard-stats') || {} } catch (error) { showToast('Could not load dashboard statistics.', 'error') } }
const fetchProjects = async () => { try { projects.value = await load('/api/admin/projects') || [] } catch (error) { showToast('Could not load projects.', 'error') } }
const fetchDemos = async () => { try { demos.value = await load('/api/admin/software-demos') || [] } catch (error) { showToast('Could not load ready software cards.', 'error') } }
const fetchDemoViews = async () => { try { demoViews.value = await load('/api/admin/software-demo-views') || [] } catch (error) { showToast('Could not load demo view history.', 'error') } }
const fetchTransactions = async () => { try { transactions.value = await load('/api/admin/transactions') || [] } catch (error) { showToast('Could not load transactions.', 'error') } }
const fetchMembers = async () => { try { members.value = await load('/api/admin/share-members') || [] } catch (error) { showToast('Could not load partners.', 'error') } }
const fetchDistributions = async () => { try { distributions.value = await load('/api/admin/profit-distributions') || [] } catch (error) { showToast('Could not load profit distributions.', 'error') } }
const refreshDashboardData = async () => { await Promise.all([fetchStats(), fetchProjects(), fetchDemos(), fetchDemoViews(), fetchTransactions(), fetchMembers(), fetchDistributions()]) }

const openModal = (type, item = null) => {
  const data = item || {}
  if (type === 'demo') Object.assign(demoForm, { id: data.id || null, icon: data.icon || 'SW', tag: data.tag || '', title: data.title || '', description: data.description || '', featuresText: (data.features || []).join('\n'), demo_url: data.demo_url || '', website_url: data.website_url || data.demo_url || '', admin_demo_url: data.admin_demo_url || '', admin_demo_email: data.admin_demo_email || '', admin_demo_password: data.admin_demo_password || '', user_demo_url: data.user_demo_url || '', user_demo_email: data.user_demo_email || '', user_demo_password: data.user_demo_password || '', sort_order: data.sort_order ?? demos.value.length + 1, is_active: data.is_active ?? true })
  if (type === 'project') Object.assign(projectForm, { id: data.id || null, name: data.name || '', client_name: data.client_name || '', client_address: data.client_address || '', client_phone: data.client_phone || '', project_url: data.project_url || '', budget: data.budget || '', status: data.status || 'active' })
  if (type === 'transaction') Object.assign(transactionForm, { id: data.id || null, type: data.type || 'income', project_id: data.project_id || '', amount: data.amount || '', transaction_date: data.transaction_date || new Date().toISOString().slice(0, 10), description: data.description || '' })
  if (type === 'member') { Object.assign(memberForm, { id: data.id || null, name: data.name || '', designation: data.designation || '', phone: data.phone || '', email: data.email || '' }); memberImageFile.value = null }
  if (type === 'distribution') Object.assign(distributionForm, { id: data.id || null, member_id: data.member_id || members.value[0]?.id || '', amount: data.amount || '', distribution_date: data.distribution_date || new Date().toISOString().slice(0, 10), comment: data.comment || '' })
  modal.value = { type, data }
}
const clearLogoPreview = () => {
  if (logoPreview.value.startsWith('blob:')) URL.revokeObjectURL(logoPreview.value)
  logoPreview.value = ''
}
const selectLogo = event => {
  clearLogoPreview()
  logoFile.value = event.target.files?.[0] || null
  if (logoFile.value) logoPreview.value = URL.createObjectURL(logoFile.value)
}
const selectMemberImage = event => { memberImageFile.value = event.target.files?.[0] || null }
const saveModal = async () => {
  if (!modal.value) return
  modalLoading.value = true
  try {
    const { type } = modal.value
    if (type === 'demo') {
      const body = { icon: demoForm.icon, tag: demoForm.tag, title: demoForm.title, description: demoForm.description, features: demoForm.featuresText.split(/\r?\n/).map(item => item.trim()).filter(Boolean), demo_url: demoForm.website_url || demoForm.demo_url || null, website_url: demoForm.website_url || null, admin_demo_url: demoForm.admin_demo_url || null, admin_demo_email: demoForm.admin_demo_email || null, admin_demo_password: demoForm.admin_demo_password || null, user_demo_url: demoForm.user_demo_url || null, user_demo_email: demoForm.user_demo_email || null, user_demo_password: demoForm.user_demo_password || null, sort_order: Number(demoForm.sort_order) || 0, is_active: demoForm.is_active }
      if (demoForm.id) await axios.put(`/api/admin/software-demos/${demoForm.id}`, body, headers()); else await axios.post('/api/admin/software-demos', body, headers())
    } else if (type === 'project') {
      const body = { ...projectForm }; const id = body.id; delete body.id
      if (id) await axios.put(`/api/admin/projects/${id}`, body, headers()); else await axios.post('/api/admin/projects', body, headers())
    } else if (type === 'transaction') {
      const body = { ...transactionForm }; const id = body.id; delete body.id
      if (id) await axios.put(`/api/admin/transactions/${id}`, body, headers()); else await axios.post('/api/admin/transactions', body, headers())
    } else if (type === 'member') {
      const body = new FormData(); Object.entries(memberForm).forEach(([key, value]) => { if (key !== 'id') body.append(key, value || '') }); if (memberImageFile.value) body.append('image_file', memberImageFile.value)
      const config = { headers: { Authorization: `Bearer ${token.value}`, 'Content-Type': 'multipart/form-data' } }
      if (memberForm.id) await axios.post(`/api/admin/share-members/${memberForm.id}`, body, config); else await axios.post('/api/admin/share-members', body, config)
    } else {
      const body = { ...distributionForm }; const id = body.id; delete body.id
      if (id) await axios.put(`/api/admin/profit-distributions/${id}`, body, headers()); else await axios.post('/api/admin/profit-distributions', body, headers())
    }
    modal.value = null; showToast('Changes saved successfully.'); await refreshDashboardData()
  } catch (error) { showToast(error.response?.data?.message || 'Could not save changes.', 'error') } finally { modalLoading.value = false }
}
const deleteDemo = async item => { if (!confirm(`Delete the "${item.title}" demo card?`)) return; try { await axios.delete(`/api/admin/software-demos/${item.id}`, headers()); showToast('Demo card deleted.'); await fetchDemos() } catch (error) { showToast('Could not delete the demo card.', 'error') } }
const deleteProject = async item => { if (!confirm(`Delete �${item.name}� and its transactions?`)) return; try { await axios.delete(`/api/admin/projects/${item.id}`, headers()); showToast('Project deleted.'); await refreshDashboardData() } catch (error) { showToast('Could not delete the project.', 'error') } }
const deleteTransaction = async item => { if (!confirm('Delete this transaction?')) return; try { await axios.delete(`/api/admin/transactions/${item.id}`, headers()); showToast('Transaction deleted.'); await refreshDashboardData() } catch (error) { showToast('Could not delete the transaction.', 'error') } }
const deleteMember = async item => { if (!confirm('Delete this partner and all related profit records?')) return; try { await axios.delete(`/api/admin/share-members/${item.id}`, headers()); showToast('Partner deleted.'); await refreshDashboardData() } catch (error) { showToast('Could not delete the partner.', 'error') } }
const deleteDistribution = async item => { if (!confirm('Delete this profit distribution?')) return; try { await axios.delete(`/api/admin/profit-distributions/${item.id}`, headers()); showToast('Distribution deleted.'); await refreshDashboardData() } catch (error) { showToast('Could not delete the distribution.', 'error') } }
const saveSettings = async () => {
  savingSettings.value = true
  const body = new FormData(); Object.entries(siteForm).forEach(([key, value]) => { if (key !== 'site_logo') body.append(key, value || '') }); if (logoFile.value) body.append('site_logo_file', logoFile.value); else if (!siteForm.site_logo) body.append('site_logo', '')
  try { const response = await settingsStore.updateSettings(body); if (response?.data) Object.assign(siteForm, response.data); logoFile.value = null; clearLogoPreview(); showToast('Website settings saved successfully.') } catch (error) { showToast(error.response?.data?.message || 'Could not save settings.', 'error') } finally { savingSettings.value = false }
}
const resetLogo = () => { siteForm.site_logo = ''; logoFile.value = null; clearLogoPreview() }

onMounted(async () => {
  if (!token.value) { router.push('/admin/login'); return }
  try { const saved = localStorage.getItem('admin_user'); if (saved) user.value = JSON.parse(saved) } catch {}
  await refreshDashboardData()
  try { const response = await axios.get('/api/admin/settings', headers()); if (response.data?.data) { Object.assign(siteForm, response.data.data); Object.assign(settingsStore.settings, response.data.data) } } catch {}
})
</script>

<style scoped>
* { box-sizing: border-box; }
.admin-layout { display: flex; height: 100vh; min-height: 100vh; overflow: hidden; background: #E7EFF3; color: #0f172a; font-family: Inter, -apple-system, BlinkMacSystemFont, sans-serif; }
.sidebar { width: 260px; flex: 0 0 260px; height: 100vh; display: flex; flex-direction: column; background: #0E3742; color: #e2e8f0; }
.brand { display: flex; align-items: center; gap: 10px; padding: 20px 18px; border-bottom: 1px solid rgba(255,255,255,.1); }
.brand strong,.brand small { display:block; }.brand small { color:#b5c8ce; font-size:11px; margin-top:3px; }.badge { color:#082832; background:#5be7ff; font-weight:800; font-size:10px; padding:4px 7px; border-radius:5px; }
.sidebar nav { flex:1; overflow:auto; padding:14px 10px; }.sidebar nav button { display:flex; align-items:center; gap:11px; width:100%; border:0; border-radius:9px; padding:11px 12px; margin:3px 0; color:#d0dce0; text-align:left; background:transparent; cursor:pointer; font:inherit; font-size:13px; }.sidebar nav button span { width:19px; text-align:center; }.sidebar nav button small { margin-left:auto; border-radius:12px; padding:2px 7px; background:rgba(91,231,255,.18); color:#5be7ff; }.sidebar nav button:hover,.sidebar nav button.active { color:#5be7ff; background:rgba(91,231,255,.12); }.sidebar-footer { padding:14px; border-top:1px solid rgba(255,255,255,.1); display:grid; gap:8px; }.sidebar-footer a,.logout { display:block; padding:9px; border-radius:7px; text-align:center; color:#5be7ff; background:rgba(91,231,255,.08); border:1px solid rgba(91,231,255,.2); text-decoration:none; cursor:pointer; }.logout { color:#fca5a5; background:rgba(239,68,68,.1); border-color:rgba(239,68,68,.25); }
.main-content { min-width:0; flex:1; height:100vh; overflow-y:auto; padding:24px 30px 50px; }.page-header { display:flex; justify-content:space-between; align-items:center; gap:16px; padding-bottom:17px; margin-bottom:24px; border-bottom:1px solid rgba(15,23,42,.13); }.page-header h1 { margin:0; font-size:24px; color:#0f172a; }.user-pill { display:flex; align-items:center; gap:9px; padding:8px 13px; border:1px solid rgba(15,23,42,.12); border-radius:22px; color:#475569; background:rgba(15,23,42,.05); font-size:13px; }.user-pill i { width:9px; height:9px; border-radius:50%; background:#10b981; }
.stats-grid { display:grid; grid-template-columns:repeat(4,minmax(0,1fr)); gap:16px; margin-bottom:22px; }.stat,.panel { color:#e2e8f0; background:#12404D; border:1px solid rgba(18,64,77,.12); border-radius:15px; box-shadow:0 10px 28px rgba(15,23,42,.08); }.stat { padding:20px; border-top:3px solid #22d3ee; }.stat span { display:block; color:#bfd3d8; font-size:13px; }.stat strong { display:block; color:#fff; font-size:23px; margin-top:8px; overflow-wrap:anywhere; }.panel { padding:22px; margin-bottom:20px; min-width:0; }.demo-form-heading { padding-top:8px; border-top:1px solid rgba(255,255,255,.15); font-weight:700; color:#5be7ff !important; }.demo-admin-grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:14px; }.demo-admin-card { min-width:0; padding:16px; border:1px solid rgba(255,255,255,.12); border-radius:12px; background:rgba(255,255,255,.05); }.demo-admin-top { display:flex; align-items:center; justify-content:space-between; margin-bottom:12px; }.demo-icon { display:grid; place-items:center; width:42px; height:42px; border-radius:10px; background:rgba(91,231,255,.14); font-size:22px; }.demo-admin-card>small { color:#5be7ff; }.demo-admin-card h3 { color:#fff; margin:7px 0; font-size:16px; }.demo-admin-card p,.demo-admin-card li,.no-demo { color:#bfd3d8; font-size:12px; }.demo-admin-card ul { padding-left:18px; min-height:80px; }.demo-admin-card li { margin:5px 0; }.demo-admin-card>a { display:inline-block; color:#5be7ff; margin-top:6px; }.demo-admin-actions { display:flex; justify-content:space-between; align-items:center; margin-top:12px; }.demo-admin-actions .danger-text { color:#fca5a5; border:0; background:none; cursor:pointer; }.status.inactive { color:#fca5a5; background:rgba(239,68,68,.14); }.check-label { display:flex !important; align-items:center; gap:8px !important; }.check-label input { width:auto; }.panel-heading { display:flex; align-items:center; justify-content:space-between; gap:14px; margin-bottom:18px; flex-wrap:wrap; }.panel-heading h2 { color:#fff; font-size:17px; margin:0 0 4px; }.panel-heading p { color:#bfd3d8; font-size:13px; margin:0; }.two-col { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:18px; }.partner-summary { display:grid; grid-template-columns:repeat(auto-fit,minmax(230px,1fr)); gap:12px; }.partner-chip,.person { display:flex; align-items:center; gap:10px; }.partner-chip { padding:12px; border-radius:10px; background:rgba(255,255,255,.06); }.partner-chip img,.person img,.avatar { width:40px; height:40px; border-radius:50%; object-fit:cover; }.avatar { display:inline-grid; place-items:center; flex:none; background:#1a9fc0; color:#fff; font-weight:700; }.partner-chip div { min-width:0; flex:1; }.partner-chip strong,.partner-chip small,.person small { display:block; }.partner-chip small,.person small { color:#b7cbd1; font-size:11px; margin-top:3px; }.partner-chip b { font-size:12px; color:#5be7ff; }
.table-wrap { width:100%; overflow-x:auto; -webkit-overflow-scrolling:touch; }table { width:100%; border-collapse:collapse; font-size:13px; }th { text-align:left; color:#d3e4e8; background:rgba(0,0,0,.16); font-weight:600; }th,td { padding:12px 13px; border-bottom:1px solid rgba(255,255,255,.1); vertical-align:middle; }td { color:#e2e8f0; }td small { display:block; color:#b7cbd1; margin-top:3px; }td a { color:#5be7ff; }table .empty,.empty { color:#bfd3d8; text-align:center; padding:18px; }.income { color:#34d399; }.expense { color:#fca5a5; }.status { display:inline-block; padding:4px 8px; border-radius:14px; background:rgba(91,231,255,.15); color:#5be7ff; font-size:11px; }.actions { white-space:nowrap; }.actions button { padding:6px 8px; border:1px solid rgba(255,255,255,.15); border-radius:6px; margin:2px; background:rgba(255,255,255,.05); color:#e2e8f0; cursor:pointer; font:inherit; font-size:11px; }.actions .danger-text { color:#fca5a5; }
.primary,.secondary { padding:9px 14px; border-radius:8px; cursor:pointer; font:inherit; font-weight:650; font-size:13px; }.primary { color:#06222b; background:#5be7ff; border:1px solid #5be7ff; }.primary:hover { background:#22d3ee; }.primary:disabled { opacity:.6; cursor:wait; }.secondary { color:#d3e4e8; border:1px solid rgba(255,255,255,.2); background:rgba(255,255,255,.07); }.filter-row { display:flex; gap:7px; margin-bottom:14px; }.filter-row button { border:1px solid rgba(255,255,255,.17); color:#d3e4e8; background:transparent; border-radius:18px; padding:6px 12px; cursor:pointer; }.filter-row button.chosen { color:#06222b; background:#5be7ff; border-color:#5be7ff; }
.settings-grid { max-width:1000px; }.logo-preview-wrap { display:grid; gap:8px; }.logo-preview-label { color:#d3e4e8; font-size:12px; }.logo-preview { display:flex; align-items:center; gap:12px; min-height:100px; padding:12px; border:1px dashed rgba(255,255,255,.22); border-radius:9px; background:rgba(255,255,255,.04); }.logo-preview img { display:block; width:auto; max-width:min(320px,100%); height:auto; max-height:100px; object-fit:contain; }.logo-preview span,.logo-preview-empty { color:#bfd3d8; font-size:12px; overflow-wrap:anywhere; }.logo-preview-empty { margin:0; padding:12px; border:1px dashed rgba(255,255,255,.22); border-radius:9px; }.form-grid { display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:14px; }.form-grid label,.modal label { display:grid; gap:6px; color:#d3e4e8; font-size:12px; }.form-grid input,.form-grid textarea,.modal input,.modal textarea,.modal select { width:100%; min-width:0; padding:10px 11px; border:1px solid rgba(255,255,255,.18); border-radius:7px; color:#fff; background:#0E3742; font:inherit; }.form-grid input[type=file],.modal input[type=file] { padding:8px; }.wide { grid-column:1/-1; }.settings-actions { display:flex; justify-content:space-between; gap:10px; }.toast { display:flex; justify-content:space-between; gap:10px; padding:12px 15px; margin-bottom:16px; border-radius:9px; background:#d1fae5; color:#065f46; }.toast.error { background:#fee2e2; color:#991b1b; }.toast button { border:0; background:none; color:inherit; font-size:18px; cursor:pointer; }
.modal-backdrop { position:fixed; inset:0; z-index:1200; display:grid; place-items:center; overflow:auto; padding:20px; background:rgba(3,17,22,.72); }.modal { width:min(560px,100%); max-height:calc(100vh - 40px); overflow:auto; display:grid; grid-template-columns:repeat(2,minmax(0,1fr)); gap:13px; padding:22px; border:1px solid rgba(91,231,255,.2); border-radius:14px; background:#12404D; box-shadow:0 20px 60px rgba(0,0,0,.3); }.modal h2,.modal-actions { grid-column:1/-1; }.modal h2 { margin:0 0 4px; color:#fff; font-size:19px; }.modal-actions { display:flex; justify-content:flex-end; gap:9px; margin-top:6px; }
.mobile-header { display:none; }.menu-toggle { border:1px solid rgba(255,255,255,.2); border-radius:6px; color:#fff; background:transparent; padding:5px 9px; }.mobile-header strong { color:#fff; font-size:14px; }.mobile-header a { color:#5be7ff; text-decoration:none; font-size:12px; }
@media(max-width:1050px) { .stats-grid { grid-template-columns:repeat(2,minmax(0,1fr)); }.two-col { grid-template-columns:1fr; } }
@media(max-width:900px) { .admin-layout { display:block; height:auto; min-height:100vh; overflow:visible; }.mobile-header { position:fixed; z-index:900; inset:0 0 auto; min-height:54px; display:flex; align-items:center; justify-content:space-between; gap:10px; padding:8px 13px; background:#12404D; border-bottom:1px solid rgba(91,231,255,.2); }.sidebar { position:fixed; z-index:950; top:54px; bottom:0; left:0; width:260px; height:auto; transform:translateX(-105%); transition:transform .25s ease; box-shadow:8px 0 25px rgba(0,0,0,.25); }.sidebar.open { transform:translateX(0); }.main-content { height:auto; overflow:visible; padding:76px 18px 35px; } }
@media(max-width:600px) { .main-content { padding:70px 12px 25px; }.page-header { align-items:flex-start; flex-direction:column; gap:10px; margin-bottom:18px; }.page-header h1 { font-size:20px; }.stats-grid { grid-template-columns:repeat(2,minmax(0,1fr)); gap:10px; }.stat { padding:14px 12px; }.stat strong { font-size:17px; }.panel { padding:15px; }.panel-heading { align-items:flex-start; flex-direction:column; }.panel-heading>.primary { width:100%; }.form-grid,.modal { grid-template-columns:1fr; }.wide,.modal h2,.modal-actions { grid-column:1; }.modal-backdrop { padding:12px; }.settings-actions { flex-direction:column-reverse; }.settings-actions button { width:100%; } }
@media(max-width:380px) { .stats-grid { grid-template-columns:1fr; }.mobile-header { padding-inline:9px; }.mobile-header strong { font-size:12px; }.user-pill { font-size:12px; } }
</style>
