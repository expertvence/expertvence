<template>
  <main class="demo-access-page">
    <header class="demo-access-header">
      <router-link to="/" class="brand">Expertvence</router-link>
      <router-link to="/" class="back-link">Back to website</router-link>
    </header>
    <section v-if="loading" class="demo-message"><h1>Preparing your demo</h1><p v-if="requiresLogin">Free preview: {{ secondsLeft }} seconds remaining.</p><p v-else>Please wait...</p></section>
    <section v-else-if="error" class="demo-message"><h1>Demo unavailable</h1><p>{{ error }}</p><router-link to="/" class="back-link">Return home</router-link></section>
    <template v-else>
      <section class="demo-intro">
        <div><span class="eyebrow">READY SOFTWARE DEMO</span><h1>{{ demo.title }}</h1><p>Choose a demo area below. Demo-only login details are shown on each card.</p></div>
        <div v-if="requiresLogin" class="countdown" aria-live="polite">{{ secondsLeft }} sec left</div>
      </section>
      <section class="demo-cards" aria-label="Demo areas">
        <article v-for="card in cards" :key="card.key" class="demo-card">
          <div class="card-icon" aria-hidden="true">{{ card.icon }}</div>
          <span class="card-label">{{ card.label }}</span>
          <h2>{{ card.title }}</h2>
          <div v-if="card.email || card.password" class="credentials">
            <p v-if="card.email"><span>Gmail</span><strong>{{ card.email }}</strong></p>
            <p v-if="card.password"><span>Password</span><strong>{{ card.password }}</strong></p>
          </div>
          <p v-else class="credentials-empty">No login details provided.</p>
          <a v-if="card.url" class="open-demo" :href="card.url" target="_blank" rel="noopener noreferrer" @click.prevent="openDemo(card)">Open {{ card.title }}</a>
          <span v-else class="open-demo disabled">Demo link not set</span>
        </article>
      </section>
      <p class="demo-footnote">{{ requiresLogin ? 'These are shared demo credentials. Do not use them for real accounts. This free preview redirects to Google login after 30 seconds.' : 'You are signed in. These are shared demo credentials; do not use them for real accounts.' }}</p>
    </template>
  </main>
</template>

