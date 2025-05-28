<template>
  <div class="main-container">
    <!-- Navigation Bar -->
    <nav class="nav-bar">
      <div class="menu-container">
        <div class="logo"><img src="/Designer.png" alt="Logo" class="logo-img" /><router-link to="/">PAWFECT</router-link></div>

        <!-- Desktop Navigation -->
        <ul class="nav-links">
          <li><router-link to="/home"><i class="fas fa-home icon-fix"></i><span class="nav-text">Home</span></router-link></li>
          <li><router-link to="/pet-profiles"><i class="fas fa-paw icon-fix"></i><span class="nav-text">Pet Profiles</span></router-link></li>

          <!-- Resources Dropdown -->
          <li class="dropdown"
            @mouseenter="handleResourcesMouseEnter"
            @mouseleave="handleResourcesMouseLeave">
            <a href="#" @click.prevent="handleResourcesClick" aria-haspopup="true" :aria-expanded="showResourcesDropdown">
              <i class="fas fa-book icon-fix"></i><span class="nav-text">Resources</span><i class="fas fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="dropdown-menu" v-show="showResourcesDropdown" :aria-expanded="showResourcesDropdown">
              <li><router-link to="/training"><i class="fas fa-paw"></i>Training Tips</router-link></li>
              <li><router-link to="/stories"><i class="fas fa-dog"></i>Success Stories</router-link></li>
            </ul>
          </li>

          <li><router-link to="/donations"><i class="fas fa-heart icon-fix"></i><span class="nav-text">Donation</span></router-link></li>

          <!-- User Profile Dropdown -->
          <li class="dropdown user-dropdown"
            @mouseenter="handleAccountMouseEnter"
            @mouseleave="handleAccountMouseLeave">
            <a href="#" @click.prevent="handleAccountClick" aria-haspopup="true" :aria-expanded="showUserDropdown">
              <i class="fas fa-user-circle icon-fix"></i><span class="nav-text">Account</span><i class="fas fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="dropdown-menu user-dropdown-menu" v-show="showUserDropdown" :aria-expanded="showUserDropdown">
              <li><router-link to="/status" class="dropdown-item profile-item"><i class="fas fa-user"></i>Profile</router-link></li>
              <li><a href="#" @click.prevent="handleLogout" class="dropdown-item logout-item"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
          </li>
        </ul>

        <!-- Mobile Menu Button -->
        <label class="mobile-menu-button" for="check" @click="closeAllDropdowns">
          <div class="hamburger-icon">
            <span class="bar"></span>
            <span class="bar"></span>
            <span class="bar"></span>
          </div>
        </label>
      </div>
    </nav>

    <!-- Mobile Sidebar -->
    <input type="checkbox" id="check" v-model="sidebarOpen" class="hidden-checkbox">

    <div class="side_bar">
      <div class="sidebar-header">
        <div class="logo">PAWFECT</div>
        <label class="close-sidebar" for="check" @click="closeAllDropdowns">
          <i class="fas fa-times"></i>
        </label>
      </div>

      <div class="sidebar-content">
        <ul class="sidebar-links">
          <li><router-link to="/" @click="closeAllDropdowns"><i class="fas fa-home icon-fix"></i><span>Home</span></router-link></li>
          <li><router-link to="/pet-profiles" @click="closeAllDropdowns"><i class="fas fa-paw icon-fix"></i><span>Pet Profiles</span></router-link></li>

          <!-- Mobile Resources Dropdown -->
          <li class="mobile-dropdown">
            <a href="#" @click.prevent="toggleMobileResourcesDropdown">
              <i class="fas fa-book icon-fix"></i><span>Resources</span>
              <i class="fas fa-chevron-down dropdown-arrow" :class="{ 'rotate-arrow': showMobileResourcesDropdown }"></i>
            </a>
            <ul class="mobile-dropdown-menu" v-show="showMobileResourcesDropdown">
              <li><router-link to="/training"><i class="fas fa-paw"></i>Training Tips</router-link></li>
              <li><router-link to="/stories"><i class="fas fa-dog"></i>Success Stories</router-link></li>
            </ul>
          </li>

          <li><router-link to="/donations" @click="closeAllDropdowns"><i class="fas fa-heart icon-fix"></i><span>Donation</span></router-link></li>

          <!-- Mobile User Dropdown -->
          <li class="mobile-dropdown">
            <a href="#" @click.prevent="toggleMobileUserDropdown">
              <i class="fas fa-user-circle icon-fix"></i><span>Account</span>
              <i class="fas fa-chevron-down dropdown-arrow" :class="{ 'rotate-arrow': showMobileUserDropdown }"></i>
            </a>
            <ul class="mobile-dropdown-menu" v-show="showMobileUserDropdown">
              <li><router-link to="/status" class="dropdown-item profile-item"><i class="fas fa-user"></i>Profile</router-link></li>
              <li><a href="#" @click.prevent="handleLogout" class="dropdown-item logout-item"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
            </ul>
          </li>
        </ul>

        <div class="sidebar-footer">
          <div class="media_icons">
            <a href="#"><i class="fab fa-facebook-f"></i></a>
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-google"></i></a>
          </div>
        </div>
      </div>
    </div>

    <!-- Hero Section -->
    <section class="hero">
      <div class="hero-content">
        <h1>Find Your Perfect Furry Friend</h1>
        <p>Adopt, don't shop. Give a loving home to pets in need.</p>
        <router-link to="/pet-profiles" class="btn">Browse Pets</router-link>
      </div>
    </section>

    <!-- Featured Pets -->
    <section class="featured-pets">
      <div class="container">
        <h2 class="section-title">Featured Pets</h2>
        <div class="pets-grid">
          <div class="pet-card" v-for="pet in pets" :key="pet.id">
            <img :src="pet.image" :alt="pet.name">
            <div class="pet-info">
              <h3>{{ pet.name }}</h3>
              <p><strong>Breed:</strong> {{ pet.breed }}</p>
              <p><strong>Age:</strong> {{ pet.age }}</p>
              <p><strong>Gender:</strong> {{ pet.gender }}</p>
              <router-link to="/pet-profile" class="btn">Meet {{ pet.name }}</router-link>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Adoption Process -->
    <section class="adoption-process">
      <div class="container">
        <h2 class="section-title">Our Adoption Process</h2>
        <div class="process-steps">
          <div class="step" v-for="(step, index) in steps" :key="index">
            <div class="step-number">{{ index + 1 }}</div>
            <h3>{{ step.title }}</h3>
            <p>{{ step.description }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Location Map Section -->
    <section class="location-section">
      <div class="container">
        <h2 class="section-title">Find Us</h2>
        <div class="map-container">
          <div class="map-info">
            <h3>Angeles Pet Care</h3>
            <p>Visit our shelter to meet our lovely pets in person!</p>
            <div class="location-details">
              <p><strong>Address:</strong> Angeles City, Pampanga, Philippines</p>
              <p><strong>Hours:</strong> Monday - Sunday, 9:00 AM - 6:00 PM</p>
              <p><strong>Contact:</strong> (123) 456-7890</p>
            </div>
          </div>
          <div class="map-wrapper">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3856.9007861381824!2d120.27661631367312!3d14.830825354692275!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3396711bd51280cb%3A0x9807796767f2153d!2sAngeles%20Pet%20Care!5e0!3m2!1sen!2sph!4v1747207650130!5m2!1sen!2sph"
              width="100%"
              height="450"
              style="border:0;"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade">
            </iframe>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer Section -->
    <footer class="footer">
      <div class="footer-container">
        <div class="footer-column logo-column">
          <img src="/Designer.png" alt="Pawfect" width="40" height="40">
          <span class="Footer-logo-text">PAWFECT</span>
          <p class="footer-description">Helping paws find their forever home.</p>
        </div>
        <div class="footer-column">
          <h4>Quick Links</h4>
          <ul>
            <li><router-link to="/home">Home</router-link></li>
            <li><router-link to="/pet-profiles">Pet Profiles</router-link></li>
            <li><router-link to="/training">Resources</router-link></li>
            <li><router-link to="/donations">Donate</router-link></li>
          </ul>
        </div>
        <div class="footer-column">
          <h4>Contact</h4>
          <p>Email: pawfectmatch5@gmail.com</p>
          <p>Phone: +123 456 7890</p>
          <p>Location: Gordon College, Olongapo</p>
        </div>
      </div>
      <div class="footer-bottom">
        <p>&copy; 2025 PawfectMatch, Inc. All rights reserved.</p>
      </div>
    </footer>
  </div>
</template>

<script>
export default {
  name: 'App',
  data() {
    return {
      sidebarOpen: false,
      showResourcesDropdown: false,
      showUserDropdown: false,
      showMobileResourcesDropdown: false,
      showMobileUserDropdown: false,
      isTablet: false,
      isTouch: false,
      pets: [
        {
          id: 1,
          name: 'Babi',
          breed: 'Chiwawa',
          age: '2 years',
          gender: 'Male',
          image: '/Img/dog4.jpg'
        },
        {
          id: 2,
          name: 'Luna',
          breed: 'Siamese Cat',
          age: '1.5 years',
          gender: 'Female',
          image: '/Img/cat3.jpg'
        },
        {
          id: 3,
          name: 'Rocky',
          breed: 'Beagle',
          age: '3 years',
          gender: 'Male',
          image: '/Img/dog5.jpg'
        },
        {
          id: 4,
          name: 'Tilapya',
          breed: 'Persian Cat',
          age: '4 months',
          gender: 'Female',
          image: '/Img/cat4.jpg'
        }
      ],
      steps: [
        {
          title: 'Browse Available Pets',
          description: 'View our gallery of pets looking for their forever homes.'
        },
        {
          title: 'Submit Application',
          description: 'Fill out our adoption application form online.'
        },
        {
          title: 'Meet & Greet',
          description: 'Schedule a visit to meet your potential new pet.'
        },
        {
          title: 'Home Check',
          description: 'We ensure your home is a safe environment for the pet.'
        },
        {
          title: 'Finalize Adoption',
          description: 'Complete paperwork and welcome your new family member!'
        }
      ]
    }
  },
  mounted() {
    window.addEventListener('resize', this.handleResizeSidebar);
    this.checkTablet();
    this.checkTouch();
    window.addEventListener('resize', this.checkTablet);
    window.addEventListener('resize', this.checkTouch);
    document.addEventListener('click', this.handleDocumentClick);
    document.addEventListener('keydown', this.handleKeydown);
    this.loadExternalScripts();
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.handleResizeSidebar);
    window.removeEventListener('resize', this.checkTablet);
    window.removeEventListener('resize', this.checkTouch);
    document.removeEventListener('click', this.handleDocumentClick);
    document.removeEventListener('keydown', this.handleKeydown);
  },
  methods: {
    loadExternalScripts() {
      const script1 = document.createElement('script');
      script1.src = 'https://cdn.botpress.cloud/webchat/v2.4/inject.js';
      document.head.appendChild(script1);

      const script2 = document.createElement('script');
      script2.src = 'https://files.bpcontent.cloud/2025/05/07/09/20250507090119-E9YC9Q2J.js';
      document.head.appendChild(script2);
    },
    closeAllDropdowns() {
      this.showResourcesDropdown = false;
      this.showUserDropdown = false;
      this.showMobileResourcesDropdown = false;
      this.showMobileUserDropdown = false;
    },
    toggleMobileResourcesDropdown() {
      this.showMobileResourcesDropdown = !this.showMobileResourcesDropdown;
    },
    toggleMobileUserDropdown() {
      this.showMobileUserDropdown = !this.showMobileUserDropdown;
    },
    handleResizeSidebar() {
      if (window.innerWidth > 768 && this.sidebarOpen) {
        this.sidebarOpen = false;
      }
      this.closeAllDropdowns();
    },
    checkTablet() {
      this.isTablet = window.innerWidth >= 769 && window.innerWidth <= 1024;
    },
    checkTouch() {
      this.isTouch = 'ontouchstart' in window || navigator.maxTouchPoints > 0;
    },
    handleResourcesClick(event) {
      if (this.isTablet || this.isTouch) {
        event.preventDefault();
        this.showResourcesDropdown = !this.showResourcesDropdown;
        if (this.showResourcesDropdown) this.showUserDropdown = false;
      }
    },
    handleAccountClick(event) {
      if (this.isTablet || this.isTouch) {
        event.preventDefault();
        this.showUserDropdown = !this.showUserDropdown;
        if (this.showUserDropdown) this.showResourcesDropdown = false;
      }
    },
    handleResourcesMouseEnter() {
      if (!this.isTablet && !this.isTouch) this.showResourcesDropdown = true;
    },
    handleResourcesMouseLeave() {
      if (!this.isTablet && !this.isTouch) this.showResourcesDropdown = false;
    },
    handleAccountMouseEnter() {
      if (!this.isTablet && !this.isTouch) this.showUserDropdown = true;
    },
    handleAccountMouseLeave() {
      if (!this.isTablet && !this.isTouch) this.showUserDropdown = false;
    },
    handleDocumentClick(e) {
      const navBar = this.$el.querySelector('.nav-bar');
      const sideBar = this.$el.querySelector('.side_bar');
      if (
        (navBar && navBar.contains(e.target)) ||
        (sideBar && sideBar.contains(e.target))
      ) {
        return;
      }
      this.closeAllDropdowns();
    },
    handleKeydown(e) {
      if (e.key === 'Escape') {
        this.closeAllDropdowns();
      }
    },
    handleLogout() {
      // Implement logout functionality
    }
  }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
@import url('https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css');

:root {
  --primary-color: #ff914d;
  --bg-color: #f0f0f0;
  --shadow-light: #ffffff;
  --shadow-dark: #d3d3d3;
  --text-color: #555;
  --sidebar-width: 300px;
  --nav-height: 70px;
  --transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: 'Poppins', sans-serif;
}

body {
  background: var(--bg-color);
}

/* Hidden checkbox */
.hidden-checkbox {
  position: absolute;
  opacity: 0;
  height: 0;
  width: 0;
}

/* Navigation Bar */
.nav-bar {
  width: 100%;
  height: var(--nav-height);
  background: var(--bg-color);
  position: fixed;
  top: 0;
  left: 0;
  z-index: 1000;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.menu-container {
  max-width: 1400px;
  height: 100%;
  margin: 0 auto;
  padding: 0 5px;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo {
  display: flex;
  align-items: center;
}

.logo a {
  font-size: 1.8rem;
  font-weight: 800;
  text-decoration: none;
  color: var(--primary-color);
  letter-spacing: 1px;
  transition: var(--transition);
  text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
}

.logo a:hover {
  transform: scale(1.05);
}

/* Desktop Navigation */
.nav-links {
  list-style: none;
  display: flex;
  gap: 10px;
}

.nav-links li {
  display: flex;
  align-items: center;
}

.nav-links a {
  text-decoration: none;
  font-size: 1rem;
  color: var(--text-color);
  font-weight: 600;
  display: flex;
  align-items: center;
  padding: 10px 10px;
  border-radius: 15px;
  transition: var(--transition);
  background: var(--bg-color);
  box-shadow:
    8px 8px 16px var(--shadow-dark),
    -8px -8px 16px var(--shadow-light);
  white-space: nowrap;
}

.nav-links a:hover {
  color: var(--primary-color);
  transform: translateY(-2px);
  box-shadow:
    4px 4px 8px var(--shadow-dark),
    -4px -4px 8px var(--shadow-light);
}

.nav-links a:active {
  transform: translateY(0);
  box-shadow:
    inset 3px 3px 6px var(--shadow-dark),
    inset -3px -3px 6px var(--shadow-light);
}

.nav-text {
  margin-left: 8px;
}

.icon-fix {
  width: 20px;
  text-align: center;
  color: var(--primary-color);
  transition: var(--transition);
}

.nav-links a:hover .icon-fix {
  transform: scale(1.2);
}

/* Mobile Menu Button */
.mobile-menu-button {
  display: none;
  cursor: pointer;
  padding: 10px;
  border-radius: 8px;
  transition: var(--transition);
  background: var(--bg-color);
  box-shadow:
    5px 5px 10px var(--shadow-dark),
    -5px -5px 10px var(--shadow-light);
  width: 40px;
  height: 40px;
  justify-content: center;
  align-items: center;
}

.hamburger-icon {
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  width: 20px;
  height: 14px;
}

.hamburger-icon .bar {
  height: 2px;
  width: 100%;
  background-color: var(--text-color);
  transition: var(--transition);
  border-radius: 2px;
}

.mobile-menu-button:hover {
  transform: scale(1.05);
}

.mobile-menu-button:hover .bar {
  background-color: var(--primary-color);
}

/* Transform hamburger to X when sidebar is open */
.hidden-checkbox:checked ~ .nav-bar .mobile-menu-button .hamburger-icon .bar:nth-child(1) {
  transform: translateY(6px) rotate(45deg);
}

.hidden-checkbox:checked ~ .nav-bar .mobile-menu-button .hamburger-icon .bar:nth-child(2) {
  opacity: 0;
}

.hidden-checkbox:checked ~ .nav-bar .mobile-menu-button .hamburger-icon .bar:nth-child(3) {
  transform: translateY(-6px) rotate(-45deg);
}

/* Sidebar Styles */
.side_bar {
  background: var(--bg-color);
  position: fixed;
  top: 0;
  left: -100%;
  height: 100%;
  width: var(--sidebar-width);
  z-index: 1001;
  transition: var(--transition);
  box-shadow: 10px 0 20px rgba(0, 0, 0, 0.1);
  display: flex;
  flex-direction: column;
  overflow-y: auto;
}

.hidden-checkbox:checked ~ .side_bar {
  left: 0;
}

.sidebar-header {
  height: var(--nav-height);
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 20px;
  border-bottom: 1px solid rgba(0,0,0,0.1);
}

.sidebar-content {
  flex: 1;
  display: flex;
  flex-direction: column;
  padding: 20px;
  overflow-y: auto;
}

.sidebar-links {
  list-style: none;
  margin-bottom: 20px;
}

.sidebar-links li {
  margin-bottom: 15px;
}

.sidebar-links a {
  position: relative;
  color: var(--text-color);
  text-decoration: none;
  font-size: 1rem;
  font-weight: 500;
  display: flex;
  align-items: center;
  width: 100%;
  border-radius: 12px;
  padding: 15px 20px;
  transition: var(--transition);
  background: var(--bg-color);
  box-shadow:
    5px 5px 10px var(--shadow-dark),
    -5px -5px 10px var(--shadow-light);
}

.sidebar-links a:hover {
  color: var(--primary-color);
  padding-left: 25px;
  transform: translateX(5px);
  box-shadow:
    3px 3px 6px var(--shadow-dark),
    -3px -3px 6px var(--shadow-light);
}

.sidebar-links a:active {
  transform: translateX(5px) scale(0.98);
  box-shadow:
    inset 2px 2px 5px var(--shadow-dark),
    inset -2px -2px 5px var(--shadow-light);
}

.sidebar-footer {
  padding: 20px 0;
  margin-top: auto;
}

.media_icons {
  display: flex;
  justify-content: center;
  gap: 15px;
}

.media_icons a {
  height: 45px;
  width: 45px;
  border-radius: 50%;
  text-align: center;
  line-height: 45px;
  color: var(--text-color);
  font-size: 1.1rem;
  background: var(--bg-color);
  transition: var(--transition);
  box-shadow:
    5px 5px 10px var(--shadow-dark),
    -5px -5px 10px var(--shadow-light);
}

.media_icons a:hover {
  color: var(--primary-color);
  transform: translateY(-3px) scale(1.1);
}

.close-sidebar {
  height: 40px;
  width: 40px;
  text-align: center;
  line-height: 40px;
  cursor: pointer;
  transition: var(--transition);
  color: var(--text-color);
  background: var(--bg-color);
  border-radius: 50%;
  box-shadow:
    3px 3px 6px var(--shadow-dark),
    -3px -3px 6px var(--shadow-light);
}

.close-sidebar:hover {
  color: var(--primary-color);
  transform: rotate(90deg);
}

/* Dropdown Styles */
.dropdown {
  position: relative;
}

.dropdown-menu {
  position: absolute;
  top: 100%;
  left: 0;
  min-width: 200px;
  background: var(--bg-color);
  border-radius: 4px;
  padding: 10px 0;
  box-shadow:
    0 8px 24px rgba(0,0,0,0.10),
    8px 8px 16px var(--shadow-dark),
    -8px -8px 16px var(--shadow-light);
  z-index: 1000;
  animation: fadeIn 0.3s ease;
  transition: opacity 0.2s, transform 0.2s;
  right: auto;
}

.dropdown-menu[aria-expanded="true"] {
  opacity: 1;
  pointer-events: auto;
  transform: translateY(0);
}

.dropdown-menu[aria-expanded="false"] {
  opacity: 0;
  pointer-events: none;
  transform: translateY(-10px);
}

.dropdown-menu li {
  margin: 0;
}

.dropdown-item {
  padding: 12px 20px;
  display: flex;
  align-items: center;
  color: var(--text-color);
  white-space: nowrap;
  width: 100%;
  transition: all 0.3s ease;
}

.dropdown-item i {
  margin-right: 10px;
  width: 20px;
  text-align: center;
}

/* Profile Item - Subtle Highlight */
.profile-item:hover {
  background: rgba(255,145,77,0.1);
  color: var(--primary-color);
}

/* Logout Item - Standout Highlight */
.logout-item:hover {
  background: rgba(255, 80, 80, 0.1);
  color: #ff5050;
  font-weight: 600;
}

.dropdown-arrow {
  margin-left: 8px;
  font-size: 0.8rem;
  transition: transform 0.3s ease;
}

.dropdown:hover .dropdown-arrow {
  transform: rotate(180deg);
}

/* User Dropdown Specific */
.user-dropdown-menu {
  right: 0;
  left: auto;
  min-width: 180px;
}

/* Mobile Dropdown Styles */
.mobile-dropdown-menu {
  padding-left: 20px;
  margin-top: 5px;
  animation: fadeIn 0.3s ease;
}

.mobile-dropdown-menu li {
  margin-bottom: 5px;
}

.mobile-dropdown-menu .dropdown-item {
  padding: 10px 15px;
}

.mobile-dropdown-menu .profile-item:hover {
  background: rgba(255,145,77,0.1);
  color: var(--primary-color);
  padding-left: 25px;
}

.mobile-dropdown-menu .logout-item:hover {
  background: rgba(255, 80, 80, 0.1);
  color: #ff5050;
  font-weight: 600;
  padding-left: 25px;
}

.rotate-arrow {
  transform: rotate(180deg);
}

/* Animations */
@keyframes fadeIn {
  from { opacity: 0; transform: translateY(10px); }
  to { opacity: 1; transform: translateY(0); }
}

/* Responsive Styles */
@media (max-width: 1024px) {
  .nav-links a {
    padding: 10px 15px;
    font-size: 0.9rem;
  }
}

@media (max-width: 900px) {
  .nav-links a .nav-text {
    display: none;
  }

  .nav-links a {
    padding: 12px;
    border-radius: 50%;
  }

  .icon-fix {
    margin-right: 0;
    font-size: 1.1rem;
  }
}

@media (max-width: 768px) {
  .nav-links {
    display: none !important;
  }
  .mobile-menu-button {
    display: flex !important;
    position: absolute;
    top: 16px;
    right: 16px;
    z-index: 1100;
  }
  .side_bar {
    width: var(--sidebar-width);
    max-width: 100vw;
    min-width: 260px;
    left: -100%;
    box-shadow: 8px 0 24px rgba(0,0,0,0.08);
    border-top-right-radius: 16px;
    border-bottom-right-radius: 16px;
    background: var(--bg-color);
    padding-top: 0;
  }
  .hidden-checkbox:checked ~ .side_bar {
    left: 0;
  }
  .sidebar-header {
    padding: 0 20px;
    height: 70px;
    border-bottom: none;
    box-shadow: none;
    background: var(--bg-color);
    border-top-right-radius: 16px;
  }
  .sidebar-links {
    margin-top: 20px;
  }
  .sidebar-links a {
    margin-bottom: 10px;
    box-shadow:
      4px 4px 12px var(--shadow-dark),
      -4px -4px 12px var(--shadow-light);
    background: var(--bg-color);
    border-radius: 12px;
    padding: 12px 20px;
    font-size: 1rem;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 10px;
    transition: var(--transition);
  }
  .sidebar-links a:hover {
    color: var(--primary-color);
    background: #fff7f0;
    box-shadow:
      2px 2px 6px var(--shadow-dark),
      -2px -2px 6px var(--shadow-light);
  }
  .sidebar-footer {
    margin-top: auto;
    padding-bottom: 24px;
    display: flex;
    justify-content: center;
  }
  .media_icons {
    display: flex;
    gap: 18px;
  }
  .media_icons a {
    height: 40px;
    width: 40px;
    border-radius: 50%;
    background: var(--bg-color);
    box-shadow:
      2px 2px 8px var(--shadow-dark),
      -2px -2px 8px var(--shadow-light);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-color);
    font-size: 1.1rem;
    transition: var(--transition);
  }
  .media_icons a:hover {
    color: var(--primary-color);
    background: #fff7f0;
    transform: scale(1.08);
  }
  .close-sidebar {
    position: absolute;
    top: 16px;
    right: 16px;
    z-index: 1200;
    background: var(--bg-color);
    box-shadow:
      2px 2px 8px var(--shadow-dark),
      -2px -2px 8px var(--shadow-light);
  }
}

@media (max-width: 480px) {
  .menu-container {
    padding: 0 15px;
  }

  .logo a {
    font-size: 1.5rem;
  }

  .side_bar {
    width: 100vw;
    min-width: 0;
    border-radius: 0;
  }
  .sidebar-header {
    border-radius: 0;
  }
  .sidebar-links a {
    padding: 15px 20px;
  }
}

.logo-img {
  height: 38px;
  width: 38px;
  margin-right: 10px;
}

.dropdown-menu i,
.mobile-dropdown-menu i {
  margin-right: 10px;
}

@media (max-width: 1200px) {
  .dropdown-menu {
    right: 0;
    left: auto;
    min-width: 180px;
    max-width: 90vw;
  }
}

.dropdown-menu li a,
.user-dropdown-menu li a {
  transition: background 0.2s, color 0.2s;
  outline: none;
}

.dropdown-menu li a:hover,
.user-dropdown-menu li a:hover,
.dropdown-menu li a:focus,
.user-dropdown-menu li a:focus {
  background: rgba(255,145,77,0.12);
  color: var(--primary-color);
}

.dropdown-menu li a:hover i,
.user-dropdown-menu li a:hover i,
.dropdown-menu li a:focus i,
.user-dropdown-menu li a:focus i {
  color: var(--primary-color);
}

/* Keep existing styles for the rest of the page content */
.container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 20px;
}

.btn {
  display: inline-block;
  padding: 10px 20px;
  background-color: #f7871f;
  color: white;
  border: none;
  border-radius: 5px;
  cursor: pointer;
  text-decoration: none;
  transition: background-color 0.3s;
}

.btn:hover {
  background-color: #f27508;
}

.section-title {
  text-align: center;
  margin-bottom: 40px;
  font-size: 2rem;
  color: var(--primary-color);
  position: relative;
  padding-top: 20px;
}

/* Hero Section Styles */
.hero {
  background-image: url('/Img/cat2.jpg');
  background-size: cover;
  background-position: center;
  height: 500px;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: white;
  margin-bottom: 50px;
  margin-top: 0;
}

.hero-content {
  max-width: 800px;
  padding: 0 20px;
}

.hero h1 {
  font-size: 3rem;
  margin-bottom: 20px;
}

.hero p {
  font-size: 1.2rem;
  margin-bottom: 30px;
}

/* Featured Pets Styles */
.featured-pets {
  padding: 80px 0 60px;
  background: var(--bg-color);
  margin-top: 20px;
}

.pets-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 30px;
}

