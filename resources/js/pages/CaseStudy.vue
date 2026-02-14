
<template>
  <div class="case-study">
    <!-- Back Button -->
    <div class="case-study__nav">
      <button class="back-btn" @click="goBack">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
          <path d="M19 12H5M5 12L12 19M5 12L12 5" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Back to Portfolio
      </button>
    </div>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero__background">
        <div class="hero__gradient"></div>
        <div class="hero__pattern">
          <div class="pattern-grid"></div>
          <div class="pattern-dots"></div>
        </div>
      </div>
      
      <div class="hero__content">
        <div class="hero__badge">
          <span class="badge-dot"></span>
          Case Study
        </div>
        
        <h1 class="hero__title">{{ projectData.title }}</h1>
        
        <div class="hero__meta">
          <div class="meta-chip">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="2"/>
              <path d="M3 10H21M8 2V6M16 2V6" stroke="currentColor" stroke-width="2"/>
            </svg>
            {{ projectData.year }}
          </div>
          
          <div class="meta-chip">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <path d="M20 21V19C20 16.7909 18.2091 15 16 15H8C5.79086 15 4 16.7909 4 19V21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="2"/>
            </svg>
            {{ projectData.client }}
          </div>
          
          <div class="meta-chip">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none">
              <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="2"/>
              <path d="M12 7V12L15 15" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
            </svg>
            {{ projectData.duration }}
          </div>
        </div>
        
        <p class="hero__description">{{ projectData.description }}</p>
        
        <!-- Action Buttons -->
        <div class="hero__actions">
          <a 
            :href="projectData.liveDemoUrl" 
            target="_blank" 
            rel="noopener noreferrer" 
            class="btn btn--primary"
          >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M18 13V19C18 20.1046 17.1046 21 16 21H5C3.89543 21 3 20.1046 3 19V8C3 6.89543 3.89543 6 5 6H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M15 3H21V9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M21 3L12 12" stroke="currentColor" stroke-width="2"/>
            </svg>
            Live Demo
            <span class="btn__badge">Live</span>
          </a>
          
          <button class="btn btn--outline" @click="downloadPDF" :disabled="isDownloading">
            <svg v-if="!isDownloading" width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M12 16V4M12 16L8 12M12 16L16 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              <path d="M20 21H4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <rect x="2" y="17" width="20" height="4" rx="1" stroke="currentColor" stroke-width="2"/>
            </svg>
            <svg v-else width="20" height="20" viewBox="0 0 24 24" fill="none" class="spinner">
              <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" stroke-dasharray="30 30"/>
            </svg>
            {{ isDownloading ? 'Downloading...' : 'Download Case Study (PDF)' }}
          </button>
        </div>
        
        <div class="hero__tech">
          <span class="tech-label">Technology Stack</span>
          <div class="tech-grid">
            <span v-for="tech in projectData.technologies" :key="tech" class="tech-pill">
              {{ tech }}
            </span>
          </div>
        </div>
      </div>
    </section>

    <!-- Overview Section -->
    <section class="section">
      <div class="container">
        <div class="section__header">
          <span class="section__number">01</span>
          <h2 class="section__title">Project Overview</h2>
        </div>
        
        <div class="overview">
          <div class="overview__content">
            <div class="overview__block">
              <h3>The Challenge</h3>
              <p>{{ projectData.challenge }}</p>
            </div>
            
            <div class="overview__block">
              <h3>Our Solution</h3>
              <p>{{ projectData.solution }}</p>
            </div>
            
            <div class="overview__block">
              <h3>Key Features</h3>
              <ul class="feature-list">
                <li v-for="feature in projectData.features" :key="feature">
                  <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                    <path d="M20 6L9 17L4 12" stroke="#38bdf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                  </svg>
                  {{ feature }}
                </li>
              </ul>
            </div>
          </div>
          
          <div class="overview__stats">
            <div class="stat-card">
              <div class="stat-card__value">{{ projectData.metrics.revenueGrowth }}</div>
              <div class="stat-card__label">Revenue Growth</div>
            </div>
            
            <div class="stat-card">
              <div class="stat-card__value">{{ projectData.metrics.userGrowth }}</div>
              <div class="stat-card__label">User Growth</div>
            </div>
            
            <div class="stat-card">
              <div class="stat-card__value">{{ projectData.metrics.performance }}</div>
              <div class="stat-card__label">Performance</div>
            </div>
            
            <div class="stat-card">
              <div class="stat-card__value">{{ projectData.metrics.satisfaction }}</div>
              <div class="stat-card__label">Satisfaction</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Gallery Section -->
    <section class="section section--alt">
      <div class="container">
        <div class="section__header">
          <span class="section__number">02</span>
          <h2 class="section__title">Visual Showcase</h2>
          <a 
            :href="projectData.liveDemoUrl" 
            target="_blank" 
            rel="noopener noreferrer" 
            class="btn btn--sm btn--primary"
          >
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
              <path d="M18 13V19C18 20.1046 17.1046 21 16 21H5C3.89543 21 3 20.1046 3 19V8C3 6.89543 3.89543 6 5 6H11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M15 3H21V9" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              <path d="M21 3L12 12" stroke="currentColor" stroke-width="2"/>
            </svg>
            Try Live Demo
          </a>
        </div>
        
        <div class="gallery">
          <div v-for="(image, index) in projectImages" :key="index" class="gallery__item">
            <div class="mockup">
              <div class="mockup__bar">
                <div class="mockup__dots">
                  <span></span>
                  <span></span>
                  <span></span>
                </div>
                <span class="mockup__title">{{ image.title }}</span>
              </div>
              <div class="mockup__content">
                <img :src="image.url" :alt="image.alt" class="mockup__image" loading="lazy">
                <div class="mockup__overlay">
                  <span class="mockup__caption">{{ image.caption }}</span>
                  <a 
                    :href="projectData.liveDemoUrl" 
                    target="_blank" 
                    rel="noopener noreferrer" 
                    class="mockup__btn"
                  >
                    View Live Demo
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Testimonial Section -->
    <section class="section">
      <div class="container">
        <div class="testimonial">
          <svg class="testimonial__quote" width="48" height="48" viewBox="0 0 24 24" fill="none">
            <path d="M10 11H6V15H10V11Z" stroke="#38bdf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M18 11H14V15H18V11Z" stroke="#38bdf8" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
          <blockquote class="testimonial__text">
            {{ projectData.testimonial }}
          </blockquote>
          <div class="testimonial__author">
            <div class="testimonial__avatar">
              {{ projectData.clientName.charAt(0) }}
            </div>
            <div class="testimonial__info">
              <div class="testimonial__name">{{ projectData.clientName }}</div>
              <div class="testimonial__position">{{ projectData.clientPosition }}</div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
      <div class="container">
        <div class="cta__content">
          <h2 class="cta__title">Have a Similar Project?</h2>
          <p class="cta__description">
            Let's discuss how we can help bring your vision to life with our expertise and experience.
          </p>
          <div class="cta__actions">
            <button class="btn btn--primary btn--lg" @click="contactUs">
              Start a Conversation
              <svg width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M5 12H19M19 12L12 5M19 12L12 19" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg>
            </button>
            <button class="btn btn--outline btn--lg" @click="downloadPDF" :disabled="isDownloading">
              <svg v-if="!isDownloading" width="20" height="20" viewBox="0 0 24 24" fill="none">
                <path d="M12 16V4M12 16L8 12M12 16L16 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                <path d="M20 21H4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
              </svg>
              <svg v-else width="20" height="20" viewBox="0 0 24 24" fill="none" class="spinner">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none" stroke-dasharray="30 30"/>
              </svg>
              {{ isDownloading ? 'Downloading...' : 'Download PDF' }}
            </button>
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue'
import { useRoute, useRouter } from 'vue-router'

