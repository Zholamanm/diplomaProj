<template>
  <div class="container card p-3" style="margin-top: 150px;">
    <h2 class="mb-4">Login</h2>

    <!-- Email/password login form -->
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

    <hr />

    <!-- Google Sign-in button -->
    <div class="mt-3 text-center">
      <button @click="loginWithGoogle" class="btn btn-outline-primary w-100">
        <i class="fa fa-google me-2"></i> Sign in with Google
      </button>
    </div>

    <div class="mt-3 text-end">
      <p>Don't have an account? </p>
      <a href="#!" class="btn btn-dark btn-sm" @click.prevent="$router.push({name: 'RegisterPage', params: { locale: $route.params.locale }})">Register here.</a>
    </div>
  </div>

  <div class="underlay-photo"></div>
  <div class="underlay-black"></div>
</template>

<script>
import authApi from "@/api/AuthApi";
import { messaging, getToken } from '@/firebase';

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
      loading: false,
    };
  },
  methods: {
    async login() {
      this.errors = {};
      this.globalError = null;
      this.loading = true;
      try {
        await authApi.login(this.form);
        await this.registerFcmToken();
        this.$router.push({ name: 'CatalogView' });
      } catch (error) {
        this.loading = false;
        this.errors = error.response?.data?.errors || {};
        this.globalError = error.response?.data?.message || 'Login failed';
      }
    },

    async loginWithGoogle() {
      this.errors = {};
      this.globalError = null;
      this.loading = true;

      try {
        await authApi.signInWithGoogle();
        await this.registerFcmToken();

        this.$router.push({ name: 'CatalogView' });
      } catch (error) {
        this.loading = false;
        this.globalError = 'Google login failed';
        console.error(error);
      }
    },

    async registerFcmToken() {
      try {
        const permission = await Notification.requestPermission();
        if (permission === 'granted') {
          const vapidKey = 'BA4R0_gkHFZmIsSzW0luYnMF9cHpvwLLepxatb9jU2o31pZwobYQGYHhwZ8mmgTj2kQuS7vvEhN1JzwO7SFRxuY';
          const currentToken = await getToken(messaging, { vapidKey });
          if (currentToken) {
            await authApi.setFcmToken(currentToken);
          }
        }
      } catch (e) {
        console.warn('FCM token registration failed', e);
      }
    }
  }
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
