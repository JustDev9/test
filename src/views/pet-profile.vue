<template>
  <div>
    <!-- Navigation Bar -->
    <nav class="nav-bar">
      <div class="menu-container">
        <div class="logo"><img src="/Designer.png" alt="Logo" class="logo-img" /><a href="#">PAWFECT</a></div>
       
        <!-- Desktop Navigation -->
        <ul class="nav-links">
          <li><a href="home"><i class="fas fa-home icon-fix"></i><span class="nav-text">Home</span></a></li>
          <li><a href="pet-profiles"><i class="fas fa-paw icon-fix"></i><span class="nav-text">Pet Profiles</span></a></li>
         
          <!-- Resources Dropdown -->
          <li class="dropdown"
            @mouseenter="handleResourcesMouseEnter"
            @mouseleave="handleResourcesMouseLeave">
            <a href="#" @click="handleResourcesClick" aria-haspopup="true" :aria-expanded="showResourcesDropdown">
              <i class="fas fa-book icon-fix"></i><span class="nav-text">Resources</span><i class="fas fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="dropdown-menu" v-show="showResourcesDropdown" :aria-expanded="showResourcesDropdown">
              <li><a href="training"><i class="fas fa-paw"></i>Training Tips</a></li>
              <li><a href="stories"><i class="fas fa-dog"></i>Success Stories</a></li>
            </ul>
          </li>
         
          <li><a href="donations"><i class="fas fa-heart icon-fix"></i><span class="nav-text">Donation</span></a></li>
         
          <!-- User Profile Dropdown -->
          <li class="dropdown user-dropdown"
            @mouseenter="handleAccountMouseEnter"
            @mouseleave="handleAccountMouseLeave">
            <a href="#" @click="handleAccountClick" aria-haspopup="true" :aria-expanded="showUserDropdown">
              <i class="fas fa-user-circle icon-fix"></i><span class="nav-text">Account</span><i class="fas fa-chevron-down dropdown-arrow"></i>
            </a>
            <ul class="dropdown-menu user-dropdown-menu" v-show="showUserDropdown" :aria-expanded="showUserDropdown">
              <li><a href="Profile" class="dropdown-item profile-item"><i class="fas fa-user"></i>Profile</a></li>
              <li><a href="#" class="dropdown-item logout-item"><i class="fas fa-sign-out-alt"></i>Logout</a></li>
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
          <li><a href="#" @click="closeAllDropdowns"><i class="fas fa-home icon-fix"></i><span>Home</span></a></li>
          <li><a href="#" @click="closeAllDropdowns"><i class="fas fa-paw icon-fix"></i><span>Pet Profiles</span></a></li>
         
          <!-- Mobile Resources Dropdown -->
          <li class="mobile-dropdown">
            <a href="#" @click="toggleMobileResourcesDropdown">
              <i class="fas fa-book icon-fix"></i><span>Resources</span>
              <i class="fas fa-chevron-down dropdown-arrow" :class="{ 'rotate-arrow': showMobileResourcesDropdown }"></i>
            </a>
            <ul class="mobile-dropdown-menu" v-show="showMobileResourcesDropdown">
              <li><a href="#"><i class="fas fa-paw"></i>Training Tips</a></li>
              <li><a href="#"><i class="fas fa-dog"></i>Success Stories</a></li>
            </ul>
          </li>
         
          <li><a href="#" @click="closeAllDropdowns"><i class="fas fa-heart icon-fix"></i><span>Donation</span></a></li>
         
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

    <!-- Pet Profile Card (matches image layout) -->
    <div class="pet-profile-card">
      <div class="pet-image-wrapper">
        <img src="/ridley.png" alt="Ridley" class="pet-image" />
      </div>
      <div class="pet-info-wrapper">
        <h1 class="pet-title">Hi! I'm Ridley</h1>
        <div class="pet-meta">
          <span><b>Age:</b> 19</span>
          <span><b>Breed:</b> American White Hair</span>
          <span><b>Sex:</b> M</span>
        </div>
        <p class="pet-description">
          Ridley is found in a corner street in Olongapo and he is trying to find his love ones. He has a gullible and joyful personality and likes to play with other people. He enjoys petting and play time. He also likes coding.
        </p>
        <button class="apply-btn" @click="showApplicationModal = true">Apply for Adoption</button>
      </div>
    </div>
  </div>
  <!-- Application Modal -->
  <div v-if="showApplicationModal" class="modal-overlay">
    <div class="modal-content pro-modal form-modern rich-form">
      <div class="modal-bar rich-bar"></div>
      <div class="step-indicator"><span class="step-circle">1</span> Application Form</div>
      <button class="close-modal pro-close" @click="showApplicationModal = false" aria-label="Close">&times;</button>
      <h2 class="modal-title rich-title"><i class="fas fa-paw rich-icon"></i> Pet Adoption Application</h2>
      <form @submit.prevent="submitApplication" class="modern-form-grid rich-form-grid">
        <h3 class="section-header rich-section"><i class="fas fa-user rich-section-icon"></i> Applicant Details</h3>
        <div class="modern-form-row">
          <div class="modern-form-col">
            <div class="modern-group">
              <label>Name <span class="required">*</span></label>
              <div class="modern-row-2">
                <input v-model="application.firstName" placeholder="First Name" required />
                <input v-model="application.lastName" placeholder="Last Name" required />
              </div>
            </div>
            <div class="modern-group">
              <label>E-mail <span class="required">*</span></label>
              <input v-model="application.emailAddress" placeholder="example@example.com" required />
            </div>
            <div class="modern-group">
              <label>Phone Number (Work)</label>
              <input 
                v-model="application.phoneNumberWork" 
                placeholder="Phone Number (Work)" 
                type="tel" 
                inputmode="numeric" 
                pattern="[0-9]{11}" 
                maxlength="11"
                @input="validatePhoneWork"
                required 
              />
            </div>
            <div class="modern-group">
              <label>Address</label>
              <input v-model="application.addressStreet" placeholder="Street Address" required />
              <div class="modern-row-3">
                <input v-model="application.addressCity" placeholder="City" required />
                <input v-model="application.addressState" placeholder="State / Province" required />
                <input 
                  v-model="application.addressZIP" 
                  placeholder="Postal / ZIP" 
                  type="tel" 
                  inputmode="numeric" 
                  pattern="[0-9]{4}" 
                  maxlength="4"
                  @input="validateZIP"
                  required 
                />
              </div>
              <input v-model="application.addressCountry" placeholder="Country" required />
            </div>
            <div class="modern-group">
              <label>Submit 1 valid ID (image or PDF) <span class="file-size-limit">(Max 5MB)</span></label>
              <input type="file" @change="handleFileUpload($event, 'validIdFile')" accept="image/*,application/pdf" required />
            </div>
            <div class="modern-group">
              <label>Submit a photo of your house <span class="file-size-limit">(Max 5MB)</span></label>
              <input type="file" @change="handleFileUpload($event, 'houseImageFile')" accept="image/*" required />
            </div>
            <div class="modern-group radio-group">
              <label>Do you have another pet?</label>
              <div class="modern-radio-row">
                <label class="rich-radio"><input type="radio" v-model="application.hasOtherPet" value="Yes" required /> Yes</label>
                <label class="rich-radio"><input type="radio" v-model="application.hasOtherPet" value="No" required /> No</label>
              </div>
            </div>
            <div v-if="application.hasOtherPet === 'Yes'" class="modern-group radio-group">
              <label><i class="fas fa-paw rich-section-icon"></i> Is your pet used to other pets?</label>
              <div class="modern-radio-row">
                <label class="rich-radio"><input type="radio" v-model="application.petUsedToOthers" value="Yes" required /> Yes</label>
                <label class="rich-radio"><input type="radio" v-model="application.petUsedToOthers" value="No" required /> No</label>
              </div>
            </div>
          </div>
          <div class="modern-form-col">
            <div class="modern-group">
              <label>Age</label>
              <input 
                v-model="application.age" 
                placeholder="Age" 
                type="tel" 
                inputmode="numeric" 
                pattern="[0-9]{1,2}" 
                maxlength="2"
                @input="validateAge"
                required 
              />
            </div>
            <div class="modern-group">
              <label>Phone Number (Mobile)</label>
              <input 
                v-model="application.phoneNumber" 
                placeholder="Phone Number (Mobile)" 
                type="tel" 
                inputmode="numeric" 
                pattern="[0-9]{11}" 
                maxlength="11"
                @input="validatePhoneMobile"
                required 
              />
            </div>
            <div class="modern-group">
              <label>Email Address</label>
              <input v-model="application.emailAddressAlternate" placeholder="Email Address" type="email" required />
            </div>
            <div class="modern-group">
              <label><i class="fas fa-home rich-section-icon"></i> I / We live in a</label>
              <div class="modern-radio-col">
                <label class="rich-radio"><input type="radio" v-model="application.homeType" value="Single Family Home" required /> Single Family Home</label>
                <label class="rich-radio"><input type="radio" v-model="application.homeType" value="Condo/Townhome/Apartment" required /> Condo/Townhome/Apartment</label>
              </div>
            </div>
            <div v-if="application.homeType === 'Condo/Townhome/Apartment'" class="modern-group radio-group">
              <label>Are pets allowed in your residence?</label>
              <div class="modern-radio-row">
                <label class="rich-radio"><input type="radio" v-model="application.petsAllowedInApartment" value="Yes" required /> Yes</label>
                <label class="rich-radio"><input type="radio" v-model="application.petsAllowedInApartment" value="No" required /> No</label>
              </div>
            </div>
            <div class="modern-group radio-group">
              <label>Are you ready for the financial needs of the pet?</label>
              <div class="modern-radio-row">
                <label class="rich-radio"><input type="radio" v-model="application.readyForFinancialNeeds" value="Yes" required /> Yes</label>
                <label class="rich-radio"><input type="radio" v-model="application.readyForFinancialNeeds" value="No" /> No</label>
              </div>
            </div>
          </div>
        </div>
        <hr class="rich-divider" />
        <div class="form-actions">
          <button type="submit" class="pro-submit rich-submit"><i class="fas fa-paper-plane"></i> Submit Application</button>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'PawfectNavigation',
  data() {
    return {
      sidebarOpen: false,
      showResourcesDropdown: false,
      showUserDropdown: false,
      showMobileResourcesDropdown: false,
      showMobileUserDropdown: false,
      isTablet: false,
      isTouch: false,
      showApplicationModal: false,
      application: {
        firstName: '',
        lastName: '',
        age: '',
        emailAddress: '',
        phoneNumber: '',
        phoneNumberWork: '',
        phoneNumberHome: '',
        addressStreet: '',
        addressStreet2: '',
        addressCity: '',
        addressState: '',
        addressZIP: '',
        addressCountry: '',
        hasOtherPet: '',
        petUsedToOthers: '',
        homeType: '',
        petsAllowedInApartment: '',
        readyForFinancialNeeds: '',
        emailAddressAlternate: '',
      },
      validIdFile: null,
      houseImageFile: null,
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
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.handleResizeSidebar);
    window.removeEventListener('resize', this.checkTablet);
    window.removeEventListener('resize', this.checkTouch);
    document.removeEventListener('click', this.handleDocumentClick);
    document.removeEventListener('keydown', this.handleKeydown);
  },
  methods: {
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
        // Click is inside nav or sidebar, do nothing
        return;
      }
      this.closeAllDropdowns();
    },
    handleKeydown(e) {
      // Esc closes dropdowns
      if (e.key === 'Escape') {
        this.closeAllDropdowns();
      }
      // Tab/Enter for accessibility
      // (implement as needed for your nav structure)
    },
    submitApplication() {
      alert('Application submitted!');
      this.showApplicationModal = false;
    },
    handleFileUpload(event, fileDataProperty) {
      const file = event.target.files[0];
      const maxSize = 5 * 1024 * 1024; // 5MB in bytes
      
      if (file) {
        if (file.size > maxSize) {
          alert('File size must be less than 5MB');
          event.target.value = ''; // Clear the file input
          this[fileDataProperty] = null;
          return;
        }
        this[fileDataProperty] = file;
      } else {
        this[fileDataProperty] = null;
      }
    },
    validateZIP(event) {
      // Remove any non-numeric characters
      let value = event.target.value.replace(/[^0-9]/g, '');
      // Limit to 4 digits
      value = value.slice(0, 4);
      // Update the input value
      this.application.addressZIP = value;
    },
    validateAge(event) {
      // Remove any non-numeric characters
      let value = event.target.value.replace(/[^0-9]/g, '');
      // Limit to 2 digits
      value = value.slice(0, 2);
      // Update the input value
      this.application.age = value;
    },
    validatePhoneWork(event) {
      // Remove any non-numeric characters
      let value = event.target.value.replace(/[^0-9]/g, '');
      // Limit to 11 digits
      value = value.slice(0, 11);
      // Update the input value
      this.application.phoneNumberWork = value;
    },
    validatePhoneMobile(event) {
      // Remove any non-numeric characters
      let value = event.target.value.replace(/[^0-9]/g, '');
      // Limit to 11 digits
      value = value.slice(0, 11);
      // Update the input value
      this.application.phoneNumber = value;
    },
  }
}
</script>

