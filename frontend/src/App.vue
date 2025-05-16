<template>
  <auth-provider>
    <RouterView/>
  </auth-provider>
</template>

<script>
import AuthProvider from "./providers/AuthProvider";
import commonData from "./api/commonData";
import store from "./store";
export default {
  name: 'App',
  components: {AuthProvider},
  data() {
    return {
      commonIsReady: false
    };
  },
  computed: {
    authorized() {
      return this.$store.state.auth.authorized;
    },
    locale() {
      return this.$route.params.locale;
    },
  },
  methods: {
    loadData() {
      commonData.getCommonData().then(res => {
        let tmp = res;
        store.commit('setData', tmp);
        this.commonIsReady = true;
      });
    }
  },
  mounted() {
    this.loadData();
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

body {
  background: linear-gradient(to bottom, #f8f9fa, #e9ecef);}
</style>
