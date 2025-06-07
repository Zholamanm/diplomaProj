<template>
  <div class="content-wrapper">
    <div class="container pt-5">
      <div class="card card-primary">
        <form class="text-start">
          <div class="card-body">
            <!-- Preview Image -->
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

            <!-- Date Range -->
            <div class="row date-range-container">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="date-label">Start Date</label>
                  <div class="date-input-wrapper">
                    <input
                        type="datetime-local"
                        class="styled-date-input"
                        v-model="form.start_date"
                        :min="minDate"
                    >
                    <span class="date-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#219e9a">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM9 10H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm-8 4H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2z"/>
                      </svg>
                    </span>
                  </div>
                  <small class="text-danger" v-if="errors.start_date">{{ errors.start_date[0] }}</small>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label class="date-label">End Date</label>
                  <div class="date-input-wrapper">
                    <input
                        type="datetime-local"
                        class="styled-date-input"
                        v-model="form.end_date"
                        :min="form.start_date || minDate"
                    >
                    <span class="date-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="#219e9a">
                        <path d="M19 3h-1V1h-2v2H8V1H6v2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM9 10H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm-8 4H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2z"/>
                      </svg>
                    </span>
                  </div>
                  <small class="text-danger" v-if="errors.end_date">{{ errors.end_date[0] }}</small>
                </div>
              </div>
            </div>

            <!-- Active Toggle -->
            <div class="form-group">
              <div class="custom-control custom-switch">
                <input
                    type="checkbox"
                    class="custom-control-input"
                    id="activeSwitch"
                    v-model="form.enabled"
                >
                <label class="custom-control-label" for="activeSwitch">Active Slider</label>
              </div>
              <small class="text-muted">Toggle to enable/disable this slider</small>
            </div>
          </div>
          <div class="card-footer">
            <button type="button" class="btn btn-primary" @click="update">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import $ from 'jquery'
import sldierApi from "@/api/Admin/SliderApi";
window.$ = window.jQuery = $;

export default {
  name: "SliderCreate",
  data() {
    return {
      form: {
        start_date: null,
        end_date: null,
        enabled: 0,
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
      return this.form.cover_image ? `https://bookers.com.kz/storage/${this.form.cover_image}` : '';
    },
  },
  methods: {
    update() {
      this.errors = [];
      const formData = new FormData();
      formData.append('start_date', this.form.start_date.split('T')[0]);
      formData.append('end_date', this.form.end_date.split('T')[0]);
      formData.append('enabled', this.form.enabled ? 1 : 0);
      if (this.form.new_cover_image) {
        formData.append('cover_image', this.form.new_cover_image);
      }
      sldierApi.edit(this.$route.params.id, formData)
          .then(() => {
            this.loading = false;
            this.$router.push({name: 'SliderIndex', params: {locale: this.$route.params.locale}});
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
      sldierApi.view(this.$route.params.id).then(res => {
        this.form.start_date = res.start_date + 'T00:00'
        this.form.end_date = res.end_date + 'T00:00'
        this.form.enabled = res.enabled === 1 ? true : false
        this.form.cover_image = res.cover_image
        this.loading = false;
      }).catch(err => {
        this.errors = err.response.data.errors;
        this.loading = false;
      });
    },
    getImageUrl(path) {
      return `/storage/${path}`;
    }
  },
  mounted() {
    this.getItem()
  },

}
</script>
<style scoped>
/* Base Styles */
.content-wrapper {
  background-color: #f4f6f9;
  min-height: calc(100vh - 56px);
}

.card-primary {
  border-top: 3px solid #007bff;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
}

/* Date Input Styling */
.date-range-container {
  margin: 1.5rem 0;
}

.date-label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #495057;
}

.date-input-wrapper {
  position: relative;
  display: flex;
  align-items: center;
}

.styled-date-input {
  width: 100%;
  padding: 0.75rem 1rem 0.75rem 2.5rem;
  border: 1px solid #ced4da;
  border-radius: 6px;
  font-size: 0.9rem;
  color: #495057;
  background-color: #fff;
  transition: all 0.3s ease;
  box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
}

.styled-date-input:focus {
  outline: none;
  border-color: #219e9a;
  box-shadow: 0 0 0 3px rgba(33, 158, 154, 0.2);
}

.date-icon {
  position: absolute;
  left: 1rem;
  pointer-events: none;
  display: flex;
  align-items: center;
}

/* Custom file input */
.custom-file-label {
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

/* Toggle switch */
.custom-switch {
  padding-left: 2.25rem;
}

.custom-control-label::before {
  background-color: #dee2e6;
  border-color: #adb5bd;
}

.custom-control-input:checked ~ .custom-control-label::before {
  background-color: #219e9a;
  border-color: #219e9a;
}

/* Button styling */
.btn-primary {
  background-color: #219e9a;
  border-color: #219e9a;
  padding: 0.5rem 1.5rem;
  border-radius: 4px;
  font-weight: 500;
  transition: all 0.3s ease;
}

.btn-primary:hover {
  background-color: #1a7f7b;
  border-color: #1a7f7b;
  transform: translateY(-1px);
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

/* Error message styling */
.text-danger {
  color: #e74c3c !important;
  font-size: 0.8rem;
  margin-top: 0.25rem;
  display: block;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .date-range-container {
    flex-direction: column;
  }

  .col-md-6 {
    margin-bottom: 1rem;
  }

  .styled-date-input {
    padding: 0.65rem 1rem 0.65rem 2.5rem;
  }
}

/* Custom datetime-local input styling */
input[type="datetime-local"]::-webkit-calendar-picker-indicator {
  background: transparent;
  bottom: 0;
  color: transparent;
  cursor: pointer;
  height: auto;
  left: 0;
  position: absolute;
  right: 0;
  top: 0;
  width: auto;
}

/* Hide the default datetime-local dropdown arrow */
input[type="datetime-local"]::-webkit-inner-spin-button,
input[type="datetime-local"]::-webkit-outer-spin-button {
  -webkit-appearance: none;
  margin: 0;
}
</style>