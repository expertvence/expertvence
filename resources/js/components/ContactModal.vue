<template>
  <transition name="contact-modal">
    <div v-if="show" class="contact-overlay" @click.self="$emit('close')">
      <div class="contact-modal">
        <div class="contact-wrapper">
          <!-- LEFT SIDE - Blue Background with Funny Topography Lines -->
          <div class="contact-left">
            <!-- Comic Style Topography Lines -->
            <div class="comic-pattern">
              <svg class="comic-svg" width="100%" height="100%" viewBox="0 0 400 500" preserveAspectRatio="xMidYMid slice">
                <!-- Squiggly lines -->
                <path d="M-50,100 Q50,80 150,120 T350,90" fill="none" stroke="white" stroke-opacity="0.3" stroke-width="2" stroke-dasharray="5,5"/>
                <path d="M-50,150 Q50,130 150,170 T350,140" fill="none" stroke="white" stroke-opacity="0.4" stroke-width="3" stroke-dasharray="8,8"/>
                <path d="M-50,200 Q50,180 150,220 T350,190" fill="none" stroke="white" stroke-opacity="0.3" stroke-width="2" stroke-dasharray="6,6"/>
                
                <!-- Funny wave lines -->
                <path d="M0,250 Q50,230 100,250 T200,230" fill="none" stroke="white" stroke-opacity="0.5" stroke-width="2"/>
                <path d="M0,280 Q50,260 100,280 T200,260" fill="none" stroke="white" stroke-opacity="0.4" stroke-width="2"/>
                <path d="M0,310 Q50,290 100,310 T200,290" fill="none" stroke="white" stroke-opacity="0.3" stroke-width="2"/>
                
                <!-- Comic dots and stars -->
                <g class="comic-dots">
                  <!-- Stars -->
                  <path d="M50,50 L55,65 L70,65 L60,75 L65,90 L50,80 L35,90 L40,75 L30,65 L45,65 Z" fill="white" fill-opacity="0.4"/>
                  <path d="M300,120 L305,135 L320,135 L310,145 L315,160 L300,150 L285,160 L290,145 L280,135 L295,135 Z" fill="white" fill-opacity="0.4"/>
                  <path d="M150,350 L155,365 L170,365 L160,375 L165,390 L150,380 L135,390 L140,375 L130,365 L145,365 Z" fill="white" fill-opacity="0.3"/>
                  
                  <!-- Funny faces -->
                  <circle cx="250" cy="300" r="15" fill="white" fill-opacity="0.2" stroke="white" stroke-opacity="0.4" stroke-width="1.5"/>
                  <circle cx="245" cy="295" r="2" fill="white" fill-opacity="0.6"/>
                  <circle cx="255" cy="295" r="2" fill="white" fill-opacity="0.6"/>
                  <path d="M245,305 Q250,310 255,305" stroke="white" stroke-opacity="0.6" stroke-width="1.5" fill="none"/>
                  
                  <circle cx="100" cy="400" r="12" fill="white" fill-opacity="0.2" stroke="white" stroke-opacity="0.4" stroke-width="1.5"/>
                  <circle cx="95" cy="395" r="1.5" fill="white" fill-opacity="0.6"/>
                  <circle cx="105" cy="395" r="1.5" fill="white" fill-opacity="0.6"/>
                  <circle cx="100" cy="400" r="1" fill="white" fill-opacity="0.8"/>
                  <path d="M95,405 Q100,410 105,405" stroke="white" stroke-opacity="0.6" stroke-width="1.5" fill="none"/>
                  
                  <!-- Dots with trails -->
                  <circle cx="350" cy="200" r="4" fill="white" fill-opacity="0.5">
                    <animate attributeName="cy" values="200;210;200" dur="3s" repeatCount="indefinite"/>
                  </circle>
                  <circle cx="80" cy="250" r="3" fill="white" fill-opacity="0.5">
                    <animate attributeName="cx" values="80;90;80" dur="4s" repeatCount="indefinite"/>
                  </circle>
                  <circle cx="200" cy="450" r="5" fill="white" fill-opacity="0.4">
                    <animate attributeName="r" values="5;7;5" dur="2s" repeatCount="indefinite"/>
                  </circle>
                </g>
                
                <!-- Speech bubble -->
                <path d="M300,400 Q320,380 340,400 T380,390" fill="none" stroke="white" stroke-opacity="0.3" stroke-width="2"/>
                <path d="M320,390 L310,410 L330,410 Z" fill="white" fill-opacity="0.2"/>
                <circle cx="360" cy="380" r="8" fill="white" fill-opacity="0.1" stroke="white" stroke-opacity="0.4" stroke-width="1"/>
              </svg>
            </div>

            <div class="contact-content">
              <h2>Get in touch and ask us anything.</h2>
              <p class="description">The difference between bookkeeping and accounting, can you start a company from Madagascar, which business literature our CEO prefers – we answer it all.</p>
            </div>
          </div>

          <!-- RIGHT SIDE - Form -->
          <div class="contact-right">
            <div class="form-header">
              <h1>Contact us</h1>
              <button class="close-btn" @click="$emit('close')">✕</button>
            </div>
            
            <div class="form-scroll">
              <form class="contact-form" @submit.prevent="handleSubmit">
                <div class="form-row">
                  <div class="form-group">
                    <label>Your name</label>
                    <input type="text" placeholder="Write Your Name" required v-model="form.name">
                  </div>
                  <div class="form-group">
                    <label>Phone number</label>
                    <div class="phone-input-wrapper">
                      <div class="country-selector" @click="toggleCountryList">
                        <img :src="selectedCountry.flag" alt="flag" class="flag">
                        <span class="country-code">+{{ selectedCountry.code }}</span>
                        <span class="dropdown-arrow">▼</span>
                      </div>
                      
                      <div v-if="showCountryList" class="country-dropdown">
                        <div 
                          v-for="country in countries" 
                          :key="country.code"
                          class="country-option"
                          @click="selectCountry(country)"
                        >
                          <img :src="country.flag" alt="flag" class="flag">
                          <span class="country-name">{{ country.name }}</span>
                          <span class="country-code">+{{ country.code }}</span>
                        </div>
                      </div>
                      
                      <input 
                        type="tel" 
                        placeholder="999 9999999"
                        class="phone-input"
                        required
                        v-model="form.phone"
                      >
                    </div>
                  </div>
                </div>

                <div class="form-group">
                  <label>Email address</label>
                  <input type="email" placeholder="you@example.com" required v-model="form.email">
                </div>

                <div class="form-group">
                  <label>Interested in</label>
                  <select required v-model="form.interest">
                    <option value="" disabled selected>Select an option</option>
                    <option>Bookkeeping</option>
                    <option>Accounting</option>
                    <option>Company Formation</option>
                    <option>Tax Services</option>
                    <option>Business Consulting</option>
                  </select>
                </div>

                <div class="form-group">
                  <label>How can we help?</label>
                  <textarea placeholder="Tell us about your project..." rows="1" required v-model="form.message"></textarea>
                </div>

                <!-- SUBMIT BUTTON SECTION - Fixed and Visible -->
                <div class="submit-section-wrapper">
                  <div class="submit-section">
                    <button type="submit" class="submit-btn">
                      <span class="btn-text">Send your message</span>
                      <span class="btn-arrow">→</span>
                    </button>
                    
                    <p class="terms">
                      By clicking, you agree to our <a href="#">Terms & Conditions</a>, <a href="#">Privacy</a> and <a href="#">Data Protection Policy</a>
                    </p>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </transition>
