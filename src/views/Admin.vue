<template>
  <div class="admin-layout">
    <!-- Sidebar -->
    <aside class="admin-sidebar">
      <div class="sidebar-header">
        <h1 class="logo">PAWFECT</h1>
      </div>
      <nav class="sidebar-nav">
        <router-link to="/admin" class="nav-item" :class="{ active: $route.path === '/admin' }">
          <i class="fas fa-chart-line"></i>
          <span>Dashboard</span>
        </router-link>
        <router-link to="/admin/pets" class="nav-item" :class="{ active: $route.path === '/admin/pets' }">
          <i class="fas fa-paw"></i>
          <span>Pets</span>
        </router-link>
        <router-link to="/admin/applications" class="nav-item" :class="{ active: $route.path === '/admin/applications' }">
          <i class="fas fa-file-alt"></i>
          <span>Applications</span>
        </router-link>
        <router-link to="/admin/appointments" class="nav-item" :class="{ active: $route.path === '/admin/appointments' }">
          <i class="fas fa-calendar-alt"></i>
          <span>Appointments</span>
        </router-link>
        <router-link to="/admin/pet-history" class="nav-item" :class="{ active: $route.path === '/admin/pet-history' }">
          <i class="fas fa-history"></i>
          <span>Pet History</span>
        </router-link>
      </nav>
      <div class="sidebar-footer">
        <button class="logout-btn" @click="handleLogout">
          <i class="fas fa-sign-out-alt"></i>
          <span>Logout</span>
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
      <header class="admin-header">
        <div class="header-left">
          <h2>{{ currentPageTitle }}</h2>
        </div>
        <div class="header-right">
          <div class="admin-profile">
            <img :src="adminAvatar" alt="Admin" class="admin-avatar" />
            <span class="admin-name">{{ adminName }}</span>
          </div>
        </div>
      </header>
      <div class="admin-content">
        <router-view></router-view>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: 'AdminLayout',
  data() {
    return {
      adminName: 'Admin User',
      adminAvatar: 'https://via.placeholder.com/40',
      currentPageTitle: 'Dashboard'
    }
  },
  watch: {
    $route: {
      immediate: true,
      handler(to) {
        this.updatePageTitle(to.name)
      }
    }
  },
  methods: {
    updatePageTitle(routeName) {
      const titles = {
        adminDashboard: 'Dashboard',
        adminPets: 'Pets Management',
        adminAddPet: 'Add New Pet',
        adminApplications: 'Adoption Applications',
        adminAppointments: 'Appointments',
        adminPetHistory: 'Pet Adoption History'
      }
      this.currentPageTitle = titles[routeName] || 'Dashboard'
    },
    handleLogout() {
      // Clear admin session
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      // Redirect to login
      this.$router.push('/login')
    }
  }
}
</script>

<style scoped>
.admin-layout {
  display: flex;
  min-height: 100vh;
  background: #f4f6fa;
}

.admin-sidebar {
  width: 260px;
  background: #fff;
  border-right: 1px solid #e0e0e0;
  display: flex;
  flex-direction: column;
  position: fixed;
  height: 100vh;
}

.sidebar-header {
  padding: 1.5rem;
  border-bottom: 1px solid #e0e0e0;
}

.logo {
  color: #f7871f;
  font-size: 1.5rem;
  font-weight: 800;
  letter-spacing: 1px;
}

.sidebar-nav {
  flex: 1;
  padding: 1rem 0;
}

.nav-item {
  display: flex;
  align-items: center;
  padding: 0.8rem 1.5rem;
  color: #555;
  text-decoration: none;
  transition: all 0.3s ease;
  border-right: 3px solid transparent;
}

.nav-item i {
  width: 20px;
  margin-right: 0.8rem;
}

.nav-item:hover {
  background: #f8f9fa;
  color: #f7871f;
}

.nav-item.active {
  background: #fff5eb;
  color: #f7871f;
  border-right: 3px solid #f7871f;
}

.sidebar-footer {
  padding: 1rem 1.5rem;
  border-top: 1px solid #e0e0e0;
}

.logout-btn {
  display: flex;
  align-items: center;
  width: 100%;
  padding: 0.8rem;
  background: none;
  border: none;
  color: #ff5252;
  cursor: pointer;
  transition: all 0.3s ease;
}

.logout-btn i {
  margin-right: 0.8rem;
}

.logout-btn:hover {
  background: #fff5f5;
}

.admin-main {
  flex: 1;
  margin-left: 260px;
}

.admin-header {
  background: #fff;
  padding: 1rem 2rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
  border-bottom: 1px solid #e0e0e0;
}

.header-left h2 {
  color: #222;
  font-size: 1.5rem;
  font-weight: 600;
}

.admin-profile {
  display: flex;
  align-items: center;
  gap: 0.8rem;
}

.admin-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
}

.admin-name {
  color: #555;
  font-weight: 500;
}

.admin-content {
  padding: 2rem;
}

@media (max-width: 768px) {
  .admin-sidebar {
    width: 70px;
  }

  .admin-main {
    margin-left: 70px;
  }

  .nav-item span,
  .logo,
  .admin-name {
    display: none;
  }

  .nav-item {
    justify-content: center;
    padding: 1rem;
  }

  .nav-item i {
    margin: 0;
  }

  .logout-btn span {
    display: none;
  }

  .logout-btn {
    justify-content: center;
  }

  .logout-btn i {
    margin: 0;
  }
}
</style>