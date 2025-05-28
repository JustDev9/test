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
              <li><a href="status" class="dropdown-item profile-item"><i class="fas fa-user"></i>Profile</a></li>
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

    <div class="donation-container">
      <!-- Donation Header Section -->
      <div class="donation-header">
        <div class="label">Make a Difference</div>
        <h1 class="title">Donate to Pawfect</h1>
        <p class="description">
          Your donation helps us provide care, shelter, and find loving homes for pets in need.
          Every contribution makes a difference in an animal's life. Together, we can create a better
          world for our furry friends.
        </p>
        <button class="donate-btn">Donate now</button>
      </div>

      <!-- Donation Information Section -->
      <div class="donations-card">
        <div class="donations-info">
          <h2 class="donations-title">Donations List</h2>
          <div class="account-info">
            <p><strong>Account Name:</strong></p>
            <p>PawfectMatch, Inc.</p>
          </div>
          <div class="account-info">
            <p><strong>BPI Account Number:</strong></p>
            <p>1234-5678-9012</p>
          </div>
          <div class="account-info">
            <p><strong>BDO Account Number:</strong></p>
            <p>9876-5432-1098</p>
          </div>
        </div>
        <div class="qr-section">
          <div class="qr-container">
            <div class="gcash-header">
              <div class="gcash-logo-text">G</div>
              <p>SCAN TO DONATE</p>
            </div>
            <div class="qr-code-placeholder">
               <img src="/Img/qr.jpg" alt="Pawfect" width="100%" height="100%"> 
            </div>
          </div>
        </div>
      </div>

      <!-- Volunteer Section -->
      <div class="volunteer-card">
        <div class="volunteer-header">Become a volunteer</div>
        <p class="volunteer-text">
          Join the Pawfect family and help make a difference in the lives of rescued animals. As a volunteer, you’ll play a vital role in caring for pets, supporting adoption events, and spreading awareness in the community.
        </p>
        <p class="volunteer-text">
          Your time and compassion can bring hope and happiness to our furry friends. Whether it’s walking dogs, assisting with shelter tasks, or helping match pets with their perfect homes, there’s a place for you at Pawfect.Together, we can create a better world—one paw at a time.
        </p>
      </div>

      <!-- Updated Pet Beneficiaries Section -->
      <div class="pet-beneficiaries-section">
        <h2 class="beneficiaries-title">Pet Beneficiaries</h2>
        <div class="beneficiaries-container">
          <div class="image-gallery">
            <!-- Left Column (tall featured image + smaller image below) -->
            <div class="gallery-left">
              <div class="feature-image">
                 <img src="/Img/dog2.png" alt="Featured pet" class="placeholder-img"> 
                <div class="image-overlay">
                  <p class="overlay-text">Featured Pet</p>
                </div>
              </div>
              <div class="small-image">
                 <img src="/Img/dog1.png" alt="Pet image" class="placeholder-img"> 
                <div class="image-overlay">
                  <p class="overlay-text">Rescued</p>
                </div>
              </div>
            </div>

            <!-- Right Side (2 rows) -->
            <div class="gallery-right">
              <!-- Top Row (image + text box) -->
              <div class="gallery-top">
                <div class="medium-image">
                   <img src="/Img/dog3.png" alt="Pet image" class="placeholder-img"> 
                  <div class="image-overlay">
                    <p class="overlay-text">Medical Care</p>
                  </div>
                </div>
                <div class="content-box">
                  <p class="beneficiary-text">
                    Your donations help us provide essential medical care, food, and shelter to pets in need.
                    Every contribution goes directly towards improving the lives of our furry friends and helping
                    them find their forever homes.
                  </p>
                  <button class="btn-label">Help Our Pets</button>
                </div>
              </div>

              <!-- Bottom Row (two images side by side) -->
              <div class="bottom-row">
                <div class="medium-image">
                   <img src="/Img/dog4.jpg" alt="Pet image" class="placeholder-img"> 
                  <div class="image-overlay">
                    <p class="overlay-text">Adoption Ready</p>
                  </div>
                </div>
                <div class="medium-image">
                  <img src="/Img/dog5.jpg" alt="Pet image" class="placeholder-img">
                  <div class="image-overlay">
                    <p class="overlay-text">Special Needs</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="browse-container">
    <div class="browse-left">
      <h2>Browse More Pet<span>!</span></h2>
      <p>
        Lorem ipsum dolor sit amet consectetur. Tortor nec enim lorem adipiscing cursus massa nisl.
        Purus consectetur risus pellentesque integer a sed suspendisse. Uma aliquam pellentesque nam ornare.
        Dui cursus sit ornare dolor turpis in.
      </p>
      <div class="button-group">
        <router-link to="/pet-profiles" class="btn primary">Browse Pets</router-link>
      </div>
    </div>
    <div class="browse-right">
      <div class="counter-box">
        <div class="count">17</div>
        <div class="label">Pawfect Pets</div>
      </div>
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

