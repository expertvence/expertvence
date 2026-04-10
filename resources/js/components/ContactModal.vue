<template>
  <Teleport to="body">
    <transition name="contact-modal">
      <div v-if="show" class="contact-overlay" @click.self="$emit('close')">
        <div class="contact-modal" :class="{ 'is-submitting': isSubmitting }">
          <div class="contact-wrapper">
            <!-- Form Container -->
            <div class="contact-right">
              <div class="form-header">
                <h1>KNOCK TO EXPERTVENCE</h1>
                <p class="form-subtitle">Drop Your Smart Choice to Us</p>
                <button class="close-btn" @click="$emit('close')">
                  <span class="close-icon">✕</span>
                </button>
              </div>

              <div class="form-content">
                <form class="contact-form" @submit.prevent="handleSubmit">
                  <!-- Name & Email -->
                  <div class="form-row">
                    <div class="form-group">
                      <label>YOUR NAME</label>
                      <div class="input-wrapper">
                        <input type="text" placeholder="WRITE YOUR NAME" required v-model="form.name"
                          class="neon-input" />
                        <div class="input-glow"></div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label>EMAIL ADDRESS</label>
                      <div class="input-wrapper">
                        <input type="email" placeholder="YOU@EXAMPLE.COM" required v-model="form.email"
                          class="neon-input" />
                        <div class="input-glow"></div>
                      </div>
                    </div>
                  </div>

                  <!-- Phone & Interest -->
                  <div class="form-row">
                    <div class="form-group">
                      <label>PHONE NUMBER</label>
                      <div class="phone-input-wrapper">
                        <div class="input-wrapper phone-combined-input">
                          <div class="country-selector-container">
                            <div class="country-selector" @click="showCountryList = !showCountryList">
                              <img v-if="selectedCountry.flag" :src="selectedCountry.flag" class="flag" />
                              <span class="dial-code">{{ selectedCountry.dial_code }}</span>
                              <span class="dropdown-arrow">▼</span>
                            </div>

                            <div v-if="showCountryList" class="country-dropdown neon-dropdown">
                              <div v-for="c in filteredCountries" :key="c.iso" @click="selectCountry(c)"
                                class="country-option">
                                <img :src="c.flag" class="flag" />
                                <span>{{ c.dial_code }} - {{ c.name }}</span>
                              </div>
                            </div>
                          </div>

                          <input type="tel" class="neon-input phone-number-input" :placeholder="phonePlaceholder"
                            required v-model="form.phone" />
                          <div class="input-glow"></div>
                        </div>
                        <p v-if="phoneMeta.message" class="error-message">
                          {{ phoneMeta.message }}
                        </p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label>INTERESTED IN</label>
                      <div class="input-wrapper">
                        <select required v-model="form.interest" class="neon-input">
                          <option value="" disabled>SELECT AN OPTION</option>
                          <option>BOOKKEEPING</option>
                          <option>ACCOUNTING</option>
                          <option>COMPANY FORMATION</option>
                          <option>TAX SERVICES</option>
                          <option>BUSINESS CONSULTING</option>
                        </select>
                        <div class="input-glow"></div>
                      </div>
                    </div>
                  </div>

                  <!-- Message -->
                  <div class="form-group">
                    <label>HOW CAN WE HELP?</label>
                    <div class="input-wrapper">
                      <textarea placeholder="TELL US ABOUT YOUR PROJECT..." rows="3" required v-model="form.message"
                        class="neon-input"></textarea>
                      <div class="input-glow"></div>
                    </div>
                  </div>

                  <!-- Terms Agreement -->
                  <div class="form-group">
                    <label class="checkbox-label neon-checkbox">
                      <input type="checkbox" v-model="form.agreed_terms" required />
                      <span class="checkmark"></span>
                      <span class="checkbox-text">
                        I AGREE TO THE
                        <a href="#" class="terms-link">TERMS & CONDITIONS</a>,
                        <a href="#" class="terms-link">PRIVACY</a> AND
                        <a href="#" class="terms-link">DATA PROTECTION POLICY</a>
                      </span>
                    </label>
                  </div>

                  <!-- Submit -->
                  <div class="submit-section-wrapper">
                    <div class="submit-section">
                      <button type="submit" class="submit-btn neon-btn"
                        :disabled="!phoneMeta.isValid || !form.agreed_terms || isSubmitting">
                        <span class="btn-text">SEND MESSAGE</span>
                        <span class="btn-arrow">→</span>
                      </button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <div v-if="isSubmitting" class="submit-overlay">
            <div class="loader">
              <div class="loader-spinner"></div>
              <div class="loader-text">TRANSMITTING...</div>
            </div>
          </div>
        </div>
      </div>
    </transition>

    <!-- Custom Toast Notification -->
    <transition name="toast-slide">
      <div v-if="showToast" class="neon-toast" :class="toastType">
        <div class="toast-content">
          <span class="toast-icon">{{ toastIcon }}</span>
          <div class="toast-text">
            <div class="toast-title">{{ toastTitle }}</div>
            <div class="toast-message">{{ toastMessage }}</div>
          </div>
          <button class="toast-close" @click="closeToast">✕</button>
        </div>
        <div class="toast-progress" :style="{ 'animation-duration': toastDuration + 'ms' }"></div>
      </div>
    </transition>
  </Teleport>
