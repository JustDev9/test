<template>
  <div class="admin-layout">
    <!-- Sidebar Navigation -->
    <aside class="admin-sidebar">
      <div class="sidebar-header">
        <img src="/Designer.png" alt="Logo" class="logo-img" />
        <span class="logo-text">PAWFECT</span>
      </div>

      <nav class="sidebar-nav">
        <router-link to="/admin/dashboard" class="nav-item" active-class="active">
          <i class="fas fa-chart-line"></i>
          <span>Dashboard</span>
        </router-link>
        <router-link to="/admin/pets" class="nav-item" active-class="active">
          <i class="fas fa-paw"></i>
          <span>Pets</span>
        </router-link>
        <router-link to="/admin/applications" class="nav-item" active-class="active">
          <i class="fas fa-file-alt"></i>
          <span>Applications</span>
        </router-link>
        <router-link to="/admin/appointments" class="nav-item" active-class="active">
          <i class="fas fa-calendar-check"></i>
          <span>Appointments</span>
        </router-link>
        <router-link to="/admin/pet-history" class="nav-item" active-class="active">
          <i class="fas fa-history"></i>
          <span>Pet History</span>
        </router-link>
      </nav>

      <div class="sidebar-footer">
        <a href="#" @click.prevent="handleLogout" class="nav-item">
          <i class="fas fa-sign-out-alt"></i>
          <span>Logout</span>
        </a>
      </div>
    </aside>

    <!-- Main Content -->
    <main class="admin-main">
  <div class="pet-history">
    <div class="history-header">
      <h2>Pet Adoption History</h2>
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search by pet name, adopter name, or date..."
          @input="filterHistory"
        />
      </div>
    </div>

    <div class="history-table-container">
      <table class="history-table">
        <thead>
          <tr>
            <th>Pet Photo</th>
            <th>Pet Details</th>
            <th>Adoption Date</th>
            <th>Adopter Information</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="pet in filteredHistory" :key="pet.id">
            <td>
              <img :src="pet.photo" :alt="pet.name" class="pet-photo" />
            </td>
            <td class="pet-details">
              <h4>{{ pet.name }}</h4>
              <p>{{ pet.breed }} • {{ pet.type }}</p>
              <p class="age">Age at adoption: {{ pet.age }}</p>
            </td>
            <td>
              <div class="adoption-date">
                <i class="fas fa-calendar-alt"></i>
                {{ formatDate(pet.adoptionDate) }}
              </div>
            </td>
            <td class="adopter-info">
              <h4>{{ pet.adopterName }}</h4>
              <p><i class="fas fa-envelope"></i> {{ pet.adopterEmail }}</p>
              <p><i class="fas fa-phone"></i> {{ pet.adopterPhone }}</p>
            </td>
            <td>
              <span class="status-badge adopted">
                Adopted
              </span>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Empty State -->
    <div v-if="filteredHistory.length === 0" class="empty-state">
      <i class="fas fa-history"></i>
      <h3>No Adoption History</h3>
      <p>There are no adopted pets in the history yet.</p>
    </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: 'PetHistory',
  data() {
    return {
      searchQuery: '',
      adoptionHistory: []
    }
  },
  computed: {
    filteredHistory() {
      return this.adoptionHistory.filter(pet => {
        const searchLower = this.searchQuery.toLowerCase()
        return (
          pet.name.toLowerCase().includes(searchLower) ||
          pet.adopterName.toLowerCase().includes(searchLower) ||
          pet.adoptionDate.includes(searchLower)
        )
      })
    }
  },
  mounted() {
    this.fetchAdoptionHistory()
  },
  methods: {
    async fetchAdoptionHistory() {
      try {
        // Replace with actual API call
        const response = await fetch('http://localhost/Pawfect-master/backend/admin/pet-history.php')
        const data = await response.json()
        this.adoptionHistory = data
      } catch (error) {
        console.error('Error fetching adoption history:', error)
        // Fallback data for testing
        this.adoptionHistory = [
          {
            id: 1,
            name: 'Max',
            type: 'Dog',
            breed: 'Labrador',
            age: '2 years',
            photo: 'https://via.placeholder.com/50',
            adoptionDate: '2024-03-15',
            adopterName: 'John Doe',
            adopterEmail: 'john@example.com',
            adopterPhone: '+1 234 567 8900'
          },
          {
            id: 2,
            name: 'Luna',
            type: 'Cat',
            breed: 'Persian',
            age: '1 year',
            photo: 'https://via.placeholder.com/50',
            adoptionDate: '2024-03-10',
            adopterName: 'Jane Smith',
            adopterEmail: 'jane@example.com',
            adopterPhone: '+1 234 567 8901'
          }
        ]
      }
    },
    formatDate(dateString) {
      const options = { year: 'numeric', month: 'long', day: 'numeric' }
      return new Date(dateString).toLocaleDateString(undefined, options)
    },
    filterHistory() {
      // Filtering is handled by computed property
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
  left: 0;
  top: 0;
  z-index: 1000;
}

.sidebar-header {
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 0.8rem;
  border-bottom: 1px solid #e0e0e0;
}

.logo-img {
  width: 32px;
  height: 32px;
}

.logo-text {
  font-size: 1.2rem;
  font-weight: 700;
  color: #f7871f;
}

.sidebar-nav {
  flex: 1;
  padding: 1rem 0;
  display: flex;
  flex-direction: column;
  gap: 0.3rem;
}

.nav-item {
  display: flex;
  align-items: center;
  gap: 0.8rem;
  padding: 0.8rem 1.5rem;
  color: #666;
  text-decoration: none;
  transition: all 0.3s ease;
  font-size: 0.95rem;
}

.nav-item:hover {
  background: #f8f9fa;
  color: #f7871f;
  padding-left: 1.8rem;
}

.nav-item.active {
  background: #fff5eb;
  color: #f7871f;
  border-left: 3px solid #f7871f;
  font-weight: 500;
}

.nav-item i {
  width: 20px;
  text-align: center;
  font-size: 1.1rem;
}

.sidebar-footer {
  padding: 1rem 0;
  border-top: 1px solid #e0e0e0;
  display: flex;
  flex-direction: column;
  gap: 0.5rem;
}

.admin-main {
  flex: 1;
  margin-left: 260px;
  padding: 2rem;
}

.pet-history {
  padding: 1.5rem;
}

.history-header {
  margin-bottom: 2rem;
}

.history-header h2 {
  color: #222;
  font-size: 1.8rem;
  font-weight: 600;
  margin-bottom: 1rem;
}

.search-box {
  position: relative;
  max-width: 400px;
}

.search-box i {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  color: #888;
}

.search-box input {
  width: 100%;
  padding: 0.8rem 1rem 0.8rem 2.5rem;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  font-size: 0.95rem;
}

.history-table-container {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  overflow: hidden;
}

.history-table {
  width: 100%;
  border-collapse: collapse;
}

.history-table th,
.history-table td {
  padding: 1.2rem;
  text-align: left;
  border-bottom: 1px solid #e0e0e0;
}

.history-table th {
  background: #f8f9fa;
  font-weight: 600;
  color: #555;
}

.pet-photo {
  width: 60px;
  height: 60px;
  border-radius: 8px;
  object-fit: cover;
}

.pet-details h4 {
  color: #222;
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 0.3rem;
}

.pet-details p {
  color: #666;
  font-size: 0.9rem;
  margin-bottom: 0.2rem;
}

.age {
  color: #888;
  font-size: 0.85rem;
}

.adoption-date {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #666;
}

.adoption-date i {
  color: #f7871f;
}

.adopter-info h4 {
  color: #222;
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 0.3rem;
}

.adopter-info p {
  color: #666;
  font-size: 0.9rem;
  margin-bottom: 0.2rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.adopter-info i {
  color: #888;
  width: 16px;
}

.status-badge {
  padding: 0.4rem 0.8rem;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 500;
}

.status-badge.adopted {
  background: #e3f2fd;
  color: #2196F3;
}

.empty-state {
  text-align: center;
  padding: 3rem;
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.empty-state i {
  font-size: 3rem;
  color: #ccc;
  margin-bottom: 1rem;
}

.empty-state h3 {
  color: #666;
  font-size: 1.2rem;
  margin-bottom: 0.5rem;
}

.empty-state p {
  color: #888;
}

@media (max-width: 768px) {
  .admin-sidebar {
    width: 70px;
  }

  .sidebar-header {
    justify-content: center;
    padding: 1rem;
  }

  .logo-text {
    display: none;
  }

  .nav-item span {
    display: none;
  }

  .nav-item {
    justify-content: center;
    padding: 1rem;
  }

  .admin-main {
    margin-left: 70px;
  }

  .pet-history {
    padding: 1rem;
  }

  .history-table {
    display: block;
    overflow-x: auto;
  }

  .search-box {
    max-width: 100%;
  }
}
</style>