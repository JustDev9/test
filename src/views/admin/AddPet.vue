<template>
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
</template>

<script>
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
        // Replace with actual API call
        await fetch('http://localhost/Pawfect-master/backend/admin/pets.php', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(this.petData)
        })

        this.$router.push('/admin/pets')
      } catch (error) {
        console.error('Error adding pet:', error)
      } finally {
        this.isSubmitting = false
      }
    },
    cancel() {
      this.$router.push('/admin/pets')
    }
  }
}
</script>

<style scoped>
.add-pet-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 1rem;
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