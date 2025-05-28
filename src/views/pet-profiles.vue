<template>
  <div>
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
          <li><router-link to="/home" @click="closeAllDropdowns"><i class="fas fa-home icon-fix"></i><span>Home</span></router-link></li>
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
            <a href="#" @click="toggleMobileUserDropdown">
              <i class="fas fa-user-circle icon-fix"></i><span>Account</span>
              <i class="fas fa-chevron-down dropdown-arrow" :class="{ 'rotate-arrow': showMobileUserDropdown }"></i>
            </a>
            <ul class="mobile-dropdown-menu" v-show="showMobileUserDropdown">
              <li><a href="/status" class="dropdown-item profile-item"><i class="fas fa-user"></i>Profile</a></li>
              <li><a href="#" class="dropdown-item logout-item"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
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

    <!-- Featured Pets Section -->
    <section class="featured-pets-section">
      <h2>Pawfect Pets</h2>
      <div class="featured-pets-grid">
        <div v-for="pet in featuredPets" :key="pet.id" class="featured-pet-card">
          <img :src="pet.image" :alt="pet.name" class="featured-pet-img" />
          <div class="featured-pet-info">
            <h3 class="featured-pet-name">{{ pet.name }}</h3>
            <p class="featured-pet-breed">{{ pet.breed }} &bull; {{ pet.age }}</p>
            <p class="featured-pet-desc">{{ pet.background }}</p>
            <button class="featured-pet-btn" @click="viewPetProfile(pet.id)">View Profile</button>
          </div>
        </div>
      </div>
    </section>
    <div class="pet-profiles-container">
      <h1>Pet Profiles</h1>
      <div class="pet-grid">
        <div v-for="pet in pets" :key="pet.id" class="pet-card" @click="viewPetProfile(pet.id)">
          <img :src="pet.photo || '/Img/default-pet.png'" :alt="pet.name" class="pet-img" />
          <div class="pet-info">
            <h2>{{ pet.name }}</h2>
            <p class="pet-breed">{{ pet.breed }} &bull; {{ pet.age }}</p>
            <p class="pet-desc">{{ pet.description || 'A wonderful companion waiting for a forever home.' }}</p>
            <div class="pet-status" :class="pet.status.toLowerCase()">
              {{ pet.status }}
            </div>
          </div>
        </div>
      </div>
    </div>
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
  name: 'PetProfiles',
  data() {
    return {
      sidebarOpen: false,
      showResourcesDropdown: false,
      showUserDropdown: false,
      showMobileResourcesDropdown: false,
      showMobileUserDropdown: false,
      isTablet: false,
      isTouch: false,
      mobileMenuOpen: false,
      dropdownOpen: false,
      desktopDropdownOpen: false,
      userDropdownOpen: false,
      isMobile: false,
      hasScrolled: false,
      pets: [],
      loading: false,
      error: null,
      featuredPets: []
    };
  },
  async created() {
    await this.fetchPets();
  },
  mounted() {
    this.checkScreenSize();
    window.addEventListener('resize', this.checkScreenSize);
    window.addEventListener('scroll', this.handleScroll);
    document.addEventListener('click', this.closeResourceDropdownOnClickOutside);
    window.addEventListener('resize', this.handleResizeSidebar);
    this.checkTablet();
    this.checkTouch();
    window.addEventListener('resize', this.checkTablet);
    window.addEventListener('resize', this.checkTouch);
    document.addEventListener('click', this.handleDocumentClick);
    document.addEventListener('keydown', this.handleKeydown);
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.checkScreenSize);
    window.removeEventListener('scroll', this.handleScroll);
    document.removeEventListener('click', this.closeResourceDropdownOnClickOutside);
    window.removeEventListener('resize', this.handleResizeSidebar);
    window.removeEventListener('resize', this.checkTablet);
    window.removeEventListener('resize', this.checkTouch);
    document.removeEventListener('click', this.handleDocumentClick);
    document.removeEventListener('keydown', this.handleKeydown);
  },
  methods: {
    async fetchPets() {
      this.loading = true;
      try {
        const response = await fetch('http://localhost:5000/api/pets');
        if (!response.ok) {
          throw new Error('Failed to fetch pets');
        }
        const data = await response.json();

        // Filter to only show available pets
        this.pets = data.filter(pet => pet.status === 'Available');

        // Set featured pets (first 4 available pets)
        this.featuredPets = this.pets.slice(0, 4).map(pet => ({
          id: pet.id,
          name: pet.name,
          breed: pet.breed,
          age: pet.age,
          image: pet.photo || '/Img/default-pet.png',
          background: pet.description || 'A wonderful companion waiting for a forever home.'
        }));
      } catch (error) {
        console.error('Error fetching pets:', error);
        this.error = 'Failed to load pets. Please try again later.';
      } finally {
        this.loading = false;
      }
    },
    toggleMobileMenu() {
      this.mobileMenuOpen = !this.mobileMenuOpen;
      if (!this.mobileMenuOpen) {
        this.dropdownOpen = false; // Close mobile resources dropdown if menu closes
      }
      if (this.mobileMenuOpen) {
        document.body.classList.add('no-scroll');
      } else {
        document.body.classList.remove('no-scroll');
      }
    },
    toggleDesktopDropdown(event) {
      event.preventDefault();
      event.stopPropagation();
      if (this.isMobile) {
        // Toggle mobile resources dropdown
        this.dropdownOpen = !this.dropdownOpen;
        // Ensure other main dropdowns are managed if needed, but userDropdownOpen is independent now
        this.desktopDropdownOpen = false;
      } else {
        // Toggle desktop resources dropdown
        this.desktopDropdownOpen = !this.desktopDropdownOpen;
      }
      // NOTE: userDropdownOpen is NOT affected by this action anymore.
    },
    toggleUserDropdown(event) {
      event.preventDefault();
      event.stopPropagation();
      // If the user menu is not already open, open it.
      // If it is already open, clicking the icon again does nothing to its state,
      // as it can now only be closed by its 'X' button.
      if (!this.userDropdownOpen) {
        this.userDropdownOpen = true;
      }
      // When user dropdown is interacted with, ensure other (non-user) dropdowns are closed.
      this.desktopDropdownOpen = false;
      if (this.isMobile) {
        this.dropdownOpen = false; // mobile resources dropdown
      }
    },
    closeUserDropdown() {
      // This is the only method that should set userDropdownOpen to false.
      this.userDropdownOpen = false;
    },
    closeMenuIfMobile() {
      if (this.isMobile) {
        this.mobileMenuOpen = false;
        this.dropdownOpen = false; // Close mobile resources dropdown
        document.body.classList.remove('no-scroll');
      }
      // userDropdownOpen is not affected here.
      // desktopDropdownOpen is not affected here by simple link clicks.
    },
    checkScreenSize() {
      const previouslyMobile = this.isMobile;
      this.isMobile = window.innerWidth <= 768;

      if (previouslyMobile !== this.isMobile) { // Only run logic if mode actually changes
        if (!this.isMobile) {
          // Switched to Desktop
          this.mobileMenuOpen = false;
          this.dropdownOpen = false; // mobile resources dropdown
          document.body.classList.remove('no-scroll');
        } else {
          // Switched to Mobile
          this.desktopDropdownOpen = false;
        }
      }
      // userDropdownOpen is NOT affected by screen size changes.
    },
    handleScroll() {
      this.hasScrolled = window.scrollY > 20;
    },
    closeResourceDropdownOnClickOutside(event) {
      // This function now ONLY handles closing the desktop resources dropdown.
      // User dropdown is not affected by clicks outside.
      const resourcesDropdownToggle = this.$el.querySelector('.nav-link.dropdown-toggle'); // Assuming this is specific enough
      const resourcesDropdownContent = this.$el.querySelector('.dropdown-content.desktop');

      if (this.desktopDropdownOpen && resourcesDropdownToggle && !resourcesDropdownToggle.contains(event.target) && resourcesDropdownContent && !resourcesDropdownContent.contains(event.target)) {
        this.desktopDropdownOpen = false;
      }
    },
    viewPetProfile(petId) {
      this.$router.push(`/pet-profile/${petId}`);
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
  },
};
</script>

