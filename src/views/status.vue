<template>
  <div>
    <nav class="nav-container" :class="{ 'nav-scrolled': hasScrolled }">
      <div class="logo-container">
        <div class="logo-image">
          <img src="/Designer.png" alt="Pawfect" width="40" height="40">
        </div>
        <span class="logo-text">PAWFECT</span>
      </div>

      <div class="nav-links-container">
        <transition name="fade">
          <div v-if="mobileMenuOpen || !isMobile" class="nav-links" :class="{ 'mobile-active': mobileMenuOpen }">
            <a href="#" class="nav-link" @click="closeMenuIfMobile">Home</a>
            <a href="#" class="nav-link" @click="closeMenuIfMobile">Pet Profiles</a>
            <div class="dropdown">
              <a href="#" class="nav-link dropdown-toggle" @click="toggleDesktopDropdown">
                Resources <span class="dropdown-arrow" :class="{ 'arrow-rotated': dropdownOpen || desktopDropdownOpen }">▼</span>
              </a>
              <transition name="slide-fade">
                <div v-if="isMobile && dropdownOpen" class="dropdown-content mobile">
                  <a href="#" @click="closeMenuIfMobile">Training Tips</a>
                  <a href="#" @click="closeMenuIfMobile">Health Guides</a>
                </div>
              </transition>
              <transition name="resources-dropdown">
                <div v-if="!isMobile && desktopDropdownOpen" class="dropdown-content desktop">
                  <a href="#">Training Tips</a>
                  <a href="#">Health Guides</a>
                  <a href="#">Pet Care</a>
                </div>
              </transition>
            </div>
            <a href="#" class="nav-link" @click="closeMenuIfMobile">Donation</a>
            <a href="#" class="nav-link" @click="closeMenuIfMobile">Contact</a>
          </div>
        </transition>
      </div>

      <div class="right-section">
        <div class="user-dropdown">
          <div class="user-icon" role="button" aria-label="User profile" tabindex="0" @click="toggleUserDropdown">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
              <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
              <circle cx="12" cy="7" r="4"></circle>
            </svg>
          </div>

          <transition name="dropdown-animation">
            <div v-if="userDropdownOpen" class="user-dropdown-content" :class="{ 'mobile-dropdown': isMobile }">
              <div class="dropdown-header">
                <span>User Menu</span>
                <button class="close-dropdown-btn" @click="closeUserDropdown" aria-label="Close menu">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                  </svg>
                </button>
              </div>
              <a href="#" @click.stop>Profile</a>
              <a href="#" @click.stop>Status</a>
              <a href="#" @click.stop>Log Out</a>
            </div>
          </transition>
        </div>

        <button class="mobile-menu-toggle" aria-label="Toggle menu" @click="toggleMobileMenu">
          <div class="bar" :class="{ 'bar-1-active': mobileMenuOpen }"></div>
          <div class="bar" :class="{ 'bar-2-active': mobileMenuOpen }"></div>
          <div class="bar" :class="{ 'bar-3-active': mobileMenuOpen }"></div>
        </button>
      </div>
    </nav>

    <main class="status-page-container">
      <h1 class="status-page-title">Adoption Status</h1>
      <div v-if="applications.length === 0" class="no-applications">
        You have no active adoption applications.
      </div>
      <div v-else class="applications-grid">
        <div v-for="app in applications" :key="app.id" class="application-card">
          <div class="card-header">
            <h2 class="application-id">Application ID: {{ app.id }}</h2>
            <span :class="['status-badge', getStatusClass(app.status)]">
              {{ getStatusIcon(app.status) }} {{ app.status }}
            </span>
          </div>

          <div class="pet-info-container">
            <img :src="app.pet.photoUrl" :alt="app.pet.name + ' Photo'" class="pet-photo-thumbnail">
            <div class="pet-details">
              <h3 class="pet-name">{{ app.pet.name }}</h3>
              <p class="pet-meta">{{ app.pet.breed }} | {{ app.pet.age }}</p>
            </div>
          </div>

          <div class="application-details">
            <p><strong>Date of Application:</strong> {{ formatDate(app.dateOfApplication) }}</p>
            <p><strong>Last Updated:</strong> {{ formatDate(app.statusUpdatedDate) }}</p>
          </div>

          <div v-if="app.remarks" class="remarks-section">
            <h4>Shelter Notes:</h4>
            <p>{{ app.remarks }}</p>
          </div>

          <div class="action-buttons">
            <button
              v-if="app.status === 'Pending'"
              @click="cancelApplication(app.id)"
              class="btn btn-cancel">
              Cancel Application
            </button>
            <button
              v-if="app.status === 'Accepted'"
              @click="contactShelter(app.id)"
              class="btn btn-contact">
              Contact Shelter
            </button>
            </div>
        </div>
      </div>
    </main>

  </div>
