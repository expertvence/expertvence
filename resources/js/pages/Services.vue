<template>
  <section class="services-page">
    <!-- Hero Section with Topography -->
    <div class="section-hero">
      <div class="topography-lines">
        <div class="line line-1"></div>
        <div class="line line-2"></div>
        <div class="line line-3"></div>
        <div class="line line-4"></div>
      </div>
      
      <div class="hero-content">
        <div class="hero-badge">Digital Excellence</div>
        <h1 class="hero-title">
          Where <span class="text-gradient">Innovation</span> Meets 
          <span class="text-outline">Expertise</span>
        </h1>
        <p class="hero-subtitle">
          We architect digital solutions that transform businesses and create 
          lasting impact in the technology landscape.
        </p>
        
        <div class="hero-stats">
          <div class="stat">
            <div class="stat-number" data-count="200">0</div>
            <div class="stat-label">Projects</div>
          </div>
          <div class="stat-divider"></div>
          <div class="stat">
            <div class="stat-number" data-count="50">0</div>
            <div class="stat-label">Clients</div>
          </div>
          <div class="stat-divider"></div>
          <div class="stat">
            <div class="stat-number" data-count="99">0</div>
            <div class="stat-label">Satisfaction</div>
          </div>
        </div>
      </div>
    </div>

    <!-- Services Showcase -->
    <div class="section-showcase">
      <div class="topography-grid">
        <div class="grid-line vertical"></div>
        <div class="grid-line horizontal"></div>
        <div class="grid-point point-1"></div>
        <div class="grid-point point-2"></div>
        <div class="grid-point point-3"></div>
      </div>

      <div class="section-header">
        <h2 class="section-title">
          Our Digital <span class="highlight">Capabilities</span>
        </h2>
        <p class="section-description">
          Comprehensive suite of services designed to propel your business forward
          in the digital era.
        </p>
      </div>

      <div class="services-grid">
        <!-- Software Development -->
        <div 
          class="service-card card-development"
          @click="$router.push('/services/software-development')"
        >
          <div class="card-topography">
            <div class="topo-wave wave-1"></div>
            <div class="topo-wave wave-2"></div>
            <div class="topo-dot dot-1"></div>
            <div class="topo-dot dot-2"></div>
          </div>
          
          <div class="card-content">
            <div class="card-header">
              <div class="service-icon">
                <span>💻</span>
                <div class="icon-glow"></div>
              </div>
              <div class="service-badge">
                <span class="badge-text">Development</span>
                <span class="badge-line"></span>
              </div>
            </div>
            
            <h3 class="card-title">Software Development</h3>
            <p class="card-description">
              Enterprise-grade custom software solutions built for scale, 
              security, and superior performance.
            </p>
            
            <div class="service-features">
              <div class="feature">
                <div class="feature-icon">⚡</div>
                <span>Scalable Architecture</span>
              </div>
              <div class="feature">
                <div class="feature-icon">🛡️</div>
                <span>Secure Code</span>
              </div>
              <div class="feature">
                <div class="feature-icon">🚀</div>
                <span>Fast Delivery</span>
              </div>
            </div>
            
            <div class="card-footer">
              <button class="explore-btn">
                <span>Explore →</span>
                <svg class="arrow" width="20" height="20" viewBox="0 0 24 24">
                  <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2"/>
                </svg>
              </button>
            </div>
          </div>
          
          <div class="card-hover-effect"></div>
        </div>

        <!-- Web & App Development -->
        <div 
          class="service-card card-webapp"
          @click="$router.push('/services/web-app-development')"
        >
          <div class="card-topography">
            <div class="topo-wave wave-1"></div>
            <div class="topo-wave wave-2"></div>
            <div class="topo-dot dot-1"></div>
            <div class="topo-dot dot-2"></div>
          </div>
          
          <div class="card-content">
            <div class="card-header">
              <div class="service-icon">
                <span>🌐</span>
                <div class="icon-glow"></div>
              </div>
              <div class="service-badge">
                <span class="badge-text">Web & Mobile</span>
                <span class="badge-line"></span>
              </div>
            </div>
            
            <h3 class="card-title">Web & App Development</h3>
            <p class="card-description">
              Modern web and mobile applications that deliver exceptional 
              user experiences across all platforms.
            </p>
            
            <div class="service-features">
              <div class="feature">
                <div class="feature-icon">📱</div>
                <span>Responsive Design</span>
              </div>
              <div class="feature">
                <div class="feature-icon">⚡</div>
                <span>High Performance</span>
              </div>
              <div class="feature">
                <div class="feature-icon">🔗</div>
                <span>API Integration</span>
              </div>
            </div>
            
            <div class="card-footer">
              <button class="explore-btn">
                <span>Explore →</span>
                <svg class="arrow" width="20" height="20" viewBox="0 0 24 24">
                  <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2"/>
                </svg>
              </button>
            </div>
          </div>
          
          <div class="card-hover-effect"></div>
        </div>

        <!-- Design -->
        <div 
          class="service-card card-design"
          @click="$router.push('/services/design')"
        >
          <div class="card-topography">
            <div class="topo-wave wave-1"></div>
            <div class="topo-wave wave-2"></div>
            <div class="topo-dot dot-1"></div>
            <div class="topo-dot dot-2"></div>
          </div>
          
          <div class="card-content">
            <div class="card-header">
              <div class="service-icon">
                <span>🎨</span>
                <div class="icon-glow"></div>
              </div>
              <div class="service-badge">
                <span class="badge-text">Design</span>
                <span class="badge-line"></span>
              </div>
            </div>
            
            <h3 class="card-title">UI/UX Design</h3>
            <p class="card-description">
              Beautiful, intuitive interfaces that enhance user engagement 
              and drive business conversion.
            </p>
            
            <div class="service-features">
              <div class="feature">
                <div class="feature-icon">✨</div>
                <span>User-Centered</span>
              </div>
              <div class="feature">
                <div class="feature-icon">🎯</div>
                <span>Conversion Focused</span>
              </div>
              <div class="feature">
                <div class="feature-icon">📐</div>
                <span>Pixel Perfect</span>
              </div>
            </div>
            
            <div class="card-footer">
              <button class="explore-btn">
                <span>Explore →</span>
                <svg class="arrow" width="20" height="20" viewBox="0 0 24 24">
                  <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2"/>
                </svg>
              </button>
            </div>
          </div>
          
          <div class="card-hover-effect"></div>
        </div>
      </div>
    </div>

    <!-- Process Section -->
    <div class="section-process">
      <div class="process-topography">
        <div class="process-line"></div>
        <div class="process-node node-1" data-step="1"></div>
        <div class="process-node node-2" data-step="2"></div>
        <div class="process-node node-3" data-step="3"></div>
        <div class="process-node node-4" data-step="4"></div>
      </div>

      <div class="section-header">
        <h2 class="section-title">
          <span class="title-number">02</span>
          Our <span class="highlight">Process</span> Journey
        </h2>
        <p class="section-description">
          A systematic approach that ensures precision, quality, and timely 
          delivery at every step.
        </p>
      </div>

      <div class="process-steps">
        <div class="step">
          <div class="step-number">01</div>
          <h3 class="step-title">Discovery & Planning</h3>
          <p class="step-description">
            Understanding your vision, goals, and requirements through 
            comprehensive analysis and strategic planning.
          </p>
          <div class="step-connector"></div>
        </div>
        
        <div class="step">
          <div class="step-number">02</div>
          <h3 class="step-title">Design & Prototyping</h3>
          <p class="step-description">
            Creating intuitive designs and interactive prototypes that 
            bring your ideas to life before development.
          </p>
          <div class="step-connector"></div>
        </div>
        
        <div class="step">
          <div class="step-number">03</div>
          <h3 class="step-title">Development & Testing</h3>
          <p class="step-description">
            Building robust solutions with clean code and rigorous testing 
            to ensure flawless performance.
          </p>
          <div class="step-connector"></div>
        </div>
        
        <div class="step">
          <div class="step-number">04</div>
          <h3 class="step-title">Deployment & Support</h3>
          <p class="step-description">
            Launching your product and providing ongoing support, 
            maintenance, and optimization services.
          </p>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="section-cta">
      <div class="cta-topography">
        <div class="cta-wave"></div>
        <div class="cta-dots">
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
          <div class="dot"></div>
        </div>
      </div>

      <div class="cta-content">
        <h2 class="cta-title">
          Ready to <span class="text-gradient">Transform</span> 
          Your Digital Presence?
        </h2>
        <p class="cta-description">
          Let's collaborate to build something extraordinary. 
          Schedule a free consultation with our experts.
        </p>
        
        <div class="cta-actions">
          <button class="btn-primary" @click="showModal = true">
            <span>Start Project</span>
            <svg class="btn-icon" width="20" height="20" viewBox="0 0 24 24">
              <path d="M13 7L19 13M19 13L13 19M19 13H5" stroke="currentColor" stroke-width="2"/>
            </svg>
          </button>
          
          <button class="btn-secondary" @click="$router.push('/portfolio')">
            View Case Studies
          </button>
        </div>
      </div>
    </div>

    <!-- Contact Modal -->
    <ContactModal v-if="showModal" :show="showModal" @close="showModal = false" />
  </section>
</template>

<script setup>
import { ref, onMounted } from 'vue'
import ContactModal from '@/components/ContactModal.vue'

const showModal = ref(false)

onMounted(() => {
  // Animate counter numbers
  const counters = document.querySelectorAll('.stat-number')
  counters.forEach(counter => {
    const target = parseInt(counter.getAttribute('data-count'))
    const increment = target / 100
    let current = 0
    
    const updateCounter = () => {
      if (current < target) {
        current += increment
        counter.textContent = Math.floor(current)
        setTimeout(updateCounter, 20)
      } else {
        counter.textContent = target + '+'
      }
    }
    
    setTimeout(updateCounter, 500)
  })
})
</script>