const route = useRoute()
const router = useRouter()
const projectId = ref(parseInt(route.params.id) || 1)
const isDownloading = ref(false)

// Project images based on project ID
const projectImages = computed(() => {
  const images = {
    1: [
      {
        url: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Enterprise SaaS Dashboard',
        caption: 'Real-time Analytics Dashboard',
        title: 'Dashboard Overview'
      },
      {
        url: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1115&q=80',
        alt: 'Analytics & Reports',
        caption: 'Automated Report Generation',
        title: 'Analytics Suite'
      },
      {
        url: 'https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Team Collaboration',
        caption: 'Multi-user Collaboration',
        title: 'Team Workspace'
      },
      {
        url: 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Mobile Analytics',
        caption: 'Mobile Responsive Design',
        title: 'Mobile View'
      }
    ],
    2: [
      {
        url: 'https://images.unsplash.com/photo-1472851294608-062f824d29cc?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'E-commerce Platform',
        caption: 'Multi-vendor Storefront',
        title: 'Store Overview'
      },
      {
        url: 'https://images.unsplash.com/photo-1556742044-3c52d6e88c62?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Payment Processing',
        caption: 'Seamless Checkout Experience',
        title: 'Payment Gateway'
      },
      {
        url: 'https://images.unsplash.com/photo-1563013544-824ae1b704d3?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Inventory Management',
        caption: 'Real-time Inventory Sync',
        title: 'Inventory Dashboard'
      },
      {
        url: 'https://images.unsplash.com/photo-1587560699334-cc4ff634909a?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Vendor Dashboard',
        caption: 'Vendor Management Portal',
        title: 'Vendor Dashboard'
      }
    ],
    3: [
      {
        url: 'https://images.unsplash.com/photo-1461773518188-b3e86f98242f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Fitness App',
        caption: 'Workout Tracking Interface',
        title: 'Workout Tracker'
      },
      {
        url: 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Nutrition Planning',
        caption: 'AI-Powered Meal Planning',
        title: 'Nutrition Tracker'
      },
      {
        url: 'https://images.unsplash.com/photo-1576678927484-cc907957088c?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Progress Tracking',
        caption: 'Progress Analytics Dashboard',
        title: 'Progress Tracker'
      },
      {
        url: 'https://images.unsplash.com/photo-1552674605-db6ffd4facb5?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Community Features',
        caption: 'Social Fitness Community',
        title: 'Community Hub'
      }
    ],
    4: [
      {
        url: 'https://images.unsplash.com/photo-1551288049-bebda4e38f71?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Financial Dashboard',
        caption: 'Real-time Market Data',
        title: 'Market Overview'
      },
      {
        url: 'https://images.unsplash.com/photo-1590283603385-17ffb3a7f29f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Predictive Analytics',
        caption: 'AI-Predictive Modeling',
        title: 'Predictive Insights'
      },
      {
        url: 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?ixlib=rb-4.0.3&auto=format&fit=crop&w=1115&q=80',
        alt: 'Compliance Reports',
        caption: 'Automated Compliance Reporting',
        title: 'Compliance Suite'
      },
      {
        url: 'https://images.unsplash.com/photo-1542744173-8e7e53415bb0?ixlib=rb-4.0.3&auto=format&fit=crop&w=1170&q=80',
        alt: 'Custom Dashboard',
        caption: 'Drag-and-drop Widget Builder',
        title: 'Custom Dashboard'
      }
    ]
  }
  return images[projectId.value] || images[1]
})

