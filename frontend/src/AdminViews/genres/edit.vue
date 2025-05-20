<template>
  <div class="content-wrapper">
    <div class="container pt-5" v-if="form.name">
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
            <div class="btn btn-primary" @click="update">Submit</div>
          </div>
        </form>
      </div>
    </div>
    <InfiniteLoading v-if="loading">
      <template #spinner>
        <div class="custom-spinner">
          <svg
              class="loading-icon"
              viewBox="0 0 50 50"
          >
            <circle
                class="path"
                cx="25"
                cy="25"
                r="20"
                fill="none"
                stroke-width="5"
                stroke="green"
                stroke-dasharray="80, 100"
                stroke-dashoffset="0" x
            ></circle>
          </svg>
        </div>
      </template>
    </InfiniteLoading>
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
    update() {
      this.errors = [];
      genreApi.edit(this.$route.params.id, this.form).then(() => {
        this.loading = false;
        this.$router.push({name: 'GenreIndex', params: {locale: this.$route.params.locale}});
      }).catch(err => {
        this.errors = err.response.data.errors;
        this.loading = false;
      });
    },
    getItem() {
      this.loading = true
      genreApi.view(this.$route.params.id).then(res => {
        this.form.name = res.name;
        this.form.category_id = res.category_id
        this.$nextTick(() => {
          $('.category-select').val(this.form.category_id).trigger('change');
        });
        this.form.category_id = res.category_id;
        this.loading = false;
      }).catch(err => {
        this.errors = err.response.data.errors;
        this.loading = false;
      });
    },
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
    });
  }
}
</script>
<style scoped>
/* Custom Loader */
.custom-spinner {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 50px;
}

.loading-icon {
  width: 40px;
  height: 40px;
  animation: spin 1s linear infinite;
  stroke: #4CAF50;
}

@keyframes spin {
  to {
    transform: rotate(360deg);
  }
}

.actions {
  justify-content: space-around;
  flex-direction: row;
  display: flex;
}
.icon-warning {
  display: block;
  margin: 0 auto 16px;
  width: 48px;
  height: 48px;
  color: #9CA3AF; /* Gray */
}

/* === Confirmation Text === */
.confirm-text {
  font-size: 1rem;
  color: #6B7280; /* Gray */
  margin-bottom: 16px;
}

/* === Button Group === */
.button-group {
  display: flex;
  justify-content: center;
  gap: 12px;
}

/* === Delete Button === */
.btn-delete {
  background-color: #DC2626; /* Red */
  color: white;
  font-size: 0.875rem;
  font-weight: 500;
  border-radius: 8px;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  transition: background 0.2s;
}

.btn-delete:hover {
  background-color: #B91C1C; /* Darker Red */
}

.btn-delete:disabled {
  opacity: 0.5;
  cursor: not-allowed;
}

/* === Cancel Button === */
.btn-cancel {
  background-color: white;
  color: #374151; /* Dark Gray */
  font-size: 0.875rem;
  font-weight: 500;
  border: 1px solid #D1D5DB; /* Light Gray Border */
  border-radius: 8px;
  padding: 10px 20px;
  cursor: pointer;
  transition: background 0.2s, color 0.2s;
}

.btn-cancel:hover {
  background-color: #F3F4F6; /* Light Gray */
  color: #2563EB; /* Blue */
}
</style>