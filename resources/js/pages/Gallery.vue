<template>
  <section class="expertvence-gallery">
    <!-- Floating Photo Frames Background -->
    <div class="gallery-atmosphere">
      <div class="atmosphere-grid"></div>
      <div class="floating-frame frame-1"></div>
      <div class="floating-frame frame-2"></div>
      <div class="floating-frame frame-3"></div>
      <div class="floating-frame frame-4"></div>
      <div class="floating-frame frame-5"></div>
      <div class="light-spot spot-1"></div>
      <div class="light-spot spot-2"></div>
      <div class="photo-strip strip-1"></div>
      <div class="photo-strip strip-2"></div>
    </div>

    <div class="gallery-content">
      <!-- Animated Header -->
      <div class="gallery-header">
        <div class="header-icon">
          <span class="icon-layer">📸</span>
          <span class="icon-layer">📷</span>
          <span class="icon-layer">🎥</span>
        </div>
        <span class="gallery-badge">EXPERTVENCE FAMILY ALBUM</span>
        <h1 class="gallery-main-title">
          Moments That<br>
          <span class="highlight">Matter Most</span>
        </h1>
        <p class="gallery-description">
          Every picture tells a story of passion, dedication, and the amazing people behind ExpertVence
        </p>
      </div>

      <!-- Unique Filter Tabs -->
      <div class="gallery-tabs">
        <button 
          v-for="tab in tabs" 
          :key="tab.id"
          class="tab-btn"
          :class="{ active: activeTab === tab.id }"
          @click="activeTab = tab.id"
        >
          <span class="tab-emoji">{{ tab.emoji }}</span>
          <span class="tab-name">{{ tab.name }}</span>
          <span class="tab-count">{{ tab.count }}</span>
        </button>
      </div>

      <!-- Polaroid Style Grid -->
      <div class="polaroid-grid">
        <div 
          v-for="(memory, index) in filteredMemories" 
          :key="index"
          class="polaroid-card"
          :class="memory.style"
          @click="openMemory(memory)"
        >
          <div class="polaroid-photo">
            <img :src="memory.image" :alt="memory.title">
            
            <!-- Sticky Note Tag -->
            <div class="photo-sticky" :class="memory.category">
              <span>{{ memory.stickyText }}</span>
            </div>

            <!-- Date Stamp -->
            <div class="photo-date">
              <span>{{ memory.date }}</span>
            </div>
          </div>

          <div class="polaroid-caption">
            <h3>{{ memory.title }}</h3>
            <p>{{ memory.caption }}</p>
            
            <!-- People Tags -->
            <div class="caption-people">
              <div 
                v-for="person in memory.featuredPeople" 
                :key="person"
                class="person-tag"
              >
                <img :src="person.avatar" :alt="person.name">
                <span>{{ person.name }}</span>
              </div>
            </div>
          </div>

          <!-- Corner Fold Effect -->
          <div class="corner-fold"></div>
        </div>
      </div>

      <!-- Vintage Photo Album -->
      <div class="album-showcase">
        <h2 class="album-title">
          <span>📖</span> 
          Flip Through Our Memories
          <span>📖</span>
        </h2>

        <div class="album-grid">
          <div class="album-left">
            <div class="album-cover">
              <div class="cover-content">
                <h3>ExpertVence</h3>
                <p>2015 - 2024</p>
                <div class="cover-strip"></div>
              </div>
            </div>
          </div>

          <div class="album-right">
            <div class="album-pages">
              <div 
                v-for="n in 4" 
                :key="n"
                class="album-page"
                :style="{ '--index': n }"
              >
                <img :src="`https://placehold.co/200x250/ef4444/ffffff?text=Memory+${n}`" alt="album page">
                <div class="page-overlay">
                  <span>Chapter {{ n }}</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Memory Wall -->
      <div class="memory-wall">
        <div class="wall-header">
          <span class="wall-icon">❤️</span>
          <h3>Most Loved Moments</h3>
        </div>

        <div class="wall-grid">
          <div 
            v-for="n in 6" 
            :key="n"
            class="wall-item"
            :style="{ '--delay': n }"
          >
            <img :src="`https://placehold.co/300x300/1e293b/ef4444?text=❤️+${n}`" alt="loved moment">
            <div class="wall-overlay">
              <span>{{ n }}K ❤️</span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Memory Modal -->
    <Transition name="memory">
      <div v-if="selectedMemory" class="memory-modal" @click.self="selectedMemory = null">
        <button class="modal-close" @click="selectedMemory = null">✕</button>
        
        <div class="modal-content">
          <div class="modal-photo">
            <img :src="selectedMemory.image" :alt="selectedMemory.title">
            <div class="modal-sticky">{{ selectedMemory.stickyText }}</div>
          </div>

          <div class="modal-info">
            <h2>{{ selectedMemory.title }}</h2>
            <p class="modal-date">📅 {{ selectedMemory.fullDate }}</p>
            <p class="modal-story">{{ selectedMemory.story }}</p>

            <div class="modal-people">
              <h4>🤝 People in this memory</h4>
              <div class="modal-people-grid">
                <div 
                  v-for="person in selectedMemory.people" 
                  :key="person.name"
                  class="modal-person"
                >
                  <img :src="person.avatar" :alt="person.name">
                  <div>
                    <strong>{{ person.name }}</strong>
                    <span>{{ person.role }}</span>
                  </div>
                </div>
              </div>
            </div>

            <div class="modal-reactions">
              <button class="reaction-btn">❤️ {{ selectedMemory.likes }}</button>
              <button class="reaction-btn">💬 {{ selectedMemory.comments }}</button>
              <button class="reaction-btn">↗️ Share</button>
            </div>
          </div>
        </div>
      </div>
    </Transition>
  </section>