.pet-card {
  background: var(--bg-color);
  border-radius: 15px;
  overflow: hidden;
  box-shadow:
    8px 8px 16px var(--shadow-dark),
    -8px -8px 16px var(--shadow-light);
  transition: var(--transition);
}

.pet-card:hover {
  transform: translateY(-10px);
  box-shadow:
    4px 4px 8px var(--shadow-dark),
    -4px -4px 8px var(--shadow-light);
}

.pet-card img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.pet-info {
  padding: 20px;
}

.pet-info h3 {
  margin-bottom: 10px;
  color: var(--primary-color);
  font-size: 1.4rem;
}

.pet-info p {
  margin-bottom: 8px;
  font-size: 0.9rem;
  color: var(--text-color);
}

.pet-info .btn {
  margin-top: 15px;
  width: 100%;
  text-align: center;
  background: var(--primary-color);
  color: white;
  border-radius: 10px;
  padding: 12px 20px;
  font-weight: 600;
  transition: var(--transition);
  box-shadow:
    4px 4px 8px var(--shadow-dark),
    -4px -4px 8px var(--shadow-light);
}

.pet-info .btn:hover {
  background: #e67e00;
  transform: translateY(-2px);
  box-shadow:
    2px 2px 4px var(--shadow-dark),
    -2px -2px 4px var(--shadow-light);
}

