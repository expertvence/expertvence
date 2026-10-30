<template>
  <Teleport to="body">
    <transition name="contact-modal">
      <div v-if="show" class="contact-overlay" @click.self="$emit('close')">
        <div class="contact-modal" :class="{ 'is-submitting': isSubmitting }">
          <div class="contact-wrapper">
            <!-- Form Container -->
            <div class="contact-content-area">
              <div class="form-header">
                <div class="header-titles">
                  <h2>Knock to ExpertVence</h2>
                  <p class="form-subtitle">Drop your project details to us and let's build together</p>
                </div>
                <button class="close-btn" @click="$emit('close')" aria-label="Close modal">
                  ✕
                </button>
              </div>

              <div class="form-content">
                <form class="contact-form" @submit.prevent="handleSubmit">
                  <!-- Name & Email -->
                  <div class="form-row">
                    <div class="form-group">
                      <label>Your Name</label>
                      <div class="input-wrapper">
                        <input
                          type="text"
                          placeholder="Your full name"
                          required
                          v-model="form.name"
                          class="modern-input"
                        />
                      </div>
                    </div>
                    <div class="form-group">
                      <label>Email Address</label>
                      <div class="input-wrapper">
                        <input
                          type="email"
                          placeholder="you@example.com"
                          required
                          v-model="form.email"
                          class="modern-input"
                        />
                      </div>
                    </div>
                  </div>

                  <!-- Phone & Interest -->
                  <div class="form-row">
                    <div class="form-group">
                      <label>Phone Number</label>
                      <div class="phone-input-wrapper">
                        <div class="input-wrapper phone-combined-input">
                          <div class="country-selector-container">
                            <div class="country-selector" @click="showCountryList = !showCountryList">
                              <img v-if="selectedCountry.flag" :src="selectedCountry.flag" class="flag" />
                              <span class="dial-code">{{ selectedCountry.dial_code }}</span>
                              <span class="dropdown-arrow">▼</span>
                            </div>

                            <div v-if="showCountryList" class="country-dropdown modern-dropdown">
                              <div
                                v-for="c in filteredCountries"
                                :key="c.iso"
                                @click="selectCountry(c)"
                                class="country-option"
                              >
                                <img :src="c.flag" class="flag" />
                                <span>{{ c.dial_code }} - {{ c.name }}</span>
                              </div>
                            </div>
                          </div>

                          <input
                            type="tel"
                            class="modern-input phone-number-input"
                            :placeholder="phonePlaceholder"
                            required
                            v-model="form.phone"
                          />
                        </div>
                        <p v-if="phoneMeta.message" class="error-message">
                          {{ phoneMeta.message }}
                        </p>
                      </div>
                    </div>

                    <div class="form-group">
                      <label>Interested In</label>
                      <div class="input-wrapper">
                        <select required v-model="form.interest" class="modern-input modern-select">
                          <option value="" disabled>Select an option</option>
                          <option>Custom Software Development</option>
                          <option>Cloud Migration &amp; DevOps</option>
                          <option>Web &amp; SaaS Development</option>
                          <option>Mobile App Development</option>
                          <option>Ready Software Solutions</option>
                          <option>IT Consulting &amp; Security</option>
                        </select>
                      </div>
                    </div>
                  </div>

                  <!-- Message -->
                  <div class="form-group">
                    <label>How Can We Help?</label>
                    <div class="input-wrapper">
                      <textarea
                        placeholder="Tell us about your project requirements..."
                        rows="3"
                        required
                        v-model="form.message"
                        class="modern-input"
                      ></textarea>
                    </div>
                  </div>

                  <!-- Terms Agreement -->
                  <div class="form-group">
                    <label class="checkbox-label modern-checkbox">
                      <input type="checkbox" v-model="form.agreed_terms" required />
                      <span class="checkmark"></span>
                      <span class="checkbox-text">
                        I agree to the
                        <a href="#" class="terms-link">Terms &amp; Conditions</a>,
                        <a href="#" class="terms-link">Privacy</a> and
                        <a href="#" class="terms-link">Data Protection Policy</a>
                      </span>
                    </label>
                  </div>

                  <!-- Submit -->
                  <div class="submit-section-wrapper">
                    <div class="submit-section">
                      <button
                        type="submit"
                        class="submit-btn modern-btn"
                        :disabled="!phoneMeta.isValid || !form.agreed_terms || isSubmitting"
                      >
                        <span class="btn-text">
                          {{ isSubmitting ? 'Sending...' : 'Send Message' }}
                        </span>
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
              <div class="loader-text">Sending message...</div>
            </div>
          </div>
        </div>
      </div>
    </transition>

    <!-- Custom Toast Notification -->
    <transition name="toast-slide">
      <div v-if="showToast" class="modern-toast" :class="toastType">
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
  if (toastTimeout.value) {
    clearTimeout(toastTimeout.value)
  }
  
  toastType.value = type
  toastTitle.value = title
  toastMessage.value = message
  toastDuration.value = duration
  showToast.value = true
  
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