</template>

<script setup>
import { ref, reactive, computed, watch, onMounted } from 'vue'
import axios from 'axios'
import { loadCountries } from '@/data/countries.js'
import { AsYouType, isPossiblePhoneNumber } from 'libphonenumber-js'

const emit = defineEmits(['close'])
defineProps({ show: Boolean })

const isSubmitting = ref(false)
const showCountryList = ref(false)
const search = ref('')
const countries = ref([])
const selectedCountry = ref({ name: '', iso: '', dial_code: '', flag: '' })

// Toast state
const showToast = ref(false)
const toastType = ref('success')
const toastTitle = ref('')
const toastMessage = ref('')
const toastDuration = ref(3000)
const toastTimeout = ref(null)

const form = reactive({
  name: '', 
  email: '', 
  phone: '', 
  interest: '', 
  message: '', 
  agreed_terms: true
})

const phoneMeta = reactive({ isValid: true, message: '' })

// Filtered countries
const filteredCountries = computed(() =>
  countries.value.filter(c =>
    c.name.toLowerCase().includes(search.value.toLowerCase()) ||
    c.dial_code.includes(search.value)
  )
)

// Toast icon based on type
const toastIcon = computed(() => {
  return toastType.value === 'success' ? '✓' : '✕'
})

// Toast functions
const showNotification = (type, title, message, duration = 3000) => {
  // Clear existing timeout
  if (toastTimeout.value) {
    clearTimeout(toastTimeout.value)
  }
  
  toastType.value = type
  toastTitle.value = title
  toastMessage.value = message
  toastDuration.value = duration
  showToast.value = true
  
  // Auto close after duration
  toastTimeout.value = setTimeout(() => {
    closeToast()
  }, duration)
}

const closeToast = () => {
  showToast.value = false
  if (toastTimeout.value) {
    clearTimeout(toastTimeout.value)
    toastTimeout.value = null
  }
}

const autoDetectCountry = async () => {
  try {
    const res = await axios.get('/api/auth/detect-country')
    const found = countries.value.find(c => c.iso === res.data.iso)
    selectedCountry.value = found || countries.value.find(c => c.iso === 'US') || { name: 'Unknown', iso: 'US', dial_code: '+1', flag: '' }
  } catch {
    selectedCountry.value = countries.value.find(c => c.iso === 'US') || { name: 'Unknown', iso: 'US', dial_code: '+1', flag: '' }
  }
}

const selectCountry = (country) => {
  selectedCountry.value = country
  showCountryList.value = false
  form.phone = ''
}

const phonePlaceholder = computed(() => {
  switch (selectedCountry.value.iso) {
    case 'BD': return '18XXXXXXXX'
    case 'US': return '201 555 0123'
    default: return 'Phone number'
  }
})

watch(() => form.phone, (val) => {
  if (!val || !selectedCountry.value.iso) {
    phoneMeta.message = ''
    phoneMeta.isValid = true
    return
  }
  const typer = new AsYouType(selectedCountry.value.iso)
  typer.input(val)
  const formatted = typer.getNumber()
  if (!formatted) {
    phoneMeta.isValid = false
    phoneMeta.message = 'Incomplete phone number'
    return
  }
  phoneMeta.isValid = isPossiblePhoneNumber(val, selectedCountry.value.iso)
  phoneMeta.message = phoneMeta.isValid ? '' : 'Invalid or incomplete phone number'
})

