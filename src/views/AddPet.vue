<template>
  <div class="add-pet">
    <h1 class="text-2xl font-bold mb-6">Add New Pet</h1>

    <form @submit.prevent="handleSubmit" class="max-w-2xl">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Pet Name -->
        <div class="form-group">
          <label for="name" class="block text-sm font-medium text-gray-700">Pet Name</label>
          <input
            type="text"
            id="name"
            v-model="form.name"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
          />
        </div>

        <!-- Pet Type -->
        <div class="form-group">
          <label for="type" class="block text-sm font-medium text-gray-700">Pet Type</label>
          <select
            id="type"
            v-model="form.type"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
          >
            <option value="">Select Type</option>
            <option value="Dog">Dog</option>
            <option value="Cat">Cat</option>
            <option value="Bird">Bird</option>
            <option value="Other">Other</option>
          </select>
        </div>

        <!-- Breed -->
        <div class="form-group">
          <label for="breed" class="block text-sm font-medium text-gray-700">Breed</label>
          <input
            type="text"
            id="breed"
            v-model="form.breed"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
          />
        </div>

        <!-- Age -->
        <div class="form-group">
          <label for="age" class="block text-sm font-medium text-gray-700">Age (years)</label>
          <input
            type="number"
            id="age"
            v-model="form.age"
            min="0"
            max="30"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
          />
        </div>

        <!-- Status -->
        <div class="form-group">
          <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
          <select
            id="status"
            v-model="form.status"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            required
          >
            <option value="Available">Available</option>
            <option value="Pending">Pending</option>
            <option value="Adopted">Adopted</option>
          </select>
        </div>

        <!-- Photo Upload -->
        <div class="form-group">
          <label for="photo" class="block text-sm font-medium text-gray-700">Photo</label>
          <input
            type="file"
            id="photo"
            @change="handlePhotoUpload"
            accept="image/*"
            class="mt-1 block w-full"
          />
          <div v-if="photoPreview" class="mt-2">
            <img :src="photoPreview" alt="Preview" class="h-32 w-32 object-cover rounded-lg" />
          </div>
        </div>
      </div>

      <!-- Description -->
      <div class="form-group mt-6">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea
          id="description"
          v-model="form.description"
          rows="4"
          class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          required
        ></textarea>
      </div>

      <!-- Submit Button -->
      <div class="mt-6">
        <button
          type="submit"
          class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
          :disabled="isSubmitting"
        >
          <span v-if="isSubmitting">Adding Pet...</span>
          <span v-else>Add Pet</span>
        </button>
      </div>
    </form>
  </div>
</template>

<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { useToast } from 'vue-toastification'

const toast = useToast()
const router = useRouter()

const form = reactive({
  name: '',
  type: '',
  breed: '',
  age: '',
  description: '',
  status: 'Available',
  photo: null
})

const photoPreview = ref(null)
const isSubmitting = ref(false)

const handlePhotoUpload = (event) => {
  const file = event.target.files[0]
  if (file) {
    form.photo = file
    const reader = new FileReader()
    reader.onload = (e) => {
      photoPreview.value = e.target.result
    }
    reader.readAsDataURL(file)
  }
}

const handleSubmit = async () => {
  try {
    isSubmitting.value = true

    // Create FormData for file upload
    const formData = new FormData()
    Object.keys(form).forEach(key => {
      if (key === 'photo' && form[key]) {
        formData.append(key, form[key])
      } else {
        formData.append(key, form[key])
      }
    })

    const response = await fetch('http://localhost/Pawfect-master/backend/pets.php', {
      method: 'POST',
      headers: {
        'Authorization': `Bearer ${localStorage.getItem('token')}`
      },
      body: formData
    })

    const data = await response.json()

    if (!response.ok) {
      throw new Error(data.error || 'Failed to add pet')
    }

    toast.success('Pet added successfully!')
    router.push('/admin/pets')
  } catch (error) {
    toast.error(error.message || 'Failed to add pet')
  } finally {
    isSubmitting.value = false
  }
}
</script>

<style scoped>
.add-pet {
  padding: 2rem;
}

.form-group {
  margin-bottom: 1rem;
}

input[type="file"] {
  padding: 0.5rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.375rem;
  width: 100%;
}
</style>