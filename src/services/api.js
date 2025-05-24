// src/services/api.js
import axios from 'axios';

// Create axios instance with base URL and default headers
const api = axios.create({
  baseURL: 'http://localhost:5000/api',
  headers: {
    'Content-Type': 'application/json',
  }
});

// Request interceptor to add auth token to requests
api.interceptors.request.use(
  (config) => {
    const token = localStorage.getItem('token');
    if (token) {
      config.headers.Authorization = `Bearer ${token}`;
    }
    return config;
  },
  (error) => {
    return Promise.reject(error);
  }
);

// Response interceptor to handle common errors
api.interceptors.response.use(
  (response) => {
    return response;
  },
  (error) => {
    // Handle 401 Unauthorized errors (token expired or invalid)
    if (error.response && error.response.status === 401) {
      localStorage.removeItem('token');
      localStorage.removeItem('user');
      window.location.href = '/login';
    }
    return Promise.reject(error);
  }
);

// Authentication API
export const authAPI = {
  login: (email, password) => api.post('/auth/login', { email, password }),
  register: (userData) => api.post('/auth/register', userData),
  logout: () => api.post('/auth/logout'),
  getProfile: () => api.get('/profile'),
  updateProfile: (userData) => api.put('/profile', userData),
  updatePassword: (passwordData) => api.put('/profile/password', passwordData)
};

// Pets API
export const petsAPI = {
  getAll: (filters = {}) => api.get('/pets', { params: filters }),
  getById: (id) => api.get(`/pets/${id}`),
  create: (petData) => {
    const formData = new FormData();
    Object.keys(petData).forEach(key => {
      if (key === 'photo' && petData[key] instanceof File) {
        formData.append(key, petData[key]);
      } else {
        formData.append(key, petData[key]);
      }
    });
    return api.post('/pets', formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });
  },
  update: (id, petData) => {
    const formData = new FormData();
    Object.keys(petData).forEach(key => {
      if (key === 'photo' && petData[key] instanceof File) {
        formData.append(key, petData[key]);
      } else {
        formData.append(key, petData[key]);
      }
    });
    return api.put(`/pets/${id}`, formData, {
      headers: {
        'Content-Type': 'multipart/form-data'
      }
    });
  },
  delete: (id) => api.delete(`/pets/${id}`)
};

// Applications API
export const applicationsAPI = {
  getAll: () => api.get('/applications'),
  getById: (id) => api.get(`/applications/${id}`),
  create: (applicationData) => api.post('/applications', applicationData),
  updateStatus: (id, status) => api.put(`/applications/${id}/status`, { status })
};

export default api;