onMounted(async () => {
  countries.value = await loadCountries()
  await autoDetectCountry()
})

// reCAPTCHA
const loadRecaptcha = () => new Promise((resolve, reject) => {
  if (window.grecaptcha) return resolve(window.grecaptcha)
  const script = document.createElement('script')
  script.src = `https://www.google.com/recaptcha/api.js?render=${import.meta.env.VITE_RECAPTCHA_SITE_KEY}`
  script.async = true
  script.defer = true
  script.onload = () => window.grecaptcha ? resolve(window.grecaptcha) : reject('grecaptcha not loaded')
  script.onerror = () => reject('Failed to load reCAPTCHA script')
  document.head.appendChild(script)
})

// Load reCAPTCHA and get token
const getRecaptchaToken = async () => {
  return new Promise((resolve, reject) => {
    if (!window.grecaptcha) {
      const script = document.createElement('script');
      script.src = `https://www.google.com/recaptcha/api.js?render=${import.meta.env.VITE_RECAPTCHA_SITE_KEY}`;
      script.async = true;
      script.defer = true;
      script.onload = () => {
        if (!window.grecaptcha) return reject('grecaptcha not loaded');
        executeRecaptcha(resolve, reject);
      };
      script.onerror = () => reject('Failed to load reCAPTCHA script');
      document.head.appendChild(script);
    } else {
      executeRecaptcha(resolve, reject);
    }

    function executeRecaptcha(resolve, reject) {
      window.grecaptcha.ready(() => {
        window.grecaptcha.execute(import.meta.env.VITE_RECAPTCHA_SITE_KEY, { action: 'contact_form' })
          .then(token => {
            if (!token) return reject('No token received');
            resolve(token);
          })
          .catch(err => reject(err));
      });
    }
  });
};

// Form submit
const handleSubmit = async () => {
  if (!phoneMeta.isValid) {
    showNotification('error', 'Validation Error', 'Please check your phone number')
    return;
  }

  
  emit('close'); // ✅ modal instant close
  // 🔔 Step 1: Sending toast
showNotification(
  'success',
  'Sending...',
  'Your message is being transmitted',
  999999 // long duration, manually replaced later
);
  
  isSubmitting.value = true;

  let recaptcha_token;
  try {
    recaptcha_token = await getRecaptchaToken();
  } catch (err) {
    showNotification('error', 'reCAPTCHA Failed', 'Please try again or refresh the page', 4000)
    isSubmitting.value = false;
    return;
  }

  const payload = {
    name: form.name,
    email: form.email,
    phone_number: form.phone,
    interest: form.interest,
    message: form.message,
    has_whatsapp: form.has_whatsapp,
    has_telegram: form.has_telegram,
    telegram_username: form.telegram_username,
    dial_code: selectedCountry.value.dial_code,
    country_name: selectedCountry.value.name,
    country_iso: selectedCountry.value.iso,
    agreed_terms: form.agreed_terms,
    recaptcha_token
  };

  try {
    const res = await axios.post('/api/auth/contact', payload);
  

    
    // Show success toast
    showNotification(
  'success',
  'Message Sent!',
  'Thank you for contacting us. We will get back to you shortly.',
  3000
);

    
    // Close modal after 1.5 seconds
    setTimeout(() => {
      
      
      // Reset form
      Object.assign(form, {
        name: '', email: '', phone: '', interest: '', message: '', agreed_terms: true
      })
    }, 1500);
    
  } catch (err) {
    const msg = err.response?.data?.message || 'Failed to send message';
    
    // Show error toast
    showNotification(
  'error',
  'Failed!',
  'Unable to send your message. Please try again later.',
  4000
);

    
  } finally {
    isSubmitting.value = false;
  }
};
</script>

<style scoped>
/* ================= NEON MINIMALIST THEME ================= */
:root {
  --neon-blue: #00f3ff;
  --neon-pink: #ff00ff;
  --neon-purple: #9d4edd;
  --dark-bg: #0a0a1a;
  --darker-bg: #050510;
  --card-bg: rgba(10, 15, 30, 0.8);
  --text-primary: #ffffff;
  --text-secondary: #a0a0c0;
  --border-glow: rgba(0, 243, 255, 0.3);
}

/* ================= Overlay ================= */
.contact-overlay {
  position: fixed;
  inset: 0;
  background: rgba(5, 5, 16, 0.85);
  backdrop-filter: blur(12px);
  z-index: 999999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
}

