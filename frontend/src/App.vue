<template>
  <auth-provider>
    <RouterView/>
  </auth-provider>
</template>

<script>
import AuthProvider from "./providers/AuthProvider";
export default {
  name: 'App',
  components: {AuthProvider},
  computed: {
    authorized() {
      return this.$store.state.auth.authorized;
    },
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
}
</style>
