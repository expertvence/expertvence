<template>
  <div class="neon-auth-wrapper">
    <div class="neon-card">
      <div class="neon-header">
        <div class="neon-icon">⬢</div>
        <h2>RECOVER_ACCESS</h2>
        <p>[ PASSWORD RECOVERY ]</p>
      </div>

      <form class="neon-form">
        <div class="neon-input">
          <span>&gt;</span>
          <input type="email" placeholder="EMAIL_ADDRESS" />
        </div>

        <button class="neon-btn neon-gradient">
          SEND RESET LINK
        </button>

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
