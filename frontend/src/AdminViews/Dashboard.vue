<template>
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0">Dashboard</h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Dashboard v1</li>
            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content"  v-if="borrows.length !== 0">
      <div class="container-fluid">
        <!-- Small boxes (Stat box) -->
        <div class="row">
          <div class="col-lg-3 col-6" v-if="users">
            <!-- small box -->
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{ users.length }}</h3>

                <p>Users</p>
              </div>
              <div class="icon">
                <i class="ion ion-bag"></i>
              </div>
<!--              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6" v-if="books">
            <!-- small box -->
            <div class="small-box bg-success">
              <div class="inner">
                <h3>{{ books.length }}</h3>

                <p>Books</p>
              </div>
              <div class="icon">
                <i class="ion ion-stats-bars"></i>
              </div>
<!--              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6" v-if="locations">
            <!-- small box -->
            <div class="small-box bg-warning">
              <div class="inner">
                <h3>{{ locations.length }}</h3>

                <p>Locations</p>
              </div>
              <div class="icon">
                <i class="ion ion-person-add"></i>
              </div>
<!--              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
            </div>
          </div>
          <!-- ./col -->
          <div class="col-lg-3 col-6" v-if="borrows">
            <!-- small box -->
            <div class="small-box bg-danger">
              <div class="inner">
                <h3>{{ borrows.length }}</h3>

                <p>Borrows</p>
              </div>
              <div class="icon">
                <i class="ion ion-pie-graph"></i>
              </div>
<!--              <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>-->
            </div>
          </div>
          <!-- ./col -->
        </div>
      </div><!-- /.container-fluid -->
    </section>
    <InfiniteLoading v-if="loading">
      <template #spinner>
        <div class="custom-spinner">
          <svg
              class="loading-icon"
              viewBox="0 0 50 50"
          >
            <circle
                class="path"
                cx="25"
                cy="25"
                r="20"
                fill="none"
                stroke-width="5"
                stroke="green"
                stroke-dasharray="80, 100"
                stroke-dashoffset="0" x
            ></circle>
          </svg>
        </div>
      </template>
    </InfiniteLoading>

    <!-- /.content -->
  </div>
</template>
<script>

import usersApi from "@/api/usersApi";
import locationApi from "@/api/Admin/LocationApi";
import bookApi from "@/api/Admin/BookApi";
import borrowApi from "@/api/Admin/BorrowApi";

export default {
  name: 'DashboardView',
  data() {
    return {
      loading: false,
      form: {
        email: '',
        password: '',
      },
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
        this.books = res.data;
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
/* Custom Loader */
.custom-spinner {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 50px;
}

.loading-icon {
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
  stroke: #4CAF50;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.actions {
  justify-content: space-around;
  flex-direction: row;
  display: flex;
}
.icon-warning {
  display: block;
  margin: 0 auto 16px;
  width: 48px;
  height: 48px;
  color: #9CA3AF; /* Gray */
}

/* === Confirmation Text === */
.confirm-text {
  font-size: 1rem;
  color: #6B7280; /* Gray */
  margin-bottom: 16px;
}

/* === Button Group === */
.button-group {
  display: flex;
  justify-content: center;
  gap: 12px;
}

/* === Delete Button === */
.btn-delete {
  background-color: #DC2626; /* Red */
  color: white;
  font-size: 0.875rem;
  font-weight: 500;
  border-radius: 8px;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  transition: background 0.2s;
}

.btn-delete:hover {
  background-color: #B91C1C; /* Darker Red */
}

.btn-delete:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* === Cancel Button === */
.btn-cancel {
  background-color: white;
  color: #374151; /* Dark Gray */
  font-size: 0.875rem;
  font-weight: 500;
  border: 1px solid #D1D5DB; /* Light Gray Border */
  border-radius: 8px;
  padding: 10px 20px;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
}

.btn-cancel:hover {
  background-color: #F3F4F6; /* Light Gray */
  color: #2563EB; /* Blue */
}
</style>