<template>
  <div class="login-container" v-if="!isLoggedIn">
    <div class="login-card">
      <h1>Welcome Back</h1>
      <p class="subtitle">Login to your account</p>

      <form @submit.prevent="handleLogin">
        <div class="form-group">
          <label for="email">Email</label>
          <input
            v-model="formData.email"
            type="email"
            id="email"
            placeholder="Enter your email"
            required
          />
        </div>

        <div class="form-group">
          <label for="password">Password</label>
          <input
            v-model="formData.password"
            type="password"
            id="password"
            placeholder="Enter your password"
            required
          />
        </div>

        <button type="submit" class="btn-login" :disabled="loading">
          {{ loading ? 'Logging in...' : 'Login' }}
        </button>

        <p v-if="error" class="error-message">{{ error }}</p>
      </form>

      <p class="register-link">
        Don't have an account? <a href="/register">Sign up</a>
      </p>

      <!-- Demo Credentials -->
      <div class="demo-section">
        <p class="demo-title">Demo Credentials:</p>
        <div class="demo-creds">
          <p><strong>Super Admin:</strong> superadmin@gmail.com / 12345678</p>
          <p><strong>Admin:</strong> admin@gmail.com / 12345678</p>
          <p><strong>User:</strong> user@gmail.com / 12345678</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { ref } from 'vue';

export default {
  name: 'LoginWithRoleCheck',
  setup() {
    const formData = ref({
      email: '',
      password: ''
    });
    const loading = ref(false);
    const error = ref('');
    const isLoggedIn = ref(!!localStorage.getItem('token'));

    const apiUrl = import.meta.env.VITE_API_URL || 'http://localhost:8000/api';

    const handleLogin = async () => {
      loading.value = true;
      error.value = '';

      try {
        const response = await fetch(`${apiUrl}/auth/login`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(formData.value)
        });

        const data = await response.json();

        if (!response.ok) {
          error.value = data.message || 'Login failed';
          return;
        }

        // Store token
        localStorage.setItem('token', data.token);
        localStorage.setItem('user', JSON.stringify(data.user));

        // Redirect based on role
        if (data.should_redirect_to_admin) {
          // Redirect to admin panel
          window.location.href = '/admin';
        } else {
          // Redirect to regular dashboard
          window.location.href = '/dashboard';
        }
      } catch (err) {
        error.value = 'An error occurred. Please try again.';
        console.error(err);
      } finally {
        loading.value = false;
      }
    };

    return {
      formData,
      loading,
      error,
      isLoggedIn,
      handleLogin
    };
  }
};
</script>

<style scoped>
.login-container {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 100vh;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  padding: 2rem;
}

.login-card {
  background: white;
  border-radius: 10px;
  box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
  max-width: 400px;
  width: 100%;
  padding: 3rem 2rem;
}

h1 {
  text-align: center;
  color: #333;
  margin-bottom: 0.5rem;
  font-size: 1.8rem;
}

.subtitle {
  text-align: center;
  color: #999;
  margin-bottom: 2rem;
  font-size: 0.95rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

label {
  display: block;
  margin-bottom: 0.5rem;
  color: #333;
  font-weight: 500;
  font-size: 0.95rem;
}

input {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ddd;
  border-radius: 4px;
  font-size: 0.95rem;
  transition: all 0.3s;
}

input:focus {
  outline: none;
  border-color: #667eea;
  box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.btn-login {
  width: 100%;
  padding: 0.875rem;
  background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 0.95rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s;
  margin-top: 1rem;
}

.btn-login:hover:not(:disabled) {
  transform: translateY(-2px);
  box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
}

.btn-login:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}

.error-message {
  color: #ff6b6b;
  font-size: 0.9rem;
  margin-top: 1rem;
  text-align: center;
}

.register-link {
  text-align: center;
  color: #666;
  margin-top: 1.5rem;
  font-size: 0.9rem;
}

.register-link a {
  color: #667eea;
  text-decoration: none;
  font-weight: 600;
}

.register-link a:hover {
  text-decoration: underline;
}

.demo-section {
  background: #f9f9f9;
  padding: 1.5rem;
  border-radius: 4px;
  margin-top: 2rem;
}

.demo-title {
  color: #333;
  font-weight: 600;
  margin-bottom: 0.75rem;
  font-size: 0.9rem;
}

.demo-creds {
  font-size: 0.85rem;
  color: #666;
  line-height: 1.6;
}

.demo-creds p {
  margin: 0.3rem 0;
}

.demo-creds strong {
  color: #333;
}

@media (max-width: 480px) {
  .login-card {
    padding: 2rem 1.5rem;
  }

  h1 {
    font-size: 1.5rem;
  }

  .demo-section {
    padding: 1rem;
  }
}
</style>
