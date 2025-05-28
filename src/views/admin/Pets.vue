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
  <div class="pets-management">
    <div class="pets-header">
      <h2>Pets Management</h2>
      <router-link to="/admin/pets/add" class="add-pet-btn">
        <i class="fas fa-plus"></i>
        Add New Pet
      </router-link>
    </div>

    <!-- Filters -->
    <div class="filters">
      <div class="search-box">
        <i class="fas fa-search"></i>
        <input
          type="text"
          v-model="searchQuery"
          placeholder="Search pets by name, breed, or status..."
          @input="filterPets"
        />
      </div>
      <div class="filter-options">
        <select v-model="statusFilter" @change="filterPets">
          <option value="">All Status</option>
          <option value="Available">Available</option>
          <option value="On Hold">On Hold</option>
        </select>
        <select v-model="typeFilter" @change="filterPets">
          <option value="">All Types</option>
          <option value="Dog">Dogs</option>
          <option value="Cat">Cats</option>
          <option value="Other">Others</option>
        </select>
      </div>
    </div>

    <!-- Pets Table -->
    <div class="pets-table-container">
      <table class="pets-table">
        <thead>
          <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Type</th>
            <th>Breed</th>
            <th>Age</th>
            <th>Status</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="pet in filteredPets" :key="pet.id">
            <td>
              <img :src="pet.photo" :alt="pet.name" class="pet-photo" />
            </td>
            <td>{{ pet.name }}</td>
            <td>{{ pet.type }}</td>
            <td>{{ pet.breed }}</td>
            <td>{{ pet.age }}</td>
            <td>
              <span class="status-badge" :class="pet.status.toLowerCase()">
                {{ pet.status }}
              </span>
            </td>
            <td>
              <div class="action-buttons">
                <button class="action-btn view" @click="viewPet(pet)">
                  <i class="fas fa-eye"></i>
                </button>
                <button class="action-btn edit" @click="editPet(pet)">
                  <i class="fas fa-edit"></i>
                </button>
                <button class="action-btn delete" @click="confirmDelete(pet)">
                  <i class="fas fa-trash"></i>
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Delete Confirmation Modal -->
    <div v-if="showDeleteModal" class="modal-overlay" @click.self="showDeleteModal = false">
      <div class="modal">
        <h3>Confirm Delete</h3>
        <p>Are you sure you want to delete {{ petToDelete?.name }}? This action cannot be undone.</p>
        <div class="modal-actions">
          <button class="cancel-btn" @click="showDeleteModal = false">Cancel</button>
          <button class="delete-btn" @click="deletePet">Delete</button>
        </div>
      </div>
    </div>
      </div>
    </main>
  </div>
</template>

<script>
export default {
  name: 'AdminPets',
  data() {
    return {
      pets: [],
      searchQuery: '',
      statusFilter: '',
      typeFilter: '',
      showDeleteModal: false,
      petToDelete: null
    }
  },
  computed: {
    filteredPets() {
      return this.pets.filter(pet => {
        // Exclude adopted pets from the main view
        if (pet.status === 'Adopted') return false;

        const matchesSearch =
          pet.name.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          pet.breed.toLowerCase().includes(this.searchQuery.toLowerCase()) ||
          pet.status.toLowerCase().includes(this.searchQuery.toLowerCase())

        const matchesStatus = !this.statusFilter || pet.status === this.statusFilter
        const matchesType = !this.typeFilter || pet.type === this.typeFilter

        return matchesSearch && matchesStatus && matchesType
      })
    }
  },
  mounted() {
    this.fetchPets()
  },
  methods: {
    handleLogout() {
      this.$router.push('/admin-login')
    },
    async fetchPets() {
      try {
        const response = await fetch('http://localhost:5000/api/pets')
        if (!response.ok) {
          throw new Error('Failed to fetch pets')
        }
        const data = await response.json()
        this.pets = data.map(pet => ({
          ...pet,
          photo: pet.photo || 'https://via.placeholder.com/50' // Fallback image if none provided
        }))
      } catch (error) {
        console.error('Error fetching pets:', error)
        // Show error message to user
        alert('Failed to load pets. Please try again later.')
      }
    },
    filterPets() {
      // Filtering is handled by computed property
    },
    viewPet(pet) {
      this.$router.push(`/admin/pets/${pet.id}`)
    },
    editPet(pet) {
      this.$router.push(`/admin/pets/edit/${pet.id}`)
    },
    confirmDelete(pet) {
      this.petToDelete = pet
      this.showDeleteModal = true
    },
    async deletePet() {
      if (!this.petToDelete) return

      try {
        await fetch(`http://localhost:5000/api/pets/${this.petToDelete.id}`, {
          method: 'DELETE'
        })

        // Remove pet from local array
        this.pets = this.pets.filter(p => p.id !== this.petToDelete.id)
        this.showDeleteModal = false
        this.petToDelete = null
      } catch (error) {
        console.error('Error deleting pet:', error)
      }
    },
    async updatePetStatus(petId, newStatus) {
      try {
        const response = await fetch(`http://localhost:5000/api/pets/${petId}/status`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
          },
          body: JSON.stringify({
            status: newStatus
          })
        })

        if (!response.ok) {
          throw new Error('Failed to update pet status')
        }

        // Update local state
        const pet = this.pets.find(p => p.id === petId)
        if (pet) {
          pet.status = newStatus
        }
      } catch (error) {
        console.error('Error updating pet status:', error)
        alert('Failed to update pet status. Please try again.')
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

.pets-management {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.pets-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.pets-header h2 {
  color: #222;
  font-size: 1.5rem;
  font-weight: 600;
}

.add-pet-btn {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: #f7871f;
  color: #fff;
  padding: 0.8rem 1.2rem;
  border-radius: 8px;
  text-decoration: none;
  font-weight: 500;
  transition: background 0.3s;
}

.add-pet-btn:hover {
  background: #e99a08;
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

.pets-table-container {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
  overflow: hidden;
}

.pets-table {
  width: 100%;
  border-collapse: collapse;
}

.pets-table th,
.pets-table td {
  padding: 1rem;
  text-align: left;
  border-bottom: 1px solid #e0e0e0;
}

.pets-table th {
  background: #f8f9fa;
  font-weight: 600;
  color: #555;
}

.pet-photo {
  width: 50px;
  height: 50px;
  border-radius: 8px;
  object-fit: cover;
}

.status-badge {
  padding: 0.4rem 0.8rem;
  border-radius: 20px;
  font-size: 0.85rem;
  font-weight: 500;
}

.status-badge.available {
  background: #e8f5e9;
  color: #4CAF50;
}

.status-badge.adopted {
  background: #e3f2fd;
  color: #2196F3;
}

.status-badge.on-hold {
  background: #fff3e0;
  color: #ff9800;
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

.action-btn.edit {
  background: #fff3e0;
  color: #ff9800;
}

.action-btn.delete {
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
  padding: 2rem;
  width: 90%;
  max-width: 400px;
}

.modal h3 {
  color: #222;
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 1rem;
}

.modal p {
  color: #666;
  margin-bottom: 1.5rem;
}

.modal-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
}

.modal-actions button {
  padding: 0.8rem 1.5rem;
  border-radius: 8px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s;
}

.cancel-btn {
  background: #f5f5f5;
  color: #666;
  border: none;
}

.delete-btn {
  background: #f44336;
  color: #fff;
  border: none;
}

.cancel-btn:hover {
  background: #e0e0e0;
}

.delete-btn:hover {
  background: #d32f2f;
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

  .pets-table {
    display: block;
    overflow-x: auto;
  }
}
</style>