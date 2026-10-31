<template>
  <section class="contact-page">
    <div class="contact-card">
      <h1>Contact Us</h1>
      <p class="subtitle">Get in touch with our team for consultations, ready solutions, and custom software development.</p>

      <div class="contact-info-grid">
        <div class="contact-item">
          <div class="item-icon">📍</div>
          <h3>Office Address</h3>
          <p>{{ settings.site_address || 'Dhaka, Bangladesh' }}</p>
        </div>

        <div class="contact-item">
          <div class="item-icon">📞</div>
          <h3>Phone</h3>
          <p>
            <a :href="'tel:' + (settings.site_phone || '+8801797488350')">{{ settings.site_phone || '+880 1797488350' }}</a>
          </p>
        </div>

        <div class="contact-item">
          <div class="item-icon">✉️</div>
          <h3>Email</h3>
          <p>
            <a :href="'mailto:' + (settings.site_email || 'info@expertvence.com')">{{ settings.site_email || 'info@expertvence.com' }}</a>
          </p>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import { computed } from 'vue'
import { useSettingsStore } from '@/stores/settings'

const settingsStore = useSettingsStore()
const settings = computed(() => settingsStore.settings)
</script>

<style scoped>
.contact-page {
  padding: 80px 20px;
  max-width: 900px;
  margin: 0 auto;
}

.contact-card {
  background: #0f172a;
  border: 1px solid rgba(91, 231, 255, 0.2);
  border-radius: 20px;
  padding: 48px 32px;
  text-align: center;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
}

.contact-card h1 {
  font-size: 32px;
  font-weight: 800;
  color: #fff;
  margin: 0 0 12px;
}

.subtitle {
  color: #94a3b8;
  font-size: 16px;
  max-width: 600px;
  margin: 0 auto 40px;
}

.contact-info-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 24px;
}

.contact-item {
  background: rgba(255, 255, 255, 0.03);
  border: 1px solid rgba(255, 255, 255, 0.08);
  border-radius: 14px;
  padding: 24px 16px;
}

.item-icon {
  font-size: 28px;
  margin-bottom: 12px;
}

.contact-item h3 {
  font-size: 15px;
  font-weight: 600;
  color: #5be7ff;
  margin: 0 0 8px;
}

.contact-item p {
  color: #cbd5e1;
  font-size: 14px;
  margin: 0;
  line-height: 1.5;
}

.contact-item a {
  color: #5be7ff;
  text-decoration: none;
}

.contact-item a:hover {
  text-decoration: underline;
}
</style>
