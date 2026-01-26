<template>
  <main class="home">

    <!-- HERO -->
<!-- HERO CAROUSEL -->
<section class="hero-carousel">
  <div
    v-for="(slide, index) in slides"
    :key="index"
    class="hero-slide"
    :class="{ active: index === activeSlide }"
    :style="{ background: slide.bg }"
  >
    <div class="hero-content">
      <h1 v-html="slide.title"></h1>
      <p>{{ slide.subtitle }}</p>

      <div class="hero-actions">
        <router-link :to="slide.primaryLink" class="btn primary">
          {{ slide.primaryText }}
        </router-link>
        <router-link :to="slide.secondaryLink" class="btn outline">
          {{ slide.secondaryText }}
        </router-link>
      </div>
    </div>
  </div>
</section>


   <!-- STATS -->
<section class="home-stats fade-section" ref="statsSection">
  <h2 class="stats-title">Our Achievements</h2>
  <p class="stats-subtitle">
    Numbers that define our expertise
  </p>

  <div class="stats-grid">
    <div class="stat-card">
      <h2>{{ projects }}+</h2>
      <p>Projects Delivered</p>
    </div>

    <div class="stat-card">
      <h2>{{ clients }}+</h2>
      <p>Happy Clients</p>
    </div>

    <div class="stat-card">
      <h2>{{ experience }}+</h2>
      <p>Years Experience</p>
    </div>
  </div>
</section>




    <!-- SERVICES -->
    <section class="industries-section fade-section">
  <div class="corner-shape"></div>

  <div class="industries-container">
    <div class="industries-header">
      <span class="section-tag">SERVICES COVERAGE</span>
      <h2>Industries We Serve</h2>
      <p>
        We build scalable and secure digital solutions
        across diverse business industries.
      </p>
    </div>

    <div class="industries-grid">

      <div class="industry-card red">
        <div class="industry-icon">🛒</div>
        <span>Retail & Ecommerce</span>
      </div>

      <div class="industry-card blue">
        <div class="industry-icon">🎓</div>
        <span>Education & E-Learning</span>
      </div>

      <div class="industry-card green">
        <div class="industry-icon">⚡</div>
        <span>On-Demand Solutions</span>
      </div>

      <div class="industry-card yellow">
        <div class="industry-icon">🍽️</div>
        <span>Food & Restaurant</span>
      </div>

      <div class="industry-card purple">
        <div class="industry-icon">🏥</div>
        <span>Healthcare & Fitness</span>
      </div>

      <div class="industry-card cyan">
        <div class="industry-icon">📰</div>
        <span>News Portal & Media</span>
      </div>

      <div class="industry-card orange">
        <div class="industry-icon">👥</div>
        <span>Social Networking</span>
      </div>

      <div class="industry-card pink">
        <div class="industry-icon">🏢</div>
        <span>Real Estate</span>
      </div>

      <div class="industry-card teal">
        <div class="industry-icon">✈️</div>
        <span>Travel & Hospitality</span>
      </div>

      <div class="industry-card lime">
        <div class="industry-icon">🎮</div>
        <span>Gaming</span>
      </div>

    </div>
  </div>
</section>

