<template>
  <div class="neon-auth-wrapper">
    <div class="neon-card">
      <div class="neon-header">
        <div class="neon-icon">⬢</div>
        <h2>NEW_ACCESS_CODE</h2>
        <p>[ RESET PASSWORD ]</p>
      </div>

      <form class="neon-form">
        <div class="neon-input">
          <span>&gt;</span>
          <input type="password" placeholder="NEW_PASSWORD" />
        </div>

        <div class="neon-input">
          <span>&gt;</span>
          <input type="password" placeholder="CONFIRM_PASSWORD" />
        </div>

        <button class="neon-btn neon-gradient">
          UPDATE ACCESS
        </button>

        <div class="neon-footer">
          <router-link to="/login">LOGIN</router-link>
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
