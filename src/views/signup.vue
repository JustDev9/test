<template>
  <div class="signup-bg">
    <div class="signup-main">
      <div class="signup-card">
        <!-- Left: Sign Up Form -->
        <div class="signup-form-col">
          <div class="signup-logo-row">
            <router-link to="/login" class="icon-back-btn" aria-label="Back to Login">
              <svg width="22" height="22" fill="none" stroke="#f7871f" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                <path d="M15 19l-7-7 7-7"/>
              </svg>
            </router-link>
            <img src="/Designer.png" alt="PawFect" class="signup-logo-img" />
            <span class="signup-logo-text">PAWFECT</span>
          </div>
          <h1 class="signup-title">Create your Account</h1>
          <p class="signup-sub">Sign up to get started with Pawfect!</p>
          <form class="signup-main-form" @submit.prevent="handleSignUp">
            <div class="name-fields">
              <div class="signup-input-group">
                <input type="text" v-model="signupFirstName" placeholder="First Name" required />
              </div>
              <div class="signup-input-group">
                <input type="text" v-model="signupLastName" placeholder="Last Name" required />
              </div>
            </div>
            <div class="signup-input-group">
              <input type="email" v-model="signupEmail" placeholder="Email" required />
            </div>
            <div class="signup-input-group password-field">
              <input :type="showPassword ? 'text' : 'password'" v-model="signupPassword" placeholder="Password" required @input="validatePassword" @focus="showPasswordRules = true" @blur="showPasswordRules = false" />
              <span class="signup-eye" @click="showPassword = !showPassword">
                <svg v-if="!showPassword" width="20" height="20" fill="none" stroke="#888" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 10s4-6 9-6 9 6 9 6-4 6-9 6-9-6-9-6z"/><circle cx="10" cy="10" r="3"/></svg>
                <svg v-else width="20" height="20" fill="none" stroke="#e99a08" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 10 19C5.58 19 1.73 15.36 1.05 10.94M23 1L1 23"/><path d="M9.53 9.53A3 3 0 0 0 13 13"/></svg>
              </span>
              <div class="password-rules" v-show="showPasswordRules">
                <div :class="{ valid: passwordValid.length }">• At least 8 characters</div>
                <div :class="{ valid: passwordValid.upper }">• One uppercase letter</div>
                <div :class="{ valid: passwordValid.number }">• One number</div>
                <div :class="{ valid: passwordValid.special }">• One special character</div>
              </div>
            </div>
            <div class="signup-input-group">
              <input :type="showPassword ? 'text' : 'password'" v-model="signupConfirm" placeholder="Confirm Password" required @input="validatePassword" :class="{ 'input-mismatch': signupConfirm && signupPassword !== signupConfirm }" />
            </div>
            <span v-if="signupConfirm && signupPassword !== signupConfirm" class="mismatch-msg">Passwords do not match</span>
            <div class="signup-options-row">
              <label class="signup-remember">
                <input type="checkbox" v-model="agreedToTerms" />
                <span class="checkmark"></span>
                I agree to the <a href="#" @click.prevent="showTerms = true">Terms & Agreement</a>
              </label>
            </div>
            <button class="signup-btn" type="submit" :disabled="!canSubmit || isLoading">
              <span v-if="isLoading" class="spinner"></span>
              {{ isLoading ? 'Creating Account...' : 'Sign Up' }}
            </button>
          </form>
          <div class="social-login">
            <div class="divider">
              <span>or sign up with</span>
            </div>
            <div class="social-buttons">
              <button class="social-btn google" @click="handleGoogleSignup">
                <img src="https://www.google.com/favicon.ico" alt="Google" />
                Google
              </button>
              <button class="social-btn facebook" @click="handleFacebookSignup">
                <img src="https://www.facebook.com/favicon.ico" alt="Facebook" />
                Facebook
              </button>
            </div>
          </div>
          <div v-if="errorMessage" class="error-message">
            {{ errorMessage }}
          </div>
          <div class="signup-bottom-row">
            <span>Already have an account?</span>
            <a href="/login" class="signup-link">Log in</a>
          </div>
        </div>
        <!-- Right: Illustration -->
        <div class="signup-illustration-col">
          <div class="signup-illustration-bg">
            <img src="/Designer.png" alt="Pawfect Logo" class="signup-illustration-img" />
            <div class="signup-illustration-text">
              <h2>Welcome to Pawfect</h2>
              <p>Your perfect place for pet adoption</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div v-if="showTerms" class="modal-overlay" @click.self="showTerms = false">
      <div class="modal">
        <button class="close-btn" @click="showTerms = false">&times;</button>
        <h2>Terms and Agreement</h2>
        <div class="modal-content">
          <p>By creating an account, you agree to our terms and conditions. You are responsible for your account and data. Please use a strong password and keep your credentials safe.</p>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import api from '@/utils/axios';

