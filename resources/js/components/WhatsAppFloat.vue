<template>
  <button
    class="whatsapp-float"
    :data-tooltip="tooltipText"
    aria-label="Chat with us on WhatsApp"
    @click="openWhatsApp"
  >
    <i class="fab fa-whatsapp"></i>
  </button>
</template>

<script setup>
import { computed } from 'vue'
import { useRoute } from 'vue-router'

const route = useRoute()
const phone = '8801797488350'

/* Page-wise messages */
const messages = {
  home: 'Hello ExpertVence Software, I want to discuss a project',
  services: 'Hello ExpertVence Software, I want to know about your services',
  about: 'Hello ExpertVence Software, I want to know more about your company',
  contact: 'Hello ExpertVence Software, I want to contact your team',
}

/* Resolve message dynamically */
const message = computed(() => {
  return messages[route.name] || 'Is, anyone available to chat?'
})

const tooltipText = computed(() => 'Chat with us on WhatsApp')

/* Open WhatsApp on click */
function openWhatsApp() {
  const url = `https://wa.me/${phone}?text=${encodeURIComponent(message.value)}`
  window.open(url, '_blank')
}
</script>
