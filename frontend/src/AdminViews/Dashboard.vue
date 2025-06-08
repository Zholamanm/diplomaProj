<template>
  <div class="content-wrapper">
    <!-- Content Header -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard Overview</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard</li>
            </ol>
          </div>
        </div>
      </div>
    </div>

    <!-- Main Content -->
    <section class="content" v-if="borrows.length !== 0">
      <div class="container-fluid">
        <!-- Stats Cards -->
        <div class="row stats-grid">
          <div class="col-lg-3 col-6" v-if="users" @click="tab = 1">
            <div class="stat-card bg-gradient-info">
              <div class="inner">
                <h3>{{ users.length }}</h3>
                <p>Users</p>
              </div>
              <div class="icon">
                <i class="fas fa-users"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6" v-if="books" @click="tab = 2">
            <div class="stat-card bg-gradient-success">
              <div class="inner">
                <h3>{{ books.length }}</h3>
                <p>Books</p>
              </div>
              <div class="icon">
                <i class="fas fa-book"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6" v-if="locations" @click="tab = 3">
            <div class="stat-card bg-gradient-warning">
              <div class="inner">
                <h3>{{ locations.length }}</h3>
                <p>Locations</p>
              </div>
              <div class="icon">
                <i class="fas fa-map-marker-alt"></i>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-6" v-if="borrows"  @click="tab = 4">
            <div class="stat-card bg-gradient-danger">
              <div class="inner">
                <h3>{{ borrows.length }}</h3>
                <p>Borrows</p>
              </div>
              <div class="icon">
                <i class="fas fa-exchange-alt"></i>
              </div>
            </div>
          </div>
        </div>
      </div>
      <user-dashboard v-if="tab === 1 && $store.state.user.user.role_id === 1" />
      <book-dashboard v-if="tab === 2 &&  $store.state.user.user.role_id === 1"/>
      <location-books-dashboard  v-if="tab === 3 &&  $store.state.user.user.role_id === 1"/>
    </section>

    <InfiniteLoading v-if="loading">
      <template #spinner>
        <div class="loading-spinner">
          <div class="spinner-circle"></div>
        </div>
      </template>
    </InfiniteLoading>
  </div>
</template>
<script>

import usersApi from "@/api/usersApi";
import locationApi from "@/api/Admin/LocationApi";
import bookApi from "@/api/Admin/BookApi";
import borrowApi from "@/api/Admin/BorrowApi";
import LocationBooksDashboard from "@/AdminViews/LocationBooksDashboard.vue";
import BookDashboard from "@/AdminViews/BookDashboard.vue";
import UserDashboard from "@/AdminViews/UserDashboard.vue";

export default {
  name: 'DashboardView',
  components: {UserDashboard, BookDashboard, LocationBooksDashboard},
  data() {
    return {
      tab: 1,
      loading: false,
      users: [],
      books: [],
      locations: [],
      borrows: [],
      errors: {},
      globalError: null,
    };
  },
  methods: {
    getUsers() {
      this.loading = true
      usersApi.getList().then(res => {
        this.users = res;
      })
    },
    getBooks() {
      bookApi.get().then(res => {
        this.books = res;
      })
    },
    getLocations() {
      locationApi.get().then(res => {
        this.locations = res;
      })
    },
    getBorrows() {
      borrowApi.get().then(res => {
        this.borrows = res;
        this.loading = false
      })
    },
    loadData() {
      this.getUsers()
      this.getLocations()
      this.getBooks()
      this.getBorrows()
    }
  },
  mounted() {
    this.loadData()
  }
};
</script>
<style scoped>
/* Content Header */
.content-header {
  padding: 15px 0.5rem;
}

.content-header h1 {
  font-weight: 600;
  color: #2c3e50;
  font-size: 1.8rem;
}

.breadcrumb {
  background-color: transparent;
  padding: 0;
  font-size: 0.9rem;
}

.breadcrumb-item.active {
  color: #6c757d;
  font-weight: 500;
}

/* Stat Cards */
.stats-grid {
  margin: 0 -10px;
}

.stat-card {
  border-radius: 10px;
  color: white;
  padding: 15px;
  margin-bottom: 20px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.05);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  overflow: hidden;
  position: relative;
}

.stat-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.stat-card .inner h3 {
  font-size: 1.8rem;
  font-weight: 700;
  margin: 0 0 5px 0;
}

.stat-card .inner p {
  font-size: 1rem;
  margin: 0;
  opacity: 0.9;
}

.stat-card .icon {
  position: absolute;
  top: 15px;
  right: 15px;
  font-size: 2.5rem;
  opacity: 0.2;
  transition: all 0.3s ease;
}

.stat-card:hover .icon {
  opacity: 0.3;
  transform: scale(1.1);
}

/* Gradient Backgrounds */
.bg-gradient-info {
  background: linear-gradient(135deg, #17a2b8 0%, #1abc9c 100%);
}

.bg-gradient-success {
  background: linear-gradient(135deg, #28a745 0%, #5cb85c 100%);
}

.bg-gradient-warning {
  background: linear-gradient(135deg, #ffc107 0%, #f0ad4e 100%);
}

.bg-gradient-danger {
  background: linear-gradient(135deg, #dc3545 0%, #d9534f 100%);
}

/* Loading Spinner */
.loading-spinner {
  display: flex;
  justify-content: center;
  padding: 30px 0;
}

.spinner-circle {
  width: 40px;
  height: 40px;
  border: 4px solid rgba(52, 152, 219, 0.2);
  border-top-color: #3498db;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  to { transform: rotate(360deg); }
}
</style>