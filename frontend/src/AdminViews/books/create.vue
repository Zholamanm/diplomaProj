<template>
  <div class="content-wrapper">
    <div class="container pt-5">
      <div class="card card-primary">
        <form class="text-start">
          <div class="card-body">
            <div class="form-group">
              <label for="exampleInputTitle1">Book title</label>
              <input v-model="form.title" type="text" class="form-control" id="exampleInputTitle1"
                     placeholder="Enter title">
            </div>
            <div class="form-group">
              <label for="exampleInputAuthor1">Book author</label>
              <input v-model="form.author" type="text" class="form-control" id="exampleInputAuthor1"
                     placeholder="Enter author">
            </div>
            <div class="form-group">
              <label for="exampleInputDesc1">Book description</label>
              <input v-model="form.description" type="text" class="form-control" id="exampleInputDesc1"
                     placeholder="Enter description">
            </div>
            <div class="form-group">
              <label>Category</label>
              <select class="select2bs4 category-select" v-model="form.category_id" style="width: 100%;"
                      :disabled="loading">
                <option selected="selected" disabled>Choose</option>
                <option v-for="option in categoriesOptions" :key="option.id" :value="option.id">{{
                    option.name
                  }}
                </option>
              </select>
              <label>Genres</label>
              <select class="select2bs4 genre-select" :disabled="!categorySelected" v-model="form.genres_id"
                      multiple="multiple"
                      data-placeholder="Select a State" style="width: 100%;">
                <option v-for="option in genresOptions.filter(g => g.category_id === parseInt(categorySelected))" :key="option.id"
                        :value="option.id">{{ option.name }}
                </option>
              </select>
            </div>
            <div class="form-group">
              <label>Tags</label>
              <select class="select2bs4 tag-select" :disabled="loading" v-model="form.tags_id" multiple="multiple"
                      data-placeholder="Select a State" style="width: 100%;">
                <option v-for="option in tagOptions" :key="option.id" :value="option.id">{{ option.name }}</option>
              </select>
            </div>
            <div class="form-group" v-if="coverImageUrl">
              <label>Preview Image</label>
              <img :src="coverImageUrl" alt="Book Image Preview"
                   style="max-width: 200px; display: block; margin-bottom: 1rem;">
            </div>
            <div class="form-group">
              <label for="exampleInputFile">Book Image</label>
              <div class="input-group">
                <div class="custom-file">
                  <input type="file" class="custom-file-input" id="exampleInputFile" @change="onFileChange">
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
        genres_id: [],
      },
      loading: false,
      errors: []
    }
  },
  computed: {
    coverImageUrl() {
      return this.form.new_cover_image ? URL.createObjectURL(this.form.new_cover_image) : '';
    },
    categorySelected() {
      return this.form.category_id;
    },
    categoriesOptions() {
      return this.$store.state.common.data.categories || [];
    },
    tagOptions() {
      return this.$store.state.common.data.tags || [];
    },
    genresOptions() {
      return this.$store.state.common.data.genres || [];
    }
  },
  methods: {
    onFileChange(e) {
      const file = e.target.files[0];
      if (file) {
        this.form.new_cover_image = file;
      }
    },
    store() {
      this.errors = [];
      const formData = new FormData();
      formData.append('title', this.form.title);
      formData.append('author', this.form.author);
      formData.append('description', this.form.description);
      formData.append('category_id', this.form.category_id);

      this.form.tags_id.forEach(tagId => formData.append('tags_id[]', tagId));
      this.form.genres_id.forEach(tagId => formData.append('genres_id[]', tagId));

      if (this.form.new_cover_image) {
        formData.append('cover_image', this.form.new_cover_image);
      }

      bookApi.store(formData)
          .then(() => {
            this.loading = false;
            this.$router.push({name: 'BookIndex', params: {locale: this.$route.params.locale}});
          })
          .catch(err => {
            this.errors = err.response.data.errors;
            this.loading = false;
          });
    },
    getCategories() {
      $('.category-select').select2({
        theme: 'bootstrap4',
        minimumResultsForSearch: Infinity
      });
    },
    getTags() {
      $('.tag-select').select2({
        theme: 'bootstrap4',
      });
      $('.tag-select').on('select2:opening select2:closing', function () {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.prop('disabled', true);
      });
    },
    getGenres() {
      $('.genre-select').select2({
        theme: 'bootstrap4',
      });
      $('.genre-select').on('select2:opening select2:closing', function () {
        var $searchfield = $(this).parent().find('.select2-search__field');
        $searchfield.prop('disabled', true);
      });
    }
  },
  mounted() {
    this.$nextTick(() => {
      if (window.initializeSelect2) {
        window.initializeSelect2();
      }

      $('.category-select').on('change', (e) => {
        this.form.category_id = $(e.target).val();
      });
      $('.tag-select').on('change', (e) => {
        this.form.tags_id = $(e.target).val();
      });
      $('.genre-select').on('change', (e) => {
        this.form.genres_id = $(e.target).val(); // Fixed typo: was gernes_id
      });
    });
  },

}
</script>
<style scoped>

</style>