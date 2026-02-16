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
  <div
    v-for="project in projects"
    :key="project.id"
    class="project-card"
    :class="projectClasses(project.id)"
    @mouseenter="hoveredProject = project.id"
    @mouseleave="hoveredProject = null"
    @click="openProject(project.id)"
  >

    <!-- Project Image -->
    <div class="project-image">
      <img :src="project.image" class="project-img" />
    </div>

    <!-- Project Content -->
    <div class="project-content">
      <div class="project-header">
        <div class="client-badge">
          <span>{{ project.client }}</span>
        </div>
        <div class="project-year">{{ project.year }}</div>
      </div>

      <h3 class="project-title">{{ project.title }}</h3>
      <p class="project-description">
        {{ project.description }}
      </p>

      <div class="project-tech">
        <span
          v-for="tech in project.tech"
          :key="tech"
          class="tech-tag"
        >
          {{ tech }}
        </span>
      </div>
    </div>

    <!-- Buttons -->
    <div class="project-actions">
      <button
        class="action-btn details-btn"
        @click.stop="openCaseStudy(project)"

      >
        View Details
      </button>

      <button
        class="action-btn demo-btn"
        @click.stop="openLiveDemo(project)"

      >
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
import saasImg from '@/assets/projects/saas.jpeg'
import ecommerceImg from '@/assets/projects/ecommerce.webp'
import healthImg from '@/assets/projects/health-fitness.webp'

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
const openCaseStudy = (project) => {
  router.push({
    name: 'CaseStudy',
    params: {
      slug: project.case_study_slug
    }
  })
}

const projects = ref([
  {
    id: 1,
    image: saasImg,
    client: 'Enterprise Client',
    year: '2024',
    title: 'Enterprise SaaS Platform',
    description:
      'A comprehensive SaaS solution for business analytics.',
    tech: ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'AWS'],
    demo_url: 'https://www.fiverr.com/',
    case_study_slug: 'enterprise-saas-platform',
    category: 'saas'
  },
  {
    id: 2,
    image: ecommerceImg,
    client: 'Retail Brand',
    year: '2023',
    title: 'Multi-vendor E-commerce Platform',
    description:
      'Scalable e-commerce solution supporting 500+ vendors.',
    tech: ['Node.js', 'React', 'MongoDB', 'Stripe', 'Docker'],
    demo_url: 'https://demo-ecommerce.example.com',
    case_study_slug: 'multi-vendor-ecommerce',
    category: 'ecommerce'
  },
  {
    id: 3,
    image: healthImg,
    client: 'Health Startup',
    year: '2024',
    title: 'Health & Fitness Mobile App',
    description:
      'Cross-platform mobile app with personalized workout plans.',
    tech: ['Flutter', 'Firebase', 'GraphQL'],
    demo_url: null,
    case_study_slug: 'health-fitness-app',
    category: 'mobile'
  }
])



const openLiveDemo = (project) => {
  if (project?.demo_url) {
    window.open(project.demo_url, '_blank', 'noopener,noreferrer')
  } else {
    alert('Live demo is not available for this project.')
  }
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