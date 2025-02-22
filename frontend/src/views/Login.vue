<template>
  <div class="container card p-3" style="margin-top: 150px;">
    <h2 class="mb-4">Login</h2>
    <form @submit.prevent="login">
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

      <div v-if="globalError" class="alert alert-danger">
        {{ globalError }}
      </div>

      <div class="text-start">
        <button type="submit" class="btn btn-sm btn-dark">Login</button>
      </div>
    </form>
    <div class="mt-3 text-end">
      <p>Don't have an account? </p>
      <router-link to="/register" class="btn btn-dark btn-sm">Register here.</router-link>
    </div>
  </div>
  <div class="underlay-photo"></div>
  <div class="underlay-black"></div>
</template>

<script>
import authApi from "@/api/AuthApi";

export default {
  name: 'LoginPage',
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
    login() {
      this.errors = false;
      this.loading = true;
      authApi.login(this.form).then(() => {
        this.loading = false;
          this.$router.push({name: 'DashboardView'});
      }).catch(() => {
        this.loading = false;
        this.errors = true;
      });

    }
  },
};
</script>

<style scoped>
@import url(https://fonts.googleapis.com/css?family=Open+Sans:100,300,400,700);
@import url(//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css);

body, html {
  height: 100%;
}
body {
  font-family: 'Open Sans';
  font-weight: 100;
  display: flex;
  overflow: hidden;
}

[class*=underlay] {
  left: 0;
  min-height: 100%;
  min-width: 100%;
  position: fixed;
  top: 0;
}
.underlay-photo {
  animation: hue-rotate 6s infinite;
  background: url('https://31.media.tumblr.com/41c01e3f366d61793e5a3df70e46b462/tumblr_n4vc8sDHsd1st5lhmo1_1280.jpg');
  background-size: cover;
  -webkit-filter: grayscale(30%);
  z-index: -1;
}
.underlay-black {
  background: rgba(0,0,0,0.7);
  z-index: -1;
}

@keyframes hue-rotate {
  from {
    -webkit-filter: grayscale(30%) hue-rotate(0deg);
  }
  to {
    -webkit-filter: grayscale(30%) hue-rotate(360deg);
  }
}
.container {
  max-width: 500px;
}

h2 {
  text-align: center;
}

.invalid-feedback {
  display: block;
}

.alert {
  margin-top: 1rem;
}
</style>
