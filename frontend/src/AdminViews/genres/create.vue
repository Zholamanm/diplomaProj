<template>
  <div class="content-wrapper">
    <div class="container pt-5">
      <div class="card card-primary">
        <form class="text-start">
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputName1">Genre name</label>
              <input v-model="form.name" type="text" class="form-control" id="exampleInputName1" placeholder="Enter name">
            </div>
            <div class="form-group">
              <label>Category</label>
              <select class="select2bs4 category-select" v-model="form.category_id" style="width: 100%;" :disabled="loading">
                <option selected="selected" disabled>Choose</option>
                <option v-for="option in categoriesOptions" :key="option.id" :value="option.id">{{ option.name }}</option>
              </select>
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
import genreApi from "@/api/Admin/GenreApi";
import $ from "jquery";

export default {
  name: "GenreCreate",
  data() {
    return {
      form: {
        name: null,
        category_id: null
      },
      errors: []
    }
  },
  computed: {
    categoriesOptions() {
      return this.$store.state.common.data.categories || [];
    },
  },
  methods: {
    store() {
      this.errors = [];
      genreApi.store(this.form).then(() => {
        this.loading = false;

        this.$router.push({name: 'GenreIndex', params: {locale: this.$route.params.locale}});
      }).catch(err => {
        this.errors = err.response.data.errors;
        this.loading = false;
      });
    },
  },
  mounted() {
    this.$nextTick(() => {
      if (window.initializeSelect2) {
        window.initializeSelect2();
      }
      $('.category-select').on('change', (e) => {
        this.form.category_id = $(e.target).val();
      });
    });
  }
}
</script>
<style scoped>

</style>