/* ================= Modal - NO SCROLL BAR ================= */
.contact-modal {
  width: auto;
  max-width: 720px;
  max-height: 90vh;
  background: var(--card-bg);
  border-radius: 5px;
  overflow: hidden;
  border: 1px solid rgba(0, 243, 255, 0.1);
  box-shadow:
    0 0 40px rgba(0, 243, 255, 0.15),
    0 20px 60px rgba(0, 0, 0, 0.4),
    inset 0 1px 0 rgba(255, 255, 255, 0.1);
  display: flex;
  flex-direction: column;
}

.contact-wrapper {
  display: flex;
  flex-direction: column;
  flex: 1;
}

/* ================= Header ================= */
.form-header {
  padding: 12px 32px 16px;
  position: relative;
  text-align: center;
  border-bottom: 1px solid rgba(0, 243, 255, 0.1);
  background: linear-gradient(to bottom, rgba(28, 141, 6, 0.527), transparent);
  flex-shrink: 0;
}

.form-header h1 {
  font-size: 18px;
  font-weight: 800;
  color: var(--text-primary);
  margin: 0;
  letter-spacing: 2px;
  text-transform: uppercase;
  background: #00f3ff;
  -webkit-background-clip: text;
  background-clip: text;
  -webkit-text-fill-color: transparent;
  text-shadow: 0 0 15px rgba(0, 243, 255, 0.3);
}

.form-subtitle {
  color: rgb(30, 224, 5);
  font-size: 14px;
  margin-top: 5px;
  letter-spacing: 1px;
}

.close-btn {
  position: absolute;
  top: 24px;
  right: 24px;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  border: 1px solid rgba(0, 243, 255, 0.3);
  background: rgba(10, 15, 30, 0.8);
  color: red;
  font-size: 18px;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
}

.close-btn:hover {
  background: rgba(0, 243, 255, 0.1);
  border-color: var(--neon-blue);
  box-shadow: 0 0 15px rgba(0, 243, 255, 0.4);
  transform: rotate(90deg);
}

/* ================= Form Content - NO SCROLL ================= */
.form-content {
  padding: 24px 32px 32px;
  flex: 2;
  display: flex;
  flex-direction: column;
  overflow: visible;
}

.contact-form {
  display: flex;
  flex-direction: column;
  flex: 1;
}

/* ================= Form Rows & Groups ================= */
.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 40px;
}

.form-group {
  display: flex;
  flex-direction: column;
}

.form-group label {
  font-size: 12px;
  font-weight: 600;
  color: linen;
  display: block;
  text-transform: uppercase;
  letter-spacing: 1.3px;
}

/* ================= Neon Inputs ================= */
.input-wrapper {
  position: relative;
  border-radius: 5px;
  overflow: hidden;
  flex: 1;
}

.neon-input {
  width: 100%;
  padding: 14px;
  background: rgba(15, 20, 40, 0.6);
  border: 1px solid rgba(0, 243, 255, 0.2);
  border-radius: 5px;
  color: rgb(30, 224, 5);
  font-size: 14px;
  font-family: monospace;
  transition: all 0.3s ease;
  backdrop-filter: blur(10px);
  box-sizing: border-box;
  margin-bottom: 7px;
}

.neon-input::placeholder {
  color: rgba(160, 160, 192, 0.5);
}

.neon-input:focus {
  outline: none;
  border-color: var(--neon-blue);
  box-shadow:
    0 0 20px rgba(0, 243, 255, 0.3),
    inset 0 1px 0 rgba(255, 255, 255, 0.1);
  background: rgba(15, 20, 40, 0.8);
}

.input-glow {
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  border-radius: 12px;
  pointer-events: none;
  opacity: 0;
  transition: opacity 0.3s ease;
  box-shadow: inset 0 0 30px rgba(0, 243, 255, 0.1);
}

.neon-input:focus~.input-glow {
  opacity: 1;
}

/* ================= COMBINED PHONE INPUT ================= */
.phone-input-wrapper {
  display: flex;
  flex-direction: column;
}

.phone-combined-input {
  display: flex;
  align-items: center;
  padding: 0;
  background: rgba(40, 27, 15, 0.6);
  border: 1px solid rgba(0, 243, 255, 0.2);
  border-radius: 12px;
  overflow: visible;
  position: relative;
}

