<template>
  <div class="content-wrapper">
    <div class="container pt-5">
      <div class="card card-primary">
        <form class="text-start">
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputName1">Tag name</label>
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
import tagApi from "@/api/Admin/TagApi";

export default {
  name: "TagCreate",
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
      tagApi.store(this.form).then(() => {
        this.loading = false;
        this.$router.push({name: 'TagIndex', params: {locale: this.$route.params.locale}});
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