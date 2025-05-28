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
          <li><router-link to="/contact" @click="closeAllDropdowns"><i class="fas fa-envelope icon-fix"></i><span>Contact</span></router-link></li>
         
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

    <!-- Training Tips Content -->
    <div class="training-container">
      <div class="tab-container">
        <button
          class="tab-button"
          :class="{ active: activeTab === 'cats' }"
          @click="activeTab = 'cats'"
        >
          <span class="emoji">🐱</span> Cat Training
        </button>
        <button
          class="tab-button"
          :class="{ active: activeTab === 'dogs' }"
          @click="activeTab = 'dogs'"
        >
          <span class="emoji">🐶</span> Dog Training
        </button>
      </div>

      <!-- Cat Training Section -->
      <div v-if="activeTab === 'cats'" class="training-content">
        <div class="pet-header">
          <h1>🐱 Training Tips for Cats</h1>
        </div>

        <div class="age-section">
          <h2>🐾 Kittens (8 weeks – 1 year)</h2>

          <div class="tip-card">
            <h3>1. Litter Box Training</h3>
            <ul>
              <li><strong>What to do</strong>: Place the litter box in a quiet area. Show your kitten the box after meals and naps.</li>
              <li><strong>Tip</strong>: Use unscented, clumping litter. Scoop daily and fully clean weekly.</li>
              <li><strong>Mistakes?</strong> Never punish. Gently place them in the box after accidents.</li>
            </ul>
          </div>

          <div class="tip-card">
            <h3>2. Scratching Furniture</h3>
            <ul>
              <li><strong>Why they do it</strong>: Scratching is natural—it sharpens claws, marks territory, and stretches muscles.</li>
              <li><strong>What to do</strong>: Provide scratching posts (both vertical and horizontal types).</li>
              <li><strong>Training tip</strong>: Rub catnip on the post or use dangling toys to attract them. Place it near the furniture they scratch.</li>
              <li><strong>Stop damage</strong>: Use double-sided tape or a pet-safe deterrent spray on furniture. Trim nails regularly or use soft nail caps.</li>
            </ul>
          </div>

          <div class="tip-card">
            <h3>3. Play Biting and Clawing</h3>
            <ul>
              <li><strong>What to do</strong>: Use wand toys or balls—not hands—for play.</li>
              <li><strong>Redirect</strong>: If they bite or claw you, stop play immediately. Resume after a minute of calm behavior.</li>
            </ul>
          </div>

          <div class="tip-card">
            <h3>4. Handling and Socialization</h3>
            <ul>
              <li>Gently hold and touch their paws, ears, and mouth daily to get them used to grooming and vet checks.</li>
              <li>Invite calm guests over to help socialize them with people.</li>
            </ul>
          </div>
        </div>

        <div class="age-section">
          <h2>🐾 Adult and Senior Cats</h2>

          <div class="tip-card">
            <h3>1. Reducing Stress</h3>
            <ul>
              <li>New homes can be overwhelming. Give them a small space (like a quiet room) for the first few days.</li>
              <li>Use calming pheromone diffusers (e.g., Feliway) to reduce anxiety.</li>
            </ul>
          </div>

          <div class="tip-card">
            <h3>2. Litter Box Issues</h3>
            <ul>
              <li>Make sure there's <strong>one box per cat plus one extra</strong>.</li>
              <li>Clean daily, and avoid scented litters.</li>
              <li>If accidents happen outside the box, consult a vet to rule out medical issues.</li>
            </ul>
          </div>

          <div class="tip-card">
            <h3>3. Scratching Habits</h3>
            <ul>
              <li>Cats scratch more when stressed or bored. Use <strong>interactive toys</strong> and <strong>cat trees</strong>.</li>
              <li>Offer rewards (treats, pets) when they scratch appropriate items.</li>
            </ul>
          </div>

          <div class="tip-card">
            <h3>4. Training with Treats</h3>
            <ul>
              <li>Yes, cats can be trained! Use <strong>treats and clicker training</strong> to teach simple commands like "come" or "high five."</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Dog Training Section -->
      <div v-if="activeTab === 'dogs'" class="training-content">
        <div class="pet-header">
          <h1>🐶 Training Tips for Dogs</h1>
        </div>

        <div class="age-section">
          <h2>🐾 Puppies (8 weeks – 1 year)</h2>

          <div class="tip-card">
            <h3>1. House Training (Potty)</h3>
            <ul>
              <li><strong>Routine</strong>: Take them outside every 1–2 hours and after eating/playing.</li>
              <li><strong>Praise</strong>: Reward with treats immediately after they go outside.</li>
              <li><strong>Accidents?</strong> Never scold. Clean with an enzyme cleaner to remove odor.</li>
            </ul>
          </div>

          <div class="tip-card">
            <h3>2. Crate Training</h3>
            <ul>
              <li>Crates help with housebreaking and provide a safe space.</li>
              <li>Use it for naps and bedtime. Never use it as punishment.</li>
              <li>Make it cozy with a blanket and a chew toy.</li>
            </ul>
          </div>

          <div class="tip-card">
            <h3>3. Basic Commands</h3>
            <ul>
              <li>Start with: Sit, Stay, Come, Down.</li>
              <li>Use treats and repeat in short sessions (5–10 mins).</li>
              <li>Be consistent—use the same words each time.</li>
            </ul>
          </div>

          <div class="tip-card">
            <h3>4. Leash Walking</h3>
            <ul>
              <li>Use a short leash and start in a quiet area.</li>
              <li>Stop walking when they pull; move only when the leash is loose.</li>
              <li>Praise when they walk beside you calmly.</li>
            </ul>
          </div>
        </div>

        <div class="age-section">
          <h2>🐾 Adult and Senior Dogs</h2>

          <div class="tip-card">
            <h3>1. Breaking Bad Habits</h3>
            <ul>
              <li><strong>Jumping on people</strong>: Ignore and turn away. Reward only when they sit calmly.</li>
              <li><strong>Chewing</strong>: Provide chew toys. Redirect when they chew on furniture or shoes.</li>
              <li><strong>Barking</strong>: Identify the cause (boredom, fear, excitement) and train accordingly. Reward quiet behavior.</li>
            </ul>
          </div>

          <div class="tip-card">
            <h3>2. Obedience Refresh</h3>
            <ul>
              <li>Reinforce sit, stay, and come commands.</li>
              <li>Add new tricks to keep their brain active.</li>
            </ul>
          </div>

          <div class="tip-card">
            <h3>3. Fear or Anxiety</h3>
            <ul>
              <li>Newly adopted dogs may fear loud noises, stairs, or certain people.</li>
              <li>Build trust with gentle voice, slow movements, and lots of positive reinforcement.</li>
            </ul>
          </div>

          <div class="tip-card">
            <h3>4. Exercise Needs</h3>
            <ul>
              <li>Adult dogs need regular walks and playtime.</li>
              <li>Senior dogs benefit from shorter, gentler walks to keep joints flexible.</li>
            </ul>
          </div>
        </div>
      </div>

      <div class="bonus-section">
        <h2>✨ Bonus Tips</h2>
        <div class="tip-card bonus">
          <ul>
            <li><strong>Consistency is key</strong>: Everyone in the household should use the same rules and commands.</li>
            <li><strong>Patience pays off</strong>: Some pets take weeks or even months to fully adjust to a new home.</li>
            <li><strong>Build trust first</strong>: Especially for rescue animals—bonding comes before obedience.</li>
          </ul>
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
        <li><a href="home">Home</a></li>
        <li><a href="pet-profiles">Pet Profiles</a></li>
        <li><a href="training">Resources</a></li>
        <li><a href="donations">Donate</a></li>
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
      activeTab: 'cats'
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