</template>

<script>
export default {
  name: 'DonationPage',
  data() {
    return {
      mobileMenuOpen: false,
      dropdownOpen: false,
      desktopDropdownOpen: false,
      userDropdownOpen: false,
      isMobile: false,
      hasScrolled: false,
      sidebarOpen: false,
      showResourcesDropdown: false,
      showMobileResourcesDropdown: false,
      showUserDropdown: false,
      showMobileUserDropdown: false
    }
  },
  mounted() {
    this.checkScreenSize();
    window.addEventListener('resize', this.checkScreenSize);
    window.addEventListener('scroll', this.handleScroll);
    document.addEventListener('click', this.closeResourceDropdownOnClickOutside);
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.checkScreenSize);
    window.removeEventListener('scroll', this.handleScroll);
    document.removeEventListener('click', this.closeResourceDropdownOnClickOutside);
  },
  methods: {
    toggleMobileMenu() {
      this.mobileMenuOpen = !this.mobileMenuOpen;
      if (!this.mobileMenuOpen) {
        this.dropdownOpen = false;
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
        this.dropdownOpen = !this.dropdownOpen;
        this.desktopDropdownOpen = false;
      } else {
        this.desktopDropdownOpen = !this.desktopDropdownOpen;
      }
    },
    toggleUserDropdown(event) {
      event.preventDefault();
      event.stopPropagation();
      if (!this.userDropdownOpen) {
        this.userDropdownOpen = true;
      }
      this.desktopDropdownOpen = false;
      if (this.isMobile) {
        this.dropdownOpen = false;
      }
    },
    closeUserDropdown() {
      this.userDropdownOpen = false;
    },
    closeMenuIfMobile() {
      if (this.isMobile) {
        this.mobileMenuOpen = false;
        this.dropdownOpen = false;
        document.body.classList.remove('no-scroll');
      }
    },
    checkScreenSize() {
      const previouslyMobile = this.isMobile;
      this.isMobile = window.innerWidth <= 768;

      if (previouslyMobile !== this.isMobile) {
        if (!this.isMobile) {
          this.mobileMenuOpen = false;
          this.dropdownOpen = false;
          document.body.classList.remove('no-scroll');
        } else {
          this.desktopDropdownOpen = false;
        }
      }
    },
    handleScroll() {
      this.hasScrolled = window.scrollY > 20;
    },
    closeResourceDropdownOnClickOutside(event) {
      const resourcesDropdownToggle = this.$el.querySelector('.nav-link.dropdown-toggle');
      const resourcesDropdownContent = this.$el.querySelector('.dropdown-content.desktop');

      if (this.desktopDropdownOpen && resourcesDropdownToggle && !resourcesDropdownToggle.contains(event.target) && resourcesDropdownContent && !resourcesDropdownContent.contains(event.target)) {
        this.desktopDropdownOpen = false;
      }
    },
    handleResourcesMouseEnter() {
      this.showResourcesDropdown = true;
    },
    handleResourcesMouseLeave() {
      this.showResourcesDropdown = false;
    },
    handleResourcesClick() {
      // Handle resources click
    },
    handleAccountMouseEnter() {
      this.showUserDropdown = true;
    },
    handleAccountMouseLeave() {
      this.showUserDropdown = false;
    },
    handleAccountClick() {
      // Handle account click
    },
    toggleMobileResourcesDropdown() {
      this.showMobileResourcesDropdown = !this.showMobileResourcesDropdown;
    },
    toggleMobileUserDropdown() {
      this.showMobileUserDropdown = !this.showMobileUserDropdown;
    },
    closeAllDropdowns() {
      this.mobileMenuOpen = false;
      this.dropdownOpen = false;
      this.desktopDropdownOpen = false;
      this.userDropdownOpen = false;
      this.showResourcesDropdown = false;
      this.showUserDropdown = false;
      this.showMobileResourcesDropdown = false;
      this.showMobileUserDropdown = false;
      document.body.classList.remove('no-scroll');
    }
  }
}
</script>