<style>
@import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&display=swap');
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
  background: #fff;
  border-radius: 4px;
  padding: 10px 0;
  box-shadow: none;
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
  .rich-form, .modal-content {
    max-width: 100vw;
    width: 100vw;
    min-width: 0;
    padding: 0.5rem 0.1rem 0.7rem 0.1rem;
    border-radius: 0;
  }
  .rich-form-grid {
    padding: 0.7rem 0.2rem 1.1rem 0.2rem;
    border-radius: 8px;
    margin-top: 0.5rem;
  }
  .section-header {
    font-size: 1.05rem;
    padding: 0.4rem 0.5rem;
    margin-bottom: 1rem;
  }
  .modern-group label {
    font-size: 0.98rem;
  }
  .modern-group input {
    font-size: 0.98rem;
    padding: 0.8rem 0.7rem 0.4rem 0.7rem;
  }
  .rich-submit {
    font-size: 1rem;
    padding: 0.8rem 1.2rem;
    border-radius: 8px;
  }
  .step-indicator {
    font-size: 0.98rem;
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
  .modern-form-row {
    flex-direction: column;
    gap: 1.2rem;
    flex-wrap: nowrap;
  }
  .rich-form-grid {
    padding: 1.2rem 0.7rem 1.2rem 0.7rem;
  }
  .section-header {
    font-size: 1.08rem;
    padding: 0.5rem 0.7rem;
  }
}
.rich-form, .modal-content {
  max-width: 700px;
  width: 100%;
  min-width: 0;
  margin: 0 auto;
  overflow-x: hidden;
}
.dropdown-menu li a:hover,
.user-dropdown-menu li a:hover,
.dropdown-menu li a:focus,
.user-dropdown-menu li a:focus {
  background: transparent;
  color: var(--primary-color);
  border-left: 3px solid var(--primary-color);
  padding-left: 17px;
}
.dropdown-menu li a:hover i,
.user-dropdown-menu li a:hover i,
.dropdown-menu li a:focus i,
.user-dropdown-menu li a:focus i {
  color: var(--primary-color);
}

