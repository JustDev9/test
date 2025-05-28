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
  <div class="applications">
    <div class="page-header">
      <h2>Adoption Applications</h2>
    </div>

    <!-- Filters -->
    <div class="filters">
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search by applicant name, pet name, or status..."
          @input="filterApplications"
        />
      </div>
      <div class="filter-options">
        <select v-model="statusFilter" @change="filterApplications">
          <option value="">All Status</option>
          <option value="Pending">Pending</option>
          <option value="Approved">Approved</option>
          <option value="Rejected">Rejected</option>
          <option value="Cancelled">Cancelled</option>
        </select>
        <select v-model="dateFilter" @change="filterApplications">
          <option value="">All Time</option>
          <option value="today">Today</option>
          <option value="week">This Week</option>
          <option value="month">This Month</option>
        </select>
      </div>
    </div>

    <!-- Applications Table -->
    <div class="applications-table-container">
      <table class="applications-table">
        <thead>
          <tr>
            <th>Applicant</th>
            <th>Pet</th>
            <th>Applied Date</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="application in filteredApplications" :key="application.id">
            <td>
              <div class="applicant-info">
                <img :src="application.applicant.avatar" :alt="application.applicant.name" class="applicant-avatar" />
                <div>
                  <p class="applicant-name">{{ application.applicant.name }}</p>
                  <p class="applicant-email">{{ application.applicant.email }}</p>
                </div>
              </div>
            </td>
            <td>
              <div class="pet-info">
                <img :src="application.pet.photo" :alt="application.pet.name" class="pet-photo" />
                <div>
                  <p class="pet-name">{{ application.pet.name }}</p>
                  <p class="pet-breed">{{ application.pet.breed }}</p>
                </div>
              </div>
            </td>
            <td>{{ formatDate(application.appliedDate) }}</td>
            <td>
              <span class="status-badge" :class="application.status.toLowerCase()">
                {{ application.status }}
              </span>
            </td>
            <td>
              <div class="action-buttons">
                <button class="action-btn view" @click="viewApplication(application)">
                  <i class="fas fa-eye"></i>
                </button>
                <button
                  v-if="application.status === 'Pending'"
                  class="action-btn approve"
                  @click="updateStatus(application, 'Approved')"
                >
                  <i class="fas fa-check"></i>
                </button>
                <button
                  v-if="application.status === 'Pending'"
                  class="action-btn reject"
                  @click="updateStatus(application, 'Rejected')"
                >
                  <i class="fas fa-times"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- View Application Modal -->
    <div v-if="showViewModal" class="modal-overlay" @click.self="showViewModal = false">
      <div class="modal">
        <div class="modal-header">
          <h3>Application Details</h3>
          <button class="close-btn" @click="showViewModal = false">&times;</button>
        </div>
        <div class="modal-content" v-if="selectedApplication">
          <div class="detail-section">
            <h4>Applicant Information</h4>
            <div class="detail-grid">
              <div class="detail-item">
                <label>Name</label>
                <p>{{ selectedApplication.applicant.name }}</p>
              </div>
              <div class="detail-item">
                <label>Email</label>
                <p>{{ selectedApplication.applicant.email }}</p>
              </div>
              <div class="detail-item">
                <label>Phone</label>
                <p>{{ selectedApplication.applicant.phone }}</p>
              </div>
              <div class="detail-item">
                <label>Address</label>
                <p>{{ selectedApplication.applicant.address }}</p>
              </div>
            </div>
          </div>

          <div class="detail-section">
            <h4>Pet Information</h4>
            <div class="detail-grid">
              <div class="detail-item">
                <label>Name</label>
                <p>{{ selectedApplication.pet.name }}</p>
              </div>
              <div class="detail-item">
                <label>Breed</label>
                <p>{{ selectedApplication.pet.breed }}</p>
              </div>
              <div class="detail-item">
                <label>Age</label>
                <p>{{ selectedApplication.pet.age }}</p>
              </div>
              <div class="detail-item">
                <label>Gender</label>
                <p>{{ selectedApplication.pet.gender }}</p>
              </div>
            </div>
          </div>

          <div class="detail-section">
            <h4>Application Details</h4>
            <div class="detail-grid">
              <div class="detail-item">
                <label>Applied Date</label>
                <p>{{ formatDate(selectedApplication.appliedDate) }}</p>
              </div>
              <div class="detail-item">
                <label>Status</label>
                <p>
                  <span class="status-badge" :class="selectedApplication.status.toLowerCase()">
                    {{ selectedApplication.status }}
                  </span>
                </p>
              </div>
              <div class="detail-item full-width">
                <label>Reason for Adoption</label>
                <p>{{ selectedApplication.reason }}</p>
              </div>
              <div class="detail-item full-width">
                <label>Experience with Pets</label>
                <p>{{ selectedApplication.experience }}</p>
              </div>
            </div>
          </div>

          <div class="modal-actions" v-if="selectedApplication.status === 'Pending'">
            <button class="approve-btn" @click="updateStatus(selectedApplication, 'Approved')">
              <i class="fas fa-check"></i>
              Approve Application
            </button>
            <button class="reject-btn" @click="updateStatus(selectedApplication, 'Rejected')">
              <i class="fas fa-times"></i>
              Reject Application
            </button>
          </div>
        </div>
      </div>
    </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: 'AdminApplications',
  data() {
    return {
      applications: [],
      searchQuery: '',
      statusFilter: '',
      dateFilter: '',
      showViewModal: false,
      selectedApplication: null
    }
  },
  computed: {
    filteredApplications() {
      return this.applications.filter(app => {
        const matchesSearch =
          app.applicant.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          app.pet.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          app.status.toLowerCase().includes(this.searchQuery.toLowerCase())

        const matchesStatus = !this.statusFilter || app.status === this.statusFilter
        const matchesDate = this.filterByDate(app.appliedDate)

        return matchesSearch && matchesStatus && matchesDate
      })
    }
  },
  mounted() {
    this.fetchApplications()
  },
  methods: {
    async fetchApplications() {
      try {
        // Replace with actual API call
        const response = await fetch('http://localhost/Pawfect-master/backend/admin/applications.php')
        const data = await response.json()
        this.applications = data
      } catch (error) {
        console.error('Error fetching applications:', error)
        // Fallback data
        this.applications = [
          {
            id: 1,
            applicant: {
              name: 'John Doe',
              email: 'john@example.com',
              phone: '+1234567890',
              address: '123 Main St, City',
              avatar: 'https://via.placeholder.com/40'
            },
            pet: {
              name: 'Max',
              breed: 'Labrador',
              age: '2 years',
              gender: 'Male',
              photo: 'https://via.placeholder.com/40'
            },
            appliedDate: '2024-03-15',
            status: 'Pending',
            reason: 'Looking for a companion for my family',
            experience: 'Had dogs growing up, currently have a cat'
          }
        ]
      }
    },
    filterApplications() {
      // Filtering is handled by computed property
    },
    filterByDate(date) {
      if (!this.dateFilter) return true

      const applicationDate = new Date(date)
      const today = new Date()
      const startOfWeek = new Date(today.setDate(today.getDate() - today.getDay()))
      const startOfMonth = new Date(today.getFullYear(), today.getMonth(), 1)

      switch (this.dateFilter) {
        case 'today':
          return applicationDate.toDateString() === new Date().toDateString()
        case 'week':
          return applicationDate >= startOfWeek
        case 'month':
          return applicationDate >= startOfMonth
        default:
          return true
      }
    },
    formatDate(date) {
      return new Date(date).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      })
    },
    viewApplication(application) {
      this.selectedApplication = application
      this.showViewModal = true
    },
    async updateStatus(application, newStatus) {
      try {
        // Replace with actual API call
        await fetch(`http://localhost/Pawfect-master/backend/admin/applications.php?id=${application.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify({ status: newStatus })
        })

        // Update local state
        application.status = newStatus
        if (this.selectedApplication?.id === application.id) {
          this.selectedApplication.status = newStatus
        }

        this.showViewModal = false
      } catch (error) {
        console.error('Error updating application status:', error)
        alert('Failed to update application status. Please try again.')
      }
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

.applications {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.page-header h2 {
  color: #222;
  font-size: 1.5rem;
  font-weight: 600;
}

.filters {
  display: flex;
  gap: 1rem;
  flex-wrap: wrap;
}

.search-box {
  flex: 1;
  min-width: 300px;
  position: relative;
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

.filter-options {
  display: flex;
  gap: 1rem;
}

.filter-options select {
  padding: 0.8rem 1rem;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  font-size: 0.95rem;
  min-width: 150px;
}

.applications-table-container {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  overflow: hidden;
}

.applications-table {
  width: 100%;
  border-collapse: collapse;
}

.applications-table th,
.applications-table td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid #e0e0e0;
}

.applications-table th {
  background: #f8f9fa;
  font-weight: 600;
  color: #555;
}

.applicant-info,
.pet-info {
  display: flex;
  align-items: center;
  gap: 0.8rem;
}

.applicant-avatar,
.pet-photo {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  object-fit: cover;
}

.applicant-name,
.pet-name {
  color: #222;
  font-weight: 500;
  margin-bottom: 0.2rem;
}

.applicant-email,
.pet-breed {
  color: #888;
  font-size: 0.85rem;
}

.status-badge {
  padding: 0.4rem 0.8rem;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 500;
}

.status-badge.pending {
  background: #fff3e0;
  color: #ff9800;
}

.status-badge.approved {
  background: #e8f5e9;
  color: #4CAF50;
}

.status-badge.rejected {
  background: #ffebee;
  color: #f44336;
}

.status-badge.cancelled {
  background: #f5f5f5;
  color: #9e9e9e;
}

.action-buttons {
  display: flex;
  gap: 0.5rem;
}

.action-btn {
  width: 32px;
  height: 32px;
  border-radius: 6px;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s;
}

.action-btn.view {
  background: #e3f2fd;
  color: #2196F3;
}

.action-btn.approve {
  background: #e8f5e9;
  color: #4CAF50;
}

.action-btn.reject {
  background: #ffebee;
  color: #f44336;
}

.action-btn:hover {
  opacity: 0.8;
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
  width: 90%;
  max-width: 800px;
  max-height: 90vh;
  overflow-y: auto;
}

.modal-header {
  padding: 1.5rem;
  border-bottom: 1px solid #e0e0e0;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.modal-header h3 {
  color: #222;
  font-size: 1.2rem;
  font-weight: 600;
}

.close-btn {
  background: none;
  border: none;
  font-size: 1.5rem;
  color: #888;
  cursor: pointer;
}

.modal-content {
  padding: 1.5rem;
}

.detail-section {
  margin-bottom: 2rem;
}

.detail-section h4 {
  color: #333;
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 1rem;
}

.detail-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 1rem;
}

.detail-item {
  display: flex;
  flex-direction: column;
  gap: 0.3rem;
}

.detail-item.full-width {
  grid-column: 1 / -1;
}

.detail-item label {
  color: #666;
  font-size: 0.9rem;
}

.detail-item p {
  color: #222;
  font-size: 1rem;
}

.modal-actions {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
  padding-top: 1.5rem;
  border-top: 1px solid #e0e0e0;
}

.approve-btn,
.reject-btn {
  flex: 1;
  padding: 0.8rem;
  border-radius: 8px;
  font-weight: 500;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  cursor: pointer;
  transition: all 0.3s;
}

.approve-btn {
  background: #e8f5e9;
  color: #4CAF50;
  border: none;
}

.reject-btn {
  background: #ffebee;
  color: #f44336;
  border: none;
}

.approve-btn:hover {
  background: #c8e6c9;
}

.reject-btn:hover {
  background: #ffcdd2;
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

  .filters {
    flex-direction: column;
  }

  .search-box {
    min-width: 100%;
  }

  .filter-options {
    width: 100%;
  }

  .filter-options select {
    flex: 1;
  }

  .applications-table {
    display: block;
    overflow-x: auto;
  }

  .modal {
    width: 95%;
    margin: 1rem;
  }
}
</style>