<template>
  <div class="login-bg">
    <div class="login-main">
      <div class="login-card">
        <!-- Left: Login Form -->
        <div class="login-form-col">
          <div class="login-logo-row">
            <router-link to="/home" class="icon-back-btn" aria-label="Back to Home">
              <svg width="22" height="22" fill="none" stroke="#f7871f" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 19l-7-7 7-7"/>
              </svg>
            </router-link>
            <img src="/Designer.png" alt="PawFect" class="login-logo-img" />
            <span class="login-logo-text">PAWFECT</span>
          </div>
          <h1 class="login-title">Log in to your Account</h1>
          <p class="login-sub">Welcome back! Please enter your details.</p>
          <form class="login-main-form" @submit.prevent="handleLogin">
            <div class="login-input-group">
              <span class="login-input-icon">
                <svg width="20" height="20" fill="none" stroke="#f7871f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h12v12H4z" opacity="0"/><path d="M4 4h12v12H4z"/><path d="M4 4l8 6 8-6"/></svg>
              </span>
              <input type="email" v-model="loginEmail" placeholder="Email" required />
            </div>
            <div class="login-input-group">
              <span class="login-input-icon">
                <svg width="20" height="20" fill="none" stroke="#f7871f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="8" width="14" height="9" rx="2"/><path d="M7 8V6a5 5 0 0 1 10 0v2"/></svg>
              </span>
              <input :type="showPassword ? 'text' : 'password'" v-model="loginPassword" placeholder="Password" required />
              <span class="login-eye" @click="showPassword = !showPassword">
                <svg v-if="!showPassword" width="20" height="20" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 10s4-6 9-6 9 6 9 6-4 6-9 6-9-6-9-6z"/><circle cx="10" cy="10" r="3"/></svg>
                <svg v-else width="20" height="20" fill="none" stroke="#f7871f" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 10 19C5.58 19 1.73 15.36 1.05 10.94M23 1L1 23"/><path d="M9.53 9.53A3 3 0 0 0 13 13"/></svg>
              </span>
            </div>
            <div class="login-options-row">
              <label class="login-remember">
                <input type="checkbox" v-model="rememberMe" />
                <span class="checkmark"></span>
                Remember me
              </label>
              <a href="#" class="login-link">Forgot Password?</a>
            </div>
            <button
              class="login-btn"
              type="submit"
              :disabled="isLoading"
            >
              <span v-if="isLoading" class="spinner"></span>
              {{ isLoading ? 'Logging in...' : 'Log in' }}
            </button>
          </form>
          <div class="social-login">
            <div class="divider">
              <span>or continue with</span>
            </div>
            <div class="social-buttons">
              <button class="social-btn google" @click="handleGoogleLogin">
                <img src="https://www.google.com/favicon.ico" alt="Google" />
                Google
              </button>
              <button class="social-btn facebook" @click="handleFacebookLogin">
                <img src="https://www.facebook.com/favicon.ico" alt="Facebook" />
                Facebook
              </button>
            </div>
          </div>
          <div v-if="errorMessage" class="error-message">
            {{ errorMessage }}
          </div>
          <div class="login-bottom-row">
            <span>Don't have an account?</span>
            <a href="/signup" class="login-link">Create an account</a>
          </div>
        </div>
        <!-- Right: Illustration -->
        <div class="login-illustration-col">
          <div class="login-illustration-bg">
            <img src="/Designer.png" alt="Pawfect Logo" class="login-illustration-img" />
            <div class="login-illustration-text">
              <h2>Welcome to Pawfect</h2>
              <p>Your perfect place for pet adoption</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/utils/axios';

