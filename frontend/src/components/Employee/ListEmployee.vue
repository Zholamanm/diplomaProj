<template>
  <DashboardNavbar @logout="handleLogout" />
  <div class="container card">
      <div class="row">
            <div class="col-md-3">
              <DashboardSidebar />
            </div>

          <div class="col-md-9">
            <h1 class="mb-4">Employee Management</h1>
            <div class="container  mt-4 pb-3">
              
              <!-- Error Alert -->
              <div v-if="deleteError" class="alert alert-danger">
                {{ deleteError }}
              </div>
              <!-- Filter Inputs -->
              <div class="row mb-4">
               
                <div class="col-md-3">
                  <input v-model="filters.name" class="form-control" placeholder="Filter by name">
                </div>
                <div class="col-md-3">
                  <input v-model="filters.position" class="form-control" placeholder="Filter by position">
                </div>
                <div class="col-md-2">
                  <input v-model.number="filters.salary_min" type="number" class="form-control" placeholder="Min salary">
                </div>
                <div class="col-md-2">
                  <input v-model.number="filters.salary_max" type="number" class="form-control" placeholder="Max salary">
                </div>
                <div class="col-md-2">
                  <button @click="fetchEmployees" class="btn btn-sm btn-dark w-100">Search</button>
                  <button @click="clearFilters" class="btn btn-sm btn-dark btn-outline w-100 mt-2">Clear</button>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 text-end mb-2">
                  <button @click="addEmployee()" class="btn btn-dark btn-sm">Add Employee +</button>
                </div>
              </div>
              
              <!-- Employee Table -->
              <table class="table table-striped table-bordered">
                <thead class="thead-dark">
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Position</th>
                    <th>Salary</th>
                    <th class="w-25">Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="employee in employees.data" :key="employee.id">
                    <td>{{ employee.name }}</td>
                    <td>{{ employee.email }}</td>
                    <td>{{ employee.position }}</td>
                    <td>{{ employee.salary }}</td>
                    <td>
                      <button @click="editEmployee(employee)" class="btn btn-secondary btn-sm me-2">Edit</button>
                      
                      <button @click="confirmDelete(employee.id)" class="btn btn-secondary btn-sm">Delete</button>
                    </td>
                  </tr>
                </tbody>
              </table>

              <!-- Pagination Component -->
              <PaginationComponent :meta="employees.meta" @page-changed="fetchEmployees" />
            </div>
            </div>
      </div>
    </div>
</template>

<script>
import axios from 'axios';
import PaginationComponent from './PaginationComponent.vue';
import DashboardNavbar from '@/components/common/DasboardNavbar.vue';
import DashboardSidebar from '@/components/dashboard/DashboardSidebar.vue';
export default {
  name: 'EmployeeCrud',
  components: {
    PaginationComponent,
    DashboardNavbar,
    DashboardSidebar
  },
  data() {
    return {
      employees: {
        data: [],
        current_page: 1,
        last_page: 1,
        per_page: 10,
        total: 0,
      },
      filters: {
        name: '',
        position: '',
        salary_min: null,
        salary_max: null,
      },
      deleteError: null, 
      isLoading: false, 
    };
  },
  methods: {
    async fetchEmployees(page = 1) {
    try {
      const response = await axios.get('http://localhost:8000/api/employees', {
        params: {
          ...this.filters,
          page
        },
        headers: {
          Authorization: `Bearer ${localStorage.getItem('token')}`,
        }
      });
      this.employees = response.data;
    } catch (error) {
      console.error("Error fetching employees:", error);
    }
  },

    
    confirmDelete(id) {
      if (confirm("Are you sure you want to delete this employee?")) {
        this.deleteEmployee(id);
      }
    },

    async deleteEmployee(id) {
      this.isLoading = true;
      const originalEmployees = [...this.employees.data]; 

      try {
        this.employees.data = this.employees.data.filter(employee => employee.id !== id);

        await axios.delete(`http://localhost:8000/api/employees/${id}`, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        });
        alert('Employee deleted successfully');
      } catch (error) {
        this.employees.data = originalEmployees;

        if (error.response) {
          this.deleteError = error.response.data.message || 'Error deleting employee';
        } else {
          console.error("Error deleting employee:", error);
          this.deleteError = 'An unexpected error occurred while trying to delete the employee.';
        }
      } finally {
        this.isLoading = false;
      }
    },

    editEmployee(employee) {
      this.$router.push({ name: 'EditEmployee', params: { id: employee.id } });
    },
    addEmployee() {
      this.$router.push({ name: 'AddEmployee' });
    },
    clearFilters() {
      this.filters = {
        name: '',
        position: '',
        salary_min: null,
        salary_max: null
      };
      this.fetchEmployees();
    }
  },
  created() {
    this.fetchEmployees();
  },
};
</script>

<style scoped>
.container, .container-lg, .container-md, .container-sm, .container-xl {
        max-width: 1342px;
    }
</style>
