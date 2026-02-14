<template>
  <footer class="footer">
    <div class="footer-container">

      <!-- BRAND -->
      <div class="footer-brand">
        <h2>ExpertVence</h2>
        <p>
          Fuel an idea with technology & build scalable,
          secure and modern software solutions.
        </p>

        <div class="socials">
          <a href="#">🌐</a>
          <a href="#">🐦</a>
          <a href="#">💼</a>
          <a href="#">📸</a>
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

        <input type="text" placeholder="Enter Full Name" />
        <input type="email" placeholder="Enter Email Address" />
        <button>SUBSCRIBE</button>
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
const year = new Date().getFullYear()
</script>
