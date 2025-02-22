<template>
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="#" role="button" @click="toggleSidebar"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="index3.html" class="nav-link">Home</a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">Contact</a>
      </li>
    </ul>
    <ul class="navbar-nav ml-auto">
      <li class="nav-item d-none d-sm-inline-block">
        <a href="" class="nav-link" @click="logout()">Logout</a>
      </li>
    </ul>
  </nav>
</template>
<script>

import authApi from "@/api/AuthApi";

export default {
  name: 'HeaderView',
  data() {
    return {
      form: {
        email: '',
        password: '',
      },
      errors: {},
      globalError: null,
    };
  },
  methods: {
    toggleSidebar() {
      document.body.classList.toggle('sidebar-collapse');
    },
    logout() {
      authApi.logout();
    },
  },
  mounted() {
  }
};
</script>
<style scoped>
.main-header{
  z-index: 0;
}
</style>