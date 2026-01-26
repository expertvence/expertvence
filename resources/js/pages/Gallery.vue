<template>
  <section class="gallery">
    <h1>Gallery</h1>

    <div class="gallery-grid">
      <div class="img-box">Project 1</div>
      <div class="img-box">Project 2</div>
      <div class="img-box">Project 3</div>
      <div class="img-box">Project 4</div>
    </div>
  </section>
</template>

<script setup>
</script>

<style scoped>
.gallery {
  padding: 80px 20px;
  text-align: center;
}

.gallery-grid {
  margin-top: 40px;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
}

.img-box {
  height: 180px;
  background: #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 10px;
  font-weight: bold;
}
</style>
