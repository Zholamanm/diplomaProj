<template>
  <div class="recommendations-container">
    <h2 class="section-title">Recommended Books</h2>
    <p class="section-subtitle">Discover your next favorite read</p>

    <div class="carousel" mask style="justify-self: center">
      <article v-for="(item, index) in list" :key="index" class="book-card">
        <div class="book-cover">
          <img :src="`http://localhost:8000/storage/${item.cover_image}`" alt="Book cover" @error="handleImageError">
          <button class="favorite-btn" @click.stop="handleFavourite(item)">
            <svg :style="{ fill: listFav?.some(x => x.book_id === item.id) ? '#e63946' : 'none' }" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
            </svg>
          </button>
        </div>

        <div class="book-details">
          <h3 class="book-title">{{ item.title }}</h3>
          <p class="book-author">{{ item.author }}</p>

          <div class="book-description">
            <p>{{ truncateDescription(item.description) }}</p>
            <div class="book-actions">
              <a href="#" class="read-more">Read more</a>
              <button class="borrow-btn" @click.stop="handleBorrow(item.id)">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                  <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
                Borrow
              </button>
            </div>
          </div>
        </div>
      </article>
    </div>
  </div>
</template>

<script>
import clientApi from "@/api/ClientApi";
import '../../assets/carousel.css'

export default {
  name: 'RecommendView',
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
    listFav: {
      type: Array,
      default: null,
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
    truncateDescription(desc) {
      return desc.length > 100 ? desc.substring(0, 100) + '...' : desc;
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
    handleImageError(e) {
      e.target.src = 'http://localhost:8000/defaults/default-cover.jpg';
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
      this.$router.push({name: 'BorrowMap', params: {id: id, locale: this.$route.params.locale}})
    },
    handleFavourite(item) {
      if (!this.isAuthorized) return;
      console.log("Added to favourites:", item.title);
    },
    loadCatalog() {
      // Your catalog loading logic
    },
    getList() {
      this.loading = true;
      clientApi.getRecommendList({
        ...this.filters,
        search: this.searchQuery,
        page: this.page,
      }).then( res => {
        this.list = res
        this.$nextTick(() => {
          this.loadCatalog();
        });
        this.loading = false;
      }).catch(() => {
        console.log('error');
      })
    }
  },
  mounted() {
    this.getList()
  },
  updated() {
    this.loadCatalog()
  }
};
</script>

<style scoped>
.recommendations-container {
  padding: 2rem 0;
  background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
}

.section-title {
  text-align: center;
  font-size: 1.8rem;
  color: #2c3e50;
  margin-bottom: 0.5rem;
  font-family: 'Roboto Slab', serif;
}

.section-subtitle {
  text-align: center;
  font-size: 1rem;
  color: #6c757d;
  margin-bottom: 2rem;
  font-weight: 300;
}

.carousel {
  --items: 6;
  --carousel-duration: 40s;
  --carousel-width: min(90vw, 1200px);
  --carousel-item-width: 240px;
  --carousel-item-height: 350px;
  --carousel-item-gap: 20px;
  --clr-primary: #219e9a;
  --clr-secondary: #2a3f54;
  --clr-accent: #ff7b54;
}

.book-card {
  position: absolute;
  top: 0;
  left: calc(100% + var(--carousel-item-gap));
  width: var(--carousel-item-width);
  height: var(--carousel-item-height);
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  display: flex;
  flex-direction: column;
}

.book-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.book-cover {
  position: relative;
  height: 180px;
  overflow: hidden;
}

.book-cover img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.3s ease;
}

.book-card:hover .book-cover img {
  transform: scale(1.05);
}

.favorite-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background: rgba(255, 255, 255, 0.8);
  border: none;
  width: 32px;
  height: 32px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s ease;
}

.favorite-btn:hover {
  background: white;
  transform: scale(1.1);
}

.favorite-btn svg {
  width: 18px;
  height: 18px;
  stroke: #e63946;
  fill: none;
}

.favorite-btn:hover svg {
  fill: #e63946;
}

.book-details {
  padding: 1rem;
  flex: 1;
  display: flex;
  flex-direction: column;
}

.book-title {
  font-size: 1.1rem;
  font-weight: 600;
  margin: 0 0 0.25rem 0;
  color: #2c3e50;
  line-height: 1.3;
}

.book-author {
  font-size: 0.85rem;
  color: #6c757d;
  margin: 0 0 0.75rem 0;
}

.book-description {
  flex: 1;
  font-size: 0.9rem;
  color: #495057;
  line-height: 1.5;
  margin-bottom: 1rem;
}

.book-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: auto;
}

.read-more {
  color: #219e9a;
  font-size: 0.85rem;
  text-decoration: none;
  transition: color 0.2s ease;
}

.read-more:hover {
  color: #1a7f7b;
  text-decoration: underline;
}

.borrow-btn {
  display: flex;
  align-items: center;
  gap: 0.3rem;
  padding: 0.4rem 0.8rem;
  background: rgba(33, 158, 154, 0.1);
  color: #219e9a;
  border: 1px solid #219e9a;
  border-radius: 4px;
  font-size: 0.85rem;
  cursor: pointer;
  transition: all 0.2s ease;
}

.borrow-btn:hover {
  background: #219e9a;
  color: white;
}

.borrow-btn svg {
  width: 14px;
  height: 14px;
  stroke-width: 2.5;
}

/* Animation delays for each card */
.carousel > article:nth-child(1) { --i: 0; }
.carousel > article:nth-child(2) { --i: 1; }
.carousel > article:nth-child(3) { --i: 2; }
.carousel > article:nth-child(4) { --i: 3; }
.carousel > article:nth-child(5) { --i: 4; }
.carousel > article:nth-child(6) { --i: 5; }
.carousel > article:nth-child(7) { --i: 6; }
.carousel > article:nth-child(8) { --i: 7; }

@media (max-width: 768px) {
  .carousel {
    --carousel-item-width: 220px;
    --carousel-item-height: 400px;
  }

  .section-title {
    font-size: 1.5rem;
  }
}
</style>