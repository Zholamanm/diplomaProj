<template>
  <div class="content-wrapper">
    <div class="container pt-5">
      <div class="card card-primary">
        <form class="text-start">
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputName1">Category name</label>
              <input v-model="form.name" type="text" class="form-control" id="exampleInputName1" placeholder="Enter name">
            </div>
          </div>
          <div class="card-footer">
            <div class="btn btn-primary" @click="store">Submit</div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import categoryApi from "@/api/Admin/CategoryApi";

export default {
  name: "CategoryCreate",
  data() {
    return {
      form: {
        name: null,
      },
      errors: []
    }
  },
  methods: {
    store() {
      this.errors = [];
      categoryApi.store(this.form).then(() => {
        this.loading = false;
        this.$router.push({name: 'CategoryIndex', params: {locale: this.$route.params.locale}});
      }).catch(err => {
        this.errors = err.response.data.errors;
        this.loading = false;
      });
    }
  }
}
</script>
<style scoped>

</style>