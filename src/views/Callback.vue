<template>
  <div class="callback-container">
    <div class="loading-spinner"></div>
    <p>Completing sign up...</p>
  </div>
</template>

<script>
export default {
  name: 'CallbackPage',
  async mounted() {
    // The actual handling is done in the signup component
    // This component just shows a loading state
  }
};
</script>

<style scoped>
.callback-container {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  height: 100vh;
  background-color: #f4f6fa;
}

.loading-spinner {
  width: 50px;
  height: 50px;
  border: 5px solid #f3f3f3;
  border-top: 5px solid #f7871f;
  border-radius: 50%;
  animation: spin 1s linear infinite;
  margin-bottom: 20px;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

p {
  color: #666;
  font-size: 1.1rem;
}
</style>