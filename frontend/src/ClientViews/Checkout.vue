<template>
  <div class="checkout-container">
    <!-- Back button -->
    <div class="back">
      <a href="#" class="back-link">&#11178; Back to Shop</a>
    </div>

    <!-- Title -->
    <h1 class="checkout-title">Your Checkouts</h1>

    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <div class="loader">
        <svg viewBox="0 0 50 50">
          <circle cx="25" cy="25" r="20" fill="none" stroke="#219e9a" stroke-width="5"></circle>
        </svg>
        <p>Loading checkouts...</p>
      </div>
    </div>

    <!-- Empty State -->
    <div v-else-if="!list || list.length === 0" class="empty-state">
      <div class="empty-content">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#95a5a6" width="48" height="48">
          <path d="M19 5h-2V3H7v2H5c-1.1 0-2 .9-2 2v1c0 2.55 1.92 4.63 4.39 4.94.63 1.5 1.98 2.63 3.61 2.96V19H7v2h10v-2h-4v-3.1c1.63-.33 2.98-1.46 3.61-2.96C19.08 12.63 21 10.55 21 8V7c0-1.1-.9-2-2-2zM5 8V7h2v3.82C5.84 10.4 5 9.3 5 8zm14 0c0 1.3-.84 2.4-2 2.82V7h2v1z"/>
        </svg>
        <p>No books checked out yet</p>
        <a href="#" class="browse-btn" @click="$router.push({name: 'CatalogView', params: {locale: $route.params.locale}})">Browse Books</a>
      </div>
    </div>

    <!-- Checkout Items -->
    <div v-else class="container-fluid">
      <div class="row justify-content-center">
        <div class="col-12 col-md-12">
          <div class="checkout-items">
            <div v-for="(item, index) in list" :key="index" class="checkout-item">
              <div class="row align-items-center">
                <!-- Book Cover -->
                <div class="col-4 col-sm-3">
                  <img
                      class="book-cover"
                      :src="`http://localhost:8000/storage/${item.book.cover_image}`"
                      :alt="item.book.title"
                      @error="handleImageError"
                  >
                </div>

                <!-- Book Info -->
                <div class="col-5 col-sm-5 book-info" style="display: flex; gap: 150px">
                  <div style="align-content: center;">
                    <p class="book-location">
                      <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="#219e9a">
                        <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                      </svg>
                      {{ item.location.name }}
                    </p>
                  </div>
                  <div>
                    <h5 class="book-title">{{ item.book.title }}</h5>
                    <p class="book-author">{{ item.book.author }}</p>
                  </div>
                </div>

                <!-- Quantity -->
                <div class="col-1 col-sm-1 text-center">
                  <span class="quantity-badge">{{ item.quantity }}</span>
                </div>

                <!-- Status -->
                <div class="col-2 col-sm-2 text-end">
                  <span class="status" :class="{'text-success': item.borrow_check === 'Active', 'text-warning': item.borrow_check !== 'Active'}">
                    CODE: {{ item.borrow_check }}
                  </span>
                </div>
              </div>
              <hr class="item-divider" v-if="list.length !== 1">
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import clientApi from "@/api/ClientApi";