</template>

<script>
export default {
  name: 'AdoptionStatusPage',
  data() {
    return {
      // --- START: Navigation Bar Data ---
      mobileMenuOpen: false,
      dropdownOpen: false,
      desktopDropdownOpen: false,
      userDropdownOpen: false,
      isMobile: false,
      hasScrolled: false,
      // --- END: Navigation Bar Data ---

      // --- START: Status Page Data ---
      applications: [ // Sample data - replace with actual data from your backend
        {
          id: 'APP-2025-001',
          pet: {
            name: 'Buddy',
            photoUrl: 'Designer.png',
            breed: 'Golden Retriever',
            age: '2 years old',
          },
          dateOfApplication: '2025-05-01T10:00:00Z',
          status: 'Pending',
          statusUpdatedDate: '2025-05-15T14:30:00Z',
          remarks: 'Application under initial review. We will contact you shortly for a virtual meet & greet.',
        },
        {
          id: 'APP-2025-002',
          pet: {
            name: 'Lucy',
            photoUrl: 'Designer.png',
            breed: 'Siamese',
            age: '1 year old',
          },
          dateOfApplication: '2025-04-20T15:30:00Z',
          status: 'Accepted',
          statusUpdatedDate: '2025-05-10T11:00:00Z',
          remarks: 'Congratulations! Your application for Lucy has been approved. Please contact us within 48 hours to arrange the adoption.',
        },
        {
          id: 'APP-2025-003',
          pet: {
            name: 'Max',
            photoUrl: 'Designer.png',
            breed: 'Labrador Mix',
            age: '3 years old',
          },
          dateOfApplication: '2025-05-10T09:00:00Z',
          status: 'Rejected',
          statusUpdatedDate: '2025-05-16T17:00:00Z',
          remarks: 'Thank you for your interest. Unfortunately, after careful consideration, we found another applicant whose home environment was a closer match for Max\'s specific needs.',
        },
        {
          id: 'APP-2025-004',
          pet: {
            name: 'Chloe',
            photoUrl: 'Designer.png',
            breed: 'Beagle',
            age: '5 months old',
          },
          dateOfApplication: '2025-03-15T12:00:00Z',
          status: 'Canceled',
          statusUpdatedDate: '2025-03-20T10:00:00Z',
          remarks: 'Application canceled by user.',
        },
        {
          id: 'APP-2025-005',
          pet: {
            name: 'Rocky',
            photoUrl: 'Designer.png',
            breed: 'German Shepherd',
            age: '4 years old',
          },
          dateOfApplication: '2025-05-16T11:00:00Z',
          status: 'Pending',
          statusUpdatedDate: '2025-05-17T09:00:00Z',
          remarks: 'Awaiting home visit scheduling.',
        },
      ]
      // --- END: Status Page Data ---
    };
  },
  mounted() {
    this.checkScreenSize();
    window.addEventListener('resize', this.checkScreenSize);
    window.addEventListener('scroll', this.handleScroll);
    document.addEventListener('click', this.closeDropdownsOnClickOutside);
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.checkScreenSize);
    window.removeEventListener('scroll', this.handleScroll);
    document.removeEventListener('click', this.closeDropdownsOnClickOutside);
    document.body.style.overflow = '';
  },
  methods: {
    // --- START: Navigation Bar Methods ---
    toggleMobileMenu() {
      this.mobileMenuOpen = !this.mobileMenuOpen;
      if (!this.mobileMenuOpen) {
        this.dropdownOpen = false;
      }
      document.body.style.overflow = this.mobileMenuOpen ? 'hidden' : '';
    },
    toggleDesktopDropdown(event) {
      event.preventDefault();
      event.stopPropagation();
      if (this.isMobile) {
        this.dropdownOpen = !this.dropdownOpen;
      } else {
        this.desktopDropdownOpen = !this.desktopDropdownOpen;
      }
    },
    toggleUserDropdown(event) {
      event.stopPropagation();
      this.userDropdownOpen = !this.userDropdownOpen;
    },
    closeUserDropdown() {
      this.userDropdownOpen = false;
    },
    closeMenuIfMobile() {
      if (this.isMobile) {
        this.mobileMenuOpen = false;
        this.dropdownOpen = false;
        document.body.style.overflow = '';
      }
    },
    checkScreenSize() {
      this.isMobile = window.innerWidth <= 768;
      if (!this.isMobile) {
        this.mobileMenuOpen = false;
        this.dropdownOpen = false;
        document.body.style.overflow = '';
      }
    },
    handleScroll() {
      this.hasScrolled = window.scrollY > 20;
    },
    closeDropdownsOnClickOutside(event) {
      if (!this.isMobile && this.desktopDropdownOpen) {
        const resourcesDropdownEl = this.$el.querySelector('.dropdown .dropdown-content.desktop');
        const resourcesToggleEl = this.$el.querySelector('.dropdown .dropdown-toggle');
        if (resourcesDropdownEl && !resourcesDropdownEl.contains(event.target) &&
            resourcesToggleEl && !resourcesToggleEl.contains(event.target)) {
          this.desktopDropdownOpen = false;
        }
      }
    },
    // --- END: Navigation Bar Methods ---

    // --- START: Status Page Methods ---
    formatDate(dateString) {
      if (!dateString) return 'N/A';
      const options = { year: 'numeric', month: 'long', day: 'numeric', hour: '2-digit', minute: '2-digit' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },
    getStatusClass(status) {
      switch (status) {
        case 'Pending': return 'status-pending';
        case 'Accepted': return 'status-accepted';
        case 'Rejected': return 'status-rejected';
        case 'Canceled': return 'status-canceled';
        default: return 'status-unknown';
      }
    },
    getStatusIcon(status) {
      switch (status) {
        case 'Pending': return '🟡';
        case 'Accepted': return '🟢';
        case 'Rejected': return '🔴';
        case 'Canceled': return '⚪';
        default: return '❓';
      }
    },
    cancelApplication(applicationId) {
      const appIndex = this.applications.findIndex(app => app.id === applicationId);
      if (appIndex !== -1 && this.applications[appIndex].status === 'Pending') {
        if (confirm(`Are you sure you want to cancel application ${applicationId} for ${this.applications[appIndex].pet.name}?`)) {
          this.applications[appIndex].status = 'Canceled';
          this.applications[appIndex].statusUpdatedDate = new Date().toISOString();
          this.applications[appIndex].remarks = 'Application canceled by user.';
          alert(`Application ${applicationId} has been canceled.`);
          // In a real app: this.$emit('application-canceled', applicationId) or call an API
        }
      } else {
        alert('This application cannot be canceled or was not found.');
      }
    },
    contactShelter(applicationId) {
      const app = this.applications.find(app => app.id === applicationId);
      if (app) {
        alert(`To finalize the adoption for ${app.pet.name} (Application ${applicationId}), please contact the PAWFECT shelter at:\n\nEmail: contact@pawfect.org\nPhone: (555) 123-4567\n\nPlease have your Application ID ready.`);
      }
    }
    // --- END: Status Page Methods ---
  }
};
</script>

