<template>
  <div class="case-study-page">
    <!-- Back Button -->
    <div class="case-study-header">
      <button class="back-button" @click="goBack">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M15 18L9 12L15 6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
        </svg>
        Back to Portfolio
      </button>
    </div>

    <!-- Case Study Hero -->
    <section class="case-study-hero">
      <div class="hero-topography">
        <div class="topo-wave"></div>
        <div class="topo-grid">
          <div class="grid-line vertical"></div>
          <div class="grid-line horizontal"></div>
        </div>
      </div>

      <div class="hero-content">
        <div class="project-badge">Case Study</div>
        
        <h1 class="project-title">{{ projectData.title }}</h1>
        
        <div class="project-meta">
          <div class="meta-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <path d="M21 10H3M16 2V6M8 2V6M7.8 22H16.2C17.8802 22 18.7202 22 19.362 21.673C19.9265 21.3854 20.3854 20.9265 20.673 20.362C21 19.7202 21 18.8802 21 17.2V8.8C21 7.11984 21 6.27976 20.673 5.63803C20.3854 5.07354 19.9265 4.6146 19.362 4.32698C18.7202 4 17.8802 4 16.2 4H7.8C6.11984 4 5.27976 4 4.63803 4.32698C4.07354 4.6146 3.6146 5.07354 3.32698 5.63803C3 6.27976 3 7.11984 3 8.8V17.2C3 18.8802 3 19.7202 3.32698 20.362C3.6146 20.9265 4.07354 21.3854 4.63803 21.673C5.27976 22 6.11984 22 7.8 22Z" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span>{{ projectData.year }}</span>
          </div>
          
          <div class="meta-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <path d="M12 15C13.6569 15 15 13.6569 15 12C15 10.3431 13.6569 9 12 9C10.3431 9 9 10.3431 9 12C9 13.6569 10.3431 15 12 15Z" 
                    stroke="currentColor" stroke-width="2"/>
              <path d="M19.4 15C19.2662 15.3035 19.1059 15.5925 18.921 15.8632C17.9399 17.2387 16.536 18.2393 14.935 18.7094C13.334 19.1794 11.6345 19.0929 10.0871 18.4625C8.53978 17.8322 7.23542 16.6922 6.38756 15.2291C5.53969 13.766 5.19621 12.0643 5.40942 10.386C5.62263 8.70774 6.37953 7.15016 7.56014 5.94581C8.74075 4.74145 10.2773 3.959 11.9375 3.717C13.5978 3.475 15.2873 3.78616 16.75 4.60004" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            <span>{{ projectData.client }}</span>
          </div>
          
          <div class="meta-item">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <path d="M13 2L3 14H12L11 22L21 10H12L13 2Z" 
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span>{{ projectData.duration }}</span>
          </div>
        </div>
        
        <p class="project-description">
          {{ projectData.description }}
        </p>
        
        <div class="project-tech-stack">
          <h3>Technology Stack</h3>
          <div class="tech-tags">
            <span v-for="tech in projectData.technologies" :key="tech" class="tech-tag">
              {{ tech }}
            </span>
          </div>
        </div>
      </div>
    </section>

    <!-- Project Overview -->
    <section class="project-overview">
      <div class="container">
        <h2>Project Overview</h2>
        <div class="overview-content">
          <div class="overview-text">
            <h3>The Challenge</h3>
            <p>{{ projectData.challenge }}</p>
            
            <h3>Our Solution</h3>
            <p>{{ projectData.solution }}</p>
            
            <h3>Key Features</h3>
            <ul class="features-list">
              <li v-for="feature in projectData.features" :key="feature">
                {{ feature }}
              </li>
            </ul>
          </div>
          
          <div class="overview-stats">
            <div class="stat-card">
              <div class="stat-value">{{ projectData.metrics.revenueGrowth }}</div>
              <div class="stat-label">Revenue Growth</div>
            </div>
            
            <div class="stat-card">
              <div class="stat-value">{{ projectData.metrics.userGrowth }}</div>
              <div class="stat-label">User Growth</div>
            </div>
            
            <div class="stat-card">
              <div class="stat-value">{{ projectData.metrics.performance }}</div>
              <div class="stat-label">Performance Improvement</div>
            </div>
            
            <div class="stat-card">
              <div class="stat-value">{{ projectData.metrics.satisfaction }}</div>
              <div class="stat-label">Client Satisfaction</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Project Gallery -->
    <section class="project-gallery">
      <div class="container">
        <h2>Project Screenshots</h2>
        <div class="gallery-grid">
          <div class="gallery-item" v-for="n in 4" :key="n">
            <div class="screenshot-placeholder">
              <div class="screenshot-header">
                <div class="browser-dots">
                  <span class="dot"></span>
                  <span class="dot"></span>
                  <span class="dot"></span>
                </div>
              </div>
              <div class="screenshot-content">
                <!-- Screenshot content here -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonial -->
    <section class="testimonial-section">
      <div class="container">
        <div class="testimonial-card">
          <div class="quote-icon">"</div>
          <p class="testimonial-text">
            {{ projectData.testimonial }}
          </p>
          <div class="client-info">
            <div class="client-name">{{ projectData.clientName }}</div>
            <div class="client-position">{{ projectData.clientPosition }}</div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="case-study-cta">
      <div class="cta-content">
        <h2>Have a Similar Project in Mind?</h2>
        <p>Let's discuss how we can help bring your vision to life.</p>
        <button class="cta-button" @click="contactUs">
          Start a Conversation
          <svg width="20" height="20" viewBox="0 0 24 24">
            <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2"/>
          </svg>
        </button>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const projectId = ref(parseInt(route.params.id) || 1)

