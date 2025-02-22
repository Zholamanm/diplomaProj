<template>
  <div class="DashboardSidebar" style="height: 600px">
    <h4>Menu</h4>
    <ul class="list-unstyled">
      <li><router-link to="/">Home</router-link></li>
      <li><router-link to="/employee">Employee</router-link></li>
    </ul>
  </div>
</template>

<script>
export default {
  name: 'DashboardSidebar'
};
</script>

<style scoped>
.DashboardSidebar {
  padding: 15px;
  border-right: 1px solid #ddd;
}
.DashboardSidebar h4 {
  margin-bottom: 15px;
}
.DashboardSidebar ul {
  padding-left: 0;
}
.DashboardSidebar ul li {
  margin-bottom: 10px;
}
</style>