export default {
  name: 'SignUpPage',
  data() {
    return {
      signupFirstName: '',
      signupLastName: '',
      signupEmail: '',
      signupPassword: '',
      signupConfirm: '',
      agreedToTerms: false,
      showPassword: false,
      showTerms: false,
      isLoading: false,
      errorMessage: '',
      passwordValid: {
        length: false,
        upper: false,
        number: false,
        special: false,
      },
      showPasswordRules: false,
    };
  },
  computed: {
    canSubmit() {
      return (
        this.signupFirstName &&
        this.signupLastName &&
        this.signupEmail &&
        this.signupPassword &&
        this.signupConfirm &&
        this.signupPassword === this.signupConfirm &&
        this.passwordValid.length &&
        this.passwordValid.upper &&
        this.passwordValid.number &&
        this.passwordValid.special &&
        this.agreedToTerms &&
        !this.isLoading
      );
    },
  },
  methods: {
    validatePassword() {
      const pwd = this.signupPassword;
      this.passwordValid.length = pwd.length >= 8;
      this.passwordValid.upper = /[A-Z]/.test(pwd);
      this.passwordValid.number = /[0-9]/.test(pwd);
      this.passwordValid.special = /[!@#$%^&*(),.?":{}|<>]/.test(pwd);
    },
    async handleSignUp() {
      if (!this.canSubmit) return;

      this.isLoading = true;
      this.errorMessage = '';

      try {
        const response = await api.post('/signup', {
          name: this.signupFirstName + ' ' + this.signupLastName,
          email: this.signupEmail,
          password: this.signupPassword
        });

        const data = response.data;

        if (data.success) {
          // Store token and user data
          if (data.token) {
            localStorage.setItem('token', data.token);
          }
          if (data.user) {
            localStorage.setItem('user', JSON.stringify(data.user));
          }

          // Clear form
          this.signupFirstName = '';
          this.signupLastName = '';
          this.signupEmail = '';
          this.signupPassword = '';
          this.signupConfirm = '';
          this.agreedToTerms = false;

          // Redirect to home page
          this.$router.push('/home');
        } else {
          this.errorMessage = data.message || 'Registration failed. Please try again.';
        }
      } catch (error) {
        console.error('Signup error:', error);
        this.errorMessage = error.response?.data?.message || 'An error occurred during registration. Please try again.';
      } finally {
        this.isLoading = false;
      }
    },
    async handleGoogleSignup() {
      try {
        this.isLoading = true;
        this.errorMessage = '';

        // Load the Google API client
        await this.loadGoogleScript();

        // Initialize Google Sign-In
        const auth2 = await this.initGoogleAuth();

        // Sign in with Google
        const googleUser = await auth2.signIn();
        const profile = googleUser.getBasicProfile();

        // Send user data to backend
        const response = await api.post('/signup/google', {
          name: profile.getName(),
          email: profile.getEmail(),
          googleId: profile.getId(),
          picture: profile.getImageUrl()
        });

        if (response.data.success) {
          // Store token and user data
          localStorage.setItem('token', response.data.token);
          localStorage.setItem('user', JSON.stringify(response.data.user));

          // Redirect to home page
          this.$router.push('/home');
        }
      } catch (error) {
        console.error('Google signup error:', error);
        this.errorMessage = 'Failed to sign up with Google. Please try again.';
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
        script.onload = resolve;
        script.onerror = reject;
        document.body.appendChild(script);
      });
    },
    initGoogleAuth() {
      return new Promise((resolve, reject) => {
        window.gapi.load('auth2', () => {
          window.gapi.auth2.init({
            client_id: '982229749981-kdq2sfh74593t69foglo2r6cbbooorsj.apps.googleusercontent.com',
            scope: 'profile email'
          }).then(resolve, reject);
        });
      });
    },
    async handleFacebookSignup() {
      try {
        // Implement Facebook signup logic here
        console.log('Facebook signup clicked');
        // You'll need to implement the actual Facebook OAuth flow
      } catch (error) {
        this.errorMessage = 'Failed to sign up with Facebook';
      }
    }
  }
};
</script>

