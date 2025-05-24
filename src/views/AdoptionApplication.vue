<template>
  <div class="adoption-application">
    <div class="form-header">
      <h2>Adoption Application</h2>
      <p class="subtitle">Complete the form below to apply for adopting {{ selectedPet?.name }}</p>
    </div>

    <form @submit.prevent="handleSubmit" class="application-form">
      <!-- Pet Information -->
      <div class="form-section">
        <h3>Selected Pet</h3>
        <div class="pet-info">
          <img :src="selectedPet?.photo" :alt="selectedPet?.name" class="pet-photo">
          <div class="pet-details">
            <h4>{{ selectedPet?.name }}</h4>
            <p>{{ selectedPet?.breed }} • {{ selectedPet?.type }}</p>
          </div>
        </div>
      </div>

      <!-- Personal Information -->
      <div class="form-section">
        <h3>Personal Information</h3>
        <div class="form-grid">
          <div class="form-group">
            <label for="fullName">Full Name</label>
            <input
              type="text"
              id="fullName"
              v-model="formData.fullName"
              placeholder="Enter your full name"
              required
            >
          </div>

          <div class="form-group">
            <label for="email">Email Address</label>
            <input
              type="email"
              id="email"
              v-model="formData.email"
              placeholder="Enter your email"
              required
            >
          </div>

          <div class="form-group">
            <label for="phone">Contact Number</label>
            <input
              type="tel"
              id="phone"
              v-model="formData.phone"
              placeholder="Enter your phone number"
              required
            >
          </div>

          <div class="form-group full-width">
            <label for="address">Address</label>
            <textarea
              id="address"
              v-model="formData.address"
              placeholder="Enter your complete address"
              rows="3"
              required
            ></textarea>
          </div>
        </div>
      </div>

      <!-- Appointment Scheduling -->
      <div class="form-section">
        <h3>Appointment Details</h3>
        <div class="form-grid">
          <div class="form-group">
            <label for="appointmentDate">Preferred Date</label>
            <input
              type="date"
              id="appointmentDate"
              v-model="formData.appointmentDate"
              :min="minDate"
              required
            >
          </div>

          <div class="form-group">
            <label for="appointmentTime">Preferred Time</label>
            <select id="appointmentTime" v-model="formData.appointmentTime" required>
              <option value="">Select time</option>
              <option v-for="time in availableTimeSlots" :key="time" :value="time">
                {{ time }}
              </option>
            </select>
          </div>
        </div>
      </div>

      <!-- Additional Notes -->
      <div class="form-section">
        <h3>Additional Information</h3>
        <div class="form-group">
          <label for="notes">Notes or Special Requests</label>
          <textarea
            id="notes"
            v-model="formData.notes"
            placeholder="Any additional information you'd like to share"
            rows="3"
          ></textarea>
        </div>
      </div>

      <div class="form-actions">
        <button type="button" class="cancel-btn" @click="cancel">Cancel</button>
        <button type="submit" class="submit-btn" :disabled="isSubmitting">
          <span v-if="!isSubmitting">Submit Application</span>
          <i v-else class="fas fa-spinner fa-spin"></i>
        </button>
      </div>
    </form>

    <!-- Success Modal -->
    <div v-if="showSuccessModal" class="modal-overlay" @click.self="closeSuccessModal">
      <div class="modal">
        <div class="modal-content">
          <i class="fas fa-check-circle success-icon"></i>
          <h3>Application Submitted Successfully!</h3>
          <p>Your adoption application has been received. We will review it and contact you shortly.</p>
          <div class="appointment-details">
            <h4>Appointment Details</h4>
            <p><strong>Date:</strong> {{ formatDate(formData.appointmentDate) }}</p>
            <p><strong>Time:</strong> {{ formData.appointmentTime }}</p>
            <p><strong>Location:</strong> 123 Pet Shelter St., City, Country</p>
          </div>
          <button class="close-btn" @click="closeSuccessModal">Close</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { computed, onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'

export default {
  name: 'AdoptionApplication',
  setup() {
    const route = useRoute()
    const router = useRouter()
    const isSubmitting = ref(false)
    const showSuccessModal = ref(false)
    const selectedPet = ref(null)

    const formData = ref({
      fullName: '',
      email: '',
      phone: '',
      address: '',
      appointmentDate: '',
      appointmentTime: '',
      notes: ''
    })

    // Available time slots (9 AM to 4 PM, 1-hour intervals)
    const availableTimeSlots = [
      '09:00 AM', '10:00 AM', '11:00 AM',
      '01:00 PM', '02:00 PM', '03:00 PM', '04:00 PM'
    ]

    // Minimum date (tomorrow)
    const minDate = computed(() => {
      const tomorrow = new Date()
      tomorrow.setDate(tomorrow.getDate() + 1)
      return tomorrow.toISOString().split('T')[0]
    })

    onMounted(async () => {
      // Fetch pet details using the ID from route params
      const petId = route.params.petId
      try {
        const response = await fetch(`http://localhost/Pawfect-master/backend/pets.php?id=${petId}`)
        const data = await response.json()
        selectedPet.value = data
      } catch (error) {
        console.error('Error fetching pet details:', error)
        router.push('/pets')
      }
    })

    const handleSubmit = async () => {
      isSubmitting.value = true
      try {
        // Save application data
        const applicationData = {
          ...formData.value,
          petId: selectedPet.value.id,
          petName: selectedPet.value.name,
          status: 'Pending'
        }

        // Save to backend
        await fetch('http://localhost/Pawfect-master/backend/applications.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(applicationData)
        })

        // Create Google Calendar event
        await createCalendarEvent(applicationData)

        // Show success modal
        showSuccessModal.value = true
      } catch (error) {
        console.error('Error submitting application:', error)
        alert('Failed to submit application. Please try again.')
      } finally {
        isSubmitting.value = false
      }
    }

    const createCalendarEvent = async (applicationData) => {
      try {
        const eventData = {
          summary: `Pet Adoption Appointment - ${applicationData.petName}`,
          location: '123 Pet Shelter St., City, Country',
          description: `Meeting with ${applicationData.fullName} for the adoption of ${applicationData.petName}.`,
          start: {
            dateTime: `${applicationData.appointmentDate}T${applicationData.appointmentTime}`,
            timeZone: 'Asia/Manila'
          },
          end: {
            dateTime: `${applicationData.appointmentDate}T${applicationData.appointmentTime}`,
            timeZone: 'Asia/Manila'
          },
          attendees: [{ email: applicationData.email }]
        }

        // Call backend endpoint to create calendar event
        await fetch('http://localhost/Pawfect-master/backend/calendar.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(eventData)
        })
      } catch (error) {
        console.error('Error creating calendar event:', error)
        throw error
      }
    }

    const formatDate = (dateString) => {
      const options = { year: 'numeric', month: 'long', day: 'numeric' }
      return new Date(dateString).toLocaleDateString(undefined, options)
    }

    const cancel = () => {
      router.back()
    }

    const closeSuccessModal = () => {
      showSuccessModal.value = false
      router.push('/pets')
    }

    return {
      formData,
      isSubmitting,
      showSuccessModal,
      selectedPet,
      availableTimeSlots,
      minDate,
      handleSubmit,
      formatDate,
      cancel,
      closeSuccessModal
    }
  }
}
</script>

