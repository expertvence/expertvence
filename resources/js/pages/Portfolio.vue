<template>
  <section class="portfolio">
    <h1>Our Portfolio</h1>

    <div class="portfolio-grid">
      <div class="project">
        <h3>SaaS Platform</h3>
        <p>Laravel + Vue</p>
      </div>

      <div class="project">
        <h3>E-commerce System</h3>
        <p>API Driven</p>
      </div>

      <div class="project">
        <h3>Company Website</h3>
        <p>Modern UI</p>
      </div>
    </div>
  </section>
</template>

<script setup>
</script>

<style scoped>
.portfolio {
  padding: 80px 20px;
  text-align: center;
}

.portfolio-grid {
  margin-top: 40px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 20px;
}

.project {
  padding: 25px;
  border-radius: 12px;
  background: #f8fafc;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}
</style>
