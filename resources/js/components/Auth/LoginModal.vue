<template>
  <teleport to="body">
    <div class="neon-modal-overlay" @click.self="$emit('close')">
      <div class="neon-modal">
        <!-- 🔥 EXISTING LOGIN CODE (UNCHANGED) -->

        <div class="neon-auth-wrapper modal-mode">
          <div class="neon-card">
            <div class="neon-header">
              <div class="neon-icon">⬢</div>
              <h2>ExpertVence</h2>
              <p>[ SECURE TERMINAL ACCESS ]</p>
            </div>

            <form class="neon-form">
              <div class="neon-input">
                <span>&gt;</span>
                <input type="email" placeholder="EMAIL_ADDRESS" />
              </div>

              <div class="neon-input">
                <span>&gt;</span>
                <input type="password" placeholder="ACCESS_CODE" />
              </div>

              <div class="neon-extra">
                <label class="neon-check">
                  <input type="checkbox" />
                  <span>Keep me signed in</span>
                </label>

                <a href="/forgot-password" class="forgot-link">
                  Forgot password?
                </a>
              </div>

              <button class="neon-btn neon-gradient">
                INITIALIZE CONNECTION
              </button>

              <div class="neon-divider">
                <span>OR</span>
              </div>

              <div class="neon-social">
                <button class="social-btn google">
                  <span>G</span> Continue with Google
                </button>

                <button class="social-btn apple">
                  <span>A</span> Continue with Apple
                </button>
              </div>

              <div class="neon-footer">
                New here?
                <router-link to="/register">CREATE_PROFILE</router-link>
              </div>
            </form>
          </div>
        </div>

        <!-- CLOSE BUTTON -->
        <button class="neon-modal-close" @click="$emit('close')">✕</button>
      </div>
    </div>
  </teleport>
</template>

<script setup>
defineEmits(['close'])
</script>

<style scoped>
@import '../../../css/neon-auth.css';
@import '../../../css/neon-modal.css';
</style>
