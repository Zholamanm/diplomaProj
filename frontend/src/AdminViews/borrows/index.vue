<template>
  <div class="content-wrapper" v-if="filtersReady">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Borrow Table</h3>

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
      <!-- /.card-header -->
      <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
          <thead>
          <tr>
            <th>ID</th>
            <th>User</th>
            <th>Book</th>
            <th>Location</th>
            <th>Code</th>
            <th>Borrow Date</th>
            <th>Receive Date</th>
            <th>Due Date</th>
            <th>Action</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="item in list" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.user.name }}</td>
            <td>{{ item.book.title }}</td>
            <td>{{ item.location.name }}</td>
            <td>{{ item.borrow_check }}</td>
            <td>{{ new Date(item.borrowed_at).toDateString() }}</td>
            <td>{{ new Date(item.received_at).toDateString() }}</td>
            <td>{{ new Date(item.due_date).toDateString() }}</td>
            <td>
              <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" :fill="item.status === 'received' ? '#4CAF50' : '#000000'"
                   @click="item.status === 'borrowed' ? showCheckoutModal(item) : showReturnModal(item)"
                   v-if="item.status !== 'returned'"
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
              <svg
                  v-else
                  xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" fill="#4CAF50" version="1.1" id="Capa_1" width="20px" height="18px" viewBox="0 0 252.045 252.045" xml:space="preserve">
                <g>
                  <path d="M169.059,129.235c4.42,4.42,10.304,6.857,16.549,6.857s12.13-2.438,16.556-6.857l49.882-49.873l-47.654-47.66   c-4.419-4.422-10.304-6.854-16.555-6.854s-12.136,2.432-16.556,6.854c-4.413,4.422-6.857,10.307-6.857,16.546   c0,2.669,0.444,5.257,1.297,7.698H85.623C38.404,55.947,0,94.353,0,141.569c0,47.222,38.404,85.629,85.623,85.629h133.312   c12.91,0,23.406-10.509,23.406-23.413s-10.496-23.407-23.406-23.407H85.623c-21.392,0-38.806-17.414-38.806-38.809   c0-21.401,17.414-38.809,38.806-38.809h78.776c-1.44,3.062-2.197,6.431-2.197,9.917   C162.202,118.937,164.639,124.828,169.059,129.235z M85.623,92.693c-26.95,0-48.885,21.927-48.885,48.876   s21.936,48.885,48.885,48.885h133.312c7.361,0,13.33,5.975,13.33,13.331c0,7.362-5.969,13.331-13.33,13.331H85.623   c-41.652,0-75.546-33.892-75.546-75.547c0-41.644,33.894-75.537,75.546-75.537H186.75l-8.341-8.35   c-5.206-5.209-5.206-13.646,0-18.846c5.206-5.215,13.648-5.215,18.849,0l40.532,40.532l-42.754,42.754   c-2.6,2.597-6.017,3.906-9.428,3.906c-3.41,0-6.821-1.31-9.427-3.906c-5.207-5.215-5.207-13.646,0-18.853l10.568-10.571H85.623   V92.693z"/>
                </g>
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
                stroke-dashoffset="0"
            ></circle>
          </svg>
        </div>
      </template>
    </InfiniteLoading>
    <admin-modal ref="checkoutModal" @close="selectedItem = null">
      <svg class="icon-warning" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <path d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
              fill="#4CAF50"
              stroke="#177c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>

      <!-- Confirmation Text -->
      <h3 class="confirm-text">
        Are you sure you want to check <br><strong>{{ selectedItem.user.name }}: {{ selectedItem.book.title }}</strong>?
      </h3>

      <!-- Action Buttons -->
      <div class="button-group">
        <button :disabled="loading" class="btn-delete" @click="checkout(selectedItem)">
          Yes
        </button>
        <button :disabled="loading" class="btn-cancel" @click="$refs.checkoutModal.hideModal()">
          No
        </button>
      </div>
    </admin-modal>
    <admin-modal ref="returnModal" @close="selectedItem = null">
      <svg class="icon-warning" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
        <path d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
              fill="#4CAF50"
              stroke="#177c00" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
      </svg>

      <!-- Confirmation Text -->
      <h3 class="confirm-text">
        Are you sure <strong>{{ selectedItem.user.name }}</strong> returned <strong>{{ selectedItem.book.title }}</strong>?
      </h3>

      <!-- Action Buttons -->
      <div class="button-group">
        <button :disabled="loading" class="btn-delete" @click="returnBook(selectedItem)">
          Yes
        </button>
        <button :disabled="loading" class="btn-cancel" @click="$refs.returnModal.hideModal()">
          No
        </button>
      </div>
    </admin-modal>
  </div>
</template>
<script>
import store from "@/store";
import AdminModal from "@/views/Components/Ui/AdminModal.vue";
import borrowApi from "@/api/Admin/BorrowApi";
import InfiniteLoading from "v3-infinite-loading/lib/v3-infinite-loading.es.js";

export default {
  name: "BorrowIndex",
  components: {AdminModal, InfiniteLoading},
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
    getList() {
      this.loading = true;
      this.page += 1;
      borrowApi
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
    dropList() {
      this.list = [];
      this.page = 0;
      this.total = 0;
      this.last_page = null;
      this.$nextTick(() => {
        this.handleLoad();
      });
    },
    showCheckoutModal(item) {
      this.selectedItem = item;
      this.$refs.checkoutModal.showModal();
    },
    showReturnModal(item) {
      this.selectedItem = item;
      this.$refs.returnModal.showModal();
    },
    returnBook(item) {
      let form = {
        borrow_id: item.id,
        status: 'returned'
      }
      borrowApi.returnBook(form).then(() => {
        this.$refs.returnModal.hideModal();
        this.dropList()
      }).catch(err => {
        console.error(err)
      })
    },
    checkout(item) {
      let form = {
        borrow_id: item.id,
        status: 'received'
      }
      borrowApi.checkout(form).then(() => {
        this.$refs.checkoutModal.hideModal();
        this.dropList()
      }).catch(err => {
        console.error(err)
      })
    },
    handleLoad() {
      if (!this.loading && this.page !== this.last_page) this.getList();
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