<style>
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
}
:root {
  --theme-color: #F9A826;
  --theme-color-transparent: rgba(249, 168, 38, 0.95);
  --text-light: white;
  --text-dark: #333;
  --card-bg: #ffffff;
  --card-shadow: rgba(0, 0, 0, 0.1);
  --border-color: #e0e0e0;
}

body {
  background-color: #f9f9f9; /* Light background for the page */
  color: var(--text-dark);
  line-height: 1.6;
}

.nav-container {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: var(--theme-color);
  padding: 0.75rem 2rem;
  color: var(--text-light);
  position: sticky;
  top: 0;
  left: 0;
  right: 0;
  width: 100%;
  z-index: 1000;
  transition: all 0.3s ease;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.nav-scrolled {
  padding: 0.5rem 2rem;
  background-color: var(--theme-color-transparent);
  backdrop-filter: blur(10px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.logo-container {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.logo-image {
  display: flex;
  align-items: center;
  justify-content: center;
  transition: transform 0.3s ease;
}

.logo-container:hover .logo-image {
  transform: scale(1.1) rotate(5deg);
}

.logo-text {
  font-size: 1.75rem;
  font-weight: 800;
  letter-spacing: 1.5px;
  color: var(--text-light);
  text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
  transition: transform 0.3s ease;
}

.logo-container:hover .logo-text {
  transform: translateX(3px);
}

.nav-links-container {
  flex: 1;
  display: flex;
  justify-content: center;
}

.nav-links {
  display: flex;
  gap: 2rem;
  align-items: center;
}

.nav-link {
  color: var(--text-light);
  text-decoration: none;
  font-size: 1.1rem;
  font-weight: 600;
  position: relative;
  padding: 0.5rem 0;
  transition: all 0.2s ease;
}

.nav-link:after {
  content: '';
  position: absolute;
  width: 0;
  height: 2px;
  bottom: 0;
  left: 0;
  background-color: var(--text-light);
  transition: width 0.3s ease;
}

.nav-link:hover:after {
  width: 100%;
}

.dropdown {
  position: relative;
}

.dropdown-arrow {
  font-size: 0.7rem;
  vertical-align: middle;
  margin-left: 4px;
  transition: transform 0.3s ease;
}

.arrow-rotated {
  transform: rotate(180deg);
}

.dropdown-content {
  min-width: 180px;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
  border-radius: 8px;
  overflow: hidden;
  z-index: 1;
}

.dropdown-content.desktop {
  position: absolute;
  top: 100%;
  left: 50%;
  transform: translateX(-50%);
  margin-top: 0.75rem;
  background-color: var(--card-bg);
  z-index: 1001;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
  border-radius: 8px;
}

.dropdown-content.desktop-active {
  animation: dropdownIn 0.3s ease-out forwards;
}

.dropdown-content a {
  padding: 0.75rem 1rem;
  text-decoration: none;
  display: block;
  transition: all 0.2s ease;
}

.dropdown-content.desktop a {
  color: var(--text-dark);
  font-weight: 500;
}

.dropdown-content.desktop a:hover {
  background-color: #f8f8f8;
  padding-left: 1.25rem;
}

.dropdown-content.mobile {
  background-color: rgba(255, 255, 255, 0.1);
  border-radius: 8px;
  margin-top: 0.5rem;
}

.dropdown-content.mobile a {
  color: var(--text-light);
  padding: 0.75rem 1.5rem;
  border-bottom: 1px solid rgba(255, 255, 255, 0.1);
}

.dropdown-content.mobile a:last-child {
  border-bottom: none;
}

.right-section {
  display: flex;
  align-items: center;
  gap: 1.5rem;
}

.user-dropdown {
  position: relative;
}

.user-icon {
  color: var(--text-light);
  cursor: pointer;
  width: 36px;
  height: 36px;
  background-color: rgba(255, 255, 255, 0.2);
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.3s ease;
}

.user-icon:hover {
  transform: scale(1.1);
  background-color: rgba(255, 255, 255, 0.3);
}

.user-dropdown-content {
  position: absolute;
  top: calc(100% + 0.5rem);
  right: 0;
  background-color: var(--card-bg);
  min-width: 220px;
  max-width: 90vw;
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
  border-radius: 12px;
  overflow: hidden;
  z-index: 1001;
  border: 1px solid rgba(0, 0, 0, 0.08);
}

.dropdown-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 0.75rem 1rem;
  background-color: #f8f8f8;
  border-bottom: 1px solid rgba(0, 0, 0, 0.08);
}

.dropdown-header span {
  font-weight: 600;
  color: var(--text-dark);
}

.close-dropdown-btn {
  background: transparent;
  border: none;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  width: 28px;
  height: 28px;
  border-radius: 50%;
  color: #666;
  transition: all 0.2s ease;
}

.close-dropdown-btn:hover {
  background-color: rgba(0, 0, 0, 0.05);
  color: var(--text-dark);
}

.user-dropdown-content a {
  color: var(--text-dark);
  padding: 0.9rem 1.2rem;
  text-decoration: none;
  display: block;
  font-weight: 500;
  transition: all 0.2s ease;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.user-dropdown-content a:last-child {
  border-bottom: none;
}

.user-dropdown-content a:hover {
  background-color: #f8f8f8;
  padding-left: 1.5rem;
}

.user-dropdown-content.mobile-dropdown {
  position: absolute;
  width: auto;
  min-width: 220px;
  max-width: 90vw;
}

.dropdown-animation-enter-active {
  animation: dropdownIn 0.3s ease-out forwards;
}

.dropdown-animation-leave-active {
  animation: dropdownOut 0.3s ease-in forwards;
}

@keyframes dropdownIn {
  0% {
    opacity: 0;
    transform: translateY(-10px);
  }
  60% {
    transform: translateY(5px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

@keyframes dropdownOut {
  0% {
    opacity: 1;
    transform: translateY(0);
  }
  100% {
    opacity: 0;
    transform: translateY(-10px);
  }
}

.resources-dropdown-enter-active {
  animation: dropdownResourcesIn 0.3s ease-out forwards;
}
.resources-dropdown-leave-active {
  animation: dropdownResourcesOut 0.3s ease-in forwards;
}

@keyframes dropdownResourcesIn {
  0% { opacity: 0; transform: translateY(-10px) translateX(-50%); }
  60% { transform: translateY(5px) translateX(-50%); }
  100% { opacity: 1; transform: translateY(0) translateX(-50%); }
}

@keyframes dropdownResourcesOut {
  0% { opacity: 1; transform: translateY(0) translateX(-50%); }
  100% { opacity: 0; transform: translateY(-10px) translateX(-50%); }
}


.mobile-menu-toggle {
  display: none;
  flex-direction: column;
  justify-content: space-between;
  width: 28px;
  height: 20px;
  background: transparent;
  border: none;
  cursor: pointer;
  padding: 0;
  z-index: 10;
}

.bar {
  height: 3px;
  width: 100%;
  background-color: var(--text-light);
  border-radius: 10px;
  transition: all 0.3s ease-in-out;
}

.bar-1-active {
  transform: translateY(8px) rotate(45deg);
}

.bar-2-active {
  opacity: 0;
}

.bar-3-active {
  transform: translateY(-8px) rotate(-45deg);
}

.fade-enter-active, .fade-leave-active {
  transition: opacity 0.3s ease;
}
.fade-enter-from, .fade-leave-to {
  opacity: 0;
}

.slide-fade-enter-active, .slide-fade-leave-active {
  transition: all 0.3s ease;
}
.slide-fade-enter-from, .slide-fade-leave-to {
  transform: translateY(-20px);
  opacity: 0;
}

@media (max-width: 900px) {
  .nav-links {
    gap: 1.5rem;
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
    left: -100%;
    width: 100%;
    height: 100vh;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    background-color: var(--theme-color);
    padding: 2rem;
    gap: 1.5rem;
    z-index: 5;
    transition: transform 0.3s ease-in-out;
    overflow-y: auto;
    padding-top: 5rem;
  }
  .nav-links.mobile-active {
    transform: translateX(100%);
  }
  .nav-link {
    font-size: 1.3rem;
  }
  .nav-link:after {
    height: 3px;
  }
}

@media (max-width: 480px) {
  .nav-container { padding: 0.75rem 1rem; }
  .logo-text { font-size: 1.3rem; }
  .user-icon { width: 32px; height: 32px; }
  .nav-links { padding: 1.5rem; gap: 1.25rem; }
}

@media (max-width: 320px) {
  .nav-container { padding: 0.75rem 0.5rem; }
  .logo-text { font-size: 1.1rem; }
  .right-section { gap: 0.75rem; }
  .user-dropdown-content { min-width: 200px; }
}

@media (max-width: 245px) {
  .logo-text { font-size: 0.9rem; }
  .user-icon { width: 28px; height: 28px; }
  .nav-container { padding: 0.5rem 0.25rem; }
  .user-dropdown-content { min-width: 180px; right: -20px;  }
}
/* --- END: Navigation Bar Styles --- */

/* --- START: Status Page Styles --- */
.status-page-container {
  padding: 2rem;
  max-width: 1200px;
  margin: 2rem auto;
  background-color: #f0f2f5;
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.08);
}

.status-page-title {
  text-align: center;
  font-size: 2.5rem;
  color: var(--theme-color);
  margin-bottom: 2rem;
  font-weight: 700;
  letter-spacing: 1px;
}

.no-applications {
  text-align: center;
  font-size: 1.2rem;
  color: #666;
  padding: 2rem;
  background-color: var(--card-bg);
  border-radius: 8px;
  box-shadow: var(--card-shadow);
}

.applications-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); /* Responsive grid */
  gap: 1.5rem; /* Space between cards */
}

.application-card {
  background-color: var(--card-bg);
  border-radius: 10px;
  box-shadow: 0 5px 15px var(--card-shadow);
  padding: 1.5rem;
  display: flex;
  flex-direction: column;
  transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
  border: 1px solid var(--border-color);
}

.application-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.12);
}

.card-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 1rem;
  border-bottom: 1px solid var(--border-color);
  padding-bottom: 0.75rem;
}

.application-id {
  font-size: 0.9rem;
  color: #555;
  font-weight: 600;
}

.status-badge {
  padding: 0.4em 0.8em;
  border-radius: 20px;
  font-size: 0.9rem;
  font-weight: 600;
  color: var(--text-light);
  display: inline-flex;
  align-items: center;
  gap: 0.4em;
}

.status-pending { background-color: #ffc107; color: #333; /* Yellow */ }
.status-accepted { background-color: #28a745; /* Green */ }
.status-rejected { background-color: #dc3545; /* Red */ }
.status-canceled { background-color: #6c757d; /* Gray */ }
.status-unknown { background-color: #adb5bd; /* Light Gray */ }


.pet-info-container {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}

.pet-photo-thumbnail {
  width: 80px;
  height: 80px;
  border-radius: 8px;
  object-fit: cover;
  border: 2px solid var(--border-color);
}

.pet-details {
  flex-grow: 1;
}

.pet-name {
  font-size: 1.5rem;
  font-weight: 700;
  color: var(--theme-color);
  margin-bottom: 0.25rem;
}

.pet-meta {
  font-size: 0.95rem;
  color: #777;
}

.application-details p {
  font-size: 0.95rem;
  color: #555;
  margin-bottom: 0.5rem;
  line-height: 1.5;
}

.application-details p strong {
  color: var(--text-dark);
}

.remarks-section {
  margin-top: 1rem;
  padding: 0.75rem;
  background-color: #f8f9fa;
  border-radius: 6px;
  border-left: 4px solid var(--theme-color);
}

.remarks-section h4 {
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 0.3rem;
  color: var(--theme-color);
}

.remarks-section p {
  font-size: 0.9rem;
  color: #444;
  line-height: 1.5;
}

.action-buttons {
  margin-top: auto;
  padding-top: 1rem;
  display: flex;
  gap: 0.75rem;
  justify-content: flex-end;
  border-top: 1px solid var(--border-color);
}

.btn {
  padding: 0.6rem 1.2rem;
  border: none;
  border-radius: 6px;
  font-size: 0.9rem;
  font-weight: 600;
  cursor: pointer;
  transition: background-color 0.2s ease, transform 0.1s ease;
  text-transform: uppercase;
  letter-spacing: 0.5px;
}

.btn:hover {
  transform: translateY(-2px);
}

.btn-cancel {
  background-color: #ff6b6b; /* A soft red */
  color: white;
}
.btn-cancel:hover {
  background-color: #ee5253;
}
.btn-cancel:disabled {
  background-color: #ced4da;
  color: #6c757d;
  cursor: not-allowed;
  transform: none;
}

.btn-contact {
  background-color: var(--theme-color);
  color: white;
}
.btn-contact:hover {
  background-color: #e09316;
}

@media (max-width: 768px) {
  .status-page-container {
    padding: 1.5rem;
    margin: 1rem;
  }
  .status-page-title {
    font-size: 2rem;
  }
  .applications-grid {
    grid-template-columns: 1fr;
    gap: 1rem;
  }
  .pet-photo-thumbnail {
    width: 70px;
    height: 70px;
  }
  .pet-name {
    font-size: 1.3rem;
  }
  .action-buttons {
    flex-direction: column;
  }
  .btn {
    width: 100%;
    text-align: center;
  }
}

@media (max-width: 480px) {
  .status-page-container {
    padding: 1rem;
    margin: 0.5rem;
    border-radius: 8px;
  }
  .status-page-title {
    font-size: 1.8rem;
    margin-bottom: 1.5rem;
  }
  .application-card {
    padding: 1rem;
  }
  .card-header {
    flex-direction: column;
    align-items: flex-start;
    gap: 0.5rem;
  }
  .status-badge {
    align-self: flex-start;
  }
  .pet-info-container {
    flex-direction: column;
    align-items: flex-start;
    text-align: left;
  }
  .pet-photo-thumbnail {
    width: 100%;
    height: 150px;
    margin-bottom: 0.5rem;
  }
}
</style>