/* Keep existing training content styles */
.training-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: calc(var(--nav-height) + 2rem) 1.5rem 2rem;
  animation: fadeIn 0.8s ease-in;
}

.tab-container {
  display: flex;
  justify-content: center;
  gap: 1rem;
  margin-bottom: 2rem;
  flex-wrap: wrap;
}

.tab-button {
  padding: 0.75rem 1.5rem;
  background-color: #f5f5f5;
  border: none;
  border-radius: 50px;
  font-size: 1.1rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
}

.tab-button.active {
  background-color: #F9A826;
  color: white;
  box-shadow: 0 4px 15px rgba(249, 168, 38, 0.4);
  transform: scale(1.05);
}

.tab-button:hover:not(.active) {
  background-color: #ececec;
  transform: translateY(-2px);
}

.emoji {
  font-size: 1.3rem;
}

.pet-header {
  text-align: center;
  margin-bottom: 2rem;
}

.pet-header h1 {
  font-size: 2.5rem;
  color: #333;
  display: inline-block;
  padding-bottom: 0.5rem;
  border-bottom: 3px solid #F9A826;
  transition: all 0.3s ease;
}

.pet-header h1:hover {
  color: #F9A826;
  letter-spacing: 1px;
}

.age-section {
  margin-bottom: 3rem;
  animation: fadeIn 0.6s ease-in;
}

.tip-card {
  background-color: white;
  border-radius: 15px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
  margin-bottom: 2rem;
  padding: 1.75rem;
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  border-left: 6px solid #F9A826;
}

.tip-card:hover {
  transform: scale(1.02);
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.tip-card h3 {
  color: #F9A826;
  font-size: 1.5rem;
  margin-bottom: 1.2rem;
}

.tip-card ul {
  list-style: none;
  padding-left: 0;
}

.tip-card li {
  position: relative;
  padding-left: 2rem;
  margin-bottom: 0.9rem;
  line-height: 1.7;
  font-size: 1.05rem;
  transition: color 0.3s;
}

.tip-card li::before {
  content: '✨';
  position: absolute;
  left: 0;
  top: 0;
  font-size: 1.1rem;
  transition: transform 0.3s;
}

.tip-card li:hover {
  color: #F9A826;
}

.tip-card li:hover::before {
  transform: rotate(15deg) scale(1.2);
}

.bonus-section {
  background: linear-gradient(to right, #fff8e6, #fff3cc);
  padding: 2.5rem;
  border-radius: 15px;
  margin-top: 2.5rem;
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.05);
  animation: fadeIn 1s ease-in;
}

.bonus-section h2 {
  text-align: center;
  margin-bottom: 1.5rem;
  color: #333;
  font-size: 1.9rem;
  font-weight: 700;
}

.tip-card.bonus {
  background-color: #fffaf0;
  border-left: 6px solid #F9A826;
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
  max-width: 150px;
  height: auto;
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
</style>
