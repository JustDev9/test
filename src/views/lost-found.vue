<template>
    <h1>Lost & Found</h1>
    <p>Lost & Found page content goes here.</p>
</template>

<style scoped>
body {
  margin: 0;
  font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
  background-color: #f9fafb;
  color: #333;
}

/* Navigation */
.navbar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  background-color: white;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
  z-index: 100;
}

.container {
  width: 100%;
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

.nav-content {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0.75rem 0;
}

.logo {
  display: flex;
  align-items: center;
  text-decoration: none;
}

.logo-icon {
  color: #ea580c;
  font-size: 2.25rem;
  margin-right: 0.5rem;
}

.logo-text {
  font-size: 1.875rem;
  font-weight: 700;
  color: #ea580c;
}

.nav-links {
  display: none;
}

.nav-link {
  color: #374151;
  font-weight: 500;
  text-decoration: none;
  transition: color 0.2s;
}

.nav-link:hover {
  color: #ea580c;
}

.dropdown {
  position: relative;
}

.dropdown-menu {
  position: absolute;
  left: 0;
  top: 100%;
  margin-top: 0.5rem;
  width: 12rem;
  background-color: white;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  border-radius: 0.375rem;
  padding: 0.5rem 0;
  display: none;
  z-index: 10;
}

.dropdown:hover .dropdown-menu {
  display: block;
}

.dropdown-item {
  display: block;
  padding: 0.5rem 1rem;
  color: #374151;
  text-decoration: none;
  font-size: 0.875rem;
}

.dropdown-item:hover {
  background-color: #f3f4f6;
}

.btn-primary {
  background-color: #ea580c;
  color: white;
  padding: 0.5rem 1.5rem;
  border-radius: 9999px;
  font-weight: 500;
  border: none;
  cursor: pointer;
  transition: background-color 0.2s;
}

.btn-primary:hover {
  background-color: #c2410c;
}

/* Mobile Menu */
.mobile-menu {
  display: none;
  background-color: white;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
}

.mobile-menu-link {
  display: block;
  padding: 0.5rem 0;
  color: #374151;
  text-decoration: none;
}

.mobile-menu-link:hover {
  color: #9333ea;
}

/* Hero Section */
.hero {
  position: relative;
  padding-top: 5rem;
  overflow: hidden;
}

.hero-image-container {
  position: relative;
  height: 600px;
  overflow: hidden;
}

.hero-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(90deg, rgba(234, 88, 12, 0.8) 0%, rgba(234, 88, 12, 0) 100%);
  z-index: 10;
}

.hero-image {
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: top;
}

.hero-content {
  position: relative;
  z-index: 20;
  max-width: 42rem;
  color: white;
}

.hero-title {
  font-size: 3rem;
  font-weight: 700;
  margin-bottom: 1rem;
}

.hero-description {
  font-size: 1.25rem;
  margin-bottom: 2rem;
}

.btn-white {
  background-color: white;
  color: #ea580c;
  padding: 0.75rem 2rem;
  border-radius: 9999px;
  font-weight: 700;
  font-size: 1.125rem;
  border: none;
  cursor: pointer;
  box-shadow: 0 4px 6px rgba(0,0,0,0.1);
  transition: background-color 0.2s;
}

.btn-white:hover {
  background-color: #f3f4f6;
}

/* Adoption Process */
.section {
  padding: 5rem 0;
}

.section-title {
  font-size: 2.25rem;
  font-weight: 700;
  color: #1f2937;
  margin-bottom: 1rem;
  text-align: center;
}

.section-description {
  font-size: 1.25rem;
  color: #4b5563;
  max-width: 48rem;
  margin: 0 auto 4rem;
  text-align: center;
}

.grid {
  display: grid;
  gap: 2rem;
}

.grid-cols-1 {
  grid-template-columns: repeat(1, 1fr);
}

.grid-cols-2 {
  grid-template-columns: repeat(2, 1fr);
}

.grid-cols-3 {
  grid-template-columns: repeat(3, 1fr);
}

.grid-cols-4 {
  grid-template-columns: repeat(4, 1fr);
}

.process-card {
  background-color: #fff7ed;
}
</style>

<script>
export default {
  name: 'LostFound'
}
</script>