<style scoped>
.adoption-application {
  max-width: 800px;
  margin: 0 auto;
  padding: 2rem;
}

.form-header {
  margin-bottom: 2rem;
  text-align: center;
}

.form-header h2 {
  color: #222;
  font-size: 1.8rem;
  font-weight: 600;
  margin-bottom: 0.5rem;
}

.subtitle {
  color: #666;
  font-size: 1rem;
}

.application-form {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  padding: 2rem;
}

.form-section {
  margin-bottom: 2rem;
}

.form-section h3 {
  color: #333;
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
}

.pet-info {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  background: #f8f9fa;
  border-radius: 8px;
}

.pet-photo {
  width: 80px;
  height: 80px;
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
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(2, 1fr);
  gap: 1.5rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group.full-width {
  grid-column: 1 / -1;
}

label {
  display: block;
  color: #555;
  font-weight: 500;
  margin-bottom: 0.5rem;
}

input, select, textarea {
  width: 100%;
  padding: 0.8rem;
  border: 1px solid #e0e0e0;
  border-radius: 8px;
  font-size: 0.95rem;
  transition: all 0.3s;
}

input:focus, select:focus, textarea:focus {
  border-color: #f7871f;
  outline: none;
  box-shadow: 0 0 0 3px rgba(247, 135, 31, 0.1);
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  margin-top: 2rem;
  padding-top: 2rem;
  border-top: 1px solid #e0e0e0;
}

.cancel-btn, .submit-btn {
  padding: 0.8rem 2rem;
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

.submit-btn {
  background: #f7871f;
  color: white;
  border: none;
}

.cancel-btn:hover {
  background: #e0e0e0;
}

.submit-btn:hover {
  background: #e99a08;
}

.submit-btn:disabled {
  background: #ccc;
  cursor: not-allowed;
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

.modal-content {
  text-align: center;
}

.success-icon {
  font-size: 4rem;
  color: #4CAF50;
  margin-bottom: 1rem;
}

.modal h3 {
  color: #222;
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 1rem;
}

.modal p {
  color: #666;
  margin-bottom: 1.5rem;
}

.appointment-details {
  background: #f8f9fa;
  border-radius: 8px;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
  text-align: left;
}

.appointment-details h4 {
  color: #333;
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 1rem;
}

.appointment-details p {
  color: #666;
  margin-bottom: 0.5rem;
}

.close-btn {
  background: #f7871f;
  color: white;
  border: none;
  padding: 0.8rem 2rem;
  border-radius: 8px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s;
}

.close-btn:hover {
  background: #e99a08;
}

@media (max-width: 768px) {
  .adoption-application {
    padding: 1rem;
  }

  .application-form {
    padding: 1.5rem;
  }

  .form-grid {
    grid-template-columns: 1fr;
  }
}
</style>