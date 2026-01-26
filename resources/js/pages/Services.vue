<template>
  <section class="services">
    <h1>Our Services</h1>

    <div class="service-grid">
      <div class="card">Web Application Development</div>
      <div class="card">Laravel & API Development</div>
      <div class="card">Vue.js Frontend Development</div>
      <div class="card">SaaS & Startup Solutions</div>
      <div class="card">Custom Software Solutions</div>
      <div class="card">Maintenance & Support</div>
    </div>
  </section>
</template>

<script setup>
</script>

<style scoped>
.services {
  padding: 80px 20px;
  text-align: center;
}

.service-grid {
  margin-top: 40px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 20px;
}

.card {
  padding: 20px;
  border-radius: 10px;
  background: #f1f5f9;
  font-weight: bold;
}
</style>
