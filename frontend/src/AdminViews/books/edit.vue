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
              <label>Category</label>
              <select class="select2bs4 category-select" v-model="form.category_id" style="width: 100%;" :disabled="loading">
                <option selected="selected" disabled>Choose</option>
                <option v-for="option in categoriesOptions" :key="option.id" :value="option.id">{{ option.name }}</option>
              </select>
            </div>
            <div class="form-group">
              <label>Tags</label>
              <select class="select2bs4 tag-select" :disabled="loading" v-model="form.tags_id" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                <option v-for="option in tagOptions" :key="option.id" :value="option.id">{{ option.name }}</option>
              </select>
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
            <div class="btn btn-primary" @click="update">Submit</div>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script>
import bookApi from "@/api/Admin/BookApi";
import categoryApi from "@/api/Admin/CategoryApi";
import tagApi from "@/api/Admin/TagApi";
import $ from 'jquery'
window.$ = window.jQuery = $;

export default {
  name: "BookCreate",
  data() {
    return {
      form: {
        title: null,
        author: null,
        description: null,
        category_id: null,
        tags_id: [],
      },
      loading: false,
      categoriesOptions: [],
      tagOptions: [],
      errors: []
    }
  },
  methods: {
    update() {
      this.errors = [];
      bookApi.edit(this.$route.params.id, this.form).then(() => {
        this.loading = false;
        this.$router.push({name: 'BookIndex', params: {locale: this.$route.params.locale}});
      }).catch(err => {
        this.errors = err.response.data.errors;
        this.loading = false;
      });
    },
    setCategory() {
      this.$nextTick(() => {
        $('.category-select').on('change', (e) => {
          this.form.category_id = $(e.target).val();
        });
      });
    },
    setTags() {
      this.$nextTick(() => {
        $('.tag-select').on('change', (e) => {
          this.form.tags_id = $(e.target).val();
        });
      });
    },
    getCategories() {
      this.loading = true
      categoryApi.get().then((res) => {
        this.categoriesOptions = res.data;
        this.loading = false;
        $('.category-select').select2({
          theme: 'bootstrap4',
          minimumResultsForSearch: Infinity
        });
      });
    },
    getTags() {
      this.loading = true
      tagApi.get().then((res) => {
        this.tagOptions = res.data;
        this.loading = false;
        $('.tag-select').select2({
          theme: 'bootstrap4',
        });
        $('.tag-select').on('select2:opening select2:closing', function( ) {
          var $searchfield = $(this).parent().find('.select2-search__field');
          $searchfield.prop('disabled', true);
        });
      });
    },
    getItem() {
      this.loading = true
      bookApi.view(this.$route.params.id).then(res => {
        this.form.title = res.title;
        this.form.author = res.author;
        this.form.description = res.description;
        this.form.category_id = res.category_id;
        this.form.tags_id = res.tags.map(tag => tag.id);
        this.loading = false;
      }).catch(err => {
        this.errors = err.response.data.errors;
        this.loading = false;
      });
    }
  },
  mounted() {
    this.getItem();
    this.getCategories();
    this.getTags();
    this.$nextTick(() => {
      $('.category-select').on('change', (e) => {
        this.form.category_id = $(e.target).val();
      });
      $('.tag-select').on('change', (e) => {
        this.form.tags_id = $(e.target).val();
      });
    })
  },

}
</script>
<style scoped>

</style>