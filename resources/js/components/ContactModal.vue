<template>
  <transition name="contact-modal">
    <div v-if="show" class="contact-overlay" @click.self="$emit('close')">
      <div class="contact-modal" :style="{
            backgroundImage: `
                                  url(${contactBg})
                                `
          }">
        <div class="contact-wrapper">
          

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
                  <label>Email address</label>
                  <input type="email" placeholder="you@example.com" required v-model="form.email">
                </div>
                  
                </div>

                
                <div class="form-row">
                <div class="form-group">
                    <label>Phone number</label>
                    <div class="phone-input-wrapper">
                      <div class="country-selector" @click="toggleCountryList">
                        <img :src="selectedCountry.flag" alt="flag" class="flag">
                        <span class="country-code">+{{ selectedCountry.code }}</span>
                        <span class="dropdown-arrow">▼</span>
                      </div>

                      <div v-if="showCountryList" class="country-dropdown">
                        <div v-for="country in countries" :key="country.code" class="country-option"
                          @click="selectCountry(country)">
                          <img :src="country.flag" alt="flag" class="flag">
                          <span class="country-name">{{ country.name }}</span>
                          <span class="country-code">+{{ country.code }}</span>
                        </div>
                      </div>

                      <input type="tel" placeholder="999 9999999" class="phone-input" required v-model="form.phone">
                    </div>
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
                </div>

                <div class="form-group">
                  <label>How can we help?</label>
                  <textarea placeholder="Tell us about your project..." rows="3" required
                    v-model="form.message"></textarea>
                </div>

                <!-- SUBMIT BUTTON SECTION - Fixed and Visible -->
                <div class="submit-section-wrapper">
                  <div class="submit-section">
                    <button type="submit" class="submit-btn">
                      <span class="btn-text">Send your message</span>
                      <span class="btn-arrow">→</span>
                    </button>

                    <p class="terms">
                      By clicking, you agree to our <a href="#">Terms & Conditions</a>, <a href="#">Privacy</a> and <a
                        href="#">Data Protection Policy</a>
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
import { ref, reactive, defineProps, defineEmits } from 'vue'
import contactBg from '@/assets/images/contact-bg4.png'

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
  { name: 'Italy', code: '+88', flag: 'https://flagcdn.com/w20/bd.png' },
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
/* ================= Overlay ================= */
.contact-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.35);
  backdrop-filter: blur(6px);
  z-index: 99999;
}

/* ================= Modal ================= */
.contact-modal {
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: min(1100px, 94vw);
  max-height: 90vh;
  display: flex;
  flex-direction: column;
  background: #e6e9f0;
  border-radius: 5px;
  overflow: hidden;
  box-shadow:
    14px 14px 30px rgba(0, 0, 0, 0.15),
    -14px -14px 30px rgba(255, 255, 255, 0.9);
}

.contact-wrapper {
  display: flex;
  align-items: center;
  justify-content: center;
  height: 100%;
}

/* ================= Right Form Card ================= */
.contact-right {
  width: 100%;
  max-width: 660px;
  background: #e6e9f0;
  display: flex;
  flex-direction: column;
  border-radius: 0px;
  box-shadow:
    inset 8px 8px 16px rgba(0, 0, 0, 0.08),
    inset -8px -8px 16px rgba(255, 255, 255, 0.9);
}

/* ================= Header ================= */
.form-header {
  padding: 18px 40px 12px;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid rgba(0,0,0,0.05);
}

.form-header h1 {
  font-size: 28px;
  font-weight: 700;
  color: #111827;
  margin: 0;
}

.close-btn {
  background: #e6e9f0;
  border: none;
  width: 40px;
  height: 40px;
  border-radius: 12px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  cursor: pointer;
  box-shadow:
    5px 5px 10px rgba(0, 0, 0, 0.15),
    -5px -5px 10px rgba(255, 255, 255, 0.9);
}

.close-btn:active {
  box-shadow:
    inset 4px 4px 8px rgba(0, 0, 0, 0.2),
    inset -4px -4px 8px rgba(255, 255, 255, 0.9);
}

/* ================= Scroll Area ================= */
.form-scroll {
  padding: 10px 40px 0;
  flex: 1;
  overflow-y: auto;
  display: flex;
  flex-direction: column;
}

.contact-form {
  display: flex;
  flex-direction: column;
  gap: 16px;
  padding-bottom: 40px;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 16px;
}

.form-group label {
  font-size: 14px;
  font-weight: 600;
  color: #374151;
  margin-bottom: 6px;
  display: block;
}

/* ================= Inputs ================= */
.form-group input:not(.phone-input),
.form-group select,
.form-group textarea,
.phone-input {
  width: 100%;
  padding: 14px 16px;
  border: none;
  border-radius: 12px;
  background: #e6e9f0;
  color: #111827;
  font-size: 15px;
  box-shadow:
    inset 5px 5px 10px rgba(0, 0, 0, 0.12),
    inset -5px -5px 10px rgba(255, 255, 255, 0.9);
}

.form-group textarea {
  resize: vertical;
  min-height: 80px;
}

