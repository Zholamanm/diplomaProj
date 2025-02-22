<template>
<DashboardNavbar @logout="handleLogout" />
  <div class="container  mt-4">
    <div class="row">
        <div class="col-md-3">
          <DashboardSidebar />
        </div>
      <div class="col-md-9">
        <div class="container  mt-4">
        <div v-if="isEditing">
          <h4>Edit Employee</h4>
          <form @submit.prevent="updateEmployee">
            <div class="form-group text-start mb-3">
              <label for="name">Name</label>
              <input v-model="employee.name" type="text" class="form-control" id="name" >
            </div>
            <div class="form-group text-start mb-3">
              <label for="email">Email</label>
              <input v-model="employee.email" type="email" class="form-control" id="email" >
            </div>
            <div class="form-group text-start mb-3">
              <label for="position">Position</label>
              <input v-model="employee.position" type="text" class="form-control" id="position" >
            </div>
            <div class="form-group text-start mb-3">
              <label for="salary">Salary</label>
              <input v-model.number="employee.salary" type="number" class="form-control" id="salary" >
            </div>
            <div class="text-start">
              <button type="submit" class="btn btn-dark btn-sm">Update Employee</button>
            </div>
          </form>
        </div>
        <div v-else>
          <h1>Add New Employee</h1>
          <form @submit.prevent="addEmployee">
            <div class="form-group text-start mb-3">
              <label for="name">Name</label>
              <input v-model="employee.name" type="text" class="form-control" id="name" >
              <span v-if="validationErrors.name" class="text-danger">{{ validationErrors.name[0] }}</span>
            </div>
            <div class="form-group text-start mb-3">
              <label for="email">Email</label>
              <input v-model="employee.email" type="email" class="form-control" id="email" >
              <span v-if="validationErrors.email" class="text-danger">{{ validationErrors.email[0] }}</span>
            </div>
            <div class="form-group text-start mb-3">
              <label for="position">Position</label>
              <input v-model="employee.position" type="text" class="form-control" id="position" >
              <span v-if="validationErrors.position" class="text-danger">{{ validationErrors.position[0] }}</span>
            </div>
            <div class="form-group text-start mb-3">
              <label for="salary">Salary</label>
              <input v-model.number="employee.salary" type="number" class="form-control" id="salary" >
              <span v-if="validationErrors.salary" class="text-danger">{{ validationErrors.salary[0] }}</span>
            </div>
            <div class="text-start">
              <button type="submit" class="btn btn-dark btn-sm">Add Employee</button>
            </div>
          </form>
        </div>
      </div>
       </div>
    </div>

  </div>
</template>

<script>
import axios from 'axios';
import DashboardNavbar from '@/components/common/DasboardNavbar.vue';
import DashboardSidebar from '@/components/dashboard/DashboardSidebar.vue';
export default {
  name: 'EmployeeForm',
  components: {
    DashboardNavbar,
    DashboardSidebar
  },
  data() {
    return {
      employee: {
        name: '',
        email: '',
        position: '',
        salary: null,
      },
      validationErrors: {},
      isEditing: false, 
    };
  },
  created() {
    this.checkIfEditing();
  },
  methods: {
    async fetchEmployee() {
      const employeeId = this.$route.params.id;
      try {
        const response = await axios.get(
          `http://localhost:8000/api/employees/${employeeId}`,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
          }
        );
        this.employee = response.data.data;
      } catch (error) {
        console.error("Error fetching employee:", error);
      }
    },
    checkIfEditing() {
      if (this.$route.params.id) {
        this.isEditing = true;
        this.fetchEmployee();
      } else {
        this.isEditing = false;
      }
    },
    async addEmployee() {
      try {
        await axios.post(
          'http://localhost:8000/api/employees',
          this.employee,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
          }
        );
        this.$router.push('/employee'); 
      } catch (error) {
        if (error.response && error.response.status === 422) {
          this.validationErrors = error.response.data.errors;
        } else {
          console.error("Error adding employee:", error);
        }
      }
    },
    async updateEmployee() {
      const employeeId = this.$route.params.id;
      try {
        await axios.put(
          `http://localhost:8000/api/employees/${employeeId}`,
          this.employee,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem('token')}`,
            },
          }
        );
        this.$router.push('/employee'); 
      } catch (error) {
        console.error("Error updating employee:", error);
      }
    }
  }
};
</script>

<style scoped>
.text-danger {
  font-size: 0.875em;
  margin-top: 0.25rem;
}
.container, .container-lg, .container-md, .container-sm, .container-xl {
        max-width: 1342px;
    }
</style>