<style scoped>
.signup-bg {
  height: 100vh;
  background: #f4f6fa;
  display: flex;
  align-items: center;
  justify-content: center;
  overflow: hidden;
}

.signup-main {
  height: 100vh;
  width: 100vw;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 0;
}

.signup-card {
  display: flex;
  background: #fff;
  border-radius: 22px;
  box-shadow: 0 8px 40px rgba(0,0,0,0.10);
  overflow: hidden;
  max-width: 800px;
  width: 100%;
  min-height: 0;
}

.signup-form-col {
  flex: 1 1 340px;
  max-width: 483px;
  padding: 28px 18px 18px 18px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  background: #fff;
}

.signup-logo-row {
  display: flex;
  align-items: center;
  gap: 0.4rem;
  margin-bottom: 0.7rem;
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

.signup-logo-img {
  width: 28px;
  height: 28px;
}

.signup-logo-text {
  font-size: 1.1rem;
  font-weight: 800;
  color: #f7871f;
  letter-spacing: 1px;
}

.signup-title {
  font-size: 1.3rem;
  font-weight: 700;
  margin-bottom: 0.1rem;
  color: #222;
  letter-spacing: 1px;
}

.signup-sub {
  color: #888;
  font-size: 0.93rem;
  margin-bottom: 1.1rem;
}

.signup-main-form {
  width: 100%;
  display: flex;
  flex-direction: column;
  gap: 0.6rem;
}

.name-fields {
  display: flex;
  gap: 0.6rem;
  margin-bottom: 0.4rem;
}

.signup-input-group {
  width: 100%;
  display: flex;
  align-items: center;
  background: #f7f8fa;
  border-radius: 12px;
  border: 1.5px solid #e0e0e0;
  margin-bottom: 0.1rem;
  position: relative;
}

.signup-input-icon {
  margin-left: 1rem;
  color: #f7871f;
  display: flex;
  align-items: center;
}

.signup-input-group input {
  flex: 1;
  border: none;
  background: transparent;
  padding: 0.7rem 0.8rem 0.7rem 0.5rem;
  font-size: 0.97rem;
  outline: none;
  color: #222;
}

.password-field {
  position: relative;
}

.signup-eye {
  margin-right: 1rem;
  cursor: pointer;
  display: flex;
  align-items: center;
}

.password-rules {
  position: absolute;
  top: 110%;
  left: 0;
  right: 0;
  background: #fff;
  padding: 0.8rem 1rem;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.1);
  margin-top: 0.2rem;
  opacity: 1;
  visibility: visible;
  z-index: 10;
  font-size: 0.92rem;
  pointer-events: none;
}

.password-rules div {
  margin-bottom: 0.3rem;
  color: #888;
  font-size: 0.92rem;
  transition: color 0.3s ease;
}

.password-rules .valid {
  color: #e99a08;
  font-weight: 600;
}

.input-mismatch {
  border: 1.5px solid #ff5252 !important;
  background: #fff6f6 !important;
}

.mismatch-msg {
  color: #ff5252;
  font-size: 0.95rem;
  margin-top: 4px;
  margin-left: 0;
  display: block;
}

.signup-options-row {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 0.5rem;
  margin-top: 0.1rem;
}

.signup-remember {
  display: flex;
  align-items: center;
  font-size: 1rem;
  color: #555;
  cursor: pointer;
  position: relative;
}

.signup-remember input[type="checkbox"] {
  accent-color: #f7871f;
  margin-right: 0.5rem;
}

