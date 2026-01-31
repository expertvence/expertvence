<template>
  <div class="neon-auth-wrapper">
    <div class="neon-card">
      <div class="neon-header">
        <div class="neon-icon">⬢</div>
        <h2>NEW_IDENTITY</h2>
        <p>[ CREATE SECURE PROFILE ]</p>
      </div>

      <form class="neon-form">
        <div class="neon-input">
          <span>&gt;</span>
          <input type="text" placeholder="USERNAME" />
        </div>

        <div class="neon-input">
          <span>&gt;</span>
          <input type="email" placeholder="EMAIL_ADDRESS" />
        </div>

        <div class="neon-input">
          <span>&gt;</span>
          <input type="password" placeholder="ACCESS_CODE" />
        </div>

        <button class="neon-btn">CREATE PROFILE</button>

        <div class="neon-footer">
          <router-link to="/login">BACK_TO_LOGIN</router-link>
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
