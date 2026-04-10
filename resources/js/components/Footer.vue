<template>
  <footer class="footer">
    <div class="footer-container">

    <!-- BRAND -->
<div class="footer-brand">
  <h2 class="brand-title">ExpertVence</h2>

  <span class="brand-slogan">Where Code Meets Expertise</span>

  <p class="brand-description">
    Custom Software, Apps & Digital Solutions.
  </p>

<div class="socials">
  <a href="https://www.facebook.com/" target="_blank" rel="noopener noreferrer" class="social facebook">
    <i class="fab fa-facebook-f"></i>
  </a>

  <a href="https://www.linkedin.com/in/yourprofile" target="_blank" rel="noopener noreferrer" class="social linkedin">
    <i class="fab fa-linkedin-in"></i>
  </a>

  <a href="https://twitter.com/yourhandle" target="_blank" rel="noopener noreferrer" class="social twitter">
    <i class="fab fa-x-twitter"></i>
  </a>

  <a href="https://www.pinterest.com/yourprofile" target="_blank" rel="noopener noreferrer" class="social pinterest">
    <i class="fab fa-pinterest-p"></i>
  </a>
</div>

</div>


      <!-- EXPLORE -->
      <div class="footer-links">
        <h4>Explore</h4>
        <ul>
          <li><router-link to="/about">About</router-link></li>
          <li><router-link to="/contact">Contact</router-link></li>
          <li><router-link to="/portfolio">Recent Works</router-link></li>
          <li><router-link to="/services">Services</router-link></li>
          <li>Privacy Policy</li>
        </ul>
      </div>

      <!-- NEWSLETTER -->
<div class="footer-newsletter">
  <h4>Newsletter</h4>
  <p>Subscribe to our newsletter and get updates in your inbox.</p>

<input type="text" placeholder="Enter Full Name" v-model="fullName" />
<input type="email" placeholder="Enter Email Address" v-model="email" />
<button :disabled="isSubmitting" @click="subscribeNewsletter">
  {{ isSubmitting ? 'SUBMITTING...' : 'SUBSCRIBE' }}
</button>

</div>


      <!-- CONTACT -->
      <div class="footer-contact">
        <h4>Dhaka OFFICE </h4>
        <p>Shanir Akhra, Jatrabari, Dhaka, Bangladesh </p>
        <p>📞 +880 1797488350</p>
        <p>✉ expertvence@gmail.com</p>
      </div>

    </div>

    <div class="footer-bottom">
      © {{ year }} ExpertVence Software. All Rights Reserved.
    </div>
  </footer>
</template>

<script setup>
import { ref } from 'vue'
import axios from 'axios'

const fullName = ref('')
const email = ref('')
const isSubmitting = ref(false)

const subscribeNewsletter = async () => {
  if (!fullName.value || !email.value) {
    alert('Please fill both fields')
    return
  }

  isSubmitting.value = true

  try {
    await axios.post('/api/auth/newsletter/subscribe', {
      name: fullName.value,
      email: email.value
    })

    alert('Subscribed successfully! Check your email.')
    fullName.value = ''
    email.value = ''
  } catch (error) {
    console.error(error)
    alert(error.response?.data?.message || 'Subscription failed')
  } finally {
    isSubmitting.value = false
  }
}
</script>


