<template>
  <div class="content-wrapper">
    <div class="container pt-5">
      <div class="card card-primary">
        <form class="text-start" enctype='multipart/form-data'>
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
              <select class="select2bs4 tag-select" :disabled="loading" v-model="form.tags_id" multiple="multiple" data-placeholder="Select a State" style="width: 100%;">
                <option v-for="option in tagOptions" :key="option.id" :value="option.id">{{ option.name }}</option>
              </select>
            </div>

            <div class="form-group" v-if="coverImageUrl">
              <label>Current Book Image</label>
              <img :src="coverImageUrl" alt="Current Book Image" style="max-width: 200px; display: block; margin-bottom: 1rem;">
            </div>

            <div class="form-group">
              <label for="exampleInputFile">Change Book Image</label>
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
            <div class="btn btn-primary" @click="update">Submit</div>
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
        cover_image: null,
        new_cover_image: null,
      },
      loading: false,
      errors: []
    }
  },
  computed: {
    coverImageUrl() {
      if (this.form.new_cover_image) {
        return URL.createObjectURL(this.form.new_cover_image);
      }
      return this.form.cover_image ? `http://localhost:8000/storage/${this.form.cover_image}` : '';
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
    update() {
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
      bookApi.edit(this.$route.params.id, formData)
          .then(() => {
            this.loading = false;
            this.$router.push({name: 'BookIndex', params: {locale: this.$route.params.locale}});
          })
          .catch(err => {
            this.errors = err.response.data.errors;
            this.loading = false;
          });
    },
    onFileChange(e) {
      const file = e.target.files[0];
      console.log('File selected:', file);
      if (file) {
        this.form.new_cover_image = file;
      }
    },
    getItem() {
      this.loading = true;
      bookApi.view(this.$route.params.id).then(res => {
        this.form.title = res.title;
        this.form.author = res.author;
        this.form.description = res.description;
        this.form.category_id = res.category_id;
        this.form.tags_id = res.tags.map(tag => tag.id);
        this.form.genres_id = res.genres.map(genre => genre.id);
        this.form.cover_image = res.cover_image
        this.$nextTick(() => {
          // Manually update Select2 for category
          $('.category-select').val(this.form.category_id).trigger('change');

          // Manually update Select2 for tags (multi-select)
          $('.tag-select').val(this.form.tags_id).trigger('change');

          // Manually update Select2 for genres (multi-select)
          $('.genre-select').val(this.form.genres_id).trigger('change');
        });
        this.loading = false;
      }).catch(err => {
        this.errors = err.response.data.errors;
        this.loading = false;
      });
    },
    getImageUrl(path) {
      // Assuming your images are stored in the storage folder and linked via "storage" symlink
      return `/storage/${path}`;
    }
  },
  mounted() {
    this.getItem()
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