<template>
  <div class="container card mt-5 p-3">
    <h3 class="mb-4">Register</h3>
    <form @submit.prevent="register">
      <div class="form-group mb-3 text-start">
        <label for="name">Name:</label>
        <input
          type="text"
          id="name"
          v-model="form.name"
          class="form-control"
          :class="{ 'is-invalid': errors.name }"
          required
        />
        <div v-if="errors.name" class="invalid-feedback">
          {{ errors.name[0] }}
        </div>
      </div>

      <div class="form-group mb-3 text-start">
        <label for="email">Email:</label>
        <input
          type="email"
          id="email"
          v-model="form.email"
          class="form-control"
          :class="{ 'is-invalid': errors.email }"
          required
        />
        <div v-if="errors.email" class="invalid-feedback">
          {{ errors.email[0] }}
        </div>
      </div>

      <div class="form-group mb-3 text-start">
        <label for="password">Password:</label>
        <input
          type="password"
          id="password"
          v-model="form.password"
          class="form-control"
          :class="{ 'is-invalid': errors.password }"
          required
        />
        <div v-if="errors.password" class="invalid-feedback">
          {{ errors.password[0] }}
        </div>
      </div>

      <div class="form-group mb-3 text-start">
        <label for="password_confirmation">Confirm Password:</label>
        <input
          type="password"
          id="password_confirmation"
          v-model="form.password_confirmation"
          class="form-control"
          :class="{ 'is-invalid': errors.password_confirmation }"
          required
        />
        <div v-if="errors.password_confirmation" class="invalid-feedback">
          {{ errors.password_confirmation[0] }}
        </div>
      </div>

      <div class="text-start">
        <button type="submit" class="btn btn-dark btn-sm">Register</button> &nbsp;
        <router-link to="/login" class="btn btn-secondary btn-sm text-blue">
            <small>Login</small>
        </router-link>
      </div>
  </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'UserRegister', 
  data() {
    return {
      form: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
      },
      errors: {},
    };
  },
  methods: {
    register() {
      axios
        .post('http://localhost:8000/api/register', this.form)
        .then((response) => {
          console.log(response.data);
          this.$router.push('/login');
        })
        .catch((error) => {
          if (error.response && error.response.data) {
            this.errors = error.response.data.errors;
          }
        });
    },
  },
};
</script>

<style scoped>
.container {
  max-width: 500px;
}

h2 {
  text-align: center;
}

.invalid-feedback {
  display: block;
}
</style>
