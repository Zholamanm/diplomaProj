<template>
  <div class="container mt-5">
    <h2 class="mb-4">Welcome to the Home Page</h2>
    <p>This is the main landing page for your application.</p>
    <div class="mt-4">
      <router-link to="/dashboard" class="btn btn-primary">Go to Dashboard</router-link>
    </div>
  </div>
</template>

<script>
export default {
  name: 'HomePage',
};
</script>

<style scoped>
.container {
  max-width: 800px;
}

h2 {
  text-align: center;
}
</style>
