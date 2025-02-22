<template>
  <footer class="main-footer">
    <strong>Copyright © 2025 <a href="">Diploma</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Version</b> 3.2.0
    </div>
  </footer>
</template>
<script>

export default {
  name: 'FooterView',
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
  },
  mounted() {
  }
};
</script>