.form-group input:focus:not(.phone-input),
.form-group select:focus,
.form-group textarea:focus,
.phone-input:focus {
  outline: none;
  box-shadow:
    inset 2px 2px 5px rgba(0, 0, 0, 0.2),
    inset -2px -2px 5px rgba(255, 255, 255, 0.9),
    0 0 0 2px rgba(79, 70, 229, 0.35);
}

/* ================= Phone ================= */
.phone-input-wrapper {
  display: grid;
  grid-template-columns: 140px 1fr;
}

.country-selector {
  display: flex;
  align-items: center;
  gap: 10px;
  padding: 0 14px;
  background: #e6e9f0;
  border-radius: 12px 0 0 12px;
  cursor: pointer;
  box-shadow:
    5px 5px 10px rgba(0, 0, 0, 0.12),
    -5px -5px 10px rgba(255, 255, 255, 0.9);
}

.country-dropdown {
  position: absolute;
  margin-top: 6px;
  width: 280px;
  max-height: 300px;
  overflow-y: auto;
  background: #e6e9f0;
  border-radius: 14px;
  box-shadow:
    10px 10px 25px rgba(0, 0, 0, 0.18),
    -10px -10px 25px rgba(255, 255, 255, 0.9);
  z-index: 200;
}

/* ================= Submit Section ================= */
.submit-section-wrapper {
  margin-top: auto;
  padding-bottom: 20px;
}

.submit-section {
  background: #e6e9f0;
  border-top: 1px solid rgba(0,0,0,0.05);
  padding-top: 30px;
  display: flex;
  flex-direction: column;
  gap: 10px;
}

.submit-btn {
  width: 100%;
  padding: 16px 20px;
  border-radius: 14px;
  border: none;
  background: #e6e9f0;
  color: #1e293b;
  font-weight: 600;
  cursor: pointer;
  box-shadow:
    8px 8px 16px rgba(0, 0, 0, 0.18),
    -8px -8px 16px rgba(255, 255, 255, 0.9);
}

.submit-btn:active {
  box-shadow:
    inset 6px 6px 12px rgba(0, 0, 0, 0.2),
    inset -6px -6px 12px rgba(255, 255, 255, 0.9);
}

.terms {
  font-size: 12px;
  text-align: center;
  color: #6b7280;
}

/* ================= Animation ================= */
.contact-modal-enter-active,
.contact-modal-leave-active {
  transition: opacity 0.25s ease;
}

.contact-modal-enter-from,
.contact-modal-leave-to {
  opacity: 0;
}

/* ================= Ultra Responsive Fixes (Additive Only) ================= */

/* Very large screens (4K, ultrawide) */
@media (min-width: 1440px) {
  .contact-modal {
    width: 1100px;
  }

  .form-header {
    padding: 24px 60px 16px;
  }

  .form-scroll {
    padding: 10px 60px 0;
  }
}

/* Tablets & small laptops */
@media (max-width: 1024px) {
  .contact-modal {
    width: 96vw;
    max-height: 92vh;
  }

  .contact-right {
    max-width: 100%;
  }

  .form-header {
    padding: 16px 28px 12px;
  }

  .form-scroll {
    padding: 0 28px;
  }
}

/* Large phones */
@media (max-width: 768px) {
  .contact-overlay {
    padding: 12px;
  }

  .contact-modal {
    position: relative;
    top: auto;
    left: auto;
    transform: none;
    width: 100%;
    max-height: 100%;
    border-radius: 16px;
  }

  .contact-wrapper {
    height: auto;
  }

  .contact-right {
    border-radius: 16px;
  }

  .form-header {
    padding: 14px 20px 12px;
  }

  .form-scroll {
    padding: 0 20px;
  }

  .submit-section-wrapper {
    padding-bottom: 12px;
  }

  .submit-btn {
    padding: 14px 16px;
    font-size: 15px;
  }
}

/* Small phones (iPhone SE, very small Android) */
@media (max-width: 480px) {
  .contact-overlay {
    padding: 8px;
  }

  .contact-modal {
    border-radius: 12px;
  }

  .form-header h1 {
    font-size: 20px;
  }

  .close-btn {
    width: 34px;
    height: 34px;
    font-size: 16px;
  }

  .form-group label {
    font-size: 12px;
  }

  .form-group input:not(.phone-input),
  .form-group select,
  .form-group textarea,
  .phone-input {
    padding: 12px 12px;
    font-size: 14px;
  }

  .phone-input-wrapper {
    grid-template-columns: 110px 1fr;
  }

  .country-selector {
    padding: 0 10px;
    gap: 6px;
  }

  .country-dropdown {
    width: 100%;
    left: 0;
    right: 0;
  }

  .submit-btn {
    padding: 13px 14px;
    font-size: 14px;
    border-radius: 12px;
  }

  .terms {
    font-size: 11px;
    line-height: 1.4;
  }
}

/* Ultra small screens / fold phones */
@media (max-width: 360px) {
  .form-header h1 {
    font-size: 18px;
  }

  .phone-input-wrapper {
    grid-template-columns: 95px 1fr;
  }

  .submit-btn {
    font-size: 13px;
    padding: 12px;
  }
}

/* Height-based responsiveness (short screens) */
@media (max-height: 600px) {
  .contact-modal {
    max-height: 98vh;
  }

  .form-scroll {
    max-height: 65vh;
  }

  .submit-section-wrapper {
    padding-bottom: 8px;
  }
}


</style>