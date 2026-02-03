<template>
  <div class="neon-auth-wrapper">
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

<!--         <div class="neon-options">
          <label>
            <input type="checkbox" />
            Maintain Session
          </label>
          <a href="#">Recover Access</a>
        </div>

        <button class="neon-btn">INITIALIZE CONNECTION</button>

        <div class="neon-footer">
          <router-link to="/register">CREATE_PROFILE</router-link>
        </div> -->

        <!-- EXTRA OPTIONS -->
<div class="neon-extra">
  <label class="neon-check">
    <input type="checkbox" />
    <span>Keep me signed in</span>
  </label>

  <a href="/forgot-password" class="forgot-link">
  Forgot password?
</a>

</div>

<!-- SIGN IN BUTTON -->
<button class="neon-btn neon-gradient">
  INITIALIZE CONNECTION
</button>

<!-- OR DIVIDER -->
<div class="neon-divider">
  <span>OR</span>
</div>

<!-- SOCIAL LOGIN -->
<div class="neon-social">
  <button class="social-btn google">
    <span>G</span> Continue with Google
  </button>

  <button class="social-btn apple">
    <span>A</span> Continue with Apple
  </button>
</div>

<!-- REGISTER LINK -->
<div class="neon-footer">
  New here?
  <router-link to="/register">CREATE_PROFILE</router-link>
</div>

      </form>
    </div>
  </div>
</template>

<script setup>
</script>

<style scoped>
@import '../../../css/neon-auth.css';
</style>