const handleSubmit = async () => {
  if (!phoneMeta.isValid) {
    showNotification('error', 'Validation Error', 'Please check your phone number')
    return;
  }

  emit('close');
  showNotification(
    'success',
    'Sending...',
    'Your message is being transmitted',
    999999
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
    dial_code: selectedCountry.value.dial_code,
    country_name: selectedCountry.value.name,
    country_iso: selectedCountry.value.iso,
    agreed_terms: form.agreed_terms,
    recaptcha_token
  };

  try {
    await axios.post('/api/auth/contact', payload);
  
    showNotification(
      'success',
      'Message Sent!',
      'Thank you for contacting us. We will get back to you shortly.',
      3000
    );
    
    Object.assign(form, {
      name: '',
      email: '',
      phone: '',
      interest: '',
      message: '',
      agreed_terms: true
    });
  } catch (err) {
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
/* ================= MODERN MODAL THEME (Matching Landing Page) ================= */
.contact-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.7);
  backdrop-filter: blur(8px);
  z-index: 999999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px;
  font-family: Inter, system-ui, -apple-system, sans-serif;
}

.contact-modal {
  width: 100%;
  max-width: 680px;
  max-height: 90vh;
  background: #ffffff;
  border-radius: 20px;
  overflow-y: auto;
  border: 1px solid #E2E8F0;
  box-shadow: 0 25px 60px rgba(15, 23, 42, 0.25);
  display: flex;
  flex-direction: column;
  position: relative;
}

.contact-wrapper {
  display: flex;
  flex-direction: column;
}

.contact-content-area {
  padding: 32px 36px 36px;
}

/* Header */
.form-header {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 26px;
  padding-bottom: 20px;
  border-bottom: 1px solid #F1F5F9;
}

.header-titles h2 {
  font-size: 24px;
  font-weight: 800;
  color: #0F172A;
  margin: 0 0 6px;
  letter-spacing: -0.02em;
}

.form-subtitle {
  font-size: 14.5px;
  color: #64748B;
  margin: 0;
}

.close-btn {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #F8FAFC;
  border: 1px solid #E2E8F0;
  color: #64748B;
  font-size: 15px;
  display: grid;
  place-items: center;
  cursor: pointer;
  transition: all 0.2s;
  flex-shrink: 0;
  margin-left: 16px;
}

.close-btn:hover {
  background: #E2E8F0;
  color: #0F172A;
  transform: rotate(90deg);
}

/* Form Layout */
.contact-form {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 18px;
}

.form-group {
  display: flex;
  flex-direction: column;
  gap: 8px;
}

.form-group label {
  font-size: 12.5px;
  font-weight: 700;
  color: #334155;
  text-transform: uppercase;
  letter-spacing: 0.04em;
}

/* Inputs */
.modern-input {
  width: 100%;
  padding: 13px 16px;
  font-size: 14.5px;
  color: #0F172A;
  background: #F8FAFC;
  border: 1.5px solid #E2E8F0;
  border-radius: 12px;
  outline: none;
  font-family: inherit;
  transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
  box-sizing: border-box;
}

.modern-input::placeholder {
  color: #94A3B8;
}

.modern-input:focus {
  border-color: #0E7490;
  background: #ffffff;
  box-shadow: 0 0 0 4px rgba(14, 116, 144, 0.12);
}

textarea.modern-input {
  resize: vertical;
  min-height: 90px;
}

.modern-select {
  cursor: pointer;
}

/* Phone combined input */
.phone-combined-input {
  display: flex;
  align-items: center;
  background: #F8FAFC;
  border: 1.5px solid #E2E8F0;
  border-radius: 12px;
  transition: border-color 0.2s, box-shadow 0.2s;
  position: relative;
}

.phone-combined-input:focus-within {
  border-color: #0E7490;
  box-shadow: 0 0 0 4px rgba(14, 116, 144, 0.12);
  background: #ffffff;
}

.phone-combined-input .phone-number-input {
  border: none;
  background: transparent;
  padding-left: 10px;
}

.phone-combined-input .phone-number-input:focus {
  box-shadow: none;
}

.country-selector-container {
  position: relative;
}

.country-selector {
  display: flex;
  align-items: center;
  gap: 6px;
  padding: 10px 12px;
  border-right: 1.5px solid #E2E8F0;
  cursor: pointer;
  background: #F1F5F9;
  border-radius: 10px 0 0 10px;
  font-size: 13px;
  font-weight: 600;
  color: #334155;
  user-select: none;
  white-space: nowrap;
}

.country-selector:hover {
  background: #E0F7FB;
}

.flag {
  width: 20px;
  height: 14px;
  object-fit: cover;
  border-radius: 2px;
}

.dropdown-arrow {
  font-size: 9px;
  color: #64748B;
}

.modern-dropdown {
  position: absolute;
  top: calc(100% + 6px);
  left: 0;
  width: 280px;
  max-height: 220px;
  overflow-y: auto;
  background: #ffffff;
  border: 1px solid #E2E8F0;
  border-radius: 12px;
  box-shadow: 0 16px 36px rgba(15, 23, 42, 0.16);
  z-index: 100;
  padding: 6px;
}