export default {
  name: 'CheckoutView',
  data() {
    return {
      list: null,
      selectedBook: null,
      errors: {},
      globalError: null,
      loading: false,
      total: 0,
      filters: {
        selectedCategory: null,
        sortBy: 0
      },
      sortBy: [
        {
          value: 0,
          label: this.$t("Sort A to Z"),
        },
        {
          value: 1,
          label: this.$t("Sort Z to A"),
        },
      ],
      last_page: null,
      page: 1,
    };
  },
  props: {
    searchQuery: {
      type: String,
      default: ''
    }
  },
  watch: {
    "searchQuery": {
      handler: function (to, from) {
        if (to != from) {
          this.dropList();
        }
      },
      deep: true,
    },
    "filters.selectedCategory": {
      handler: function (to, from) {
        if (to != from) {
          this.dropList();
        }
      },
      deep: true,
    },
    "filters.sortBy": {
      handler: function (to, from) {
        if (to != from) {
          this.dropList();
        }
      },
      deep: true,
    },
  },
  computed: {
    isAuthorized() {
      return this.$store.state.auth.authorized;
    },
    categories() {
      return this.$store.state.common?.data?.categories ?? []
    },
    tags() {
      return this.$store.state.common.data.tags ?? []
    }
  },
  methods: {
    handleImageError(e) {
      e.target.src = 'http://localhost:8000/defaults/default-cover.jpg';
    },
    dropList() {
      this.list = [];
      this.page = 1;
      this.total = 0;
      this.last_page = null;
      this.loading = false;
      this.$nextTick(() => {
        this.handleLoad();
      });
    },
    handleLoad() {
      if (!this.loading && this.page !== this.last_page) this.getList();
    },
    setCategory(id) {
      this.filters.selectedCategory = id
    },
    setSort(id) {
      this.filters.sortBy = id
    },
    handleBorrow(id) {
      if (this.isAuthorized) {
        this.$router.push({name: 'BorrowMap', params: {id: id, locale: this.$route.params.locale}})
      }
    },
    getList() {
      this.loading = true
      clientApi.getCheckoutList({
        ...this.filters,
        search: this.searchQuery,
        page: this.page,
      }).then(res => {
        this.list = res.data
        this.loading = false;
      }).catch(err => {
        console.log('error', err);
      })
    }
  },
  mounted() {
    this.getList()
  },
};
</script>
<style>
@import url(https://fonts.googleapis.com/css?family=Lato:400,300,700,900);
@import url(https://fonts.googleapis.com/css?family=Roboto+Slab:400,700);
@import url("https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css");
</style>
<style scoped>
.checkout-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem 1rem;
  font-family: 'Lato', sans-serif;
  min-height: calc(100vh - 150px); /* Adjust based on your header height */
}

.empty-state {
  display: flex;
  align-items: center;
  justify-content: center;
  min-height: 60vh; /* Takes majority of viewport */
  text-align: center;
  margin-top: -2rem; /* Compensate for container padding */
}

.empty-content {
  max-width: 300px;
  margin: 0 auto;
}

.back {
  margin-bottom: 1rem;
}

.back-link {
  color: #219e9a;
  font-weight: 500;
  text-decoration: none;
  transition: color 0.2s;
}

.back-link:hover {
  color: #1a7f7b;
}

.checkout-title {
  font-size: 2rem;
  color: #12263a;
  margin-bottom: 2rem;
  text-align: center;
  font-family: 'Roboto Slab', serif;
}

.loading-state {
  display: flex;
  justify-content: center;
  padding: 3rem 0;
}

.loader svg {
  width: 50px;
  height: 50px;
  animation: rotate 1s linear infinite;
}

.empty-state {
  text-align: center;
  padding: 3rem 0;
}

.empty-state svg {
  margin-bottom: 1rem;
}

.empty-state p {
  color: #95a5a6;
  margin-bottom: 1.5rem;
}

.browse-btn {
  display: inline-block;
  padding: 0.5rem 1.5rem;
  background: #219e9a;
  color: white;
  border-radius: 4px;
  text-decoration: none;
  transition: background 0.2s;
}

.browse-btn:hover {
  background: #1a7f7b;
  color: white;
}

.checkout-items {
  background: white;
  border-radius: 8px;
  box-shadow: 0 2px 8px rgba(0,0,0,0.1);
  padding: 1rem;
}

.checkout-item {
  margin-bottom: 1rem;
}

.book-cover {
  width: 100%;
  max-height: 120px;
  object-fit: cover;
  border-radius: 4px;
  box-shadow: 0 2px 4px rgba(0,0,0,0.1);
}

.book-info {
  padding-left: 1rem;
}

.book-title {
  font-size: 1rem;
  font-weight: 700;
  margin-bottom: 0.25rem;
  color: #12263a;
}

.book-author {
  font-size: 0.875rem;
  color: #6c757d;
  margin-bottom: 0.5rem;
}

.book-location {
  font-size: 0.875rem;
  color: #495057;
  display: flex;
  align-items: center;
  gap: 0.25rem;
}

.quantity-badge {
  display: inline-block;
  background: #f4f4f4;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.875rem;
  font-weight: 600;
}

.status {
  font-size: 0.75rem;
  font-weight: 600;
  text-transform: uppercase;
}

.text-success {
  color: #28a745;
}

.text-warning {
  color: #ffc107;
}

.item-divider {
  margin: 1rem 0;
  border: 0;
  border-top: 1px solid rgba(0,0,0,0.1);
}

@keyframes rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@media (max-width: 576px) {
  .book-title {
    font-size: 0.875rem;
  }

  .book-author,
  .book-location {
    font-size: 0.75rem;
  }
}
</style>