</template>

<script setup>
import { ref, reactive } from 'vue'

defineProps({ show: Boolean })
defineEmits(['close'])

const showCountryList = ref(false)

const form = reactive({
  name: '',
  phone: '',
  email: '',
  interest: '',
  message: ''
})

const countries = ref([
  { name: 'Italy', code: '39', flag: 'https://flagcdn.com/w20/it.png' },
  { name: 'United States', code: '1', flag: 'https://flagcdn.com/w20/us.png' },
  { name: 'United Kingdom', code: '44', flag: 'https://flagcdn.com/w20/gb.png' },
  { name: 'Germany', code: '49', flag: 'https://flagcdn.com/w20/de.png' },
  { name: 'France', code: '33', flag: 'https://flagcdn.com/w20/fr.png' },
  { name: 'Spain', code: '34', flag: 'https://flagcdn.com/w20/es.png' },
])

const selectedCountry = ref(countries.value[0])

const toggleCountryList = () => {
  showCountryList.value = !showCountryList.value
}

const selectCountry = (country) => {
  selectedCountry.value = country
  showCountryList.value = false
}

const handleSubmit = () => {
  // Handle form submission
  console.log('Form submitted:', form)
  alert('Thanks for your message! We\'ll get back to you soon.')
  // Reset form
  Object.keys(form).forEach(key => form[key] = '')
}
</script>

<style scoped>
.contact-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.35);
  backdrop-filter: blur(4px);

  z-index: 99999;
}

.contact-modal {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);

  width: min(1100px, 94vw);
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  background: #c0c2da;
  border-radius: 14px;
  overflow: hidden;
}

.contact-wrapper {
  display: flex;
  height:45rem;
  min-height: 650px;
}

