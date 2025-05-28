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
      <div class="add-pet-container">
        <div class="form-header">
          <h2>Add New Pet</h2>
          <p class="subtitle">Fill in the details to add a new pet to the system</p>
        </div>

        <form @submit.prevent="handleSubmit" class="pet-form">
          <div class="form-grid">
            <!-- Basic Information -->
            <div class="form-section">
              <h3>Basic Information</h3>
              <div class="form-group">
                <label for="name">Pet Name</label>
                <input
                  type="text"
                  id="name"
                  v-model="petData.name"
                  placeholder="Enter pet name"
                  required
                >
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="type">Pet Type</label>
                  <select id="type" v-model="petData.type" required>
                    <option value="">Select type</option>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                  </select>
                </div>

                <div class="form-group">
                  <label for="breed">Breed</label>
                  <input
                    type="text"
                    id="breed"
                    v-model="petData.breed"
                    placeholder="Enter breed"
                    required
                  >
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label for="age">Age</label>
                  <input
                    type="text"
                    id="age"
                    v-model="petData.age"
                    placeholder="e.g., 2 years"
                    required
                  >
                </div>

                <div class="form-group">
                  <label for="gender">Sex</label>
                  <select id="gender" v-model="petData.gender" required>
                    <option value="">Select gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
                </div>
              </div>
            </div>

            <!-- Additional Details -->
            <div class="form-section">
              <h3>Additional Details</h3>
              <div class="form-group">
                <label for="description">Description</label>
                <textarea
                  id="description"
                  v-model="petData.description"
                  placeholder="Describe the pet's personality, behavior, and any special needs"
                  rows="4"
                ></textarea>
              </div>

              <div class="form-group">
                <label for="status">Status</label>
                <select id="status" v-model="petData.status" required>
                  <option value="Available">Available</option>
                  <option value="Adopted">Adopted</option>
                </select>
              </div>
            </div>

            <!-- Photo Upload -->
            <div class="form-section">
              <h3>Pet Photos</h3>
              <div class="photo-upload">
                <div class="upload-area" @click="triggerFileInput" @dragover.prevent @drop.prevent="handleDrop">
                  <input
                    type="file"
                    ref="fileInput"
                    @change="handleFileSelect"
                    accept="image/*"
                    multiple
                    class="hidden"
                  >
                  <div class="upload-content" v-if="!petData.photos.length">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p>Drag & drop photos here or click to upload</p>
                    <span class="upload-hint">Supports JPG, PNG (max 5MB)</span>
                  </div>
                  <div class="photo-preview" v-else>
                    <div v-for="(photo, index) in petData.photos" :key="index" class="preview-item">
                      <img :src="photo" :alt="'Pet photo ' + (index + 1)">
                      <button type="button" class="remove-photo" @click="removePhoto(index)">
                        <i class="fas fa-times"></i>
                      </button>
                    </div>
                    <div class="add-more" @click="triggerFileInput">
                      <i class="fas fa-plus"></i>
                      <span>Add More</span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="form-actions">
            <button type="button" class="cancel-btn" @click="cancel">Cancel</button>
            <button type="submit" class="submit-btn" :disabled="isSubmitting">
              <span v-if="!isSubmitting">Add Pet</span>
              <i v-else class="fas fa-spinner fa-spin"></i>
            </button>
          </div>
        </form>
      </div>
    </main>
  </div>
</template>

<script>
import { supabase } from '@/config/supabase'

