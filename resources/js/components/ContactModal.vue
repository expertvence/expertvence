<template>
  <transition name="contact-modal">
    <div v-if="show" class="contact-overlay" @click.self="$emit('close')">
      <div class="contact-modal contact-bg">
        <!-- HEADER -->
        <div class="contact-header">
          <h3>Let’s build something great 🚀</h3>
          <button class="close-btn" @click="$emit('close')">✕</button>
        </div>

        <!-- BODY -->
        <div class="contact-body">
          <!-- LEFT -->
          <div class="contact-info">
            <h2>Tell us about your goals</h2>
            <p>We’ll get back within one business day.</p>
            <ul>
              <li>📧 info@expertvence.com</li>
              <li>📞 +880 18183590326</li>
            </ul>
          </div>

          <!-- RIGHT -->
          <form class="contact-form">
            <div class="row">
              <input type="text" placeholder="Your name" />
              <input type="email" placeholder="Email" />
            </div>

            <!-- PHONE INPUT -->
            <label class="label">Mobile</label>
            <div class="phone-input">
              <button
                type="button"
                class="phone-prefix"
                @click="open = !open"
              >
                <img :src="selected.flag" />
                <span>{{ selected.code }}</span>
                ▾
              </button>

            <input
              type="tel"
              placeholder="Enter mobile number"
              @input="showMessaging = $event.target.value.length > 0"
            />



              <!-- DROPDOWN -->
              <div v-if="open" class="country-list">
                <div
                  v-for="c in countries"
                  :key="c.code"
                  @click="selectCountry(c)"
                  class="country-item"
                >
                  <img :src="c.flag" />
                  {{ c.name }} ({{ c.code }})
                </div>
              </div>
            </div>
            <!-- MESSAGING OPTIONS -->
<div class="messaging-options" v-show="showMessaging">

  <label class="msg-item">
    <input type="checkbox" />
    <img src="https://cdn-icons-png.flaticon.com/512/733/733585.png" />
    <span>WhatsApp</span>
  </label>

  <label class="msg-item">
    <input type="checkbox" />
    <img src="https://cdn-icons-png.flaticon.com/512/2111/2111646.png" />
    <span>Telegram</span>
  </label>
</div>


            <select>
              <option>Project type</option>
              <option>Web Development</option>
              <option>SaaS</option>
            </select>

            <textarea placeholder="Project brief"></textarea>

            <button class="submit">Submit</button>
          </form>
        </div>
      </div>
    </div>
  </transition>
</template>




<script setup>
import { ref, watch } from 'vue'

defineProps({ show: Boolean })

const open = ref(false)
const showMessaging = ref(false)


const countries = [
  {
    name: 'Afghanistan',
    code: '+93',
    flag: 'https://flagcdn.com/w20/af.png'
  },
  {
    name: 'Bangladesh',
    code: '+880',
    flag: 'https://flagcdn.com/w20/bd.png'
  },
  {
    name: 'India',
    code: '+91',
    flag: 'https://flagcdn.com/w20/in.png'
  }
]

const selected = ref(countries[0])

const selectCountry = (c) => {
  selected.value = c
  open.value = false
}

watch(
  () => open.value,
  v => document.body.style.overflow = v ? 'hidden' : ''
)
</script>



<style scoped>

/* ================= ICON WATERMARKS ================= */
.contact-bg::after {
  content: "";
  position: absolute;
  inset: 0;

  background:
    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2399a2ff' stroke-width='1.4'%3E%3Cpath d='M22 16.9V21a1 1 0 0 1-1.1 1A19.8 19.8 0 0 1 3 5.1 1 1 0 0 1 4 4h4.1a1 1 0 0 1 1 .8l1.2 4.7a1 1 0 0 1-.3 1L8.9 11a16 16 0 0 0 4.1 4.1l1.5-1.5a1 1 0 0 1 1-.3l4.7 1.2a1 1 0 0 1 .8 1z'/%3E%3C/svg%3E")
      12% 22% / 120px no-repeat,

    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2399a2ff' stroke-width='1.4'%3E%3Cpath d='M22 2L11 13'/%3E%3Cpath d='M22 2L15 22l-4-9-9-4z'/%3E%3C/svg%3E")
      80% 75% / 140px no-repeat,

    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%2399a2ff' stroke-width='1.4'%3E%3Crect x='5' y='2' width='14' height='20' rx='2'/%3E%3Cline x1='12' y1='18' x2='12' y2='18'/%3E%3C/svg%3E")
      86% 28% / 100px no-repeat;

  opacity: 0.12;
  animation: iconDrift 40s ease-in-out infinite;
  pointer-events: none;
}

@keyframes iconDrift {
  0% { transform: translateY(0); }
  50% { transform: translateY(-20px); }
  100% { transform: translateY(0); }
}
.contact-bg::before,
.contact-bg::after {
  will-change: transform;
}

