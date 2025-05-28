// src/router/index.js

import { createRouter, createWebHistory } from 'vue-router';
import AdminLogin from '../views/admin-login.vue';
import AddPet from '../views/admin/AddPet.vue';
import Applications from '../views/admin/Applications.vue';
import Appointments from '../views/admin/Appointments.vue';
import Dashboard from '../views/admin/Dashboard.vue';
import PetHistory from '../views/admin/PetHistory.vue';
import Pets from '../views/admin/Pets.vue';
import donations from '../views/donations.vue';
import HomeVue from '../views/home.vue';
import Login from '../views/login.vue';
import PetProfile from '../views/pet-profile.vue';
import PetProfiles from '../views/pet-profiles.vue';
import Signup from '../views/signup.vue';
import status from '../views/status.vue';
import stories from '../views/stories.vue';
import training from '../views/training.vue';

const routes = [
  {
    path: '/home',
    name: 'home',
    component: HomeVue
  },
  {
    path: '/pet-profile',
    name: 'petProfile',
    component: PetProfile
  },
  {
    path: '/donations',
    name: 'donations',
    component: donations
  },
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/signup',
    name: 'signup',
    component: Signup
  },
  {
    path: '/admin',
    name: 'admin',
    component: Dashboard
  },
  {
    path: '/admin/dashboard',
    name: 'adminDashboard',
    component: Dashboard
  },
  {
    path: '/admin/pets',
    name: 'adminPets',
    component: Pets
  },
  {
    path: '/admin/pets/add',
    name: 'adminAddPet',
    component: AddPet
  },
  {
    path: '/admin/applications',
    name: 'adminApplications',
    component: Applications
  },
  {
    path: '/admin/appointments',
    name: 'adminAppointments',
    component: Appointments
  },
  {
    path: '/admin/pet-history',
    name: 'adminPetHistory',
    component: PetHistory
  },
  {
    path: '/pet-profiles',
    name: 'petProfiles',
    component: PetProfiles
  },
  {
    path: '/',
    redirect: '/home'
  },
  {
    path: '/training',
    name: 'training',
    component: training
  },
  {
    path: '/stories',
    name: 'stories',
    component: stories
  },
  {
    path: '/status',
    name: 'status',
    component: status
  },
  {
    path: '/admin-login',
    name: 'adminLogin',
    component: AdminLogin
  }
]

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes,
})

export default router