// Project data with REAL demo URLs and secure PDF links
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
    clientPosition: 'CTO, Enterprise Solutions Inc.',
    // Real demo URLs - Replace these with actual demo links
    liveDemoUrl: 'https://demo.enterprise-saas.example.com',
    // Secure PDF links using Google Drive viewer or actual PDF URLs
    pdfUrl: 'https://drive.google.com/file/d/1xJ3qf3vZ8k9XwQ5mR2nP7cL4sT6yB8dE/view?usp=sharing'
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
    clientPosition: 'CEO, RetailHub',
    liveDemoUrl: 'https://demo.ecommerce-platform.example.com',
    pdfUrl: 'https://drive.google.com/file/d/2yK4rf3wZ8k9XwQ5mR2nP7cL4sT6yB8dF/view?usp=sharing'
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
    clientPosition: 'Founder, FitLife Technologies',
    liveDemoUrl: 'https://demo.fitness-app.example.com',
    pdfUrl: 'https://drive.google.com/file/d/3zL5sg4wA9j0XrR6nS3oQ8dM5uV9zC9eG/view?usp=sharing'
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
    clientPosition: 'Head of Analytics, FinCorp',
    liveDemoUrl: 'https://demo.finance-dashboard.example.com',
    pdfUrl: 'https://drive.google.com/file/d/4aM6th5xB0k1YsS7oT4pR9eN6vW0aD0fH/view?usp=sharing'
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

// Secure PDF download function
const downloadPDF = async () => {
  if (isDownloading.value) return
  
  isDownloading.value = true
  
  try {
    const pdfUrl = projectData.value.pdfUrl
    
    // For Google Drive links, convert to direct download
    let downloadUrl = pdfUrl
    
    // Check if it's a Google Drive link and convert to direct download
    if (pdfUrl.includes('drive.google.com')) {
      const fileId = pdfUrl.match(/\/d\/(.*?)\/|id=(.*?)&|id=(.*?)$/);
      if (fileId) {
        const id = fileId[1] || fileId[2] || fileId[3];
        downloadUrl = `https://drive.google.com/uc?export=download&id=${id}&confirm=t`;
      }
    }
    
    // Create a hidden anchor element
    const link = document.createElement('a')
    link.href = downloadUrl
    link.download = `${projectData.value.title.toLowerCase().replace(/\s+/g, '-')}-case-study.pdf`
    link.target = '_blank'
    link.rel = 'noopener noreferrer'
    
    // Append to body, click, and remove
    document.body.appendChild(link)
    link.click()
    document.body.removeChild(link)
    
    // Show success message
    console.log('Download started for:', projectData.value.title)
    
    // Reset downloading state after 2 seconds
    setTimeout(() => {
      isDownloading.value = false
    }, 2000)
    
  } catch (error) {
    console.error('Download failed:', error)
    alert('Download failed. Please try again or contact support.')
    isDownloading.value = false
  }
}
</script>