// Project data based on ID
const projectsData = {
  1: {
    title: 'Enterprise SaaS Platform',
    year: '2024',
    client: 'Enterprise Client',
    duration: '6 Months',
    description: 'A comprehensive SaaS solution for business analytics with real-time dashboard, automated reporting, and AI insights that transformed how our client processes and visualizes business data.',
    technologies: ['Laravel', 'Vue.js', 'MySQL', 'Redis', 'AWS', 'Docker', 'WebSockets'],
    challenge: 'The client needed a unified platform to process millions of data points from various sources and provide actionable insights in real-time. Their existing system was slow, fragmented, and couldn\'t scale.',
    solution: 'We developed a microservices-based architecture with real-time data processing, AI-powered analytics, and an intuitive dashboard that provides instant insights and predictive analytics.',
    features: [
      'Real-time data dashboard with customizable widgets',
      'AI-powered predictive analytics and trend detection',
      'Automated report generation and distribution',
      'Multi-tenant architecture for enterprise scaling',
      'Advanced user permission and role management',
      'Integration with 50+ third-party platforms'
    ],
    metrics: {
      revenueGrowth: '40%',
      userGrowth: '300%',
      performance: '10x Faster',
      satisfaction: '95%'
    },
    testimonial: 'The platform revolutionized our data analytics capabilities. What used to take days now happens in minutes. The team delivered beyond expectations.',
    clientName: 'John Anderson',
    clientPosition: 'CTO, Enterprise Solutions Inc.'
  },
  2: {
    title: 'Multi-vendor E-commerce Platform',
    year: '2023',
    client: 'Retail Brand',
    duration: '8 Months',
    description: 'Scalable e-commerce solution supporting 500+ vendors with real-time inventory management, AI-powered recommendations, and seamless payment processing.',
    technologies: ['Node.js', 'React', 'MongoDB', 'Stripe', 'Docker', 'Redis', 'Elasticsearch'],
    challenge: 'Managing multiple vendors with different inventory systems, pricing strategies, and shipping methods while maintaining a seamless customer experience.',
    solution: 'Built a scalable multi-vendor platform with real-time inventory sync, intelligent commission management, and AI-driven product recommendations.',
    features: [
      'Multi-vendor dashboard with commission tracking',
      'Real-time inventory synchronization',
      'AI-powered product recommendations',
      'Advanced search with filters and sorting',
      'Integrated payment gateway with split payments',
      'Automated shipping and tax calculations'
    ],
    metrics: {
      revenueGrowth: '150%',
      userGrowth: '500%',
      performance: '99.9% Uptime',
      satisfaction: '98%'
    },
    testimonial: 'The platform handles millions of visitors seamlessly. Vendor onboarding increased by 300% and customer satisfaction scores are through the roof.',
    clientName: 'Sarah Chen',
    clientPosition: 'CEO, RetailHub'
  },
  3: {
    title: 'Health & Fitness Mobile App',
    year: '2024',
    client: 'HealthTech Startup',
    duration: '5 Months',
    description: 'Cross-platform fitness application with workout tracking, nutrition planning, AI-powered personal coaching, and health data integration.',
    technologies: ['Flutter', 'Firebase', 'Node.js', 'ML Kit', 'Google Fit', 'Apple Health'],
    challenge: 'Creating a personalized fitness experience that adapts to individual goals, tracks progress accurately, and integrates with various health data sources.',
    solution: 'Developed an AI-powered fitness companion that creates personalized workout plans, tracks nutrition, and integrates with wearables for comprehensive health monitoring.',
    features: [
      'AI-powered workout plan generation',
      'Nutrition tracking with barcode scanning',
      'Integration with wearables and health apps',
      'Progress tracking with detailed analytics',
      'Community features and challenges',
      'Live coaching sessions'
    ],
    metrics: {
      revenueGrowth: '200%',
      userGrowth: '100K+ Downloads',
      performance: '4.8★ Rating',
      satisfaction: '96%'
    },
    testimonial: 'Our app retention rates tripled after launch. The AI coaching feature has been a game-changer for user engagement.',
    clientName: 'Dr. Michael Rodriguez',
    clientPosition: 'Founder, FitLife Technologies'
  },
  4: {
    title: 'Real-time Analytics Dashboard',
    year: '2023',
    client: 'Financial Services',
    duration: '4 Months',
    description: 'Enterprise dashboard for financial data visualization with predictive analytics, automated reporting, and real-time market insights.',
    technologies: ['Python', 'Django', 'React', 'D3.js', 'PostgreSQL', 'WebSockets'],
    challenge: 'Processing and visualizing complex financial data in real-time with predictive capabilities and ensuring data accuracy and security.',
    solution: 'Built a secure, real-time analytics platform with advanced data visualization, predictive modeling, and automated compliance reporting.',
    features: [
      'Real-time financial data visualization',
      'Predictive analytics and trend forecasting',
      'Automated compliance and regulatory reporting',
      'Customizable dashboard with drag-and-drop widgets',
      'Advanced security and access controls',
      'Integration with financial APIs and data sources'
    ],
    metrics: {
      revenueGrowth: '35%',
      userGrowth: '250%',
      performance: '10x Faster Insights',
      satisfaction: '97%'
    },
    testimonial: 'The dashboard provides insights we never had access to before. Decision-making time has been reduced from days to minutes.',
    clientName: 'Robert Williams',
    clientPosition: 'Head of Analytics, FinCorp'
  }
}

