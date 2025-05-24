<template>
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
    async fetchPets() {
      try {
        // Replace with actual API call
        const response = await fetch('http://localhost/Pawfect-master/backend/admin/pets.php')
        const data = await response.json()
        this.pets = data
      } catch (error) {
        console.error('Error fetching pets:', error)
        // Fallback data
        this.pets = [
          {
            id: 1,
            name: 'Max',
            type: 'Dog',
            breed: 'Labrador',
            age: '2 years',
            status: 'Available',
            photo: 'https://via.placeholder.com/50'
          },
          {
            id: 2,
            name: 'Luna',
            type: 'Cat',
            breed: 'Persian',
            age: '1 year',
            status: 'Adopted',
            photo: 'https://via.placeholder.com/50'
          }
        ]
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
        // Replace with actual API call
        await fetch(`http://localhost/Pawfect-master/backend/admin/pets.php?id=${this.petToDelete.id}`, {
          method: 'DELETE'
        })

        // Remove pet from local array
        this.pets = this.pets.filter(p => p.id !== this.petToDelete.id)
        this.showDeleteModal = false
        this.petToDelete = null
      } catch (error) {
        console.error('Error deleting pet:', error)
      }
    }
  }
}
</script>

<style scoped>
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