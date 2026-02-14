<template>
  <!-- Hero Section -->
  <section class="portfolio-hero">
    <div class="hero-topography">
      <div class="topo-wave"></div>
      <div class="topo-grid">
        <div class="grid-line vertical"></div>
        <div class="grid-line horizontal"></div>
        <div class="grid-node node-1"></div>
        <div class="grid-node node-2"></div>
        <div class="grid-node node-3"></div>
      </div>
    </div>

    <div class="hero-content">
      <div class="hero-badge">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
          <path
            d="M9 12L11 14L15 10M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
            stroke="currentColor" stroke-width="2" stroke-linecap="round" />
        </svg>
        <span>Our Work</span>
      </div>

      <h1 class="hero-title">
        Where <span class="text-gradient">Innovation</span> Meets
        <span class="text-outline">Execution</span>
      </h1>

      <p class="hero-subtitle">
        Showcasing digital solutions that have transformed businesses and
        delivered exceptional value to our clients worldwide.
      </p>

      <div class="hero-stats">
        <div class="stat">
          <div class="stat-number">50+</div>
          <div class="stat-label">Projects Delivered</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat">
          <div class="stat-number">95%</div>
          <div class="stat-label">Client Satisfaction</div>
        </div>
        <div class="stat-divider"></div>
        <div class="stat">
          <div class="stat-number">30+</div>
          <div class="stat-label">Industries Served</div>
        </div>
      </div>
    </div>
  </section>

  <!-- Portfolio Filter -->
  <section class="portfolio-filter">
    <div class="filter-container">
      <button v-for="category in categories" :key="category.id"
        :class="['filter-btn', { active: activeFilter === category.id }]" @click="setFilter(category.id)">
        {{ category.name }}
        <span class="project-count">{{ category.count }}</span>
      </button>
    </div>
  </section>

  <!-- Portfolio Projects -->
  <section class="portfolio-projects">
    <div class="projects-grid">
      <!-- Project 1: SaaS Platform -->
      <div class="project-card" :class="projectClasses(1)" @mouseenter="hoveredProject = 1"
        @mouseleave="hoveredProject = null" @click="openProject(1)">

        <div class="project-image">
          <div class="image-placeholder saas-preview">
            <div class="preview-header">
              <div class="browser-dots">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
              </div>
            </div>
            <div class="preview-content">
              <div class="dashboard-preview">
                <div class="metric-card"></div>
                <div class="chart-preview"></div>
                <div class="data-grid"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="project-content">
          <div class="project-header">
            <div class="client-badge">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path
                  d="M17 21V19C17 17.9391 16.5786 16.9217 15.8284 16.1716C15.0783 15.4214 14.0609 15 13 15H5C3.93913 15 2.92172 15.4214 2.17157 16.1716C1.42143 16.9217 1 17.9391 1 19V21M23 21V19C22.9993 18.1137 22.7044 17.2528 22.1614 16.5523C21.6184 15.8519 20.8581 15.3516 20 15.13M16 3.13C16.8604 3.3503 17.623 3.8507 18.1676 4.55231C18.7122 5.25392 19.0078 6.11683 19.0078 7.005C19.0078 7.89317 18.7122 8.75608 18.1676 9.45769C17.623 10.1593 16.8604 10.6597 16 10.88M13 7C13 9.20914 11.2091 11 9 11C6.79086 11 5 9.20914 5 7C5 4.79086 6.79086 3 9 3C11.2091 3 13 4.79086 13 7Z"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              <span>Enterprise Client</span>
            </div>
            <div class="project-year">2024</div>
          </div>

          <h3 class="project-title">Enterprise SaaS Platform</h3>
          <p class="project-description">
            A comprehensive SaaS solution for business analytics with
            real-time dashboard, automated reporting, and AI insights.
          </p>

          <div class="project-tech">
            <span class="tech-tag">Laravel</span>
            <span class="tech-tag">Vue.js</span>
            <span class="tech-tag">MySQL</span>
            <span class="tech-tag">Redis</span>
            <span class="tech-tag">AWS</span>
          </div>
        </div>
        <!-- Project Bottom Buttons -->
        <!-- Project Bottom Buttons -->
        <div class="project-actions">
          <button class="action-btn details-btn" @click.stop="openCaseStudy(1)">
            View Details
          </button>

          <button class="action-btn demo-btn" @click.stop="openLiveDemo(1)">
            Live Demo
          </button>
        </div>


        <div class="project-glow"></div>
      </div>

      <!-- Project 2: E-commerce System -->
      <div class="project-card" :class="projectClasses(2)" @mouseenter="hoveredProject = 2"
        @mouseleave="hoveredProject = null" @click="openProject(2)">

        <div class="project-image">
          <div class="image-placeholder ecommerce-preview">
            <div class="preview-header">
              <div class="browser-dots">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
              </div>
            </div>
            <div class="preview-content">
              <div class="shop-preview">
                <div class="product-card"></div>
                <div class="product-card"></div>
                <div class="cart-preview"></div>
              </div>
            </div>
          </div>
        </div>

        <div class="project-content">
          <div class="project-header">
            <div class="client-badge">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path
                  d="M3 10H21M7 15H8M12 15H13M6 19H18C19.6569 19 21 17.6569 21 16V8C21 6.34315 19.6569 5 18 5H6C4.34315 5 3 6.34315 3 8V16C3 17.6569 4.34315 19 6 19Z"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              <span>Retail Brand</span>
            </div>
            <div class="project-year">2023</div>
          </div>

          <h3 class="project-title">Multi-vendor E-commerce Platform</h3>
          <p class="project-description">
            Scalable e-commerce solution supporting 500+ vendors,
            real-time inventory, and AI-powered recommendations.
          </p>

          <div class="project-tech">
            <span class="tech-tag">Node.js</span>
            <span class="tech-tag">React</span>
            <span class="tech-tag">MongoDB</span>
            <span class="tech-tag">Stripe</span>
            <span class="tech-tag">Docker</span>
          </div>
        </div>
        <!-- Project Bottom Buttons -->
        <div class="project-actions">
          <button class="action-btn details-btn" @click.stop="openCaseStudy(2)">
            View Details
          </button>

          <button class="action-btn demo-btn" @click.stop="openLiveDemo(2)">
            Live Demo
          </button>
        </div>

        <div class="project-glow"></div>
      </div>

      <!-- Project 3: Mobile App -->
      <div class="project-card" :class="projectClasses(3)" @mouseenter="hoveredProject = 3"
        @mouseleave="hoveredProject = null" @click="openProject(3)">

        <div class="project-image">
          <div class="image-placeholder mobile-preview">
            <div class="phone-frame">
              <div class="phone-screen">
                <div class="app-header"></div>
                <div class="app-content">
                  <div class="notification-card"></div>
                  <div class="progress-indicator"></div>
                  <div class="action-buttons"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="project-content">
          <div class="project-header">
            <div class="client-badge">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path
                  d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z"
                  stroke="currentColor" stroke-width="2" />
                <path
                  d="M19.4 15C19.2662 15.3035 19.1059 15.5925 18.921 15.8632C17.9399 17.2387 16.536 18.2393 14.935 18.7094C13.334 19.1794 11.6345 19.0929 10.0871 18.4625C8.53978 17.8322 7.23542 16.6922 6.38756 15.2291C5.53969 13.766 5.19621 12.0643 5.40942 10.386C5.62263 8.70774 6.37953 7.15016 7.56014 5.94581C8.74075 4.74145 10.2773 3.959 11.9375 3.717C13.5978 3.475 15.2873 3.78616 16.75 4.60004"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              <span>HealthTech Startup</span>
            </div>
            <div class="project-year">2024</div>
          </div>

          <h3 class="project-title">Health & Fitness Mobile App</h3>
          <p class="project-description">
            Cross-platform fitness application with workout tracking,
            nutrition planning, and AI-powered personal coaching.
          </p>

          <div class="project-tech">
            <span class="tech-tag">Flutter</span>
            <span class="tech-tag">Firebase</span>
            <span class="tech-tag">Node.js</span>
            <span class="tech-tag">ML Kit</span>
            <span class="tech-tag">Google Fit</span>
          </div>
        </div>
        <!-- Project Bottom Buttons -->
        <div class="project-actions">
          <button class="action-btn details-btn" @click.stop="openCaseStudy(3)">
            View Details
          </button>

          <button class="action-btn demo-btn" @click.stop="openLiveDemo(3)">
            Live Demo
          </button>
        </div>

        <div class="project-glow"></div>
      </div>

      <!-- Project 4: Dashboard System -->
      <div class="project-card" :class="projectClasses(4)" @mouseenter="hoveredProject = 4"
        @mouseleave="hoveredProject = null" @click="openProject(4)">

        <div class="project-image">
          <div class="image-placeholder dashboard-preview">
            <div class="preview-header">
              <div class="browser-dots">
                <span class="dot"></span>
                <span class="dot"></span>
                <span class="dot"></span>
              </div>
            </div>
            <div class="preview-content">
              <div class="analytics-dashboard">
                <div class="chart-container"></div>
                <div class="kpi-grid">
                  <div class="kpi-card"></div>
                  <div class="kpi-card"></div>
                  <div class="kpi-card"></div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="project-content">
          <div class="project-header">
            <div class="client-badge">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="none">
                <path
                  d="M13 7L19 13M19 13L13 19M19 13H5M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" />
              </svg>
              <span>Financial Services</span>
            </div>
            <div class="project-year">2023</div>
          </div>

          <h3 class="project-title">Real-time Analytics Dashboard</h3>
          <p class="project-description">
            Enterprise dashboard for financial data visualization with
            predictive analytics and automated reporting capabilities.
          </p>

          <div class="project-tech">
            <span class="tech-tag">Python</span>
            <span class="tech-tag">Django</span>
            <span class="tech-tag">React</span>
            <span class="tech-tag">D3.js</span>
            <span class="tech-tag">PostgreSQL</span>
          </div>
        </div>
        <!-- Project Bottom Buttons -->
        <div class="project-actions">
          <button class="action-btn details-btn" @click.stop="openCaseStudy(4)">
            View Details
          </button>

          <button class="action-btn demo-btn" @click.stop="openLiveDemo(4)">
            Live Demo
          </button>
        </div>

        <div class="project-glow"></div>
      </div>
    </div>
  </section>

  <!-- Portfolio CTA -->
  <section class="portfolio-cta">
    <div class="cta-topography">
      <div class="cta-wave"></div>
      <div class="cta-dots">
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
        <div class="dot"></div>
      </div>
    </div>

    <div class="cta-content">
      <h2 class="cta-title">
        Ready to Build Your
        <span class="text-gradient">Next Project?</span>
      </h2>
      <p class="cta-description">
        Let's discuss how we can transform your ideas into
        exceptional digital experiences.
      </p>

      <div class="cta-actions">
        <button class="primary-cta-btn" @click="openContactModal">
          Start Your Project
          <svg class="cta-icon" width="20" height="20" viewBox="0 0 24 24">
            <path d="M13 7L19 13M19 13L13 19M19 13H5" stroke="currentColor" stroke-width="2" />
          </svg>
        </button>
        <button class="secondary-cta-btn" @click="openCaseStudyModal">
          Download Case Studies
        </button>
      </div>
    </div>
  </section>

  <!-- Contact Modal Component -->
  <ContactModal v-if="showContactModal" :show="showContactModal" @close="closeContactModal" />