export default {
  name: 'AddPet',
  data() {
    return {
      isSubmitting: false,
      petData: {
        name: '',
        type: '',
        breed: '',
        age: '',
        gender: '',
        description: '',
        status: 'Available',
        photos: []
      }
    }
  },
  methods: {
    handleLogout() {
      this.$router.push('/admin-login')
    },
    triggerFileInput() {
      this.$refs.fileInput.click()
    },
    handleFileSelect(event) {
      const files = event.target.files
      this.processFiles(files)
    },
    handleDrop(event) {
      const files = event.dataTransfer.files
      this.processFiles(files)
    },
    processFiles(files) {
      Array.from(files).forEach(file => {
        if (file.type.startsWith('image/')) {
          const reader = new FileReader()
          reader.onload = (e) => {
            this.petData.photos.push(e.target.result)
          }
          reader.readAsDataURL(file)
        }
      })
    },
    removePhoto(index) {
      this.petData.photos.splice(index, 1)
    },
    async handleSubmit() {
      this.isSubmitting = true
      try {
        // Upload photos to Supabase Storage
        const photoUrls = []
        for (const photo of this.petData.photos) {
          const base64Data = photo.split(',')[1]
          const fileName = `pet_${Date.now()}_${Math.random().toString(36).substring(7)}.jpg`

          const { data: uploadData, error: uploadError } = await supabase.storage
            .from('pet-photos')
            .upload(fileName, this.base64ToBlob(base64Data, 'image/jpeg'))

          if (uploadError) throw uploadError

          const { data: { publicUrl } } = supabase.storage
            .from('pet-photos')
            .getPublicUrl(fileName)

          photoUrls.push(publicUrl)
        }

        // Insert pet data into Supabase
        const { data, error } = await supabase
          .from('pets')
          .insert([
            {
              name: this.petData.name,
              species: this.petData.type,
              breed: this.petData.breed,
              age: parseInt(this.petData.age),
              description: this.petData.description,
              status: this.petData.status.toLowerCase(),
              image_url: photoUrls[0] || null, // Use first photo as main image
              photos: photoUrls // Store all photo URLs
            }
          ])
          .select()

        if (error) throw error

        // Show success message
        alert('Pet added successfully!')
        this.$router.push('/admin/pets')
      } catch (error) {
        console.error('Error adding pet:', error)
        alert('Failed to add pet. Please try again.')
      } finally {
        this.isSubmitting = false
      }
    },
    base64ToBlob(base64, type = 'application/octet-stream') {
      const binStr = window.atob(base64)
      const len = binStr.length
      const arr = new Uint8Array(len)
      for (let i = 0; i < len; i++) {
        arr[i] = binStr.charCodeAt(i)
      }
      return new Blob([arr], { type })
    },
    cancel() {
      this.$router.push('/admin/pets')
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

.add-pet-container {
  max-width: 1200px;
  margin: 0 auto;
}

.form-header {
  margin-bottom: 2rem;
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

.pet-form {
  background: #fff;
  border-radius: 12px;
  box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
  padding: 2rem;
}

.form-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
  gap: 2rem;
}

.form-section {
  background: #f8f9fa;
  border-radius: 8px;
  padding: 1.5rem;
}

.form-section h3 {
  color: #333;
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-row {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 1rem;
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

.photo-upload {
  margin-top: 1rem;
}

.upload-area {
  border: 2px dashed #e0e0e0;
  border-radius: 8px;
  padding: 2rem;
  text-align: center;
  cursor: pointer;
  transition: all 0.3s;
}

.upload-area:hover {
  border-color: #f7871f;
  background: #fff5eb;
}

.upload-content {
  color: #666;
}

.upload-content i {
  font-size: 2rem;
  color: #f7871f;
  margin-bottom: 1rem;
}

.upload-hint {
  display: block;
  font-size: 0.85rem;
  color: #888;
  margin-top: 0.5rem;
}

.photo-preview {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(100px, 1fr));
  gap: 1rem;
}

.preview-item {
  position: relative;
  aspect-ratio: 1;
}

.preview-item img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  border-radius: 8px;
}

.remove-photo {
  position: absolute;
  top: -8px;
  right: -8px;
  width: 24px;
  height: 24px;
  background: #ff4444;
  color: white;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem;
}

.add-more {
  aspect-ratio: 1;
  border: 2px dashed #e0e0e0;
  border-radius: 8px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  color: #666;
  transition: all 0.3s;
}

.add-more:hover {
  border-color: #f7871f;
  color: #f7871f;
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

.hidden {
  display: none;
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

  .add-pet-container {
    padding: 1rem;
  }

  .pet-form {
    padding: 1.5rem;
  }

  .form-grid {
    grid-template-columns: 1fr;
  }

  .form-row {
    grid-template-columns: 1fr;
  }
}
</style>