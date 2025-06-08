<template>
  <div class="content-wrapper" v-if="filtersReady">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Slider Table</h3>

        <div class="card-tools">
          <div class="card-tools">
            <div class="input-group input-group-sm" style="width: 150px;">
              <input type="text" v-model="filters.search" :disabled="loading"
                     @keyup.enter="keyEnter"
                     name="table_search"
                     class="form-control float-right"
                     placeholder="Search">

              <div class="input-group-append">
                <button type="submit" class="btn btn-default" @click="keyEnter">
                  <i class="fas fa-search"></i>
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
      <button type="submit" class="btn btn-default" @click="$router.push({
                                            name: 'SliderCreate',
                                            params: {
                                                locale: $route.params.locale,
                                            },
                                        })">
        <i class="fas fa-plus"></i>
        <span>Add slider</span>
      </button>

      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Enabled</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="item in list" :key="item.id">
            <td>{{ item.id }}</td>
            <td style="justify-items: center;"><img :src="`https://bookers.com.kz/public/storage/${item.cover_image}`" alt="Slider Image Preview" style="display: block; margin-bottom: 1rem;"></td>
            <td>{{ new Date(item.start_date).toDateString() }}</td>
            <td>{{ new Date(item.end_date).toDateString() }}</td>
            <td>
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" :fill="item.enabled ? '#4CAF50' : '#000000'"
                   @click="enableSlider(item.id)"
                   style="cursor: pointer;"
                   height="20px" width="18px" version="1.1" id="Capa_1" viewBox="0 0 489 489" xml:space="preserve">
                <g>
                  <g>
                    <path
                        d="M417.4,71.6C371.2,25.4,309.8,0,244.5,0S117.8,25.4,71.6,71.6S0,179.2,0,244.5s25.4,126.7,71.6,172.9S179.2,489,244.5,489    s126.7-25.4,172.9-71.6S489,309.8,489,244.5S463.6,117.8,417.4,71.6z M244.5,462C124.6,462,27,364.4,27,244.5S124.6,27,244.5,27    S462,124.6,462,244.5S364.4,462,244.5,462z"/>
                    <path
                        d="M301.6,188.1l-84.1,84.2l-30.1-30.1c-5.3-5.3-13.8-5.3-19.1,0c-5.3,5.3-5.3,13.8,0,19.1L208,301c2.6,2.6,6.1,4,9.5,4    s6.9-1.3,9.5-4l93.7-93.7c5.3-5.3,5.3-13.8,0-19.1C315.5,182.8,306.9,182.8,301.6,188.1z"/>
                  </g>
                </g>
              </svg>
            </td>
            <td class="actions">
              <svg
                  aria-hidden="true"
                  class="w-6 h-6 text-gray-800 dark:text-white cursor-pointer h-full"
                  fill="currentColor"
                  width="20"
                  height="18"
                  viewBox="0 0 20 18"
                  xmlns="http://www.w3.org/2000/svg"
                  @click="
                                        $router.push({
                                            name: 'SliderEdit',
                                            params: {
                                                id: item.id,
                                                locale: $route.params.locale,
                                            },
                                        })
                                    "
              >
                <path
                    d="M12.687 14.408a3.01 3.01 0 0 1-1.533.821l-3.566.713a3 3 0 0 1-3.53-3.53l.713-3.566a3.01 3.01 0 0 1 .821-1.533L10.905 2H2.167A2.169 2.169 0 0 0 0 4.167v11.666A2.169 2.169 0 0 0 2.167 18h11.666A2.169 2.169 0 0 0 16 15.833V11.1l-3.313 3.308Zm5.53-9.065.546-.546a2.518 2.518 0 0 0 0-3.56 2.576 2.576 0 0 0-3.559 0l-.547.547 3.56 3.56Z"
                />
                <path
                    d="M13.243 3.2 7.359 9.081a.5.5 0 0 0-.136.256L6.51 12.9a.5.5 0 0 0 .59.59l3.566-.713a.5.5 0 0 0 .255-.136L16.8 6.757 13.243 3.2Z"
                />
              </svg>
              <svg
                  v-if="$store.state.user.user.role_id === 1"
                  aria-hidden="true"
                  class="w-6 h-6 text-red-600 dark:text-white cursor-pointer h-full"
                  fill="currentColor"
                  width="24"
                  height="24"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                  @click="showDeleteModal(item)"
              >
                <path
                    clip-rule="evenodd"
                    d="M2 12a10 10 0 1 1 20 0 10 10 0 0 1-20 0Zm7.7-3.7a1 1 0 0 0-1.4 1.4l2.3 2.3-2.3 2.3a1 1 0 1 0 1.4 1.4l2.3-2.3 2.3 2.3a1 1 0 0 0 1.4-1.4L13.4 12l2.3-2.3a1 1 0 0 0-1.4-1.4L12 10.6 9.7 8.3Z"
                    fill-rule="evenodd"
                />
              </svg>
            </td>
          </tr>
          </tbody>
        </table>
      </div>
      <!-- /.card-body -->
    </div>
    <InfiniteLoading v-if="page !== last_page" @infinite="handleLoad">
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
    <admin-modal ref="deleteModal" @close="selectedItem = null">
      <svg class="icon-warning" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <path d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
              stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>

      <!-- Confirmation Text -->
      <h3 class="confirm-text">
        Are you sure you want to delete <strong>{{ selectedItem.title }}</strong>?
      </h3>

      <!-- Action Buttons -->
      <div class="button-group">
        <button :disabled="loading" class="btn-delete" @click="deleteItem">
          Yes
        </button>
        <button :disabled="loading" class="btn-cancel" @click="$refs.deleteModal.hideModal()">
          No
        </button>
      </div>
    </admin-modal>
  </div>