<section class="services-section">
  <div class="services-container">

    <div class="services-header">
      <span class="section-tag">SERVICES</span>
      <h2>Services We Offer</h2>
      <p>
        We build scalable, secure and high-performance digital products
        tailored to your business needs.
      </p>
    </div>

    <div class="services-grid">

      <!-- Card -->
      <div class="service-card">
        <div class="service-title">
          <i class="fa-solid fa-mobile-screen-button red"></i>
          <h4>Mobile App Development</h4>
        </div>
        <ul>
          <li><i class="fa-brands fa-android"></i> Android App</li>
          <li><i class="fa-brands fa-apple"></i> iOS App</li>
          <li><i class="fa-brands fa-react"></i> React Native</li>
          <li><i class="fa-solid fa-code"></i> Flutter</li>
        </ul>
      </div>

      <div class="service-card">
        <div class="service-title">
          <i class="fa-solid fa-globe blue"></i>
          <h4>Web Development</h4>
        </div>
        <ul>
          <li><i class="fa-brands fa-vuejs"></i> Vue / Nuxt</li>
          <li><i class="fa-brands fa-laravel"></i> Laravel</li>
          <li><i class="fa-brands fa-node-js"></i> Node.js</li>
          <li><i class="fa-solid fa-database"></i> MySQL</li>
        </ul>
      </div>

      <div class="service-card">
        <div class="service-title">
          <i class="fa-brands fa-bitcoin green"></i>
          <h4>Blockchain Development</h4>
        </div>
        <ul>
          <li><i class="fa-brands fa-ethereum"></i> Ethereum</li>
          <li><i class="fa-solid fa-file-contract"></i> Smart Contracts</li>
          <li><i class="fa-solid fa-link"></i> Web3</li>
          <li><i class="fa-solid fa-cube"></i> NFT Platform</li>
        </ul>
      </div>

      <div class="service-card">
        <div class="service-title">
          <i class="fa-solid fa-cart-shopping yellow"></i>
          <h4>E-commerce Development</h4>
        </div>
        <ul>
          <li><i class="fa-brands fa-shopify"></i> Shopify</li>
          <li><i class="fa-brands fa-magento"></i> Magento</li>
          <li><i class="fa-solid fa-credit-card"></i> Payment Gateway</li>
        </ul>
      </div>

      <div class="service-card">
        <div class="service-title">
          <i class="fa-solid fa-shield-halved purple"></i>
          <h4>Cyber Security</h4>
        </div>
        <ul>
          <li><i class="fa-solid fa-lock"></i> Application Security</li>
          <li><i class="fa-solid fa-cloud"></i> Cloud Security</li>
          <li><i class="fa-solid fa-bug"></i> Pen Testing</li>
        </ul>
      </div>

      <div class="service-card">
        <div class="service-title">
          <i class="fa-solid fa-brain cyan"></i>
          <h4>AI & Machine Learning</h4>
        </div>
        <ul>
          <li><i class="fa-solid fa-robot"></i> AI Automation</li>
          <li><i class="fa-solid fa-chart-line"></i> Data Analytics</li>
          <li><i class="fa-solid fa-language"></i> NLP</li>
        </ul>
      </div>

    </div>
  </div>
</section>



<section class="why-usp-section fade-section">
  <div class="why-usp-container">

    <!-- Section Header -->
    <div class="why-usp-header">
      <span class="why-usp-tag">WHY CHOOSE US</span>
      <h2>Why ExpertVence Software?</h2>
    </div>

    <!-- Cards -->
    <div class="why-usp-grid">

      <div class="why-usp-card">
        <div class="why-usp-icon">
          👨‍💻
        </div>

        <h3>Dedicated Development Team</h3>

        <p>
          Our skilled engineers are fully dedicated to delivering
          high-quality solutions tailored to your business needs,
          ensuring reliability and performance.
        </p>

        <router-link to="/contact" class="why-usp-link">
          START NOW <span>➜</span>
        </router-link>
      </div>

      <div class="why-usp-card">
        <div class="why-usp-icon">
          🏆
        </div>

        <h3>Quality Deliverance</h3>

        <p>
          We follow strict quality standards and best practices
          to ensure every project meets requirements,
          deadlines and industry benchmarks.
        </p>

        <router-link to="/portfolio" class="why-usp-link">
          START NOW <span>➜</span>
        </router-link>
      </div>

      <div class="why-usp-card">
        <div class="why-usp-icon">
          🎧
        </div>

        <h3>Excellent Support</h3>

        <p>
          From project kickoff to post-launch support,
          our team stays connected to ensure smooth operation,
          updates and long-term success.
        </p>

        <router-link to="/contact" class="why-usp-link">
          START NOW <span>➜</span>
        </router-link>
      </div>

    </div>
  </div>
</section>


    <!-- About Us -->
      <section class="about-section fade-section">
    <div class="about-container">

      <!-- LEFT IMAGE -->
      <div class="about-image">
        <img
          src=""
          alt="ExpertVence Team"
        />

        <div class="about-badge">
          <h3>98%</h3>
          <p>Satisfied Customers</p>
        </div>
      </div>

      <!-- RIGHT CONTENT -->
      <div class="about-content">
        <span class="about-tag">ABOUT ExpertVence</span>

        <h2>
          Experienced & Quality <br />
          IT Services Providers
        </h2>

        <p class="about-text">
          We are a highly experienced IT services company dedicated to
          delivering top-quality digital solutions. From software
          development to secure systems, we help businesses grow and
          succeed in the modern digital era.
        </p>

        <div class="about-features">
          <div class="feature">
            ✔ Innovative Work
          </div>
          <div class="feature">
            ✔ Customized Services
          </div>
        </div>

        <router-link to="/about" class="btn primary">
          Discover More
        </router-link>
      </div>

    </div>
  </section>

