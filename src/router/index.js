// src/router/index.js

import { createRouter, createWebHistory } from 'vue-router';
import Admin from '../views/Admin.vue';
import AdminAddPet from '../views/admin/AddPet.vue';
import AdminApplications from '../views/admin/Applications.vue';
import AdminAppointments from '../views/admin/Appointments.vue';
import AdminDashboard from '../views/admin/Dashboard.vue';
import AdminPetHistory from '../views/admin/PetHistory.vue';
import AdminPets from '../views/admin/Pets.vue';
import Donations from '../views/donations.vue';
import HomeVue from '../views/home.vue';
import Login from '../views/login.vue';
import News from '../views/News.vue';
import PetProfile from '../views/pet-profile.vue';
import PetProfiles from '../views/pet-profiles.vue';
import Profile from '../views/Profile.vue';
import Signup from '../views/signup.vue';
import Status from '../views/status.vue';
import Stories from '../views/stories.vue';
import Training from '../views/training.vue';

const routes = [
  {
    path: '/admin',
    name: 'admin',
    component: Admin,
    children: [
      {
        path: '',
        name: 'adminDashboard',
        component: AdminDashboard
      },
      {
        path: 'pets',
        name: 'adminPets',
        component: AdminPets
      },
      {
        path: 'pets/add',
        name: 'adminAddPet',
        component: AdminAddPet
      },
      {
        path: 'applications',
        name: 'adminApplications',
        component: AdminApplications
      },
      {
        path: 'appointments',
        name: 'adminAppointments',
        component: AdminAppointments
      },
      {
        path: 'pet-history',
        name: 'adminPetHistory',
        component: AdminPetHistory
      }
    ]
  },
  {
    path: '/home',
    name: 'home',
    component: HomeVue,
  },
  {
    path: '/pet-profile',
    name: 'petProfile',
    component: PetProfile,
  },

  {
    path: '/news',
    name: 'news',
    component: News,
  },
  {
    path: '/donations',
    name: 'donations',
    component: Donations,
  },
  {
    path: '/login',
    name: 'login',
    component: Login,
  },
  {
    path: '/signup',
    name: 'signup',
    component: Signup,
  },
  {
    path: '/pet-profiles',
    name: 'petProfiles',
    component: PetProfiles,
  },
  {
    path: '/',
    redirect: '/home',
  },
  {
    path: '/training',
    name: 'training',
    component: Training,
  },
  {
    path: '/stories',
    name: 'stories',
    component: Stories,
  },
  {
    path: '/status',
    name: 'status',
    component: Status,
  },
  {
    path: '/profile',
    name: 'Profile',
    component: Profile,
    meta: { requiresAuth: true }
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

// Add navigation guard
router.beforeEach((to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth)
  const token = localStorage.getItem('token')

  if (requiresAuth && !token) {
    next('/login')
  } else {
    next()
  }
})

export default router