</template>
<script>
import sliderApi from "@/api/Admin/SliderApi";
import store from "@/store";
import AdminModal from "@/views/Components/Ui/AdminModal.vue";

export default {
  name: "SliderIndex",
  components: {AdminModal},
  // components: {InfiniteLoading},
  data() {
    return {
      list: [],
      filters: {
        search: null,
        sortBy: 1,
      },
      loading: false,
      selectedItem: null,
      last_page: null,
      page: 0,
      selectedFilters: [],
      total: 0,
      sortBy: [
        {
          value: 1,
          label: this.$t("ASC"),
        },
        {
          value: 0,
          label: this.$t("DESC"),
        },
      ],
      filtersReady: false,
    }
  },
  watch: {
    filters: {
      handler(to, from) {
        if (to !== from) {
          this.dropList();
        }
      },
      deep: true,
    },
  },
  computed: {},
  methods: {
    enableSlider(id) {
      this.loading = true;
      sliderApi.enableSlider(id).then(() => {
        this.dropList()
        this.loading = false
      }).catch(err => {
        console.log(err);
      })
    },
    getList() {
      this.loading = true;
      this.page += 1;
      sliderApi
          .getList({
            ...this.filters,
            page: this.page,
          })
          .then((res) => {
            this.list = this.list.concat(res.data);
            this.total = res.total;
            this.last_page = res.last_page;
            this.loading = false;
            store.commit("setFilters", this.filters);
          });
    },
    showDeleteModal(item) {
      this.selectedItem = item;
      this.$refs.deleteModal.showModal();
    },
    dropList() {
      this.list = [];
      this.page = 0;
      this.total = 0;
      this.last_page = null;
      this.$nextTick(() => {
        this.handleLoad();
      });
    },
    handleLoad() {
      if (!this.loading && this.page !== this.last_page) this.getList();
    },
    deleteItem() {
      this.deleteSlider(this.selectedItem);
    },
    deleteSlider(id) {
      this.loading = true;
      sliderApi.delete(id).then(() => {
        this.loading = false;
        this.$refs.deleteModal.hideModal();
        this.dropList();
      });
    },
    keyEnter() {
      this.list = [];
      this.page = 0;
      this.total = 0;
      this.last_page = null;
      this.handleLoad();
    },
  },
  mounted() {
    this.$nextTick(() => {
      this.filtersReady = true;
    });
  },
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
