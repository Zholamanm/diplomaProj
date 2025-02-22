<template>
  <div class="content-wrapper">
    <div class="container pt-5">
      <div class="card card-primary">
        <form class="text-start">
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputTitle1">Book title</label>
              <input v-model="form.title" type="text" class="form-control" id="exampleInputTitle1" placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="exampleInputAuthor1">Book author</label>
              <input v-model="form.author" type="text" class="form-control" id="exampleInputAuthor1" placeholder="Enter author">
            </div>
            <div class="form-group">
              <label for="exampleInputDesc1">Book description</label>
              <input v-model="form.description" type="text" class="form-control" id="exampleInputDesc1" placeholder="Enter description">
            </div>
            <div class="form-group">
              <label for="exampleInputFile">Book Image</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="exampleInputFile">
                  <label class="custom-file-label" for="exampleInputFile">Choose file</label>
                </div>
                <div class="input-group-append">
                  <span class="input-group-text">Upload</span>
                </div>
              </div>
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
import bookApi from "@/api/Admin/BookApi";

export default {
  name: "BookCreate",
  data() {
    return {
      form: {
        title: null,
        author: null,
        description: null
      },
      errors: []
    }
  },
  methods: {
    store() {
      this.errors = [];
      bookApi.store(this.form).then(() => {
        this.loading = false;
        this.$router.push({name: 'BookIndex', params: {locale: this.$route.params.locale}});
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