.phone-combined-input:focus-within {
  border-color: var(--neon-blue);
  box-shadow:
    0 0 20px rgba(0, 243, 255, 0.3),
    inset 0 1px 0 rgba(255, 255, 255, 0.1);
  background: rgba(15, 20, 40, 0.8);
}

.phone-combined-input:focus-within~.input-glow {
  opacity: 1;
}

.country-selector-container {
  position: relative;
  flex-shrink: 0;
}

.country-selector {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 0 12px 0 16px;
  height: 48px;
  cursor: pointer;
  transition: all 0.3s ease;
  border-right: 1px solid rgba(0, 243, 255, 0.2);
  min-width: 100px;
}

.country-selector:hover {
  background: rgba(0, 243, 255, 0.05);
}

.flag {
  width: 20px;
  height: 15px;
  object-fit: cover;
  border-radius: 2px;
}

.dial-code {
  color: rgb(30, 224, 5);
  font-size: 14px;
  font-weight: 500;
  font-family: monospace;
}

.dropdown-arrow {
  font-size: 10px;
  color: var(--neon-blue);
  margin-left: 4px;
  transition: transform 0.3s ease;
}

.country-selector:hover .dropdown-arrow {
  transform: rotate(180deg);
}

/* Country Dropdown */
.country-dropdown {
  position: absolute;
  top: 100%;
  left: 0;
  margin-top: 4px;
  width: 280px;
  max-height: 300px;
  overflow-y: auto;
  background: rgba(15, 20, 40, 0.98);
  border: 1px solid rgba(0, 243, 255, 0.3);
  border-radius: 6px;
  z-index: 1000;
  backdrop-filter: blur(20px);
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.5);
}

.country-option {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 16px;
  color: var(--text-primary);
  cursor: pointer;
  transition: all 0.2s ease;
}

.country-option:hover {
  background: rgba(0, 243, 255, 0.1);
}

/* Phone Number Input Field */
.phone-number-input {
  flex: 1;
  border: none;
  background: transparent;
  border-radius: 0;
  padding: 16px;
  margin: 0;
  height: 48px;
}

.phone-number-input:focus {
  outline: none;
  box-shadow: none;
  background: transparent;
}

.error-message {
  color: #ff6b6b;
  font-size: 12px;
  margin-top: 4px;
  text-align: left;
}

/* ================= Textarea ================= */
textarea.neon-input {
  min-height: 100px;
  resize: vertical;
  font-family: inherit;
}

/* ================= Checkboxes ================= */
.neon-checkbox {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  color: var(--text-secondary);
  transition: color 0.3s ease;
  height: 28px;
}

.neon-checkbox:hover {
  color: rgb(30, 224, 5);
}

.neon-checkbox input[type="checkbox"] {
  display: none;
}

.neon-checkbox .checkmark {
  width: 20px;
  height: 20px;
  border: 1px solid rgba(0, 243, 255, 0.3);
  border-radius: 4px;
  position: relative;
  transition: all 0.3s ease;
}

.neon-checkbox input[type="checkbox"]:checked~.checkmark {
  background: rgba(0, 243, 255, 0.1);
  border-color: var(--neon-blue);
}

.neon-checkbox .checkmark::after {
  content: '✓';
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  color: var(--neon-blue);
  opacity: 0;
  transition: opacity 0.3s ease;
  font-size: 14px;
}

.neon-checkbox input[type="checkbox"]:checked~.checkmark::after {
  opacity: 1;
}

.checkbox-text {
  font-size: 12px;
  text-transform: uppercase;
  letter-spacing: 1px;
}

.terms-link {
  color: red;
  text-decoration: none;
  transition: all 0.3s ease;
}

.terms-link:hover {
  color: darkorange;
  text-shadow: 0 0 10px rgba(255, 0, 255, 0.5);
}

/* ================= Submit Section ================= */
.submit-section-wrapper {
  margin-top: auto;
  padding-top: 12px;
}

.submit-section {
  display: flex;
  flex-direction: column;
  gap: 16px;
}

.neon-btn {
  width: 100%;
  padding: 18px;
  background: linear-gradient(135deg, rgba(0, 243, 255, 0.1), rgba(157, 78, 221, 0.1));
  border: 1px solid rgba(0, 243, 255, 0.3);
  border-radius: 6px;
  color: rgb(30, 224, 5);
  font-size: 16px;
  font-weight: 600;
  letter-spacing: 1px;
  text-transform: uppercase;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  position: relative;
  overflow: hidden;
}