<style>
/* Global Styles */
html {
  box-sizing: border-box;
}
*, *:before, *:after {
  box-sizing: inherit;
}
body {
  margin: 0;
  padding: 0;
  font-family: "Poppins", sans-serif;
}

body.no-scroll {
  overflow: hidden;
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
  border-radius: 0;
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
  border-radius: 0;
  transition: opacity 0.2s, transform 0.2s;
  animation: fadeIn 0.3s ease;
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

/* Donation page styles */
.donation-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem 1.5rem;
  display: flex;
  flex-direction: column;
  gap: 2rem;
  margin-top: var(--nav-height);
}

/* Donation Header Section */
.donation-header {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
  max-width: 700px;
  margin: 0 auto;
  text-align: center;
  padding: 2rem 1rem;
  background: linear-gradient(to right, #f9f9fb, #f1f2f6);
  border-radius: 16px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.05);
  position: relative;
  overflow: hidden;
}

.donation-header::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 5px;
  background: linear-gradient(to right, #F9A826, #FFD166);
}

.label {
  color: #4B6584;
  font-size: 1rem;
  text-transform: uppercase;
  letter-spacing: 3px;
  font-weight: 600;
  background: linear-gradient(to right, #4B6584, #778ca3);
  background-clip: text;
  -webkit-background-clip: text;
  color: transparent;
}

.title {
  font-size: 2.5rem;
  color: #4B6584;
  margin: 0;
  font-weight: 700;
  position: relative;
  display: inline-block;
}

.title::after {
  content: '';
  position: absolute;
  width: 60px;
  height: 3px;
  background-color: #F9A826;
  bottom: -10px;
  left: 50%;
  transform: translateX(-50%);
  border-radius: 2px;
}

.description {
  color: #666;
  line-height: 1.8;
  margin: 1rem 0;
  font-size: 1.1rem;
}

.donate-btn {
  align-self: center;
  background: linear-gradient(135deg, #F9A826, #FFD166);
  border: none;
  color: white;
  padding: 0.8rem 2.5rem;
  border-radius: 30px;
  font-weight: 600;
  font-size: 1.1rem;
  cursor: pointer;
  transition: all 0.3s ease;
  box-shadow: 0 8px 15px rgba(249, 168, 38, 0.3);
  position: relative;
  overflow: hidden;
  z-index: 1;
}

.donate-btn::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, #FFD166, #F9A826);
  transition: all 0.4s ease;
  z-index: -1;
}

.donate-btn:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 20px rgba(249, 168, 38, 0.4);
}

.donate-btn:hover::before {
  left: 0;
}

.donate-btn:active {
  transform: translateY(1px);
}

/* Payment Information Section */
.donations-card {
  background: white;
  border-radius: 20px;
  padding: 3rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 2.5rem;
  box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
  position: relative;
  overflow: hidden;
}

.donations-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23f0f0f0' fill-opacity='0.4'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
  opacity: 0.07;
  z-index: 0;
}

.donations-info {
  flex: 1;
  position: relative;
  z-index: 1;
  padding-left: 6rem;

}

.donations-title {
  font-size: 1.8rem;
  margin-top: 0;
  margin-bottom: 1.5rem;
  color: #4B6584;
  font-weight: 700;
  position: relative;
  display: inline-block;
}