/* LEFT SIDE - Blue Background with Comic Style Lines */
.contact-left {
  flex: 0 0 45%;
  background: linear-gradient(135deg, #4f46e5 0%, #3730a3 100%);
  padding: 50px 40px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

.comic-pattern {
  position: absolute;
  inset: 0;
  pointer-events: none;
  opacity: 0.7;
}

.comic-svg {
  animation: wavyMove 15s ease-in-out infinite alternate;
}

@keyframes wavyMove {
  0% {
    transform: translate(0, 0) rotate(0deg);
  }
  25% {
    transform: translate(-5px, -5px) rotate(0.5deg);
  }
  50% {
    transform: translate(5px, -5px) rotate(-0.5deg);
  }
  75% {
    transform: translate(-5px, 5px) rotate(0.5deg);
  }
  100% {
    transform: translate(5px, 5px) rotate(-0.5deg);
  }
}

.comic-dots {
  animation: bounce 8s ease-in-out infinite;
}

@keyframes bounce {
  0%, 100% {
    transform: translateY(0);
  }
  50% {
    transform: translateY(-5px);
  }
}

.contact-content {
  position: relative;
  z-index: 2;
}

.contact-left h2 {
  font-size: 32px;
  font-weight: 700;
  color: white;
  margin: 0 0 25px 0;
  line-height: 1.3;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
}

.description {
  color: rgba(255, 255, 255, 0.9);
  font-size: 16px;
  line-height: 1.6;
  margin: 0;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* RIGHT SIDE - Form */
.contact-right {
  flex: 0 0 55%;
  background: white;
  display: flex;
  flex-direction: column;
}

.form-header {
  padding: 10px 55px 0;
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  border-bottom: 1px solid #e5e7eb;
  padding-bottom: 10px;
  flex-shrink: 0;
}

.form-header h1 {
  font-size: 28px;
  font-weight: 700;
  color: #111827;
  margin: 0;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.close-btn {
  background: #f3f4f6;
  border: none;
  width: 40px;
  height: 40px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  color: #374151;
  cursor: pointer;
  transition: all 0.2s;
}

.close-btn:hover {
  background: #e5e7eb;
  transform: scale(1.05);
}

.form-scroll {
  padding: 0 40px 0; /* Changed: Removed bottom padding */
  flex: 1;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
}

/* FORM STYLES */
.contact-form {
  display: flex;
  flex-direction: column;
  flex: 1;
  padding-bottom: 40px; /* Added padding at bottom of form */
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 14px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-size: 14px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 8px;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.form-group input:not(.phone-input),
.form-group select,
.form-group textarea {
  padding: 13px 16px;
  border: 2px solid #e5e7eb;
  border-radius: 5px;
  font-size: 15px;
  color: #111827;
  background: white;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  transition: all 0.2s;
}

.form-group input:focus:not(.phone-input),
.form-group select:focus,
.form-group textarea:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
}

.form-group input::placeholder:not(.phone-input),
.form-group textarea::placeholder {
  color: #9ca3af;
}

.form-group select {
  appearance: none;
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%236b7280'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 16px center;
  background-size: 18px;
  padding-right: 45px;
  cursor: pointer;
}

.form-group textarea {
  resize: vertical;
  min-height: 80px;
  line-height: 1.5;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

/* PHONE INPUT */
.phone-input-wrapper {
  position: relative;
  display: flex;
}

.country-selector {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0 16px;
  background: white;
  border: 2px solid #e5e7eb;
  border-right: none;
  border-radius: 10px 0 0 10px;
  cursor: pointer;
  transition: all 0.2s;
  font-size: 15px;
  color: #374151;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  min-width: 120px;
}

.country-selector:hover {
  background: #f9fafb;
}

.flag {
  width: 22px;
  height: 16px;
  object-fit: cover;
  border-radius: 2px;
}

.dropdown-arrow {
  font-size: 11px;
  color: #6b7280;
  margin-left: auto;
}

.country-dropdown {
  position: absolute;
  top: calc(100% + 4px);
  left: 0;
  width: 300px;
  max-height: 320px;
  overflow-y: auto;
  background: white;
  border: 2px solid #e5e7eb;
  border-radius: 10px;
  box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
  z-index: 100;
}

.country-option {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 13px 16px;
  cursor: pointer;
  transition: background-color 0.2s;
  border-bottom: 1px solid #f3f4f6;
}

.country-option:last-child {
  border-bottom: none;
}

.country-option:hover {
  background: #f9fafb;
}

.country-name {
  flex: 1;
  font-size: 14px;
  color: #374151;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.country-option .country-code {
  font-family: monospace;
  color: #6b7280;
  font-size: 14px;
  font-weight: 500;
}

.phone-input {
  flex: 1;
  padding: 13px 16px;
  border: 2px solid #e5e7eb;
  border-left: none;
  border-radius: 0 10px 10px 0;
  font-size: 15px;
  color: #111827;
  background: white;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  transition: all 0.2s;
}

.phone-input:focus {
  outline: none;
  border-color: #4f46e5;
  box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
}

.phone-input::placeholder {
  color: #9ca3af;
}

.phone-input-wrapper:focus-within .country-selector,
.phone-input-wrapper:focus-within .phone-input {
  border-color: #4f46e5;
}

/* SUBMIT BUTTON SECTION - FIXED AND ALWAYS VISIBLE */
.submit-section-wrapper {
  margin-top: auto;
  margin-bottom: 20px;
  position: relative;
  bottom: 0;
  background: linear-gradient(to top, white 80%, transparent);
  padding-bottom: 20px;
}

.submit-section {
  display: flex;
  flex-direction: column;
  gap: 5px;
  background: white;
  border-top: 1px solid #e5e7eb;
  padding-top: 20px;
}

.submit-btn {
  background: #1e293b;
  color: white;
  border: none;
  border-radius: 5px;
  padding: 16px 24px;
  padding-bottom: 10px;
  padding-top: 10px;
  font-size: 16px;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  position: relative;
  overflow: hidden;
}

.submit-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
  transition: left 0.5s;
}

.submit-btn:hover::before {
  left: 100%;
}

.submit-btn:hover {
  background: #334155;
  transform: translateY(-3px);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
}

.submit-btn:active {
  transform: translateY(-1px);
}

.btn-arrow {
  font-size: 20px;
  transition: transform 0.3s;
}

.submit-btn:hover .btn-arrow {
  transform: translateX(5px);
}

.terms {
  font-size: 12px;
  color: #6b7280;
  text-align: center;
  margin-bottom: 10px;
  line-height: 2.5;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
}

.terms a {
  color: #4f46e5;
  text-decoration: none;
  font-weight: 500;
}

.terms a:hover {
  text-decoration: underline;
}

/* ANIMATION */
.contact-modal-enter-active,
.contact-modal-leave-active {
  transition: opacity 0.3s ease;
}

.contact-modal-enter-active .contact-modal,
.contact-modal-leave-active .contact-modal {
  transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1), opacity 0.3s ease;
}

.contact-modal-enter-from,
.contact-modal-leave-to {
  opacity: 0;
}

.contact-modal-enter-from .contact-modal {
  transform: translateY(-20px) scale(0.95);
  opacity: 0;
}

.contact-modal-leave-to .contact-modal {
  transform: translateY(20px) scale(0.95);
  opacity: 0;
}

/* RESPONSIVE */
@media (max-width: 1024px) {
  .contact-modal {
    max-width: 95vw;
  }
  
  .contact-wrapper {
    min-height: 600px;
  }
}

@media (max-width: 768px) {
  .contact-wrapper {
    flex-direction: column;
    min-height: auto;
  }
  
  .contact-left {
    flex: none;
    padding: 40px 30px;
    min-height: 300px;
  }
  
  .contact-right {
    flex: none;
    max-height: 70vh;
  }
  
  .form-header {
    padding: 20px 30px 20px;
  }
  
  .form-scroll {
    padding: 0 30px 0;
  }
  
  .contact-form {
    padding-bottom: 30px;
  }
  
  .form-row {
    grid-template-columns: 1fr;
    gap: 20px;
  }
}

@media (max-width: 480px) {
  .contact-overlay {
    padding: 10px;
  }
  
  .contact-modal {
    max-height: 95vh;
    border-radius: 12px;
  }
  
  .contact-left {
    padding: 30px 20px;
    min-height: 250px;
  }
  
  .contact-left h2 {
    font-size: 24px;
    margin-bottom: 15px;
  }
  
  .description {
    font-size: 14px;
  }
  
  .form-header {
    padding: 15px 20px 15px;
  }
  
  .form-scroll {
    padding: 0 20px 0;
  }
  
  .contact-form {
    padding-bottom: 20px;
  }
  
  .form-header h1 {
    font-size: 24px;
  }
  
  .close-btn {
    width: 36px;
    height: 36px;
    font-size: 18px;
  }
  
  .form-group input:not(.phone-input),
  .form-group select,
  .form-group textarea {
    padding: 11px 14px;
    font-size: 14px;
  }
  
  .country-dropdown {
    width: 100%;
  }
  
  .submit-btn {
    padding: 14px;
    font-size: 15px;
  }
}
</style>