export default {
  name: 'LoginPage',
  data() {
    return {
      loginEmail: '',
      loginPassword: '',
      rememberMe: false,
      showPassword: false,
      isLoading: false,
      errorMessage: '',
    };
  },
  methods: {
    async handleLogin() {
      if (!this.loginEmail || !this.loginPassword) {
        this.errorMessage = 'Email and password are required';
        return;
      }
      const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
      if (!emailPattern.test(this.loginEmail)) {
        this.errorMessage = 'Please enter a valid email address';
        return;
      }

      this.isLoading = true;
      this.errorMessage = '';

      try {
        const response = await api.post('/login', {
          email: this.loginEmail,
          password: this.loginPassword
        });

        const data = response.data;

        if (data.success) {
          if (data.token) {
            localStorage.setItem('token', data.token);
          }

          if (data.user) {
            localStorage.setItem('user', JSON.stringify(data.user));
          }

          if (this.rememberMe) {
            localStorage.setItem('rememberedEmail', this.loginEmail);
          }

          this.$nextTick(() => {
            const targetRoute = data.user && data.user.role === 'admin'
              ? '/admin'
              : '/home';

            this.$router.push(targetRoute).catch(err => {
              if (err.name !== 'NavigationDuplicated') {
                console.error('Navigation error:', err);
              }
            });
          });
        } else {
          this.errorMessage = data.message || 'Login failed. Please check your credentials.';
        }
      } catch (error) {
        console.error('Login error:', error);
        this.errorMessage = error.response?.data?.message || 'An error occurred during login. Please try again.';
      } finally {
        this.isLoading = false;
      }
    },
    loadGoogleScript() {
      return new Promise((resolve, reject) => {
        if (window.gapi) {
          resolve();
          return;
        }
        const script = document.createElement('script');
        script.src = 'https://apis.google.com/js/platform.js';
        script.async = true;
        script.defer = true;
        script.onload = () => {
          console.log('Google API script loaded successfully');
          resolve();
        };
        script.onerror = (error) => {
          console.error('Error loading Google API script:', error);
          reject(new Error('Failed to load Google API script'));
        };
        document.body.appendChild(script);
      });
    },
    initGoogleAuth() {
      return new Promise((resolve, reject) => {
        window.gapi.load('auth2', () => {
          window.gapi.auth2.init({
            client_id: '982229749981-kdq2sfh74593t69foglo2r6cbbooorsj.apps.googleusercontent.com',
            scope: 'profile email'
          }).then((auth2) => {
            console.log('Google Auth2 initialized successfully');
            resolve(auth2);
          }).catch((error) => {
            console.error('Error initializing Google Auth2:', error);
            reject(error);
          });
        });
      });
    },
    async handleGoogleLogin() {
      try {
        this.isLoading = true;
        this.errorMessage = '';

        console.log('Starting Google login process...');

        // Load the Google API client
        await this.loadGoogleScript();
        console.log('Google script loaded');

        // Initialize Google Sign-In
        const auth2 = await this.initGoogleAuth();
        console.log('Google Auth2 initialized');

        // Sign in with Google
        const googleUser = await auth2.signIn();
        console.log('Google sign-in successful');

        const profile = googleUser.getBasicProfile();
        console.log('Got user profile:', {
          email: profile.getEmail(),
          name: profile.getName(),
          id: profile.getId()
        });

        // Send user data to backend
        const response = await api.post('/login/google', {
          email: profile.getEmail(),
          googleId: profile.getId()
        });

        if (response.data.success) {
          // Store token and user data
          localStorage.setItem('token', response.data.token);
          localStorage.setItem('user', JSON.stringify(response.data.user));

          // Redirect to home page
          this.$router.push('/home');
        } else {
          throw new Error(response.data.message || 'Login failed');
        }
      } catch (error) {
        console.error('Google login error:', error);
        this.errorMessage = error.message || 'Failed to login with Google. Please try again.';
      } finally {
        this.isLoading = false;
      }
    },
    async handleFacebookLogin() {
      try {
        // Implement Facebook login logic here
        console.log('Facebook login clicked');
        // You'll need to implement the actual Facebook OAuth flow
      } catch (error) {
        this.errorMessage = 'Failed to login with Facebook';
      }
    }
  },
  mounted() {
    const rememberedEmail = localStorage.getItem('rememberedEmail');
    if (rememberedEmail) {
      this.loginEmail = rememberedEmail;
      this.rememberMe = true;
    }
  }
};
</script>

<style scoped>
.login-bg {
  height: 100vh;
  background: #f4f6fa;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
  overflow: hidden;
}

.login-main {
  height: 100vh;
  width: 100vw;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
}

