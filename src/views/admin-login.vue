<template>
  <div class="admin-login-bg">
    <div class="admin-login-main">
      <div class="admin-login-card">
        <div class="admin-login-form-col">
          <div class="admin-login-logo-row">
            <img src="/Designer.png" alt="PawFect Admin" class="admin-login-logo-img" />
            <span class="admin-login-logo-text">PAWFECT <span class="admin-badge">ADMIN</span></span>
          </div>
          <h1 class="admin-login-title">Admin Login</h1>
          <p class="admin-login-sub">Sign in to manage Pawfect as an administrator.</p>
          <form class="admin-login-main-form" @submit.prevent="handleAdminLogin">
            <div class="admin-login-input-group">
              <span class="admin-login-input-icon">
                <i class="fa-solid fa-envelope"></i>
              </span>
              <input type="email" v-model="adminEmail" placeholder="Admin Email" required />
            </div>
            <div class="admin-login-input-group">
              <span class="admin-login-input-icon">
                <i class="fa-solid fa-lock"></i>
              </span>
              <input :type="showPassword ? 'text' : 'password'" v-model="adminPassword" placeholder="Password" required />
              <span class="admin-login-eye" @click="showPassword = !showPassword">
                <i v-if="!showPassword" class="fa-solid fa-eye-slash" style="color:#f7871f"></i>
                <i v-else class="fa-solid fa-eye" style="color:#f7871f"></i>
              </span>
            </div>
            <button class="admin-login-btn" type="submit" :disabled="isLoading">
              <span v-if="isLoading" class="spinner"></span>
              {{ isLoading ? 'Logging in...' : 'Log in as Admin' }}
            </button>
            <div v-if="errorMessage" class="admin-error-message">
              {{ errorMessage }}
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { supabase } from '@/config/supabase';

export default {
  name: 'AdminLoginPage',
  data() {
    return {
      adminEmail: '',
      adminPassword: '',
      showPassword: false,
      isLoading: false,
      errorMessage: '',
    };
  },
  methods: {
    async handleAdminLogin() {
      this.isLoading = true;
      this.errorMessage = '';
      try {
        const { error } = await supabase.auth.signInWithPassword({
          email: this.adminEmail,
          password: this.adminPassword
        });
        if (error) {
          this.errorMessage = error.message || 'Invalid admin credentials.';
        } else {
          // Optionally, check user role here if you want to restrict to admins only
          this.$router.push('/admin/dashboard');
        }
      } catch (error) {
        this.errorMessage = 'An error occurred during admin login.';
      } finally {
        this.isLoading = false;
      }
    }
  }
};
</script>

<style scoped>
.admin-login-bg {
  height: 100vh;
  background: #f4f6fa;
  display: flex;
  align-items: center;
  justify-content: center;
}
.admin-login-main {
  width: 100vw;
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
}
.admin-login-card {
  background: #fff;
  border-radius: 24px;
  box-shadow: 0 8px 40px rgba(0,0,0,0.10);
  max-width: 420px;
  width: 100%;
  padding: 40px 32px 32px 32px;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.admin-login-form-col {
  width: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
}
.admin-login-logo-row {
  display: flex;
  align-items: center;
  gap: 0.7rem;
  margin-bottom: 1.5rem;
}
.admin-login-logo-img {
  width: 38px;
  height: 38px;
}
.admin-login-logo-text {
  font-size: 1.4rem;
  font-weight: 900;
  color: #f7871f;
  letter-spacing: 1px;
  display: flex;
  align-items: center;
}
.admin-badge {
  background: #222;
  color: #fff;
  font-size: 0.8rem;
  font-weight: 700;
  border-radius: 6px;
  padding: 2px 8px;
  margin-left: 0.7rem;
  letter-spacing: 1px;
}
.admin-login-title {
  font-size: 2rem;
  font-weight: 800;
  margin-bottom: 0.2rem;
  color: #222;
  letter-spacing: 1px;
  text-align: center;
}
.admin-login-sub {
  color: #888;
  font-size: 1.05rem;
  margin-bottom: 2rem;
  text-align: center;
}
.admin-login-main-form {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 1.1rem;
}
.admin-login-input-group {
  width: 100%;
  display: flex;
  align-items: center;
  background: #f7f8fa;
  border-radius: 10px;
  border: 1.5px solid #e0e0e0;
  margin-bottom: 0.1rem;
  position: relative;
}
.admin-login-input-icon {
  margin-left: 1rem;
  color: #f7871f;
  display: flex;
  align-items: center;
  font-size: 1.2rem;
}
.admin-login-input-group input {
  flex: 1;
  border: none;
  background: transparent;
  padding: 1rem 1rem 1rem 0.5rem;
  font-size: 1.08rem;
  outline: none;
  color: #222;
}
.admin-login-input-group input:focus {
  border: none;
  outline: 2px solid #f7871f;
  background: #fff7ef;
}
.admin-login-eye {
  margin-right: 1rem;
  cursor: pointer;
  display: flex;
  align-items: center;
}
.admin-login-btn {
  width: 100%;
  padding: 1rem 0;
  background: #f7871f;
  color: #fff;
  border: none;
  border-radius: 10px;
  font-size: 1.2rem;
  font-weight: 800;
  margin-top: 0.7rem;
  cursor: pointer;
  transition: background 0.2s;
  position: relative;
  box-shadow: none;
  letter-spacing: 0.5px;
}
.admin-login-btn:disabled {
  background: #ffd699;
  color: #fff;
  cursor: not-allowed;
}
.admin-error-message {
  color: #ff5252;
  font-size: 0.98rem;
  margin-top: 0.7rem;
  text-align: center;
}
</style>