/* Adoption Process Styles */
.adoption-process {
  background-color: #f0f7f4;
  padding: 80px 0;
  text-align: center;
}

.process-steps {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 30px;
  margin-top: 40px;
}

.step {
  flex: 1;
  min-width: 200px;
  max-width: 250px;
  background-color: white;
  padding: 30px 20px;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.step-number {
  width: 50px;
  height: 50px;
  background-color: #fe7b01;
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  font-weight: bold;
  margin: 0 auto 20px;
}

.step h3 {
  margin-bottom: 15px;
  color: #333;
}

.step p {
  font-size: 0.9rem;
  color: #666;
}

/* Footer Styles */
.footer {
  background-color: #f6f6f6;
  color: #333;
  padding: 40px 20px 20px;
  font-family: Arial, sans-serif;
  margin-top: 60px;
  border-top: 1px solid #ddd;
}

.footer-container {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  gap: 40px;
  max-width: 1200px;
  margin: 0 auto;
}

.footer-column {
  flex: 1 1 250px;
}

.logo-column {
  display: flex;
  flex-direction: column;
  align-items: flex-start;
}

.logo-column img {
  margin-bottom: 10px;
}

.Footer-logo-text {
  font-size: 24px;
  font-weight: bold;
  color: #2b7a78;
  margin-bottom: 8px;
}

.footer-description {
  font-size: 14px;
  color: #666;
}

.footer-column h4 {
  font-size: 16px;
  font-weight: bold;
  margin-bottom: 12px;
  color: #17252a;
}

.footer-column ul {
  list-style: none;
  padding: 0;
  margin: 0;
}

.footer-column ul li {
  margin-bottom: 8px;
}

.footer-column ul li a {
  text-decoration: none;
  color: #333;
  transition: color 0.3s;
}

.footer-column ul li a:hover {
  color: #2b7a78;
}

.footer-bottom {
  text-align: center;
  margin-top: 30px;
  font-size: 14px;
  color: #888;
  border-top: 1px solid #ddd;
  padding-top: 20px;
}

/* Responsive Footer */
@media (max-width: 1100px) {
  .footer-container {
    flex-wrap: wrap;
    gap: 2rem;
    justify-content: center;
  }

  .footer-column {
    flex: 1 1 200px;
    text-align: center;
  }

  .logo-column {
    align-items: center;
  }
}

@media (max-width: 992px) {
  .footer-container {
    padding: 1.5rem 1rem;
  }

  .footer-column {
    flex-basis: 100%;
  }
}

@media (max-width: 768px) {
  .footer-container {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .footer-column {
    margin-bottom: 1.5rem;
  }
}

/* Location Map Section Styles */
.location-section {
  padding: 80px 0;
  background-color: #fff;
}

.map-container {
  display: flex;
  gap: 40px;
  align-items: flex-start;
  margin-top: 40px;
}

.map-info {
  flex: 1;
  padding: 30px;
  background-color: #f8f9fa;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.map-info h3 {
  color: #333;
  font-size: 1.8rem;
  margin-bottom: 20px;
}

.map-info p {
  color: #666;
  margin-bottom: 15px;
  line-height: 1.6;
}

.location-details {
  margin-top: 25px;
  padding-top: 25px;
  border-top: 1px solid #eee;
}

.location-details p {
  margin-bottom: 10px;
}

.map-wrapper {
  flex: 2;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

@media (max-width: 768px) {
  .map-container {
    flex-direction: column;
  }

  .map-info {
    order: 2;
  }

  .map-wrapper {
    order: 1;
    width: 100%;
  }

  .map-wrapper iframe {
    height: 350px;
  }
}

.main-container {
  padding-top: var(--nav-height);
}
</style>