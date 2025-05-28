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

    <!-- Profile Container -->
    <main class="profile-container">
      <div class="profile-header">
        <h2 class="welcome-message">Welcome! {{ userProfile.name }}!</h2>
        <div class="user-info">
          <div class="profile-picture">
            <img :src="userProfile.avatar || 'data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' width=\'150\' height=\'150\'><circle cx=\'12\' cy=\'8\' r=\'4\' stroke=\'black\' stroke-width=\'2\' fill=\'none\'/><path d=\'M4 20c0-4 4-6 8-6s8 2 8 6\' stroke=\'black\' stroke-width=\'2\' fill=\'none\'/></svg>'" alt="Profile Picture">
          </div>
          <div class="user-details">
            <h1>{{ userProfile.name }}</h1>
            <p class="email">{{ userProfile.email }}</p>
            <button class="edit-profile-btn" @click="handleEditProfile">
              <i class="fas fa-edit"></i> Edit Profile
            </button>
          </div>
        </div>
      </div>
    </main>

    <!-- Status Container -->
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
              {{ app.status }}
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
            <button
              v-if="app.status === 'Canceled' || app.status === 'Rejected'"
              @click="deleteApplication(app.id)"
              class="btn btn-cancel">
              Delete
            </button>
          </div>
        </div>
      </div>
    </main>

    <!-- Edit Profile Modal -->
    <div v-if="showEditModal" class="modal-overlay" @click.self="closeEditModal">
      <div class="modal">
        <h2>Edit Profile</h2>
        <form @submit.prevent="updateProfile">
          <div class="profile-edit-avatar">
            <div class="avatar-preview">
              <img :src="editForm.avatar || 'data:image/svg+xml;utf8,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 24 24\' width=\'150\' height=\'150\'><circle cx=\'12\' cy=\'8\' r=\'4\' stroke=\'black\' stroke-width=\'2\' fill=\'none\'/><path d=\'M4 20c0-4 4-6 8-6s8 2 8 6\' stroke=\'black\' stroke-width=\'2\' fill=\'none\'/></svg>'" alt="Profile Picture">
            </div>
            <div class="edit-avatar-btn-beside-wrapper">
              <button type="button" class="edit-avatar-btn-beside" @click="openCamera">
                <i class="fas fa-camera"></i>
              </button>
              <button type="button" class="edit-avatar-btn-beside" @click="triggerGalleryUpload">
                <i class="fas fa-image"></i>
              </button>
              <input
                type="file"
                ref="galleryInput"
                accept="image/*"
                style="display: none"
                @change="handleGalleryChange"
              >
            </div>
          </div>
          <div class="form-group">
            <label for="name">Full Name</label>
            <input
              type="text"
              id="name"
              v-model="editForm.name"
              required
            >
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input
              type="email"
              id="email"
              v-model="editForm.email"
              required
            >
          </div>
          <div class="form-actions">
            <button type="button" class="cancel-btn" @click="closeEditModal">Cancel</button>
            <button type="submit" class="save-btn">Save Changes</button>
          </div>
        </form>
      </div>
    </div>

    <!-- Camera Modal -->
    <div v-if="showCameraModal" class="modal-overlay" @click.self="closeCamera">
      <div class="modal camera-modal">
        <h2>Take Profile Picture</h2>
        <div class="camera-container">
          <video ref="video" autoplay playsinline></video>
          <canvas ref="canvas" style="display: none;"></canvas>
        </div>
        <div class="camera-actions">
          <button class="cancel-btn" @click="closeCamera">Cancel</button>
          <button class="capture-btn" @click="capturePhoto">
            <i class="fas fa-camera"></i> Capture
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AdoptionStatusPage',
  data() {
    return {
      // Navigation Data
      sidebarOpen: false,
      showResourcesDropdown: false,
      showUserDropdown: false,
      showMobileResourcesDropdown: false,
      showMobileUserDropdown: false,
      isTablet: false,
      isTouch: false,

      // User Profile Data
      userProfile: {
        name: '',
        email: '',
        avatar: null
      },

      // Edit Modal Data
      showEditModal: false,
      editForm: {
        name: '',
        email: '',
        avatar: null
      },

      // Status Page Data
      applications: [
        {
          id: 'APP-2025-001',
          pet: {
            name: 'Badi',
            photoUrl: 'ridley.png',
            breed: 'Persian',
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
            photoUrl: '/Img/cat3.jpg',
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
            photoUrl: '/Img/dog5.jpg',
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
            photoUrl: '/Img/dog7.png',
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
            photoUrl: '/Img/dog1.png',
            breed: 'Golden Retriever',
            age: '4 years old',
          },
          dateOfApplication: '2025-05-16T11:00:00Z',
          status: 'Pending',
          statusUpdatedDate: '2025-05-17T09:00:00Z',
          remarks: 'Awaiting home visit scheduling.',
        },
      ],

      // Camera Data
      showCameraModal: false,
      stream: null,
    };
  },
  mounted() {
    window.addEventListener('resize', this.handleResizeSidebar);
    this.checkTablet();
    this.checkTouch();
    window.addEventListener('resize', this.checkTablet);
    window.addEventListener('resize', this.checkTouch);
    document.addEventListener('click', this.handleDocumentClick);
    document.addEventListener('keydown', this.handleKeydown);

    // Get user data from localStorage
    const userData = localStorage.getItem('user');
    if (userData) {
      const user = JSON.parse(userData);
      this.userProfile = {
        name: user.name,
        email: user.email,
        avatar: user.avatar || null
      };
    } else {
      // If no user data found, redirect to login
      this.$router.push('/login');
    }
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.handleResizeSidebar);
    window.removeEventListener('resize', this.checkTablet);
    window.removeEventListener('resize', this.checkTouch);
    document.removeEventListener('click', this.handleDocumentClick);
    document.removeEventListener('keydown', this.handleKeydown);

    // Clean up camera stream when component is destroyed
    if (this.stream) {
      this.stream.getTracks().forEach(track => track.stop());
    }
  },
  methods: {
    // Navigation Methods
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
      // Clear user data from localStorage
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      localStorage.removeItem('rememberedEmail');

      // Redirect to login page
      this.$router.push('/login');
    },

    // Status Page Methods
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
    cancelApplication(applicationId) {
      const appIndex = this.applications.findIndex(app => app.id === applicationId);
      if (appIndex !== -1 && this.applications[appIndex].status === 'Pending') {
        if (confirm(`Are you sure you want to cancel application ${applicationId} for ${this.applications[appIndex].pet.name}?`)) {
          this.applications[appIndex].status = 'Canceled';
          this.applications[appIndex].statusUpdatedDate = new Date().toISOString();
          this.applications[appIndex].remarks = 'Application canceled by user.';
          alert(`Application ${applicationId} has been canceled.`);
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
    },
    deleteApplication(applicationId) {
      const idx = this.applications.findIndex(app => app.id === applicationId);
      if (idx !== -1) {
        if (confirm('Are you sure you want to permanently delete this canceled application?')) {
          this.applications.splice(idx, 1);
        }
      }
    },
    handleEditProfile() {
      this.editForm = { ...this.userProfile };
      this.showEditModal = true;
    },
    closeEditModal() {
      this.showEditModal = false;
    },
    updateProfile() {
      this.userProfile = { ...this.editForm };
      this.showEditModal = false;
      // Here you would typically make an API call to update the profile
      alert('Profile updated successfully');
    },
    async openCamera() {
      try {
        this.stream = await navigator.mediaDevices.getUserMedia({
          video: {
            facingMode: 'user',
            width: { ideal: 1280 },
            height: { ideal: 720 }
          }
        });
        this.showCameraModal = true;
        this.$nextTick(() => {
          const video = this.$refs.video;
          video.srcObject = this.stream;
        });
      } catch (err) {
        console.error('Error accessing camera:', err);
        alert('Unable to access camera. Please make sure you have granted camera permissions.');
      }
    },
    closeCamera() {
      if (this.stream) {
        this.stream.getTracks().forEach(track => track.stop());
        this.stream = null;
      }
      this.showCameraModal = false;
    },
    capturePhoto() {
      const video = this.$refs.video;
      const canvas = this.$refs.canvas;
      const context = canvas.getContext('2d');

      // Set canvas dimensions to match video
      canvas.width = video.videoWidth;
      canvas.height = video.videoHeight;

      // Draw the current video frame on the canvas
      context.drawImage(video, 0, 0, canvas.width, canvas.height);

      // Convert canvas to data URL
      const imageDataUrl = canvas.toDataURL('image/jpeg', 0.8);

      // Update profile picture in edit form
      this.editForm.avatar = imageDataUrl;

      // Close camera
      this.closeCamera();
    },
    triggerGalleryUpload() {
      this.$refs.galleryInput.click();
    },
    handleGalleryChange(event) {
      const file = event.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
          this.editForm.avatar = e.target.result;
        };
        reader.readAsDataURL(file);
      }
    },
  }
};
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