.country-option {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 9px 12px;
  border-radius: 8px;
  font-size: 13.5px;
  color: #334155;
  cursor: pointer;
  transition: background 0.15s;
}

.country-option:hover {
  background: #E0F7FB;
  color: #0E7490;
}

.error-message {
  font-size: 12px;
  color: #EF4444;
  margin: 4px 0 0;
}

/* Checkbox */
.modern-checkbox {
  display: flex;
  align-items: center;
  gap: 10px;
  cursor: pointer;
  user-select: none;
}

.modern-checkbox input {
  width: 17px;
  height: 17px;
  accent-color: #0E7490;
  cursor: pointer;
}

.checkbox-text {
  font-size: 13px;
  color: #64748B;
  line-height: 1.4;
}

.terms-link {
  color: #0E7490;
  font-weight: 600;
  text-decoration: underline;
}

.terms-link:hover {
  color: #155E75;
}

/* Submit Button */
.submit-btn.modern-btn {
  width: 100%;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  background: linear-gradient(90deg, #3BD9F2, #1BA9C9);
  color: #06222B;
  font-weight: 700;
  font-size: 15px;
  padding: 15px 28px;
  border: none;
  border-radius: 99px;
  cursor: pointer;
  box-shadow: 0 8px 22px rgba(34, 197, 227, 0.28);
  transition: all 0.2s;
  font-family: inherit;
}

.submit-btn.modern-btn:hover:not(:disabled) {
  background: linear-gradient(90deg, #22C5E3, #0E8FB0);
  transform: translateY(-2px);
  box-shadow: 0 12px 28px rgba(34, 197, 227, 0.35);
}

.submit-btn.modern-btn:disabled {
  opacity: 0.6;
  cursor: not-allowed;
  transform: none;
}

.btn-arrow {
  font-size: 18px;
  transition: transform 0.2s;
}

.submit-btn.modern-btn:hover:not(:disabled) .btn-arrow {
  transform: translateX(4px);
}

/* Loader */
.submit-overlay {
  position: absolute;
  inset: 0;
  background: rgba(255, 255, 255, 0.85);
  backdrop-filter: blur(4px);
  display: grid;
  place-items: center;
  border-radius: 20px;
}

.loader {
  display: flex;
  flex-direction: column;
  align-items: center;
  gap: 12px;
}

.loader-spinner {
  width: 36px;
  height: 36px;
  border: 3px solid #E0F7FB;
  border-top-color: #0E7490;
  border-radius: 50%;
  animation: spin 0.8s linear infinite;
}

.loader-text {
  font-size: 14px;
  font-weight: 600;
  color: #0F172A;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}

/* Toast */
.modern-toast {
  position: fixed;
  bottom: 24px;
  right: 24px;
  background: #ffffff;
  border: 1px solid #E2E8F0;
  border-radius: 14px;
  box-shadow: 0 16px 36px rgba(15, 23, 42, 0.15);
  padding: 16px 20px;
  z-index: 1000000;
  min-width: 300px;
  overflow: hidden;
}

.modern-toast.success {
  border-left: 4px solid #16A34A;
}

.modern-toast.error {
  border-left: 4px solid #EF4444;
}

.toast-content {
  display: flex;
  align-items: center;
  gap: 12px;
}

.toast-icon {
  width: 28px;
  height: 28px;
  border-radius: 50%;
  background: #DCFCE7;
  color: #16A34A;
  display: grid;
  place-items: center;
  font-weight: 800;
  font-size: 14px;
  flex-shrink: 0;
}

.modern-toast.error .toast-icon {
  background: #FEE2E2;
  color: #EF4444;
}

.toast-text {
  flex: 1;
}

.toast-title {
  font-size: 14px;
  font-weight: 700;
  color: #0F172A;
  margin-bottom: 2px;
}

.toast-message {
  font-size: 13px;
  color: #64748B;
}

.toast-close {
  background: none;
  border: none;
  font-size: 16px;
  color: #94A3B8;
  cursor: pointer;
  padding: 4px;
}

.toast-close:hover {
  color: #0F172A;
}

/* Transitions */
.contact-modal-enter-active,
.contact-modal-leave-active {
  transition: opacity 0.25s ease;
}

.contact-modal-enter-from,
.contact-modal-leave-to {
  opacity: 0;
}

.contact-modal-enter-active .contact-modal {
  transition: transform 0.25s cubic-bezier(0.16, 1, 0.3, 1);
}

.contact-modal-enter-from .contact-modal {
  transform: scale(0.95) translateY(12px);
}

/* Responsive */
@media (max-width: 640px) {
  .contact-content-area {
    padding: 24px 20px 28px;
  }

  .form-row {
    grid-template-columns: 1fr;
    gap: 14px;
  }

  .header-titles h2 {
    font-size: 20px;
  }
}
</style>