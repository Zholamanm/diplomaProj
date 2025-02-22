<template>
  <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
      <!-- Brand Logo -->
      <router-link to="/dashboard" class="navbar-brand font-weight-bold">
        <img src="@/assets/logo.png" alt="Logo" class="logo mr-2" />
        My Dashboard
      </router-link>

      <!-- Responsive Toggle Button -->
      <button
        class="navbar-toggler"
        type="button"
        data-toggle="collapse"
        data-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>

     <!-- Navbar Links -->
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto"> <!-- Use me-auto to push logout to the right -->
        <li class="nav-item">
          <router-link to="/dashboard" class="nav-link">
            <small>Home</small>
          </router-link>
        </li>
        <li class="nav-item">
          <router-link to="/employee" class="nav-link">
            <small>Employees</small>
          </router-link>
        </li>
      </ul>
      <ul class="navbar-nav ms-auto"> <!-- Use ms-auto to align logout to the right -->
        <li class="nav-item">
          <router-link to="/login" class="nav-link" @click="logout">
            <small>Logout</small>
          </router-link>
        </li>
      </ul>
    </div>

    </div>
  </nav>
</template>

<script>
export default {
  name: 'DashboardNavbar',
  methods: {
    logout() {
      this.$emit('logout');
    }
  }
};
</script>

<style scoped>
.navbar {
  margin-bottom: 20px;
}

.navbar-brand {
  font-size: 1.5rem;
  color: #333;
}

.navbar-brand .logo {
  width: 30px;
  height: 30px;
}

.nav-link {
  color: #555;
  font-size: 1.1rem;
  transition: color 0.3s;
}

.nav-link:hover {
  color: #007bff;
}

.navbar-toggler {
  border: none;
}

.navbar-toggler-icon {
  color: #555;
}

@media (max-width: 767px) {
  .navbar-nav {
    text-align: center;
  }
}
</style>