.dropdown-menu,
.user-dropdown-menu,
.dropdown-item,
.dropdown-menu li a,
.user-dropdown-menu li a {
  box-shadow: none !important;
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

/* Status Page Styles */
.status-page-container {
  padding: 2rem;
  max-width: 1200px;
  margin: 2rem auto;
  background-color: #f0f2f5;
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  margin-top: calc(var(--nav-height) + 2rem);
}

.status-page-title {
  text-align: center;
  font-size: 2.5rem;
  color: var(--primary-color);
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
  grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
  gap: 1.5rem;
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

.status-pending { background-color: #ffc107; color: #333; }
.status-accepted { background-color: #28a745; }
.status-rejected { background-color: #dc3545; }
.status-canceled { background-color: #6c757d; }
.status-unknown { background-color: #adb5bd; }

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
  color: var(--primary-color);
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
  border-left: 4px solid var(--primary-color);
}

.remarks-section h4 {
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 0.3rem;
  color: var(--primary-color);
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
  background-color: #ff6b6b;
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
  background-color: var(--primary-color);
  color: white;
}

.btn-contact:hover {
  background-color: #e09316;
}

/* Responsive Styles for Status Page */
@media (max-width: 1200px) {
  .status-page-container {
    margin: 1.5rem;
    padding: 1.5rem;
  }
}

@media (max-width: 992px) {
  .status-page-container {
    margin: 1rem;
    padding: 1.25rem;
  }

  .status-page-title {
    font-size: 2.2rem;
  }

  .applications-grid {
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.25rem;
  }
}

@media (max-width: 768px) {
  .status-page-container {
    margin: 0.75rem;
    padding: 1rem;
    border-radius: 8px;
  }

  .status-page-title {
    font-size: 2rem;
    margin-bottom: 1.5rem;
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
    margin: 0.5rem;
    padding: 0.75rem;
    border-radius: 6px;
  }

  .status-page-title {
    font-size: 1.8rem;
    margin-bottom: 1.25rem;
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

  .pet-details {
    width: 100%;
  }

  .application-details p {
    font-size: 0.9rem;
  }

  .remarks-section {
    padding: 0.5rem;
  }

  .remarks-section h4 {
    font-size: 0.95rem;
  }

  .remarks-section p {
    font-size: 0.85rem;
  }
}

@media (max-width: 320px) {
  .status-page-container {
    margin: 0.25rem;
    padding: 0.5rem;
  }

  .status-page-title {
    font-size: 1.6rem;
    margin-bottom: 1rem;
  }

  .application-card {
    padding: 0.75rem;
  }

  .pet-photo-thumbnail {
    height: 120px;
  }

  .pet-name {
    font-size: 1.2rem;
  }

  .pet-meta {
    font-size: 0.85rem;
  }

  .application-details p {
    font-size: 0.85rem;
  }

  .btn {
    padding: 0.5rem 1rem;
    font-size: 0.85rem;
  }
}

/* Profile Container Styles */
.profile-container {
  padding: 2rem;
  max-width: 1200px;
  margin: 2rem auto;
  background-color: #f0f2f5;
  border-radius: 12px;
  box-shadow: 0 8px 25px rgba(0,0,0,0.08);
  margin-top: calc(var(--nav-height) + 2rem);
}

.profile-header {
  background: #fff;
  border-radius: 12px;
  padding: 2rem;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.welcome-message {
  font-size: 1.5rem;
  font-weight: 700;
  color: #f7871f;
  margin-bottom: 1rem;
}

.user-info {
  display: flex;
  align-items: center;
  gap: 2rem;
}

.profile-picture {
  position: relative;
  width: 120px;
  height: 120px;
}

.profile-picture img {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  object-fit: cover;
}

.edit-avatar {
  position: absolute;
  bottom: 0;
  right: 0;
  background: #f7871f;
  color: white;
  border: none;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: background-color 0.2s;
}

.edit-avatar:hover {
  background: #e67e00;
}

.user-details h1 {
  color: #222;
  font-size: 1.8rem;
  margin-bottom: 0.5rem;
}

.email {
  color: #666;
  margin-bottom: 1rem;
}

.edit-profile-btn {
  background: #f7871f;
  color: white;
  border: none;
  padding: 0.8rem 1.5rem;
  border-radius: 8px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  transition: background-color 0.2s;
}

.edit-profile-btn:hover {
  background: #e67e00;
}

@media (max-width: 768px) {
  .profile-container {
    margin: 1rem;
    padding: 1rem;
  }

  .user-info {
    flex-direction: column;
    text-align: center;
  }

  .profile-picture {
    margin: 0 auto;
  }

  .user-details {
    width: 100%;
  }

  .edit-profile-btn {
    margin: 0 auto;
  }
}

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100vw;
  height: 100vh;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal {
  background: #fff;
  border-radius: 12px;
  padding: 2rem;
  width: 90%;
  max-width: 500px;
}

.modal h2 {
  color: #222;
  margin-bottom: 1.5rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  color: #555;
  margin-bottom: 0.5rem;
}

.form-group input {
  width: 100%;
  padding: 0.8rem;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}

.save-btn {
  background: #f7871f;
  color: white;
  border: none;
  padding: 0.8rem 1.5rem;
  border-radius: 8px;
  cursor: pointer;
}

.save-btn:hover {
  background: #e67e00;
}

.cancel-btn {
  background: #f1f1f1;
  color: #666;
  border: none;
  padding: 0.8rem 1.5rem;
  border-radius: 8px;
  cursor: pointer;
}

.cancel-btn:hover {
  background: #e0e0e0;
}

/* Camera Modal Styles */
.camera-modal {
  max-width: 800px;
  width: 95%;
}

.camera-container {
  width: 100%;
  margin: 1rem 0;
  background: #000;
  border-radius: 8px;
  overflow: hidden;
  position: relative;
}

.camera-container video {
  width: 100%;
  height: auto;
  display: block;
}

.camera-actions {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-top: 1rem;
}

.capture-btn {
  background: #f7871f;
  color: white;
  border: none;
  padding: 0.8rem 1.5rem;
  border-radius: 8px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.capture-btn:hover {
  background: #e67e00;
}

.capture-btn i {
  font-size: 1.2rem;
}

@media (max-width: 768px) {
  .camera-modal {
    width: 100%;
    margin: 0;
    border-radius: 0;
  }

  .camera-container {
    border-radius: 0;
  }
}

/* Profile Edit Modal Styles */
.profile-edit-avatar {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
  margin-bottom: 2rem;
  position: relative;
  height: auto;
}

.avatar-preview {
  position: relative;
  width: 150px;
  height: 150px;
  border-radius: 50%;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.avatar-preview img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.edit-avatar-btn-beside-wrapper {
  display: flex;
  gap: 10px;
  margin-top: 16px;
}

.edit-avatar-btn-beside {
  background: #f7871f;
  color: white;
  border: none;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  transition: all 0.2s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  z-index: 2;
}

.edit-avatar-btn-beside:hover {
  background: #e67e00;
  transform: scale(1.1);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.3);
}

.edit-avatar-btn-beside:active {
  transform: scale(0.95);
}

.edit-avatar-btn-beside i {
  font-size: 1.2rem;
}

@media (max-width: 768px) {
  .avatar-preview {
    width: 120px;
    height: 120px;
  }
  .profile-edit-avatar {
    height: 135px;
  }
  .edit-avatar-btn-beside {
    width: 32px;
    height: 32px;
  }
  .edit-avatar-btn-beside:hover {
    transform: scale(1.1);
  }
  .edit-avatar-btn-beside:active {
    transform: scale(0.95);
  }
}
</style>