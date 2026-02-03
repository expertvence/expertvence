<template>
  <section class="service-hero">
    <div class="hero-content">
      <span class="badge">{{ service.sections?.heroBadge || 'Our Services' }}</span>
      <h1>{{ service.title }}</h1>
      <p class="hero-desc">
        {{ service.description }}
      </p>
    </div>
  </section>

  <section class="service-overview">
  <div class="overview-grid">
    <div class="overview-text">
      <h2>{{ service.sections?.overviewTitle }}</h2>
      <p>{{ service.sections?.overviewDesc }}</p>

<ul class="benefits">
  <li v-for="(benefit, i) in service.sections?.benefits" :key="i">
    ✔ {{ benefit }}
  </li>
</ul>
    </div>

    <div class="overview-card">
      <h3>{{ service.sections?.processTitle }}</h3>
      <p>{{ service.sections?.processDesc }}</p>
    </div>
  </div>
</section>

<section class="seo-content">
  <h2>Why Choose ExpertVence for {{ service.title }}?</h2>
  <p>
    ExpertVence is a trusted {{ service.title }} company in Bangladesh, offering
    custom software solutions, enterprise application development, and blockchain
    technology services for global clients. Our expert engineers design scalable,
    secure, and performance-driven systems that align with your business goals.
  </p>

  <p>
    Whether you need a business management system, SaaS platform, ERP solution,
    we ensure your software is optimized for
    speed, security, and long-term growth. Our agile development approach helps
    deliver faster results with transparent communication.
  </p>
</section>

<!-- Replace the entire tech-stack-section in ServiceDetail.vue with this: -->
<section class="tech-stack-section" v-if="service.techStacks">
  <div class="tech-stack-header">
    <h2 class="section-title">
      Our Proven <span class="highlight">{{ service.title }}</span> Tech Stack for Success
    </h2>
    <p class="section-subtitle">{{ service.title }} Tech Stack That Delivers</p>
  </div>

  <div class="tech-stack-container">
    <!-- Left side: categories -->
    <div class="tech-categories">
      <div class="categories-header">
        <h3>Emerging Tech</h3>
      </div>
      <div class="categories-list">
        <div
          v-for="(items, category) in service.techStacks"
          :key="category"
          class="category-item"
          :class="{ active: selectedCategory === category }"
          @mouseenter="selectedCategory = category"
        >
          <span class="category-name">{{ category }}</span>
          <span class="arrow">→</span>
        </div>
      </div>
    </div>

    <!-- Middle: vertical line -->
    <div class="vertical-divider">
      <div class="line"></div>
      <div class="circle"></div>
      <div class="line"></div>
    </div>

    <!-- Right side: technologies -->
    <div class="tech-items-container">
      <!-- Always show the selected category -->
      <div class="tech-items">
        <h3 class="tech-category-title">{{ selectedCategory }}</h3>
        <p class="tech-category-desc">
          {{ getCategoryDescription(selectedCategory) }}
        </p>
        <div class="tech-grid">
          <div v-for="tech in service.techStacks[selectedCategory]" :key="tech.name" class="tech-item">
            <div class="tech-icon">
              <img :src="tech.icon" :alt="tech.name" class="tech-img" />
            </div>
            <span class="tech-name">{{ tech.name }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>




  <section class="sub-services" v-if="service.items">
    <h2 class="section-title">Our Expertise in {{ service.title }}</h2>

    <div class="sub-services-grid">
      <div
        v-for="item in service.items"
        :key="item.slug"
        class="sub-service-card"
      >
        <h3>{{ item.name }}</h3>
        <p>
          Professional {{ item.name }} service tailored for your business needs.
        </p>
        <router-link :to="`/services/${service.slug}/${item.slug}`">
          Learn More →
        </router-link>
      </div>
    </div>
  </section>

  <section class="service-cta">
  <h2>{{ service.sections?.ctaTitle }}</h2>
  <p>{{ service.sections?.ctaDesc }}</p>

  <button class="cta-btn" @click="showModal = true">
    Start a Project
  </button>

  <ContactModal :show="showModal" @close="showModal = false" />
</section>

</template>

<script setup>
import { ref, computed, watch, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import { services } from '@/data/services'
import ContactModal from '@/components/ContactModal.vue'

import { useHead } from '@vueuse/head'

onMounted(() => {
  if (service.value?.seo) {
    useHead({
      title: service.value.seo.title,
      meta: [
        { name: 'description', content: service.value.seo.description },
        { name: 'keywords', content: service.value.seo.keywords },
        { property: 'og:title', content: service.value.seo.title },
        { property: 'og:description', content: service.value.seo.description }
      ]
    })
  }
})


const showModal = ref(false)
const selectedCategory = ref("Database")
const route = useRoute()

const service = computed(() => {
  return services.find(s => s.slug === route.params.slug)
})

// route change হলে category reset করার জন্য
watch(service, (newService) => {
  if (newService?.techStacks?.Database) {
    selectedCategory.value = "Database"
  } else if (newService?.techStacks) {
    const categories = Object.keys(newService.techStacks)
    if (categories.length > 0) {
      selectedCategory.value = categories[0]
    }
  }
})

const getCategoryDescription = (category) => {
  const descriptions = {
    "Programming Languages": "Robust programming languages for building scalable and efficient applications.",
    "Mobile App Frameworks": "Modern frameworks for cross-platform and native mobile app development.",
    "Front-End Technologies": "Latest frontend libraries and frameworks for responsive UI development.",
    "Back-End Technologies": "Powerful backend frameworks for server-side logic and API development.",
    "Database": "Store, manage, and process app data efficiently with reliable database solutions.",
    "Cloud Platforms": "Scalable cloud infrastructure and deployment platforms for modern applications."
  }
  return descriptions[category] || "Cutting-edge technologies for modern application development."
}
</script>

<style src="../../css/service-detail.css"></style> 