<!-- TECH -->
<section class="home-tech fade-section">
  <h2>Technology We Use</h2>

  <div class="tech-row">
  <div
    v-for="tech in techs"
    :key="tech.name"
    class="tech-item"
  >
    <img :src="tech.icon" :alt="tech.name" />
    <span>{{ tech.name }}</span>
  </div>
</div>

</section>




    <!-- PORTFOLIO -->
<section class="projects-v2">
  <div class="projects-header">
    <span class="tag">PROJECT HIGHLIGHTS</span>
    <h2>Our Recent Projects</h2>
    <p>
      We design and develop scalable digital products with real-world impact.
    </p>
  </div>

  <div class="projects-grid">
    <!-- CARD 1 -->
    <div class="project-card">
      <div class="project-thumb">
        <img src="" alt="Education Platform">
        <span class="project-badge">Education</span>
      </div>

      <div class="project-body">
        <h3>Education Consultancy Platform</h3>
        <div class="tech-tags">
          <span>Laravel</span>
          <span>Vue</span>
          <span>Automation</span>
        </div>

        <a href="#" class="read-more">
          Read More <span>→</span>
        </a>
      </div>
    </div>

    <!-- CARD 2 -->
    <div class="project-card">
      <div class="project-thumb">
        <img src="" alt="Travel Website">
        <span class="project-badge blue">Travel</span>
      </div>

      <div class="project-body">
        <h3>WAFIMA – Tour & Travel Website</h3>
        <div class="tech-tags">
          <span>WordPress</span>
          <span>Elementor</span>
          <span>CMS</span>
        </div>

        <a href="#" class="read-more">
          Read More <span>→</span>
        </a>
      </div>
    </div>

    <!-- CARD 3 -->
    <div class="project-card">
      <div class="project-thumb">
        <img src="" alt="EdTech Platform">
        <span class="project-badge purple">EdTech</span>
      </div>

      <div class="project-body">
        <h3>Classter – Education Technology Platform</h3>
        <div class="tech-tags">
          <span>Core JS</span>
          <span>WordPress</span>
          <span>CMS</span>
        </div>

        <a href="#" class="read-more">
          Read More <span>→</span>
        </a>
      </div>
    </div>
  </div>
</section>


<!-- CTA -->
<section class="cta-unique fade-section">
  <div class="cta-bg-shape cta-shape-1"></div>
  <div class="cta-bg-shape cta-shape-2"></div>

  <div class="cta-content">
    <span class="cta-badge">Let’s Work Together</span>

    <h2>
      Have a <span>Project</span> in Mind?
    </h2>

    <p>
      Tell us about your idea and let ExpertVence Software
      transform it into a scalable digital solution.
    </p>

    <router-link to="/contact" class="cta-btn">
      Get Started
      <span class="arrow">→</span>
    </router-link>
  </div>
</section>

<!-- FAQ -->
<section class="faq-section fade-section">
  <div class="faq-wrapper">

    <!-- IMAGE -->
    <div class="faq-image">
  <img :src="faqImage" alt="FAQ Illustration" />


    </div>

    <!-- CONTENT -->
    <div class="faq-content">
      <h2>Frequently Asked Questions</h2>
      <p class="faq-sub">
        Common questions before working with ExpertVence Software.
      </p>

      <div class="faq-list">
        <div
          v-for="(item, index) in faqs"
          :key="index"
          class="faq-item"
        >
          <button
            class="faq-question"
            @click="toggleFaq(index)"
          >
            {{ item.q }}
            <span
              class="icon"
              :class="{ open: activeFaq === index }"
            >+</span>
          </button>

          <div
  class="faq-answer"
  ref="answers"
  :style="{
    height: activeFaq === index
      ? answers[index]?.scrollHeight + 'px'
      : '0px'
  }"
>
  <p>{{ item.a }}</p>
</div>

        </div>
      </div>
    </div>

  </div>

  <!-- NEWSLETTER -->
<div class="faq-newsletter">
  <h4>Stay Updated</h4>
  <p>Get product updates & company news directly in your inbox.</p>

  <form class="newsletter-form" @submit.prevent="subscribe">
    <input
      type="email"
      placeholder="Enter your email address"
      required
    />
    <button type="submit">Subscribe</button>
  </form>
</div>

</section>


  </main>
</template>
<script setup>
import { ref, onMounted, onUnmounted, nextTick } from 'vue'