</template>

<script setup>
import { ref } from 'vue'
import { useRouter } from 'vue-router'
import ContactModal from '@/components/ContactModal.vue'

const router = useRouter()
const activeFilter = ref('all')
const hoveredProject = ref(null)
const showContactModal = ref(false)

const categories = [
  { id: 'all', name: 'All Projects', count: 12 },
  { id: 'web', name: 'Web Development', count: 8 },
  { id: 'mobile', name: 'Mobile Apps', count: 4 },
  { id: 'saas', name: 'SaaS Platforms', count: 5 },
  { id: 'ecommerce', name: 'E-commerce', count: 3 },
  { id: 'design', name: 'UI/UX Design', count: 6 }
]

const setFilter = (filter) => {
  activeFilter.value = filter
}

const projectClasses = (projectId) => ({
  'featured': projectId === 1,
  'hovered': hoveredProject.value === projectId
})

// নতুন ফাংশন: CaseStudy.vue পেজে নেভিগেট করতে
const openCaseStudy = (projectId) => {
  // CaseStudy.vue পেজে নেভিগেট করুন
  router.push({
    name: 'CaseStudy',
    params: {
      id: projectId,
      // আপনি চাইলে additional data pass করতে পারেন
      title: getProjectTitle(projectId),
      type: getProjectType(projectId)
    }
  })
}

// প্রজেক্ট টাইটেল ফাংশন
const getProjectTitle = (projectId) => {
  const titles = {
    1: 'Enterprise SaaS Platform',
    2: 'Multi-vendor E-commerce Platform',
    3: 'Health & Fitness Mobile App',
    4: 'Real-time Analytics Dashboard'
  }
  return titles[projectId] || 'Project Details'
}

// প্রজেক্ট টাইপ ফাংশন
const getProjectType = (projectId) => {
  const types = {
    1: 'saas',
    2: 'ecommerce',
    3: 'mobile',
    4: 'dashboard'
  }
  return types[projectId] || 'web'
}

const openContactModal = () => {
  showContactModal.value = true
}

const closeContactModal = () => {
  showContactModal.value = false
}

const openCaseStudyModal = () => {
  // Open case studies modal
  console.log('Opening case studies')
}
</script>