<style scoped>
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

/* Navigation Bar Styles */
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

.dropdown-item,
.dropdown-item:hover,
.dropdown-menu li a,
.dropdown-menu li a:hover,
.user-dropdown-menu li a,
.user-dropdown-menu li a:hover {
  border-radius: 0 !important;
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
  border-left: none;
  padding-left: 0;
}

/* Logout Item - Standout Highlight */
.logout-item:hover {
  background: rgba(255, 80, 80, 0.1);
  color: #ff5050;
  font-weight: 600;
  border-left: none;
  padding-left: 0;
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
  border-radius: 0;
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
  border-radius: 4px;
  border-left: none;
  padding-left: 20px;
}

.dropdown-menu li a:hover,
.user-dropdown-menu li a:hover,
.dropdown-menu li a:focus,
.user-dropdown-menu li a:focus {
  background: rgba(255,145,77,0.12);
  color: var(--primary-color);
  border-left: none;
  padding-left: 20px;
}

.dropdown-menu li a:hover i,
.user-dropdown-menu li a:hover i,
.dropdown-menu li a:focus i,
.user-dropdown-menu li a:focus i {
  color: var(--primary-color);
}

/* Pet profiles styles (as before) */
.pet-profiles-container {
  max-width: 1100px;
  margin: 2rem auto;
  padding: 2rem;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 24px rgba(0,0,0,0.08);
}
.pet-profiles-container h1 {
  text-align: center;
  color: #f7871f;
  margin-bottom: 2rem;
}
.pet-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 2rem;
}
.pet-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  transition: transform 0.3s ease;
  cursor: pointer;
  position: relative;
}
.pet-card:hover {
  transform: translateY(-5px);
}
.pet-img {
  width: 100%;
  height: 200px;
  object-fit: cover;
}
.pet-info {
  padding: 1rem;
}
.pet-info h2 {
  margin: 0 0 0.5rem 0;
  color: #333;
  font-size: 1.25rem;
}
.pet-breed {
  color: #666;
  margin: 0 0 0.5rem 0;
  font-size: 0.9rem;
}
.pet-desc {
  color: #444;
  margin: 0 0 1rem 0;
  font-size: 0.9rem;
  line-height: 1.4;
}
.pet-status {
  display: inline-block;
  padding: 0.25rem 0.75rem;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: 500;
  text-transform: uppercase;
}
.pet-status.available {
  background-color: #e3fcef;
  color: #00a854;
}
.pet-status.on-hold {
  background-color: #fff7e6;
  color: #fa8c16;
}
.pet-status.adopted {
  background-color: #f5f5f5;
  color: #8c8c8c;
}
.loading {
  text-align: center;
  padding: 2rem;
  color: #f7871f;
  font-size: 1.2rem;
}
.error {
  text-align: center;
  padding: 2rem;
  color: #ff5252;
  font-size: 1.2rem;
}
.featured-pets-section {
  max-width: 1200px;
  margin: 2rem auto 2rem auto;
  padding: 2rem 1rem;
  background: #fff8e6;
  border-radius: 18px;
  box-shadow: 0 4px 24px rgba(249, 168, 38, 0.08);
  margin-top: calc(var(--nav-height) + 2rem);
}
.featured-pets-section h2 {
  text-align: center;
  color: #f7871f;
  font-size: 2rem;
  margin-bottom: 2rem;
  font-weight: 700;
}
.featured-pets-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 2rem;
}
.featured-pet-card {
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 2px 8px rgba(249, 168, 38, 0.08);
  padding: 1.5rem 1rem 1rem 1rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  transition: transform 0.2s, box-shadow 0.2s;
}
.featured-pet-card:hover {
  transform: translateY(-6px) scale(1.03);
  box-shadow: 0 8px 24px rgba(249, 168, 38, 0.15);
}
.featured-pet-img {
  width: 110px;
  height: 110px;
  object-fit: cover;
  border-radius: 50%;
  margin-bottom: 1rem;
  border: 4px solid #fff6e9;
  box-shadow: 0 2px 8px rgba(249, 168, 38, 0.06);
}
.featured-pet-info {
  text-align: center;
}
.featured-pet-name {
  color: #f7871f;
  font-size: 1.2rem;
  margin: 0.5rem 0 0.2rem 0;
}
.featured-pet-breed {
  color: #888;
  font-size: 1rem;
  margin-bottom: 0.7rem;
}
.featured-pet-desc {
  color: #444;
  font-size: 0.98rem;
  margin-bottom: 0.5rem;
}
.featured-pet-btn {
  background-color: #F9A826;
  color: white;
  padding: 0.6rem 1.2rem;
  border: none;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.2s;
  box-shadow: 0 2px 6px rgba(249, 168, 38, 0.1);
  margin-top: 0.5rem;
}
.featured-pet-btn:hover {
  background-color: #e0941f;
  transform: translateY(-2px);
}
.featured-pet-btn:active {
  transform: translateY(0px);
}
/* Footer  */
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
/* Responsive adjustments for footer */
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
</style>