.donations-title::after {
  content: '';
  position: absolute;
  width: 40px;
  height: 3px;
  background-color: #F9A826;
  bottom: -8px;
  left: 0;
  border-radius: 2px;
}

.account-info {
  margin-top: 2rem;
  margin-bottom: 1.5rem;
  background: #f9fafb;
  padding: 1rem;
  border-radius: 10px;
  border: 1px solid #F9A826 ;
  border-left: 4px solid #F9A826;
  transition: all 0.3s ease;
}

.account-info:hover {
  transform: translateX(5px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.account-info p {
  margin: 0.25rem 0;
  color: #4B6584;
}

.account-info p strong {
  color: #2d3748;
  font-weight: 600;
}

.qr-section {
  flex: 1;
  display: flex;
  justify-content: center;
  position: relative;
  z-index: 1;
  padding-right: 2rem;
}

.qr-container {
  background: white;
  border-radius: 16px;
  padding: 1.25rem;
  width: 240px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  transition: all 0.3s ease;
  border: 1px solid #eaeaea;
}

.qr-container:hover {
  transform: translateY(-5px);
  box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
}

.gcash-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-bottom: 1rem;
  background: #0075FF;
  color: white;
  padding: 0.75rem 1rem;
  border-radius: 8px;
  font-weight: 500;
}

.gcash-logo-text {
  font-weight: bold;
  font-size: 1.25rem;
  background: white;
  color: #0075FF;
  width: 30px;
  height: 30px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  box-shadow: 0 3px 8px rgba(0, 117, 255, 0.2);
}

.qr-code-placeholder {
  width: 100%;
  height: 200px;
  border-radius: 8px;
  position: relative;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
}

.qr-code-placeholder img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.qr-code-placeholder:hover img {
  transform: scale(1.03);
}

/* Volunteer Section */
.volunteer-card {
  background: linear-gradient(135deg, #F9A826, #FFD166);
  border-radius: 20px;
  padding: 3rem;
  color: white;
  position: relative;
  overflow: hidden;
  box-shadow: 0 15px 30px rgba(249, 168, 38, 0.2);
}

.volunteer-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
  z-index: 0;
}

.volunteer-header {
  font-size: 1.8rem;
  font-weight: 700;
  margin-bottom: 1.5rem;
  position: relative;
  z-index: 1;
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
}

.volunteer-text {
  margin-bottom: 1.5rem;
  line-height: 1.8;
  font-size: 1.1rem;
  position: relative;
  z-index: 1;
  text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.05);
}

/* Pet Beneficiaries Section*/
.pet-beneficiaries-section {
  margin-top: 2rem;
}

.beneficiaries-title {
  font-size: 2.2rem;
  color: #4B6584;
  margin-bottom: 2rem;
  position: relative;
  display: inline-block;
  font-weight: 700;
}

.beneficiaries-title::after {
  content: '';
  position: absolute;
  width: 50px;
  height: 3px;
  background-color: #F9A826;
  bottom: -10px;
  left: 0;
  border-radius: 2px;
}

.beneficiaries-container {
  width: 100%;
}

/* Image Gallery */
.image-gallery {
  display: flex;
  gap: 1.5rem;
}