.contact-overlay {
  position: fixed;
  inset: 0;

  /* lighter overlay */
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

/* HEADER */
.contact-header {
  padding: 14px 20px;
  background: #f3f4f6;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.close-btn {
  border: none;
  background: none;
  font-size: 18px;
  cursor: pointer;
}

/* BODY */
.contact-body {
  display: grid;
  grid-template-columns: 1fr 1.2fr;
  gap: 30px;
  padding: 26px;
  overflow-y: auto;
  max-height: calc(90vh - 70px); /* header height বাদ */
}



.contact-info h2 {
  font-size: 26px;
  margin-bottom: 10px;
}

.contact-info p {
  opacity: 0.9;
  margin-bottom: 24px;
}

.contact-info ul {
  list-style: none;
  padding: 0;
}

.contact-info li {
  margin-bottom: 12px;
  font-size: 15px;
}


.contact-body::before {
  content: "";
  position: absolute;
  top: 10%;
  bottom: 10%;
  left: 45%;
  width: 2px;
  background: linear-gradient(
    to bottom,
    transparent,
    rgba(99, 102, 241, 0.4),
    transparent
  );
}

.contact-form input:focus,
.contact-form textarea:focus,
.contact-form select:focus {
  border-color: #6366f1;
  box-shadow: 0 0 0 2px rgba(99,102,241,0.15);
  outline: none;
}

/* FORM */
.contact-form input,
.contact-form select,
.contact-form textarea {
  width: 100%;
  padding: 10px 12px;
  margin-bottom: 12px;
  border-radius: 6px;
  border: 1px solid #d1d5db;
}

.row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 12px;
}

/* PHONE */
.phone-input {
  position: relative;
  display: flex;
  height: 2.5rem;
  border: 1px solid #d1d5db;
  border-radius: 6px;
  overflow: visible;
  margin-bottom: 12px;
}

.phone-prefix {
  display: flex;
  align-items: center;
  gap: 6px;
  height: 2.5rem;
  padding: 0 12px;
  background: #d1d5db;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}

.phone-prefix img {
  width: 18px;
}

.phone-input input {
  border: none;
  flex: 1;
  padding: 10px 12px;
  outline: none;
}

/* COUNTRY LIST */
.country-list {
  position: absolute;
  top: 100%;
  left: 0;
  width: 260px;
  max-height: 220px;
  overflow-y: auto;
  background: #fff;
  border: 1px solid #d1d5db;
  z-index: 10;
}

.country-item {
  padding: 8px 10px;
  display: flex;
  gap: 8px;
  cursor: pointer;
}
.country-item:hover {
  background: #f3f4f6;
}

/* BUTTON */
.submit {
  background: #f59e0b;
  color: #fff;
  width: 100%;
  border: none;
  padding: 12px;
  border-radius: 8px;
  font-weight: 600;
  cursor: pointer;
}

.submit:hover {
  background: #d97706;
}

/* ANIMATION */
.contact-modal-enter-active,
.contact-modal-leave-active {
  transition: .35s ease;
}
.contact-modal-enter-from,
.contact-modal-leave-to {
  opacity: 0;
  transform: translate(-50%, -55%) scale(.96);
}

@media (max-width: 900px) {
  .contact-modal {
    width: 96vw;
    max-height: 92vh;
    border-radius: 18px;
  }

  .contact-body {
    grid-template-columns: 1fr;
  }

  /* REMOVE vertical divider */
  .contact-body::before {
    display: none;
  }

  /* ADD horizontal divider */
  .contact-info {
    position: relative;
  }

  .contact-info::after {
    content: "";
    position: absolute;
    left: 10%;
    right: 10%;
    bottom: 0;
    height: 2px;
    background: linear-gradient(
      to right,
      transparent,
      rgba(255,255,255,0.2),
      transparent
    );
  }
}

@media (max-width: 520px) {
  .contact-modal {
    top: auto;
    bottom: 0;
    transform: translate(-50%, 0);
    border-radius: 22px 22px 0 0;
    height: 92vh;
  }

  .contact-header h3 {
    font-size: 16px;
  }

  .row {
    grid-template-columns: 1fr;
  }

  .contact-info h2 {
    font-size: 22px;
  }

  .contact-body {
    max-height: calc(92vh - 60px);
    padding-bottom: 30px;
  }
}

  /* MESSAGING ICONS */
.messaging-options {
  display: flex;
  gap: 18px;
  margin-bottom: 16px;
}

.msg-item {
  display: flex;
  align-items: center;
  gap: 10px;
  background: rgba(255,255,255,0.55);
  padding: 8px 14px;
  border-radius: 999px;
  cursor: pointer;
  font-size: 14px;
  box-shadow: 0 4px 14px rgba(0,0,0,0.08);
  transition: transform .2s ease, box-shadow .2s ease;
}

.msg-item:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 20px rgba(0,0,0,0.12);
}

.msg-item img {
  width: 22px;
  height: 22px;
}

.msg-item input {
  accent-color: #22c55e;
  transform: scale(1.15);
  cursor: pointer;
}




.phone-input input:focus {
  outline: none !important;
  box-shadow: none !important;
}





</style>