</template>

<script setup>
import { ref, computed } from 'vue'

const activeTab = ref('all')

const tabs = [
  { id: 'all', name: 'All Moments', emoji: '📸', count: 42 },
  { id: 'leadership', name: 'Leadership', emoji: '👔', count: 8 },
  { id: 'team', name: 'Team', emoji: '👥', count: 24 },
  { id: 'celebrations', name: 'Celebrations', emoji: '🎉', count: 15 },
  { id: 'events', name: 'Events', emoji: '🎪', count: 12 },
  { id: 'culture', name: 'Culture', emoji: '🌟', count: 18 }
]

// Sample data
const memories = ref([
  {
    id: 1,
    title: 'Founder\'s Day 2024',
    caption: 'Celebrating 9 years of journey',
    image: 'https://placehold.co/400x500/ef4444/ffffff?text=Founder',
    style: 'portrait',
    category: 'leadership',
    stickyText: '✨ Special',
    date: 'MAR 2024',
    fullDate: 'March 15, 2024',
    story: 'On this day, our founder shared the vision for the next decade...',
    featuredPeople: [
      { name: 'John D.', avatar: 'https://randomuser.me/api/portraits/men/1.jpg' },
      { name: 'Sarah K.', avatar: 'https://randomuser.me/api/portraits/women/2.jpg' }
    ],
    people: [
      { name: 'John Doe', role: 'Founder & CEO', avatar: 'https://randomuser.me/api/portraits/men/1.jpg' },
      { name: 'Sarah Khan', role: 'Co-founder', avatar: 'https://randomuser.me/api/portraits/women/2.jpg' }
    ],
    likes: 234,
    comments: 45
  },
  {
    id: 2,
    title: 'Team Building 2024',
    caption: 'Day out at the beach',
    image: 'https://placehold.co/600x400/3b82f6/ffffff?text=Team',
    style: 'landscape',
    category: 'team',
    stickyText: '🏖️ Fun Day',
    date: 'FEB 2024',
    fullDate: 'February 10, 2024',
    story: 'The entire team spent a day at Cox\'s Bazar...',
    featuredPeople: [
      { name: 'Mike T.', avatar: 'https://randomuser.me/api/portraits/men/3.jpg' },
      { name: 'Lisa R.', avatar: 'https://randomuser.me/api/portraits/women/4.jpg' }
    ],
    people: [
      { name: 'Mike Thompson', role: 'Tech Lead', avatar: 'https://randomuser.me/api/portraits/men/3.jpg' },
      { name: 'Lisa Roy', role: 'HR Manager', avatar: 'https://randomuser.me/api/portraits/women/4.jpg' }
    ],
    likes: 567,
    comments: 89
  },
  {
    id: 3,
    title: 'Eid Celebration',
    caption: 'Dressed in traditional attire',
    image: 'https://placehold.co/400x600/10b981/ffffff?text=Eid',
    style: 'tall',
    category: 'celebrations',
    stickyText: '🌙 Eid Mubarak',
    date: 'APR 2024',
    fullDate: 'April 12, 2024',
    story: 'Celebrating Eid together with traditional food and gifts...',
    featuredPeople: [
      { name: 'Rahim M.', avatar: 'https://randomuser.me/api/portraits/men/5.jpg' },
      { name: 'Karima B.', avatar: 'https://randomuser.me/api/portraits/women/6.jpg' }
    ],
    people: [
      { name: 'Rahim Mia', role: 'Senior Developer', avatar: 'https://randomuser.me/api/portraits/men/5.jpg' },
      { name: 'Karima Begum', role: 'Designer', avatar: 'https://randomuser.me/api/portraits/women/6.jpg' }
    ],
    likes: 892,
    comments: 123
  },
  {
    id: 4,
    title: 'Tech Seminar',
    caption: 'AI & Machine Learning Workshop',
    image: 'https://placehold.co/800x400/f59e0b/ffffff?text=Seminar',
    style: 'wide',
    category: 'events',
    stickyText: '🤖 Tech Talk',
    date: 'JAN 2024',
    fullDate: 'January 25, 2024',
    story: 'Industry experts shared insights on future of AI...',
    featuredPeople: [
      { name: 'Dr. A.', avatar: 'https://randomuser.me/api/portraits/men/7.jpg' },
      { name: 'Prof. B.', avatar: 'https://randomuser.me/api/portraits/women/8.jpg' }
    ],
    people: [
      { name: 'Dr. Ahmed', role: 'Guest Speaker', avatar: 'https://randomuser.me/api/portraits/men/7.jpg' },
      { name: 'Prof. Bashir', role: 'Guest Speaker', avatar: 'https://randomuser.me/api/portraits/women/8.jpg' }
    ],
    likes: 445,
    comments: 67
  },
  {
    id: 5,
    title: 'Birthday Celebration',
    caption: 'Surprise party for CEO',
    image: 'https://placehold.co/500x500/8b5cf6/ffffff?text=Birthday',
    style: 'square',
    category: 'celebrations',
    stickyText: '🎂 Surprise!',
    date: 'DEC 2023',
    fullDate: 'December 5, 2023',
    story: 'Team secretly planned a birthday party...',
    featuredPeople: [
      { name: 'Team', avatar: 'https://randomuser.me/api/portraits/lego/1.jpg' }
    ],
    people: [
      { name: 'John Doe', role: 'CEO', avatar: 'https://randomuser.me/api/portraits/men/1.jpg' },
      { name: 'Entire Team', role: 'All Members', avatar: 'https://randomuser.me/api/portraits/lego/1.jpg' }
    ],
    likes: 678,
    comments: 98
  },
  {
    id: 6,
    title: 'Office Culture',
    caption: 'Casual Friday vibes',
    image: 'https://placehold.co/600x400/ec4899/ffffff?text=Casual',
    style: 'landscape',
    category: 'culture',
    stickyText: '🎮 Game Time',
    date: 'MAR 2024',
    fullDate: 'March 8, 2024',
    story: 'Friendly FIFA tournament during lunch break...',
    featuredPeople: [
      { name: 'Gamers', avatar: 'https://randomuser.me/api/portraits/men/9.jpg' }
    ],
    people: [
      { name: 'Gaming Squad', role: 'Team', avatar: 'https://randomuser.me/api/portraits/lego/2.jpg' }
    ],
    likes: 345,
    comments: 56
  }
])

const filteredMemories = computed(() => {
  if (activeTab.value === 'all') return memories.value
  return memories.value.filter(m => m.category === activeTab.value)
})

const selectedMemory = ref(null)

const openMemory = (memory) => {
  selectedMemory.value = memory
  document.body.style.overflow = 'hidden'
}

const closeMemory = () => {
  selectedMemory.value = null
  document.body.style.overflow = ''
}
</script>