.gallery-left {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.gallery-right {
  flex: 2;
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.feature-image {
  height: 0;
  padding-bottom: 100%; /* Square aspect ratio */
  position: relative;
  overflow: hidden;
  border-radius: 16px;
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
}

.small-image {
  height: 0;
  padding-bottom: 50%; /* 2:1 aspect ratio */
  position: relative;
  overflow: hidden;
  border-radius: 16px;
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
}

.gallery-top {
  display: flex;
  gap: 1.5rem;
  height: 50%;
}

.medium-image {
  flex: 1;
  position: relative;
  overflow: hidden;
  border-radius: 16px;
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
  transition: all 0.3s ease;
}

.feature-image:hover,
.small-image:hover,
.medium-image:hover {
  transform: translateY(-5px);
  box-shadow: 0 18px 30px rgba(0, 0, 0, 0.2);
}

.content-box {
  flex: 1;
  background: white;
  border-radius: 16px;
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  box-shadow: 0 12px 24px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  border-left: 4px solid #4B6584;
}

.content-box:hover {
  transform: translateY(-5px);
  box-shadow: 0 18px 30px rgba(0, 0, 0, 0.12);
}

.bottom-row {
  display: flex;
  gap: 1.5rem;
  height: 50%;
}

.beneficiary-text {
  color: #4B6584;
  line-height: 1.8;
  margin-bottom: 1.5rem;
  font-size: 1rem;
}

.image-overlay {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.3) 60%, transparent);
  padding: 2rem 1.5rem 1.5rem;
  color: white;
  transition: all 0.4s ease;
}

.feature-image:hover .image-overlay,
.small-image:hover .image-overlay,
.medium-image:hover .image-overlay {
  padding-bottom: 2rem;
}

.overlay-text {
  font-weight: 700;
  font-size: 1.2rem;
  margin: 0;
  text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.4);
  transform: translateY(0);
  transition: all 0.3s ease;
}

.feature-image:hover .overlay-text,
.small-image:hover .overlay-text,
.medium-image:hover .overlay-text {
  transform: translateY(-5px);
}

.placeholder-img {
  position: absolute;
  width: 100%;
  height: 100%;
  top: 0;
  left: 0;
  object-fit: cover;
  transition: transform 0.5s ease;
}

.feature-image:hover .placeholder-img,
.small-image:hover .placeholder-img,
.medium-image:hover .placeholder-img {
  transform: scale(1.1);
}