const projectData = computed(() => {
  return projectsData[projectId.value] || projectsData[1]
})

const goBack = () => {
  router.back()
}

const contactUs = () => {
  router.push({ name: 'Contact' })
}

onMounted(() => {
  console.log('Loading case study for project:', projectId.value)
})
</script>

<style scoped>
/* Add your CSS styles here for CaseStudy.vue */
.case-study-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 20px;
}

.case-study-header {
  margin-bottom: 40px;
}

.back-button {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: transparent;
  border: none;
  color: #666;
  font-size: 16px;
  cursor: pointer;
  padding: 10px 0;
  transition: color 0.3s;
}

.back-button:hover {
  color: #333;
}

.case-study-hero {
  position: relative;
  margin-bottom: 60px;
}

.project-badge {
  display: inline-block;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 6px 16px;
  border-radius: 20px;
  font-size: 14px;
  font-weight: 600;
  margin-bottom: 20px;
}

.project-title {
  font-size: 48px;
  font-weight: 700;
  margin-bottom: 24px;
  line-height: 1.2;
}

.project-meta {
  display: flex;
  gap: 30px;
  margin-bottom: 30px;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 8px;
  color: #666;
  font-size: 16px;
}

.project-description {
  font-size: 18px;
  line-height: 1.6;
  color: #555;
  margin-bottom: 30px;
  max-width: 800px;
}