.login-card {
  display: flex;
  background: #fff;
  border-radius: 20px;
  box-shadow: 0 8px 40px rgba(0,0,0,0.10);
  overflow: hidden;
  max-width: 850px;
  width: 100%;
  min-height: 550px;
}
.login-form-col {
  flex: 1.1;
  padding: 40px 36px 36px 36px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background: #fff;
}
.login-logo-row {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 1rem;
}
.login-logo-img {
  width: 32px;
  height: 32px;
}
.login-logo-text {
  font-size: 1.3rem;
  font-weight: 800;
  color: #f7871f;
  letter-spacing: 1px;
}
.login-title {
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 0.2rem;
  color: #222;
  letter-spacing: 1px;
}
.login-sub {
  color: #888;
  font-size: 0.95rem;
  margin-bottom: 1.5rem;
}
.login-main-form {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 0.8rem;
}
.login-input-group {
  width: 100%;
  display: flex;
  align-items: center;
  background: #f7f8fa;
  border-radius: 8px;
  border: 1.5px solid #e0e0e0;
  margin-bottom: 0.1rem;
  position: relative;
}
.login-input-icon {
  margin-left: 1rem;
  color: #f7871f;
  display: flex;
  align-items: center;
}
.login-input-group input {
  flex: 1;
  border: none;
  background: transparent;
  padding: 0.8rem 1rem 0.8rem 0.5rem;
  font-size: 0.95rem;
  outline: none;
  color: #222;
}
.login-eye {
  margin-right: 1rem;
  cursor: pointer;
  display: flex;
  align-items: center;
}
.login-options-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.5rem;
  margin-top: 0.1rem;
}
.login-remember {
  font-size: 0.9rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #555;
}
.login-remember input[type="checkbox"] {
  accent-color: #f7871f;
}
.login-link {
  color: #f7871f;
  text-decoration: none;
  font-size: 0.97rem;
  font-weight: 500;
  transition: color 0.2s;
}
.login-link:hover {
  color: #ff9800;
  text-decoration: underline;
}
.login-btn {
  width: 100%;
  padding: 1rem 0;
  background: #dedede;
  color: #222;
  border: none;
  border-radius: 12px;
  font-size: 1.35rem;
  font-weight: 700;
  margin-top: 0.5rem;
  cursor: pointer;
  transition: background 0.2s;
  position: relative;
  box-shadow: none;
  letter-spacing: 0.5px;
}
.login-btn:disabled {
  background: #e0e0e0;
  color: #aaa;
  cursor: not-allowed;
}
.login-btn .spinner {
  position: absolute;
  right: 1rem;
  top: 50%;
  transform: translateY(-50%);
  width: 20px;
  height: 20px;
  border: 2px solid #fff;
  border-top-color: transparent;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}
.login-btn:hover {
  background: #f7871f;
  color: #fff;
}
.login-bottom-row {
  margin-top: 1.2rem;
  font-size: 0.9rem;
}
.login-bottom-row .login-link {
  margin-left: 0.3rem;
  font-weight: 600;
}
.login-illustration-col {
  flex: 1.2;
  background: #fc9d04;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}
.login-illustration-bg {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  position: relative;
  padding: 2rem;
}
.login-illustration-img {
  width: 180px;
  height: 180px;
  object-fit: contain;
  margin-bottom: 2rem;
}
.login-illustration-text {
  color: #fff;
  text-align: center;
  max-width: 340px;
}
.login-illustration-text h2 {
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 1rem;
}
.login-illustration-text p {
  font-size: 1.1rem;
  color: #fff;
  opacity: 0.9;
}
.error-message {
  color: #ff5252;
  font-size: 0.9rem;
  margin-top: 0.5rem;
  text-align: center;
}
.social-login {
  margin-top: 1.2rem;
}
.divider {
  margin: 0.8rem 0;
}
.social-buttons {
  display: flex;
  gap: 1rem;
  justify-content: center;
  margin-top: 1rem;
}
.social-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.9rem 2.2rem;
  border: 1.5px solid #dedede;
  border-radius: 12px;
  background: #fff;
  color: #222;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: box-shadow 0.2s, border 0.2s;
  box-shadow: none;
  min-width: 150px;
}
.social-btn img {
  width: 24px;
  height: 24px;
}
.social-btn.google {
  border-color: #dedede;
}
.social-btn.facebook {
  border-color: #dedede;
}
.social-btn:hover {
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
  border-color: #bdbdbd;
}
@media (max-width: 1100px) {
  .login-card {
    flex-direction: column;
    min-height: 0;
    max-width: 500px;
  }
  .login-illustration-col {
    display: none;
  }
  .login-form-col {
    padding: 40px 24px 32px 24px;
  }
}
@media (max-width: 600px) {
  .login-main {
    padding: 0 0.5rem;
  }
  .login-form-col {
    padding: 24px 6px 18px 6px;
  }
  .login-title {
    font-size: 1.5rem;
  }
}
.icon-back-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 36px;
  height: 36px;
  border-radius: 50%;
  background: #fff;
  border: 1.5px solid #f7871f;
  margin-right: 0.5rem;
  transition: background 0.2s, box-shadow 0.2s;
  cursor: pointer;
  text-decoration: none;
}
.icon-back-btn:hover {
  background: #fef3e6;
  box-shadow: 0 2px 8px rgba(247,135,31,0.08);
}
.icon-back-btn svg {
  display: block;
}
</style>