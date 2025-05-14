<template>
  <div class="content-wrapper" v-if="filtersReady">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Black List Table</h3>

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
            <th>Violation Count</th>
            <th>Start Date</th>
            <th>Expire Date</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="item in list" :key="item.id">
            <td>{{ item.id }}</td>
            <td>{{ item.user.name }}</td>
            <td>{{ item.violation_count }}</td>
            <td>{{ item.start_date ? new Date(item.start_date).toDateString() : '' }}</td>
            <td>{{ item.expire_date ? new Date(item.expire_date).toDateString() : '' }}</td>
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
  </div>
</template>
<script>
import store from "@/store";
import InfiniteLoading from "v3-infinite-loading/lib/v3-infinite-loading.es.js";
import blackListApi from "@/api/Admin/BlackListApi";

export default {
  name: "BorrowIndex",
  components: {InfiniteLoading},
  data() {
    return {
      list: [],
      filters: {
        search: null,
        sortBy: 1,
      },
      loading: false,
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
      blackListApi
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