import php from '@/assets/tech/php.svg'
import python from '@/assets/tech/python.svg'
import laravel from '@/assets/tech/laravel.svg'
import django from '@/assets/tech/django.svg'
import wordpress from '@/assets/tech/wordpress.svg'
import react from '@/assets/tech/react.svg'
import vue from '@/assets/tech/vuejs.svg'
import flutter from '@/assets/tech/flutter.svg'
import android from '@/assets/tech/android.svg'
import apple from '@/assets/tech/apple.svg'
import mysql from '@/assets/tech/mysql.svg'
import docker from '@/assets/tech/docker.svg'

const techs = [
  { name: 'PHP', icon: php },
  { name: 'Python', icon: python },
  { name: 'Laravel', icon: laravel },
  { name: 'Django', icon: django },
  { name: 'WordPress', icon: wordpress },
  { name: 'Vue', icon: vue },
  { name: 'React', icon: react },
  { name: 'Flutter', icon: flutter },
  { name: 'Android', icon: android },
  { name: 'iOS', icon: apple },
  { name: 'MySQL', icon: mysql },
  { name: 'Docker', icon: docker },
]



/* ================= HERO SLIDER ================= */

const slides = [
  {
    title: 'We Build <span>Modern</span> & <span>Scalable</span> Software',
    subtitle:
      'High-performance web & SaaS solutions using Laravel & Vue.',
    bg: 'linear-gradient(135deg, #020617, #1e293b)',
    primaryText: 'Our Services',
    primaryLink: '/services',
    secondaryText: 'Contact Us',
    secondaryLink: '/contact',
  },
  {
    title: 'Enterprise <span>Web</span> & <span>API</span> Solutions',
    subtitle:
      'Secure, scalable and future-ready digital platforms.',
    bg: 'linear-gradient(135deg, #312e81, #1e1b4b)',
    primaryText: 'View Portfolio',
    primaryLink: '/portfolio',
    secondaryText: 'Get Quote',
    secondaryLink: '/contact',
  },
  {
    title: 'Build Your Next <span>SaaS</span> With Confidence',
    subtitle:
      'From idea to production — we deliver excellence.',
    bg: 'linear-gradient(135deg, #064e3b, #022c22)',
    primaryText: 'Start Project',
    primaryLink: '/contact',
    secondaryText: 'About Us',
    secondaryLink: '/about',
  },
]

const activeSlide = ref(0)
let interval = null

/* ================= STATS COUNTER ================= */

const projects = ref(0)
const clients = ref(0)
const experience = ref(0)

const statsSection = ref(null)
let statsAnimated = false

function animateCount(target, refVar, speed = 20) {
  let count = 0
  const step = Math.ceil(target / 60)

  const timer = setInterval(() => {
    count += step
    if (count >= target) {
      refVar.value = target
      clearInterval(timer)
    } else {
      refVar.value = count
    }
  }, speed)
}

/* ================= LIFECYCLE ================= */

onMounted(() => {
  /* Fade-in animation */
  const sections = document.querySelectorAll('.fade-section')
  sections.forEach((section, index) => {
    setTimeout(() => {
      section.classList.add('visible')
    }, index * 120)
  })

  /* Hero auto carousel */
  interval = setInterval(() => {
    activeSlide.value =
      (activeSlide.value + 1) % slides.length
  }, 5000)

  /* Stats counter on scroll */
  const observer = new IntersectionObserver(
    ([entry]) => {
      if (entry.isIntersecting && !statsAnimated) {
        statsAnimated = true

        animateCount(50, projects)
        animateCount(20, clients)
        animateCount(5, experience)

        observer.disconnect()
      }
    },
    { threshold: 0.4 }
  )

  if (statsSection.value) {
    observer.observe(statsSection.value)
  }
})

onUnmounted(() => {
  clearInterval(interval)
})


import faqImage from '@/assets/images/faq2.svg'


const activeFaq = ref(null)
const answers = ref([])

const faqs = [
  {
    q: 'How long does a project take?',
    a: 'Project duration depends on scope, but most projects take 2–6 weeks.',
  },
  {
    q: 'Which technologies do you use?',
    a: 'We use Laravel, Vue 3, REST API, MySQL, Docker and modern tools.',
  },
  {
    q: 'Do you provide long-term support?',
    a: 'Yes, we provide maintenance and long-term support after delivery.',
  },
  {
    q: 'Can you build custom SaaS products?',
    a: 'Absolutely. We specialize in scalable SaaS platforms.',
  },
]

const toggleFaq = async (index) => {
  activeFaq.value = activeFaq.value === index ? null : index
  await nextTick()
}


const subscribe = () => {
  alert('Subscribed successfully!')
}



</script>