.btn-label {
  background: linear-gradient(135deg, #4B6584, #3a506b);
  color: white;
  border: none;
  padding: 0.8rem 1.8rem;
  border-radius: 30px;
  font-weight: 600;
  cursor: pointer;
  align-self: flex-start;
  transition: all 0.3s ease;
  box-shadow: 0 8px 15px rgba(75, 101, 132, 0.2);
  position: relative;
  overflow: hidden;
  z-index: 1;
}

.btn-label::before {
  content: '';
  position: absolute;
  top: 0;
  left: -100%;
  width: 100%;
  height: 100%;
  background: linear-gradient(135deg, #3a506b, #4B6584);
  transition: all 0.4s ease;
  z-index: -1;
}

.btn-label:hover {
  transform: translateY(-3px);
  box-shadow: 0 12px 20px rgba(75, 101, 132, 0.3);
}

.btn-label:hover::before {
  left: 0;
}

.btn-label:active {
  transform: translateY(1px);
}

.browse-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  gap: 2rem;
  padding: 2rem;
  font-family: 'Segoe UI', sans-serif;
}

.browse-left {
  flex: 1;
}

.browse-left h2 {
  font-size: 2rem;
  color: #1d1d1d;
}

.browse-left span {
  color: #4a6fa5;
}

.browse-left p {
  font-size: 0.9rem;
  color: #6b7280;
  margin: 1rem 0;
  max-width: 500px;
}

.button-group {
  display: flex;
  gap: 1rem;
}

.btn {
  padding: 0.5rem 1rem;
  border-radius: 20px;
  border: none;
  cursor: pointer;
  font-weight: 500;
}

.primary {
  background-color: #4B6584;
  color: white;
  font-weight: bold;
  padding: 0.8rem;
}

.browse-right {
  display: flex;
  align-items: center;
  gap: 1rem;
}

.image-box {
  background-color: #a5b4fc;
  border-radius: 12px;
  padding: 2rem;
  display: flex;
  align-items: center;
  justify-content: center;
}

.counter-box {
  background-color: #F9A826;
  color: white;
  padding: 1.5rem 1rem;
  border-radius: 12px;
  text-align: center;
  min-width: 80px;
}

.count {
  font-size: 1.8rem;
  font-weight: bold;
}

.label {
  font-size: 0.9rem;
  color: white;
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

/* Responsive adjustments */
@media (max-width: 1100px) {
  .donation-container {
    padding: 2rem 1rem;
    gap: 2.5rem;
  }

  .donations-info {
    padding-left: 0rem;
  }

  .donations-card {
    padding: 1rem;
  }

  .volunteer-card {
    padding: 2rem;
  }

  /* Footer */
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
  .image-gallery {
    flex-direction: column;
  }

  .gallery-top, .bottom-row {
    height: auto;
  }

  .gallery-left {
    flex-direction: row;
  }

  .feature-image {
    flex: 2;
    padding-bottom: 60%;
  }

  .small-image {
    flex: 1;
    padding-bottom: 60%;
  }

  /* Footer tweaks */
  .footer-container {
    padding: 1.5rem 1rem;
  }

  .footer-column {
    flex-basis: 100%;
  }
}

@media (max-width: 900px) {
  .nav-links {
    gap: 1.5rem;
  }

  .qr-section {
    padding-left: 2rem;
  }

  .donations-card {
    flex-direction: column;
    text-align: center;
    gap: 2rem;
  }

  .donations-title::after {
    left: 50%;
    transform: translateX(-50%);
  }

  .account-info {
    max-width: 500px;
    margin-left: auto;
    margin-right: auto;
  }

  .account-info:hover {
    transform: translateY(-5px);
  }

  .volunteer-header {
    font-size: 1.6rem;
  }
}

@media (max-width: 768px) {
  .nav-container {
    padding: 0.75rem 1.25rem;
  }

  .logo-text {
    font-size: 1.5rem;
  }

  .mobile-menu-toggle {
    display: flex;
  }

  .nav-links-container {
    position: static;
  }

  .nav-links {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: #F9A826;
    padding: 2rem;
    gap: 1.5rem;
    z-index: 1000;
    transition: transform 0.3s ease;
    transform: translateX(100%);
    overflow-y: auto;
    padding-top: 5rem;
    width: 100vw;
    margin: 0;
  }

  .nav-links.mobile-active {
    transform: translateX(0);
  }

  .nav-link {
    font-size: 1.3rem;
  }

  .nav-link:after {
    height: 3px;
  }

  .gallery-left {
    flex-direction: column;
  }

  .feature-image, .small-image {
    padding-bottom: 50%;
  }

  .gallery-top {
    flex-direction: column;
  }

  .bottom-row {
    flex-direction: column;
  }

  .donations-card {
    flex-direction: column;
    text-align: center;
  }

  .qr-section {
    width: 100%;
  }

  .qr-container {
    margin: 0 auto;
  }

  .donation-header {
    text-align: center;
  }

  .donate-btn {
    align-self: center;
  }

  /* Footer stacks fully on mobile */
  .footer-container {
    flex-direction: column;
    align-items: center;
    text-align: center;
  }

  .footer-column {
    margin-bottom: 1.5rem;
  }
}

@media (max-width: 576px) {
  .feature-image, .small-image, .medium-image {
    padding-bottom: 66.67%;
  }

  .image-overlay {
    padding: 10px;
  }

  .overlay-text {
    font-size: 0.9rem;
  }

  .content-box {
    padding: 12px;
  }

  .beneficiary-text {
    font-size: 0.9rem;
    margin-bottom: 10px;
  }

  .btn-label {
    padding: 0.5rem 1.2rem;
    font-size: 0.9rem;
  }
}

@media (max-width: 480px) {
  .nav-container {
    padding: 0.75rem 1rem;
  }

  .logo-text {
    font-size: 1.3rem;
  }

  .user-icon {
    width: 32px;
    height: 32px;
  }

  .nav-links {
    padding: 1.5rem;
    gap: 1.25rem;
  }

  .donation-container {
    padding: 1.5rem 1rem;
  }

  .title {
    font-size: 1.75rem;
  }

  .donations-card, .volunteer-card {
    padding: 1.5rem;
  }
}
/* Animation for mobile menu */
@keyframes slideIn {
  from {
    transform: translateX(100%);
    opacity: 0;
  }
  to {
    transform: translateX(0);
    opacity: 1;
  }
}
</style>