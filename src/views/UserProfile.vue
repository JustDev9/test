<template>
  <div class="profile-page">
    <!-- Back Button -->
    <button class="back-btn" @click="goBack">
      <i class="fas fa-arrow-left"></i> Back
    </button>
    <!-- Loading Overlay -->
    <div v-if="isLoading" class="loading-overlay">
      <div class="loading-spinner"></div>
      <p>Loading profile data...</p>
    </div>

    <template v-else>
      <!-- User Information Section -->
      <div class="profile-header">
        <h2 class="welcome-message">Welcome back, {{ userProfile.name }}!</h2>
        <div class="user-info">
          <div class="profile-picture">
            <img :src="userProfile.avatar || '/assets/default-avatar.png'" alt="Profile Picture">
            <button class="edit-avatar" @click="handleEditAvatar">
              <i class="fas fa-camera"></i>
            </button>
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

      <!-- Main Content -->
      <div class="profile-content">
        <!-- Adopted Pets Section -->
        <section class="profile-section">
          <div class="section-header">
            <h2><i class="fas fa-paw"></i> Adopted Pets</h2>
          </div>
          <div v-if="adoptedPets.length" class="pets-grid">
            <div v-for="pet in adoptedPets" :key="pet.id" class="pet-card">
              <img :src="pet.photo" :alt="pet.name" class="pet-photo">
              <div class="pet-info">
                <h3>{{ pet.name }}</h3>
                <p>{{ pet.breed }}</p>
                <p class="adoption-date">Adopted on {{ formatDate(pet.adoptionDate) }}</p>
              </div>
            </div>
          </div>
          <div v-else class="empty-state">
            <i class="fas fa-paw"></i>
            <p>No adopted pets yet</p>
          </div>
        </section>

        <!-- Pending Applications Section -->
        <section class="profile-section">
          <div class="section-header">
            <h2><i class="fas fa-clock"></i> Pending Applications</h2>
          </div>
          <div v-if="pendingApplications.length" class="applications-list">
            <div v-for="app in pendingApplications" :key="app.id" class="application-card">
              <img :src="app.petPhoto" :alt="app.petName" class="pet-thumbnail">
              <div class="application-info">
                <h3>{{ app.petName }}</h3>
                <p>Applied on {{ formatDate(app.applicationDate) }}</p>
                <span class="status-badge" :class="app.status.toLowerCase()">
                  {{ app.status }}
                </span>
              </div>
              <button
                v-if="app.status === 'Pending'"
                class="cancel-btn"
                @click="cancelApplication(app.id)"
              >
                Cancel Request
              </button>
            </div>
          </div>
          <div v-else class="empty-state">
            <i class="fas fa-clock"></i>
            <p>No pending applications</p>
          </div>
        </section>

        <!-- Appointments Section -->
        <section class="profile-section">
          <div class="section-header">
            <h2><i class="fas fa-calendar-alt"></i> Upcoming Appointments</h2>
          </div>
          <div v-if="appointments.length" class="appointments-list">
            <div v-for="apt in appointments" :key="apt.id" class="appointment-card">
              <div class="appointment-info">
                <h3>{{ apt.petName }}</h3>
                <p class="datetime">
                  <i class="fas fa-calendar"></i> {{ formatDate(apt.date) }}
                  <i class="fas fa-clock"></i> {{ apt.time }}
                </p>
                <span class="status-badge" :class="apt.status.toLowerCase()">
                  {{ apt.status }}
                </span>
              </div>
              <div class="appointment-actions">
                <button
                  v-if="apt.status === 'Scheduled'"
                  class="reschedule-btn"
                  @click="rescheduleAppointment(apt.id)"
                >
                  Reschedule
                </button>
                <button
                  v-if="apt.status === 'Scheduled'"
                  class="cancel-btn"
                  @click="cancelAppointment(apt.id)"
                >
                  Cancel
                </button>
              </div>
            </div>
          </div>
          <div v-else class="empty-state">
            <i class="fas fa-calendar-alt"></i>
            <p>No upcoming appointments</p>
          </div>
        </section>
      </div>
    </template>

    <!-- Logout Button -->
    <button class="logout-btn" @click="handleLogout">
      <i class="fas fa-sign-out-alt"></i> Logout
    </button>

    <!-- Edit Profile Modal -->
    <div v-if="showEditModal" class="modal-overlay" @click.self="closeEditModal">
      <div class="modal">
        <h2>Edit Profile</h2>
        <form @submit.prevent="updateProfile">
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
            <button type="button" class="cancel-btn" @click="closeEditModal" :disabled="isUpdating">Cancel</button>
            <button type="submit" class="save-btn" :disabled="isUpdating">
              <span v-if="isUpdating" class="spinner"></span>
              {{ isUpdating ? 'Saving...' : 'Save Changes' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import { onMounted, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'

export default {
  name: 'UserProfile',
  setup() {
    const router = useRouter()
    const toast = useToast()

    // Loading states
    const isLoading = ref(true)
    const isUpdating = ref(false)

    // User profile data
    const userProfile = ref({
      name: '',
      email: '',
      avatar: null
    })

    // Lists
    const adoptedPets = ref([])
    const pendingApplications = ref([])
    const appointments = ref([])

    // Modal state
    const showEditModal = ref(false)
    const editForm = ref({
      name: '',
      email: ''
    })

    // Fetch user data
    const fetchUserData = async () => {
      isLoading.value = true
      try {
        const response = await fetch('http://localhost/Pawfect-master/backend/profile.php', {
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        })

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`)
        }

        const data = await response.json()

        if (data.error) {
          throw new Error(data.error)
        }

        userProfile.value = data.profile
        adoptedPets.value = data.adoptedPets
        pendingApplications.value = data.pendingApplications
        appointments.value = data.appointments
      } catch (error) {
        console.error('Error fetching user data:', error)
        toast.error(error.message || 'Failed to load profile data')
        if (error.message.includes('401') || error.message.includes('403')) {
          router.push('/login')
        }
      } finally {
        isLoading.value = false
      }
    }

    // Format date helper
    const formatDate = (dateString) => {
      return new Date(dateString).toLocaleDateString('en-US', {
        year: 'numeric',
        month: 'long',
        day: 'numeric'
      })
    }

    // Handle profile edit
    const handleEditProfile = () => {
      editForm.value = { ...userProfile.value }
      showEditModal.value = true
    }

    const handleEditAvatar = () => {
      // Implement avatar editing logic
      toast.info('Avatar editing feature coming soon')
    }

    const closeEditModal = () => {
      showEditModal.value = false
    }

    const updateProfile = async () => {
      isUpdating.value = true
      try {
        const response = await fetch('http://localhost/Pawfect-master/backend/profile.php', {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          },
          body: JSON.stringify(editForm.value)
        })

        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`)
        }

        const data = await response.json()

        if (data.error) {
          throw new Error(data.error)
        }

        userProfile.value = { ...editForm.value }
        showEditModal.value = false
        toast.success('Profile updated successfully')
      } catch (error) {
        console.error('Error updating profile:', error)
        toast.error(error.message || 'Failed to update profile')
      } finally {
        isUpdating.value = false
      }
    }

    // Handle application cancellation
    const cancelApplication = async (applicationId) => {
      try {
        const response = await fetch(`http://localhost/Pawfect-master/backend/applications.php?id=${applicationId}`, {
          method: 'DELETE',
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        })

        if (response.ok) {
          pendingApplications.value = pendingApplications.value.filter(app => app.id !== applicationId)
          toast.success('Application cancelled successfully')
        } else {
          throw new Error('Failed to cancel application')
        }
      } catch (error) {
        console.error('Error cancelling application:', error)
        toast.error('Failed to cancel application')
      }
    }

    // Handle appointment actions
    const rescheduleAppointment = (appointmentId) => {
      // Implement rescheduling logic
      console.log('Rescheduling appointment:', appointmentId)
      toast.info('Rescheduling feature coming soon')
    }

    const cancelAppointment = async (appointmentId) => {
      try {
        const response = await fetch(`http://localhost/Pawfect-master/backend/appointments.php?id=${appointmentId}`, {
          method: 'DELETE',
          headers: {
            'Authorization': `Bearer ${localStorage.getItem('token')}`
          }
        })

        if (response.ok) {
          appointments.value = appointments.value.filter(apt => apt.id !== appointmentId)
          toast.success('Appointment cancelled successfully')
        } else {
          throw new Error('Failed to cancel appointment')
        }
      } catch (error) {
        console.error('Error cancelling appointment:', error)
        toast.error('Failed to cancel appointment')
      }
    }

    // Handle logout
    const handleLogout = () => {
      localStorage.removeItem('token')
      router.push('/login')
      toast.success('Logged out successfully')
    }

    const goBack = () => {
      router.back()
    }

    onMounted(() => {
      fetchUserData()
    })

    return {
      userProfile,
      adoptedPets,
      pendingApplications,
      appointments,
      showEditModal,
      editForm,
      isLoading,
      isUpdating,
      formatDate,
      handleEditProfile,
      handleEditAvatar,
      closeEditModal,
      updateProfile,
      cancelApplication,
      rescheduleAppointment,
      cancelAppointment,
      handleLogout,
      goBack
    }
  }
}
</script>

<style scoped>
.profile-page {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.profile-header {
  background: #fff;
  border-radius: 12px;
  padding: 2rem;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  margin-bottom: 2rem;
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
}

.profile-content {
  display: grid;
  gap: 2rem;
}

.profile-section {
  background: #fff;
  border-radius: 12px;
  padding: 2rem;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
}

.section-header {
  margin-bottom: 1.5rem;
}

.section-header h2 {
  color: #222;
  font-size: 1.4rem;
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.pets-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 1.5rem;
}

.pet-card {
  background: #f8f9fa;
  border-radius: 8px;
  overflow: hidden;
}

.pet-photo {
  width: 100%;
  height: 200px;
  object-fit: cover;
}

.pet-info {
  padding: 1rem;
}

.pet-info h3 {
  color: #222;
  margin-bottom: 0.5rem;
}

.adoption-date {
  color: #666;
  font-size: 0.9rem;
  margin-top: 0.5rem;
}

.applications-list,
.appointments-list {
  display: grid;
  gap: 1rem;
}

.application-card,
.appointment-card {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: #f8f9fa;
  border-radius: 8px;
}

.pet-thumbnail {
  width: 60px;
  height: 60px;
  border-radius: 8px;
  object-fit: cover;
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

.status-badge.scheduled {
  background: #e3f2fd;
  color: #2196F3;
}

.status-badge.completed {
  background: #e8f5e9;
  color: #4CAF50;
}

.status-badge.missed {
  background: #ffebee;
  color: #f44336;
}

.cancel-btn,
.reschedule-btn {
  padding: 0.5rem 1rem;
  border-radius: 6px;
  font-size: 0.9rem;
  cursor: pointer;
}

.cancel-btn {
  background: #ffebee;
  color: #f44336;
  border: none;
}

.reschedule-btn {
  background: #e3f2fd;
  color: #2196F3;
  border: none;
}

.empty-state {
  text-align: center;
  padding: 3rem;
  color: #666;
}

.empty-state i {
  font-size: 3rem;
  margin-bottom: 1rem;
  color: #ccc;
}

.logout-btn {
  position: fixed;
  bottom: 2rem;
  right: 2rem;
  background: #f44336;
  color: white;
  border: none;
  padding: 1rem 2rem;
  border-radius: 8px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.1);
}

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

.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.9);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.loading-spinner {
  width: 40px;
  height: 40px;
  border: 4px solid #f3f3f3;
  border-top: 4px solid #f7871f;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 1rem;
}

.spinner {
  display: inline-block;
  width: 16px;
  height: 16px;
  border: 2px solid #fff;
  border-top: 2px solid transparent;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-right: 8px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@media (max-width: 768px) {
  .profile-page {
    padding: 1rem;
  }

  .user-info {
    flex-direction: column;
    text-align: center;
  }

  .pets-grid {
    grid-template-columns: 1fr;
  }

  .application-card,
  .appointment-card {
    flex-direction: column;
    text-align: center;
  }

  .logout-btn {
    position: static;
    width: 100%;
    margin-top: 2rem;
  }
}

.welcome-message {
  font-size: 1.5rem;
  font-weight: 700;
  color: #f7871f;
  margin-bottom: 1rem;
}

.back-btn {
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  background: #f7f7f7;
  color: #f7871f;
  border: none;
  border-radius: 8px;
  padding: 0.5rem 1.2rem;
  font-size: 1rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
  cursor: pointer;
  box-shadow: 0 2px 8px rgba(0,0,0,0.04);
  transition: background 0.2s, color 0.2s;
}

.back-btn:hover {
  background: #f7871f;
  color: #fff;
}
</style> 