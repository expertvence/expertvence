<template>
  <section class="services-page">
    <h1 class="page-title">Our Services</h1>
    <p class="page-subtitle">
      Explore our professional IT services & solutions
    </p>

    <div class="services-grid">
      <div
        v-for="service in services"
        :key="service.slug"
        class="service-card"
        @click="$router.push(`/services/${service.slug}`)"
      >
        <div class="icon">{{ service.icon }}</div>
        <h2>{{ service.title }}</h2>
        <p>{{ service.description }}</p>
        <span class="view-more">View Details →</span>
      </div>
    </div>
  </section>
</template>

<script setup>
import { services } from '@/data/services'
</script>


<!-- <script setup>
import { services } from '@/data/services'
</script> -->

<!-- <style src="../../css/services.css"></style> -->