.dropdown-menu,
.user-dropdown-menu {
  box-shadow: none;
  background: #fff;
  border: 1px solid #ececec;
}

.dropdown-item,
.dropdown-menu li a,
.user-dropdown-menu li a {
  box-shadow: none;
  background: transparent;
  border-radius: 0;
  border-bottom: 1px solid #f3f3f3;
}

.dropdown-menu li:last-child a,
.user-dropdown-menu li:last-child a {
  border-bottom: none;
}

.dropdown-menu li a:hover,
.user-dropdown-menu li a:hover,
.dropdown-menu li a:focus,
.user-dropdown-menu li a:focus {
  background: transparent;
  color: var(--primary-color);
  border-left: 3px solid var(--primary-color);
  padding-left: 17px;
}

.modal-overlay {
  position: fixed;
  top: 0; left: 0; right: 0; bottom: 0;
  background: rgba(0,0,0,0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 2000;
}
.modal-content {
  background: #fff;
  padding: 2rem;
  border-radius: 10px;
  max-width: 500px;
  width: 100%;
  position: relative;
}
.close-modal {
  position: fixed;
  top: 20px;
  right: 20px;
  background: #fff;
  border: none;
  width: 35px;
  height: 35px;
  border-radius: 50%;
  font-size: 1.3rem;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  color: #888;
  box-shadow: 0 2px 6px rgba(0,0,0,0.08);
  transition: all 0.2s ease;
  z-index: 2001;
}

.close-modal:hover {
  background: #ff914d;
  color: #fff;
}

.close-modal:active {
  transform: scale(0.95);
}

.pet-profile-card {
  display: flex;
  align-items: flex-start;
  justify-content: center;
  background: #fff;
  border-radius: 32px;
  box-shadow: 0 6px 24px rgba(0,0,0,0.08);
  padding: 2.5rem 2rem;
  max-width: 800px;
  margin: calc(var(--nav-height) + 2rem) auto 2.5rem auto;
  gap: 2.5rem;
}
.pet-image-wrapper {
  flex: 0 0 240px;
  display: flex;
  align-items: flex-start;
  justify-content: center;
}
.pet-image {
  width: 240px;
  height: 240px;
  object-fit: cover;
  border-radius: 24px;
  box-shadow: 0 2px 12px rgba(0,0,0,0.10);
}
.pet-info-wrapper {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: flex-start;
}
.pet-title {
  font-size: 2.6rem;
  font-weight: 700;
  color: #546e7a;
  margin-bottom: 0.5rem;
}
.pet-meta {
  font-size: 1.1rem;
  color: #6b7a8f;
  margin-bottom: 1.2rem;
  display: flex;
  gap: 1.5rem;
  flex-wrap: wrap;
}
.pet-description {
  color: #7a8ca3;
  font-size: 1.08rem;
  margin-bottom: 1.5rem;
  line-height: 1.6;
}
.apply-btn {
  background: #6b7a8f;
  color: #fff;
  font-size: 1.08rem;
  font-weight: 500;
  border: none;
  border-radius: 18px;
  padding: 0.7rem 1.7rem;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(107,122,143,0.10);
  transition: background 0.2s, transform 0.2s;
}
.apply-btn:hover {
  background: #ff914d;
  color: #fff;
  transform: translateY(-2px) scale(1.04);
}
@media (max-width: 700px) {
  .pet-profile-card {
    flex-direction: column;
    align-items: center;
    padding: 1.2rem 0.5rem;
    gap: 1.2rem;
  }
  .pet-image-wrapper {
    flex: none;
  }
  .pet-image {
    width: 180px;
    height: 180px;
    border-radius: 18px;
  }
  .pet-title {
    font-size: 2rem;
  }
}
.pro-modal {
  max-width: 700px;
  width: 98vw;
  background: #f8fafc;
  border-radius: 18px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.13);
  padding: 2.5rem 2rem 2rem 2rem;
  position: relative;
  overflow-y: auto;
  max-height: 90vh;
}
.pro-close {
  top: 18px;
  right: 18px;
  color: #888;
  font-size: 2.2rem;
  font-weight: 400;
  transition: color 0.2s;
}
.pro-close:hover {
  color: #ff914d;
}
.modal-progress {
  font-size: 1.08rem;
  color: #ff914d;
  font-weight: 600;
  margin-bottom: 0.5rem;
  letter-spacing: 0.5px;
}
.modal-title {
  font-size: 2rem;
  font-weight: 700;
  color: #546e7a;
  margin-bottom: 1.2rem;
}
.pro-form {
  display: flex;
  flex-direction: column;
  gap: 1.7rem;
}
.form-section {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  padding: 1.2rem 1rem 1.2rem 1rem;
  margin-bottom: 0.5rem;
}
.form-section h3 {
  font-size: 1.18rem;
  color: #ff914d;
  font-weight: 700;
  margin-bottom: 1rem;
}
.form-row {
  display: flex;
  gap: 1.2rem;
  margin-bottom: 0.7rem;
}
.form-group {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 0.3rem;
}
.form-group label {
  font-size: 0.98rem;
  color: #546e7a;
  font-weight: 500;
}
.form-group input,
.form-group select {
  padding: 0.6rem 0.9rem;
  border: 1px solid #e0e7ef;
  border-radius: 7px;
  font-size: 1rem;
  background: #f7fafd;
  margin-top: 0.2rem;
  transition: border 0.2s;
}
.form-group input:focus,
.form-group select:focus {
  border: 1.5px solid #ff914d;
  outline: none;
}
.checkbox-group {
  flex-direction: row;
  align-items: center;
  gap: 0.7rem;
}
.form-actions {
  display: flex;
  justify-content: flex-end;
  margin-top: 1.2rem;
}
.pro-submit {
  background: #ff914d;
  color: #fff;
  font-size: 1.1rem;
  font-weight: 600;
  border: none;
  border-radius: 8px;
  padding: 0.7rem 2.2rem;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(255,145,77,0.10);
  transition: background 0.2s, transform 0.2s;
}
.pro-submit:hover {
  background: #ffb07b;
  color: #fff;
  transform: translateY(-2px) scale(1.03);
}
@media (max-width: 600px) {
  .pro-modal {
    padding: 1.1rem 0.3rem 1.1rem 0.3rem;
    max-width: 99vw;
  }
  .form-row {
    flex-direction: column;
    gap: 0.2rem;
  }
  .form-section {
    padding: 0.7rem 0.3rem;
  }
  .modal-title {
    font-size: 1.3rem;
  }
}
.form-modern {
  padding-top: 0.5rem;
  background: #f8fafc;
  border-radius: 18px;
  box-shadow: 0 8px 32px rgba(0,0,0,0.13);
  max-width: 900px;
  width: 98vw;
  position: relative;
  overflow-y: auto;
  max-height: 95vh;
}
.modal-bar {
  height: 8px;
  width: 100%;
  background: #ff914d;
  border-radius: 18px 18px 0 0;
  margin-bottom: 1.2rem;
}
.section-header {
  font-size: 1.25rem;
  font-weight: 700;
  color: #444;
  margin-bottom: 1.2rem;
  margin-top: 0.5rem;
  letter-spacing: 0.5px;
}
.modern-form-grid {
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
}
.modern-form-row {
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
  margin-bottom: 1.2rem;
  max-width: 100%;
  min-width: 0;
}
.modern-form-col {
  flex: 1 1 0;
  display: flex;
  flex-direction: column;
  gap: 1.3rem;
  min-width: 0;
  max-width: 100%;
}
.modern-group {
  display: flex;
  flex-direction: column;
  gap: 0.3rem;
}
.modern-row-2 {
  display: flex;
  gap: 0.7rem;
  flex-wrap: wrap;
  min-width: 0;
  max-width: 100%;
}
.modern-row-3 {
  display: flex;
  gap: 0.7rem;
  flex-wrap: wrap;
  min-width: 0;
  max-width: 100%;
}
.modern-row-3 input {
  min-width: 0;
  flex: 1 1 0;
  max-width: 100%;
}
.modern-group input {
  border: 2px solid #b5d6f6;
  border-radius: 7px;
  background: #fafdff;
  padding: 0.6rem 0.9rem;
  font-size: 1rem;
  margin-top: 0.2rem;
  transition: border 0.2s;
  outline: none;
}
.modern-group input:focus {
  border: 2px solid #ff914d;
}
.modern-group label {
  font-size: 0.98rem;
  color: #444;
  font-weight: 500;
}
.modern-radio-row {
  display: flex;
  gap: 1.2rem;
  align-items: center;
}
.modern-radio-col {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}
.radio-group label {
  font-weight: 400;
  color: #444;
}
@media (max-width: 800px) {
  .modern-form-row {
    flex-direction: column;
    gap: 0.7rem;
  }
}
@media (max-width: 600px) {
  .rich-form, .modal-content {
    max-width: 95vw;
    width: 95vw;
    min-width: 0;
    margin: 2vw auto;
    padding: 0.7rem 0.5rem 1.1rem 0.5rem;
    border-radius: 12px;
    box-sizing: border-box;
  }
  .rich-form-grid {
    padding: 0.7rem 0.5rem 1.1rem 0.5rem;
    border-radius: 10px;
    margin-top: 0.5rem;
  }
  .rich-title {
    font-size: 1rem;
  }
  .step-indicator {
    font-size: 0.95rem;
  }
}
.rich-form {
  background: linear-gradient(135deg, #f8fafc 70%, #ffe5d0 100%);
  border: 1.5px solid #ff914d33;
  box-shadow: 0 10px 40px rgba(255,145,77,0.13), 0 2px 8px rgba(0,0,0,0.06);
  padding-bottom: 2.5rem;
  font-family: 'Inter', 'Poppins', Arial, sans-serif;
  position: relative;
}
.rich-bar {
  background: linear-gradient(90deg, #ff914d 60%, #ffb07b 100%);
  height: 10px;
  border-radius: 18px 18px 0 0;
  margin-bottom: 1.5rem;
  box-shadow: 0 2px 8px #ff914d33;
}
.progress-bar {
  width: 100%;
  height: 7px;
  background: #ffe5d0;
  border-radius: 6px;
  margin-bottom: 1.2rem;
  overflow: hidden;
}
.progress-bar-inner {
  width: 60%; /* Example: 60% complete */
  height: 100%;
  background: linear-gradient(90deg, #ff914d 60%, #ffb07b 100%);
  border-radius: 6px;
  transition: width 0.4s cubic-bezier(.4,2,.6,1);
}
.rich-form-grid {
  background: #fff9f3;
  border-radius: 20px;
  box-shadow: 0 4px 24px #ff914d18, 0 1.5px 8px #ff914d11;
  padding: 2.5rem 2rem 2rem 2rem;
  border: 1.5px solid #ff914d22;
  margin-top: 1.2rem;
  max-width: 100%;
  min-width: 0;
  overflow-x: hidden;
}
.section-header {
  font-size: 1.3rem;
  font-weight: 700;
  color: #ff914d;
  margin-bottom: 1.5rem;
  margin-top: 0.5rem;
  letter-spacing: 0.5px;
  background: linear-gradient(90deg, #fff9f3 60%, #ffe5d0 100%);
  padding: 0.7rem 1rem;
  border-radius: 12px;
  box-shadow: 0 1px 4px #ff914d11;
}
.modern-form-row {
  display: flex;
  flex-direction: column;
  gap: 1.2rem;
  margin-bottom: 1.2rem;
  max-width: 100%;
  min-width: 0;
}
.modern-form-col {
  flex: 1 1 0;
  display: flex;
  flex-direction: column;
  gap: 1.3rem;
  min-width: 0;
  max-width: 100%;
}
.modern-group {
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
  position: relative;
}
.modern-group label {
  font-size: 1.05rem;
  color: #444;
  font-weight: 500;
  margin-bottom: 0.2rem;
  letter-spacing: 0.01em;
}
.modern-group input {
  border: 2px solid #e0e7ef;
  border-radius: 9px;
  background: #fafdff;
  padding: 1.1rem 1.1rem 0.5rem 1.1rem;
  font-size: 1.05rem;
  margin-top: 0.1rem;
  transition: border 0.2s, box-shadow 0.2s;
  outline: none;
  box-shadow: 0 1.5px 8px #ff914d11;
}
.modern-group input:focus {
  border: 2px solid #ff914d;
  box-shadow: 0 2px 12px #ff914d22;
  background: #fff7f0;
}
.modern-group input::placeholder {
  color: #b5b5b5;
  opacity: 1;
  font-size: 1rem;
  font-style: italic;
}
.modern-row-2, .modern-row-3 {
  display: flex;
  gap: 0.7rem;
  flex-wrap: wrap;
  min-width: 0;
  max-width: 100%;
}
.modern-row-3 input {
  min-width: 0;
  flex: 1 1 0;
  max-width: 100%;
}
.rich-radio input[type="radio"] {
  accent-color: #ff914d;
  width: 1.3em;
  height: 1.3em;
  margin-right: 0.5em;
  box-shadow: 0 1px 4px #ff914d22;
  border-radius: 50%;
  background: #fff9f3;
  border: 2px solid #ff914d44;
  transition: border 0.2s;
}
.rich-radio input[type="radio"]:focus {
  border: 2px solid #ff914d;
  outline: 2px solid #ff914d88;
}
.rich-radio label {
  font-size: 1.08em;
  color: #444;
  font-weight: 500;
  margin-right: 1.2em;
  cursor: pointer;
}
.modern-radio-row {
  display: flex;
  gap: 1.5rem;
  align-items: center;
  margin-top: 0.2rem;
}
.modern-radio-col {
  display: flex;
  flex-direction: column;
  gap: 0.7rem;
  margin-top: 0.2rem;
}
.rich-divider {
  border: none;
  border-top: 2px dashed #ff914d44;
  margin: 2.2rem 0 1.2rem 0;
}
.required {
  color: #ff5050;
  font-size: 1.1em;
  margin-left: 0.2em;
}
.rich-submit {
  background: linear-gradient(90deg, #ff914d 60%, #ffb07b 100%);
  color: #fff;
  font-size: 1.18rem;
  font-weight: 700;
  border: none;
  border-radius: 12px;
  padding: 1.1rem 2.7rem;
  cursor: pointer;
  box-shadow: 0 2px 16px #ff914d33;
  transition: background 0.2s, transform 0.2s;
  display: flex;
  align-items: center;
  gap: 0.7rem;
  margin-top: 1.2rem;
}
.rich-submit:hover {
  background: linear-gradient(90deg, #ffb07b 60%, #ff914d 100%);
  color: #fff;
  transform: translateY(-2px) scale(1.04);
  box-shadow: 0 4px 24px #ff914d33;
}
@media (max-width: 800px) {
  .rich-form-grid {
    padding: 1.1rem 0.5rem 1.1rem 0.5rem;
  }
  .modern-form-row {
    flex-direction: column;
    gap: 0.7rem;
  }
}
@media (max-width: 600px) {
  .rich-form, .modal-content {
    max-width: 100vw;
    width: 100vw;
    min-width: 0;
    padding: 0.2rem 0.05rem 0.5rem 0.05rem;
    border-radius: 0;
  }
  .rich-form-grid {
    padding: 0.4rem 0.05rem 0.7rem 0.05rem;
    border-radius: 5px;
    margin-top: 0.2rem;
  }
  .section-header {
    font-size: 0.95rem;
    padding: 0.2rem 0.2rem;
    margin-bottom: 0.7rem;
  }
  .modern-group label {
    font-size: 0.93rem;
  }
  .modern-group input {
    font-size: 0.93rem;
    padding: 0.7rem 0.5rem 0.3rem 0.5rem;
  }
  .rich-submit {
    font-size: 0.95rem;
    padding: 0.7rem 0.7rem;
    border-radius: 6px;
  }
  .step-indicator {
    font-size: 0.93rem;
  }
}
.file-size-limit {
  font-size: 0.85rem;
  color: #666;
  font-weight: normal;
  font-style: italic;
}
</style>