.neon-btn:hover:not(:disabled) {
  background: linear-gradient(135deg, rgba(0, 243, 255, 0.2), rgba(157, 78, 221, 0.2));
  border-color: var(--neon-blue);
  box-shadow:
    0 0 30px rgba(0, 243, 255, 0.4),
    0 0 60px rgba(0, 243, 255, 0.2);
  transform: translateY(-2px);
}

.neon-btn:active:not(:disabled) {
  transform: translateY(0);
}

.neon-btn:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

.btn-arrow {
  font-size: 20px;
  transition: transform 0.3s ease;
}

.neon-btn:hover:not(:disabled) .btn-arrow {
  transform: translateX(4px);
}

/* ================= Submit Overlay ================= */
.contact-modal.is-submitting {
  pointer-events: none;
}

.submit-overlay {
  position: absolute;
  inset: 0;
  background: rgba(5, 5, 16, 0.9);
  backdrop-filter: blur(8px);
  display: none !important;
  align-items: center;
  justify-content: center;
  z-index: 10;
}

.loader {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 20px;
}

.loader-spinner {
  width: 50px;
  height: 50px;
  border: 3px solid transparent;
  border-top: 3px solid var(--neon-blue);
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

.loader-text {
  color: var(--neon-blue);
  font-size: 14px;
  letter-spacing: 2px;
  text-transform: uppercase;
  animation: pulse 1.5s ease-in-out infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

@keyframes pulse {
  0%, 100% {
    opacity: 0.6;
  }
  50% {
    opacity: 1;
  }
}

/* ================= CUSTOM TOAST STYLES ================= */
.neon-toast {
  position: fixed;
  top: 20px;
  right: 20px;
  min-width: 320px;
  max-width: 400px;
  background: rgba(15, 20, 40, 0.95);
  border: 1px solid;
  border-radius: 8px;
  padding: 16px;
  z-index: 1000000;
  backdrop-filter: blur(20px);
  overflow: hidden;
  box-shadow: 
    0 10px 30px rgba(0, 0, 0, 0.5),
    0 5px 15px rgba(0, 0, 0, 0.3);
}

.neon-toast.success {
  border-color: rgba(0, 243, 255, 0.4);
  box-shadow: 
    0 0 30px rgba(0, 243, 255, 0.2),
    inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.neon-toast.error {
  border-color: rgba(255, 107, 107, 0.4);
  box-shadow: 
    0 0 30px rgba(255, 107, 107, 0.2),
    inset 0 1px 0 rgba(255, 255, 255, 0.1);
}

.toast-content {
  display: flex;
  align-items: flex-start;
  gap: 12px;
}

.toast-icon {
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 50%;
  font-size: 14px;
  font-weight: bold;
  flex-shrink: 0;
  margin-top: 2px;
}

.neon-toast.success .toast-icon {
  background: rgba(0, 243, 255, 0.1);
  color: #00f3ff;
  border: 1px solid rgba(0, 243, 255, 0.3);
  text-shadow: 0 0 10px rgba(0, 243, 255, 0.5);
}

.neon-toast.error .toast-icon {
  background: rgba(255, 107, 107, 0.1);
  color: #ff6b6b;
  border: 1px solid rgba(255, 107, 107, 0.3);
  text-shadow: 0 0 10px rgba(255, 107, 107, 0.5);
}

.toast-text {
  flex: 1;
  min-width: 0;
}

.toast-title {
  font-size: 14px;
  font-weight: 700;
  letter-spacing: 1px;
  margin-bottom: 4px;
  text-transform: uppercase;
}

.neon-toast.success .toast-title {
  color: #00f3ff;
  text-shadow: 0 0 10px rgba(0, 243, 255, 0.3);
}

.neon-toast.error .toast-title {
  color: #ff6b6b;
  text-shadow: 0 0 10px rgba(255, 107, 107, 0.3);
}

.toast-message {
  font-size: 13px;
  color: rgba(255, 255, 255, 0.85);
  line-height: 1.4;
  word-wrap: break-word;
}

.toast-close {
  background: transparent;
  border: none;
  color: rgba(255, 255, 255, 0.5);
  cursor: pointer;
  font-size: 14px;
  padding: 0;
  width: 20px;
  height: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
  flex-shrink: 0;
  border-radius: 50%;
}

.toast-close:hover {
  color: #fff;
  background: rgba(255, 255, 255, 0.1);
}

.toast-progress {
  position: absolute;
  bottom: 0;
  left: 0;
  height: 3px;
  width: 100%;
  transform-origin: left;
  animation: toastProgress linear forwards;
}

.neon-toast.success .toast-progress {
  background: linear-gradient(90deg, #00f3ff, #9d4edd);
}

.neon-toast.error .toast-progress {
  background: linear-gradient(90deg, #ff6b6b, #ff00ff);
}

@keyframes toastProgress {
  0% {
    transform: scaleX(1);
  }
  100% {
    transform: scaleX(0);
  }
}

/* Toast Animation */
.toast-slide-enter-active,
.toast-slide-leave-active {
  transition: all 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
}

.toast-slide-enter-from {
  opacity: 0;
  transform: translateX(100%) translateY(-20px);
}

.toast-slide-enter-to {
  opacity: 1;
  transform: translateX(0) translateY(0);
}

.toast-slide-leave-from {
  opacity: 1;
  transform: translateX(0) translateY(0);
}

.toast-slide-leave-to {
  opacity: 0;
  transform: translateX(100%) translateY(-20px);
}

/* ================= Transitions ================= */
.contact-modal-enter-active,
.contact-modal-leave-active {
  transition: opacity 0.4s ease, transform 0.4s ease;
}

.contact-modal-enter-from,
.contact-modal-leave-to {
  opacity: 0;
  transform: scale(0.95) translateY(-20px);
}

/* ================= Responsive - MOBILE: SINGLE COLUMN ================= */
/* Tablet: 2 columns */
@media (min-width: 769px) {
  .contact-modal {
    max-height: 85vh;
  }
  .form-content {
    padding: 24px 32px 32px;
  }
}

/* Mobile: Single column (one field per row) */
@media (max-width: 768px) {
  .contact-overlay {
    padding: 16px;
  }
  .contact-modal {
    max-height: 95vh;
    border-radius: 5px;
  }
  .form-header {
    padding: 24px 20px 16px;
  }
  .form-content {
    padding: 20px 20px 24px;
  }
  /* MOBILE: SINGLE COLUMN - One field per row */
  .form-row {
    grid-template-columns: 1fr;
    gap: 16px;
  }
  .phone-combined-input {
    flex-direction: row;
  }
  .country-selector {
    min-width: 90px;
    padding: 0 10px 0 12px;
  }
  .neon-btn {
    padding: 16px;
  }
  .form-group {
    width: 100%;
  }
  /* Toast mobile */
  .neon-toast {
    min-width: calc(100vw - 40px);
    max-width: calc(100vw - 40px);
    right: 20px;
    left: 20px;
    top: 20px;
  }
}

/* Small mobile devices */
@media (max-width: 480px) {
  .form-header h1 {
    font-size: 22px;
  }
  .form-subtitle {
    font-size: 12px;
  }
  .close-btn {
    width: 32px;
    height: 32px;
    top: 20px;
    right: 20px;
  }
  .neon-input {
    padding: 14px;
  }
  .country-selector {
    min-width: 80px;
    padding: 0 8px 0 10px;
  }
  .dial-code {
    font-size: 13px;
  }
  .phone-number-input {
    padding: 14px;
  }
  /* Toast mobile small */
  .neon-toast {
    padding: 12px;
  }
  .toast-title {
    font-size: 13px;
  }
  .toast-message {
    font-size: 12px;
  }
}

/* Extra small devices */
@media (max-width: 360px) {
  .form-content {
    padding: 16px 16px 20px;
  }
  .neon-input {
    padding: 12px;
    font-size: 13px;
  }
  .country-selector {
    min-width: 70px;
    gap: 6px;
  }
  .flag {
    width: 18px;
    height: 13px;
  }
  .dial-code {
    font-size: 12px;
  }
  .phone-number-input {
    padding: 12px;
  }
  .neon-btn {
    padding: 14px;
    font-size: 14px;
  }
}

/* Height-based adjustments */
@media (min-height: 900px) and (min-width: 769px) {
  .contact-modal {
    max-height: 80vh;
  }
  .form-content {
    padding: 32px 40px 40px;
  }
  .contact-form {
    gap: 24px;
  }
}
</style>