.project-tech-stack {
  margin-top: 40px;
}

.project-tech-stack h3 {
  font-size: 20px;
  margin-bottom: 15px;
}

.tech-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 10px;
}

.tech-tag {
  background: #f3f4f6;
  padding: 6px 16px;
  border-radius: 20px;
  font-size: 14px;
  color: #4b5563;
}

.container {
  max-width: 1000px;
  margin: 0 auto;
  padding: 0 20px;
}

.project-overview h2 {
  font-size: 36px;
  margin-bottom: 30px;
}

.overview-content {
  display: grid;
  grid-template-columns: 2fr 1fr;
  gap: 50px;
}

.overview-text h3 {
  font-size: 24px;
  margin: 25px 0 15px;
}

.overview-text p {
  line-height: 1.6;
  color: #555;
  margin-bottom: 20px;
}

.features-list {
  list-style: none;
  padding: 0;
}

.features-list li {
  padding: 8px 0;
  padding-left: 24px;
  position: relative;
  color: #555;
}

.features-list li:before {
  content: "✓";
  position: absolute;
  left: 0;
  color: #667eea;
  font-weight: bold;
}

.overview-stats {
  display: grid;
  grid-template-columns: 1fr;
  gap: 20px;
}

.stat-card {
  background: white;
  border-radius: 12px;
  padding: 20px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.stat-value {
  font-size: 32px;
  font-weight: 700;
  color: #667eea;
  margin-bottom: 8px;
}

.stat-label {
  font-size: 14px;
  color: #666;
}

.project-gallery {
  margin: 80px 0;
}

.project-gallery h2 {
  font-size: 36px;
  margin-bottom: 40px;
}

.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 30px;
}

.screenshot-placeholder {
  background: #f8f9fa;
  border-radius: 12px;
  overflow: hidden;
  height: 200px;
}

.screenshot-header {
  background: #e5e7eb;
  padding: 12px;
}

.browser-dots {
  display: flex;
  gap: 8px;
}

.dot {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  background: #d1d5db;
}

.screenshot-content {
  padding: 20px;
  height: calc(100% - 44px);
}

.testimonial-section {
  margin: 80px 0;
}

.testimonial-card {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  padding: 50px;
  border-radius: 20px;
  position: relative;
}

.quote-icon {
  font-size: 60px;
  font-weight: 700;
  opacity: 0.3;
  position: absolute;
  top: 20px;
  left: 30px;
}

.testimonial-text {
  font-size: 20px;
  line-height: 1.6;
  margin-bottom: 30px;
  font-style: italic;
}

.client-info {
  text-align: right;
}

.client-name {
  font-size: 18px;
  font-weight: 600;
  margin-bottom: 5px;
}

.client-position {
  font-size: 16px;
  opacity: 0.8;
}

.case-study-cta {
  text-align: center;
  padding: 60px 20px;
  background: #f8f9fa;
  border-radius: 20px;
  margin: 80px 0;
}

.case-study-cta h2 {
  font-size: 36px;
  margin-bottom: 20px;
}

.case-study-cta p {
  font-size: 18px;
  color: #666;
  margin-bottom: 30px;
}

.cta-button {
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  padding: 16px 32px;
  border-radius: 50px;
  font-size: 18px;
  font-weight: 600;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 10px;
  transition: transform 0.3s, box-shadow 0.3s;
}

.cta-button:hover {
  transform: translateY(-2px);
  box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
}

@media (max-width: 768px) {
  .project-title {
    font-size: 32px;
  }
  
  .overview-content {
    grid-template-columns: 1fr;
  }
  
  .project-meta {
    flex-direction: column;
    gap: 15px;
  }
}
</style>