.signup-btn {
  width: 100%;
  padding: 0.8rem 0;
  background: #dedede;
  color: #222;
  border: none;
  border-radius: 10px;
  font-size: 1.08rem;
  font-weight: 700;
  margin-top: 0.3rem;
  cursor: pointer;
  transition: background 0.2s;
  position: relative;
  box-shadow: none;
  letter-spacing: 0.5px;
}

.signup-btn:disabled {
  background: #e0e0e0;
  color: #aaa;
  cursor: not-allowed;
}

.signup-btn .spinner {
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

@keyframes spin {
  to { transform: translateY(-50%) rotate(360deg); }
}

.signup-bottom-row {
  margin-top: 0.7rem;
  text-align: center;
  color: #888;
  font-size: 0.85rem;
}

.signup-bottom-row .signup-link {
  margin-left: 0.3rem;
  font-weight: 700;
  color: #f7871f;
  text-decoration: none;
}

.signup-bottom-row .signup-link:hover {
  color: #ff9800;
  text-decoration: underline;
}

.signup-illustration-col {
  flex: 1 1 320px;
  background: #fc9d04;
  display: flex;
  align-items: center;
  justify-content: center;
  position: relative;
}

.signup-illustration-bg {
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  position: relative;
  padding: 2.5rem;
}

.signup-illustration-img {
  width: 140px;
  height: 140px;
  object-fit: contain;
  margin-bottom: 2.2rem;
}

.signup-illustration-text {
  color: #fff;
  text-align: center;
  max-width: 340px;
}

.signup-illustration-text h2 {
  font-size: 1.7rem;
  font-weight: 800;
  margin-bottom: 1rem;
}

.signup-illustration-text p {
  font-size: 1.08rem;
  color: #fff;
  opacity: 0.9;
}

.signup-illustration-text p {
  font-size: 1.08rem;
  color: #fff;
  opacity: 0.9;
}

.social-login {
  margin-top: 0.8rem;
}

.divider {
  margin: 0.5rem 0;
  display: flex;
  align-items: center;
  text-align: center;
}

.divider::before,
.divider::after {
  content: '';
  flex: 1;
  border-bottom: 1px solid #e0e0e0;
}

.divider span {
  padding: 0 1rem;
  color: #888;
  font-size: 1rem;
}

.social-buttons {
  display: flex;
  gap: 0.6rem;
  justify-content: center;
  margin-top: 0.5rem;
}

.social-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.6rem 1.2rem;
  border: 1.5px solid #dedede;
  border-radius: 10px;
  background: #fff;
  color: #222;
  font-size: 0.95rem;
  font-weight: 600;
  cursor: pointer;
  transition: box-shadow 0.2s, border 0.2s;
  box-shadow: none;
  min-width: 110px;
}

.social-btn img {
  width: 18px;
  height: 18px;
}

.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0,0,0,0.4);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal {
  background: #fff;
  border-radius: 12px;
  max-width: 420px;
  width: 90vw;
  padding: 2rem 1.5rem 1.5rem 1.5rem;
  box-shadow: 0 8px 32px rgba(0,0,0,0.18);
  position: relative;
}

.close-btn {
  position: absolute;
  top: 12px;
  right: 16px;
  background: none;
  border: none;
  font-size: 2rem;
  color: #e99a08;
  cursor: pointer;
}

.modal-content {
  margin-top: 1rem;
  color: #333;
  font-size: 1rem;
}

@media (max-width: 900px) {
  .signup-card {
    flex-direction: column;
    min-height: 0;
    max-width: 98vw;
  }
  .signup-illustration-col {
    display: none;
  }
  .signup-form-col {
    max-width: 100vw;
    padding: 12px 2px 8px 2px;
  }
}

.social-btn.google {
  background-color: #fff;
  color: #757575;
  border: 1px solid #ddd;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 10px;
  transition: all 0.3s ease;
}

.social-btn.google:hover {
  background-color: #f1f1f1;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.social-btn.google img {
  width: 18px;
  height: 18px;
}

.social-btn.google:disabled {
  opacity: 0.7;
  cursor: not-allowed;
}
</style>