<script setup>
import { computed, onMounted, onUnmounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import axios from 'axios'

const route = useRoute()
const router = useRouter()
const demo = ref(null)
const loading = ref(true)
const error = ref('')
const secondsLeft = ref(30)
const requiresLogin = ref(false)
const openedDemoWindows = new Set()
let timer = null

const cards = computed(() => {
  if (!demo.value) return []
  return [
    { key: 'admin', icon: 'A', label: 'ADMIN ACCESS', title: 'Admin Panel', url: demo.value.admin_demo_url, email: demo.value.admin_demo_email, password: demo.value.admin_demo_password },
    { key: 'user', icon: 'U', label: 'USER ACCESS', title: 'User Panel', url: demo.value.user_demo_url, email: demo.value.user_demo_email, password: demo.value.user_demo_password },
    { key: 'website', icon: 'W', label: 'PUBLIC WEBSITE', title: 'Website', url: demo.value.website_url || demo.value.demo_url, email: '', password: '' },
  ]
})

const returnPath = () => `/demo-access/${encodeURIComponent(String(route.params.id))}`
const sendToGoogleLogin = () => router.replace({ path: '/login', query: { redirect: returnPath(), demoExpired: 'true' } })
const openDemo = card => {
  const openedWindow = window.open(card.url, '_blank')
  if (openedWindow) {
    openedWindow.opener = null
    openedDemoWindows.add(openedWindow)
  }
}
const closeOpenedDemoWindows = () => {
  openedDemoWindows.forEach(openedWindow => {
    try { if (!openedWindow.closed) openedWindow.close() } catch {}
  })
  openedDemoWindows.clear()
}
const trackDemoView = token => {
  const config = token ? { headers: { Authorization: 'Bearer ' + token } } : {}
  axios.post('/api/software-demo-views', { demo_id: route.params.id }, config).catch(() => {})
}

onMounted(async () => {
  const previewDeadline = Date.now() + 30_000
  const startGuestTimer = () => {
    requiresLogin.value = true
    const tick = () => {
      secondsLeft.value = Math.max(0, Math.ceil((previewDeadline - Date.now()) / 1000))
      if (secondsLeft.value <= 0) {
        if (timer) window.clearInterval(timer)
        closeOpenedDemoWindows()
        sendToGoogleLogin()
      }
    }
    tick()
    if (secondsLeft.value > 0) timer = window.setInterval(tick, 250)
  }

  const token = localStorage.getItem('token')
  const isGoogleDemoViewer = localStorage.getItem('demo_viewer') === 'true'
  let isAuthenticated = false
  if (!token || !isGoogleDemoViewer) {
    startGuestTimer()
  } else {
    try {
      await axios.get('/api/auth/me', { headers: { Authorization: 'Bearer ' + token } })
      isAuthenticated = true
    } catch {
      localStorage.removeItem('token')
      localStorage.removeItem('demo_viewer')
      startGuestTimer()
    }
  }

  try {
    const response = await axios.get(`/api/software-demos/${encodeURIComponent(String(route.params.id))}`)
    demo.value = response.data?.data
    if (demo.value) trackDemoView(isAuthenticated ? token : '')
    if (!demo.value || !cards.value.some(card => card.url)) {
      error.value = 'This demo has not been configured yet. Please check back later.'
    }
  } catch {
    error.value = 'This demo link is unavailable.'
  } finally {
    loading.value = false
  }
})

onUnmounted(() => {
  if (timer) window.clearInterval(timer)
})
</script>

<style scoped>
.demo-access-page{min-height:100vh;padding-bottom:34px;background:#e7eff3;color:#102d36;font-family:Inter,Arial,sans-serif}.demo-access-header{height:64px;display:flex;align-items:center;justify-content:space-between;padding:0 5vw;background:#103d49;color:white}.brand{font-weight:800;color:white;text-decoration:none}.back-link{color:#d7f6fb;text-decoration:none;font-weight:650}.demo-intro{max-width:1180px;margin:0 auto;padding:54px 24px 28px;display:flex;justify-content:space-between;align-items:flex-end;gap:20px}.eyebrow{color:#078ba5;font-size:13px;font-weight:800;letter-spacing:.12em}.demo-intro h1{margin:9px 0;font-size:clamp(30px,5vw,48px);color:#10202d}.demo-intro p{margin:0;color:#607786;font-size:16px}.countdown{flex:none;border-radius:999px;padding:10px 16px;background:#d0f1f5;color:#087d97;font-weight:800}.demo-cards{max-width:1180px;margin:0 auto;padding:0 24px;display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:18px}.demo-card{display:flex;flex-direction:column;min-width:0;padding:25px;border:1px solid #d3e0e5;border-radius:18px;background:white;box-shadow:0 12px 32px rgba(16,61,73,.08)}.card-icon{width:50px;height:50px;display:grid;place-items:center;border-radius:14px;background:#def6f9;color:#087d97;font-size:25px}.card-label{margin-top:22px;color:#078ba5;font-size:11px;font-weight:800;letter-spacing:.1em}.demo-card h2{margin:7px 0 16px;color:#142b37;font-size:23px}.credentials{display:grid;gap:10px;min-height:105px;padding:14px;border-radius:11px;background:#f1f6f8}.credentials p{display:grid;gap:3px;margin:0;overflow-wrap:anywhere}.credentials p span{color:#72838c;font-size:11px;text-transform:uppercase;letter-spacing:.07em}.credentials p strong{color:#153b47;font-size:14px;user-select:all}.credentials-empty{min-height:105px;margin:0;padding:14px;border-radius:11px;background:#f1f6f8;color:#72838c;font-size:13px}.open-demo{display:flex;justify-content:space-between;align-items:center;gap:8px;margin-top:18px;padding:12px 15px;border-radius:9px;background:#0e889e;color:white;text-decoration:none;font-weight:750}.open-demo:hover{background:#096d80}.open-demo.disabled{background:#d5e0e4;color:#71838b}.demo-footnote{max-width:1180px;margin:20px auto 0;padding:0 24px;text-align:center;color:#697f88;font-size:13px}.demo-message{min-height:75vh;display:grid;align-content:center;justify-items:center;text-align:center;padding:28px}.demo-message h1{font-size:clamp(24px,4vw,36px)}.demo-message p{color:#647985;margin-bottom:22px}@media(max-width:800px){.demo-cards{grid-template-columns:1fr;max-width:620px}.demo-intro{align-items:flex-start;flex-direction:column;padding-top:36px}.demo-card{padding:21px}.credentials,.credentials-empty{min-height:0}}@media(max-width:600px){.demo-access-header{padding:0 16px}.demo-intro,.demo-cards{padding-left:16px;padding-right:16px}.demo-intro p{font-size:14px}.demo-footnote{padding:0 16px}}
</style>