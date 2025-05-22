<template>
  <slider-list />
  <div id="main-container" class="catalog-container">
    <div class="catalog-main">
      <div class="page-container">
        <div class="catalog-header">
          <h2 class="catalog-title">Book Catalog</h2>
          <p class="catalog-subtitle">Browse our collection of books</p>
        </div>

        <section class="book-list-section">
          <div class="toolbar">
            <div class="category-filters">
              <button
                  v-for="category in categories"
                  :key="category.id"
                  class="filter-btn"
                  :class="{ 'active': filters.selectedCategory === category.id }"
                  @click="setCategory(category.id)"
              >
                {{ category.name }}
              </button>
              <button
                  class="filter-btn"
                  :class="{ 'active': filters.selectedCategory === null }"
                  @click="setCategory(null)"
              >
                All Categories
              </button>
            </div>

            <div class="sort-control">
              <select class="sort-select" v-model="filters.sortBy">
                <option value="" disabled selected>Sort by</option>
                <option v-for="(sort, index) in sortBy" :key="index" :value="sort.value">
                  {{ sort.label }}
                </option>
              </select>
            </div>
          </div>

          <div class="book-grid-container">
            <div v-if="loading" class="loading-state">
              <div class="loader">
                <svg viewBox="0 0 50 50">
                  <circle cx="25" cy="25" r="20" fill="none" stroke="#219e9a" stroke-width="5"></circle>
                </svg>
                <p>Loading books...</p>
              </div>
            </div>

            <ul v-else class="book-grid">
              <li class="book-item" v-for="book in list" :key="book.id" :id="'book' + book.id">
                <div class="book-cover-container">
                  <div class="book-3d">
                    <div class="bk-book">
                      <div class="bk-front">
                        <div
                            class="bk-cover"
                            :style="{ backgroundImage: `url('http://localhost:8000/storage/${book.cover_image}')` }"
                            @error="handleImageError"
                        ></div>
                      </div>
                      <div class="bk-back"></div>
                      <div class="bk-left"></div>
                    </div>
                  </div>
                </div>

                <div class="book-info">
                  <h3 class="book-title">{{ book.title }}</h3>
                  <p class="book-author">{{ book.author }}</p>
                  <p class="book-description">{{ truncateDescription(book.description) }}</p>
                  <button class="details-btn" @click="showBookDetails($event, book)">
                    View Details
                  </button>
                </div>

                <div class="overlay-details">
                  <button class="close-overlay-btn" @click="closeModal">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                      <path d="M18 6L6 18M6 6l12 12"/>
                    </svg>
                  </button>

                  <div class="overlay-content">
                    <div class="overlay-image-container">
                      <div class="overlay-image">
                        <img
                            :src="'http://localhost:8000/storage/' + book.cover_image"
                            alt="Book Cover"
                            @error="handleImageError"
                        >
                      </div>
                    </div>

                    <div class="overlay-info">
                      <h2 class="overlay-title">{{ book.title }}</h2>
                      <p class="overlay-author">{{ book.author }}</p>
                      <p class="overlay-synopsis">{{ book.description }}</p>

                      <div class="overlay-actions">
                        <button
                            class="overlay-btn borrow-btn"
                            :class="{ 'disabled': !isAuthorized }"
                            @click="handleBorrow(book.id)"
                        >
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                            <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                          </svg>
                          Borrow
                        </button>

                        <button
                            class="overlay-btn favorite-btn"
                            :class="{ 'disabled': !isAuthorized, 'active': listFav?.some(fav => fav?.book_id === book?.id) }"
                            @click="handleFavourite(book.id)"
                        >
                          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                          </svg>
                          {{ listFav?.some(fav => fav.book_id === book.id) ? 'Remove Favorite' : 'Add Favorite' }}
                        </button>
                      </div>
                    </div>
                  </div>
                </div>
              </li>
            </ul>
          </div>
        </section>
      </div>
    </div>
    <iframe	style="width: 400px; height: 600px;" src="https://app.fastbots.ai/embed/cmazk5jqk0a8nn8luyhslp7l1"></iframe>

    <div class="overlay-backdrop"></div>
  </div>
</template>

<script>
import $ from 'jquery';
import clientApi from "@/api/ClientApi";
import SliderList from "@/ClientViews/Elements/SliderList.vue";

export default {
  name: 'CatalogView',
  components: {SliderList},
  data() {
    return {
      list: null,
      listFav: null,
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
    truncateDescription(desc) {
      if (!desc) return '';
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
    handleLoad() {
      if (!this.loading && this.page !== this.last_page) this.getList();
    },
    setCategory(id) {
      this.filters.selectedCategory = id;
    },
    setSort(id) {
      this.filters.sortBy = id;
    },
    handleBorrow(id) {
      if (this.isAuthorized) {
        this.$router.push({name: 'BorrowMap', params: {id: id, locale: this.$route.params.locale}});
      }
    },
    handleFavourite(id) {
      if (this.isAuthorized) {
        if (this.listFav.some(fav => fav.book_id === parseInt(id))) {
          this.loading = true;
          clientApi.removeFromFavourite(id).then(() => {
            this.dropList();
            this.loading = false;
            this.closeModal();
          });
        } else {
          this.loading = true;
          clientApi.addToFavourite(id).then(() => {
            this.dropList();
            this.loading = false;
            this.closeModal();
          });
        }
      }
    },
    handleImageError(e) {
      e.target.src = 'http://localhost:8000/defaults/default-cover.jpg';
    },
    showBookDetails(event, book) {
      const $el = $(event.currentTarget).closest('.book-item');
      this.selectedBook = book
      this.displayBookDetails($el);
    },
    displayBookDetails(el) {
      $('.catalog-container').addClass('prevent-scroll');
      $('.overlay-backdrop').fadeIn();

      const $overlay = $(el).find('.overlay-details').clone();
      $overlay.prependTo('.overlay-backdrop');
      $overlay.css('display', 'block');
      $overlay.find('.borrow-btn').on('click', () => {
        this.handleBorrow(el.attr('id').replace('book', ''));
      });

      $overlay.find('.favorite-btn').on('click', () => {
        this.handleFavourite(el.attr('id').replace('book', ''));
      });
      $overlay.find('.close-overlay-btn').on('click', () => {
        this.closeModal();
      });
    },
    closeModal() {
      $('.catalog-container').removeClass('prevent-scroll');
      $('.overlay-backdrop').fadeOut();
      this.selectedBook = null
      $('.overlay-details').css('display', 'none');
      $('.overlay-backdrop').find('.overlay-details').remove();
    },
    getList() {
      this.loading = true;
      if (this.isAuthorized) {
        clientApi.getList({
          ...this.filters,
          search: this.searchQuery ?? this.$route.query.search,
          page: this.page,
        }).then(res => {
          this.list = res.books.data;
          this.total = res.total
          this.page = res.page;
          this.last_page = res.last_page;
          this.listFav = res.favourites;
          this.$nextTick(() => {
            this.initBookAnimations();
          });
          this.loading = false;
        }).catch(err => {
          console.error('Error fetching book list:', err);
          this.loading = false;
        });
      } else {
        clientApi.getGuestList({
          ...this.filters,
          search: this.searchQuery,
          page: this.page,
        }).then(res => {
          this.list = res.data;
          this.total = res.total
          this.page = res.page;
          this.last_page = res.last_page;
          this.$nextTick(() => {
            this.initBookAnimations();
          });
          this.loading = false;
        }).catch(err => {
          console.error('Error fetching guest book list:', err);
          this.loading = false;
        });
      }
    },
    initBookAnimations() {
      $(".bk-book").each(function() {
        const $book = $(this);
        $book.hover(
            function() {
              $book.css('transform', 'rotate3d(0, 1, 0, 25deg)');
              $book.find('.bk-back').css('opacity', '1');
            },
            function() {
              $book.css('transform', '');
              $book.find('.bk-back').css('opacity', '0');
            }
        );
      });
    }
  },
  mounted() {
    this.getList();
  }
};
</script>

<style scoped>
/* Base Styles */
.catalog-container {
  padding: 2rem 0;
  background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
  min-height: 100vh;
}

.catalog-main {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

.catalog-header {
  text-align: center;
  margin-bottom: 2rem;
}

.catalog-title {
  font-size: 2rem;
  color: #2c3e50;
  font-family: 'Roboto Slab', serif;
  margin-bottom: 0.5rem;
}

.catalog-subtitle {
  font-size: 1rem;
  color: #6c757d;
  font-weight: 300;
}

/* Toolbar Styles */
.toolbar {
  display: flex;
  flex-wrap: wrap;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid rgba(33, 158, 154, 0.2);
}

.category-filters {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
  margin-bottom: 1rem;
}

.filter-btn {
  padding: 0.5rem 1rem;
  background: rgba(33, 158, 154, 0.1);
  color: #219e9a;
  border: none;
  border-radius: 20px;
  font-size: 0.9rem;
  cursor: pointer;
  transition: all 0.2s ease;
}

.filter-btn:hover {
  background: rgba(33, 158, 154, 0.2);
}

.filter-btn.active {
  background: #219e9a;
  color: white;
}

.sort-control {
  margin-bottom: 1rem;
}

.sort-select {
  padding: 0.5rem 1rem;
  border: 1px solid rgba(33, 158, 154, 0.3);
  border-radius: 4px;
  background: white;
  color: #2c3e50;
  font-size: 0.9rem;
}

.sort-select:focus {
  outline: none;
  border-color: #219e9a;
  box-shadow: 0 0 0 2px rgba(33, 158, 154, 0.2);
}

/* Book Grid Styles */
.book-grid-container {
  position: relative;
  min-height: 300px;
}

.loading-state {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 300px;
}

.loader {
  text-align: center;
}

.loader svg {
  width: 50px;
  height: 50px;
  animation: rotate 1s linear infinite;
}

.loader p {
  margin-top: 1rem;
  color: #219e9a;
  font-weight: 500;
}

.book-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
  gap: 2rem;
  list-style: none;
  padding: 0;
  margin: 0;
}

.book-item {
  position: relative;
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
}

.book-item:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

/* Book Cover 3D Effect */
.book-cover-container {
  padding: 1.5rem;
  background: rgba(33, 158, 154, 0.05);
  text-align: center;
}

.book-3d {
  perspective: 1400px;
  height: 250px;
}

.bk-book {
  position: relative;
  width: 150px;
  height: 215px;
  margin: 0 auto;
  transform-style: preserve-3d;
  transition: transform 0.5s;
}

.bk-front, .bk-back, .bk-left {
  position: absolute;
  width: 100%;
  height: 100%;
  transform-style: preserve-3d;
}

.bk-front {
  transform: translate3d(0, 0, 20px);
  z-index: 10;
}

.bk-front > div {
  position: absolute;
  width: 100%;
  height: 100%;
  backface-visibility: hidden;
  transform-style: preserve-3d;
  border-radius: 0 3px 3px 0;
  box-shadow: inset 4px 0 10px rgba(0, 0, 0, 0.1);
}

.bk-cover {
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
  width: 100%;
  height: 100%;
}

.bk-back {
  transform: rotate3d(0, 1, 0, -180deg) translate3d(0, 0, 20px);
  box-shadow: 5px 7px 15px rgba(0, 0, 0, 0.3);
  border-radius: 3px 0 0 3px;
  opacity: 0;
  transition: opacity 0.3s ease;
  background: white;
}

.bk-left {
  width: 40px;
  left: -20px;
  transform: rotate3d(0, 1, 0, -90deg);
  background: #219e9a;
}

/* Book Info Styles */
.book-info {
  padding: 1.5rem;
}

.book-title {
  font-size: 1.2rem;
  color: #2c3e50;
  margin: 0 0 0.5rem 0;
  line-height: 1.3;
}

.book-author {
  color: #6c757d;
  font-size: 0.9rem;
  margin: 0 0 1rem 0;
}

.book-description {
  color: #495057;
  font-size: 0.9rem;
  line-height: 1.5;
  margin-bottom: 1.5rem;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.details-btn {
  display: block;
  width: 100%;
  padding: 0.75rem;
  background: rgba(33, 158, 154, 0.1);
  color: #219e9a;
  border: 1px solid #219e9a;
  border-radius: 4px;
  font-size: 0.9rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
  text-align: center;
}

.details-btn:hover {
  background: #219e9a;
  color: white;
}

/* Overlay Styles */
.overlay-backdrop {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.7);
  display: none;
  z-index: 1000;
  overflow-y: auto;
}

.overlay-details {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 90%;
  max-width: 800px;
  max-height: 90vh;
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
  display: none;
}

.close-overlay-btn {
  position: absolute;
  top: 15px;
  right: 15px;
  width: 32px;
  height: 32px;
  background: rgba(255, 255, 255, 0.8);
  border: none;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  z-index: 10;
}

.close-overlay-btn svg {
  width: 20px;
  height: 20px;
  stroke: #2c3e50;
}

.overlay-content {
  display: flex;
  flex-direction: column;
  height: 100%;
}

.overlay-image-container {
  position: relative;
  height: 300px;
  background: rgba(33, 158, 154, 0.1);
}

.overlay-image {
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  width: 200px;
  height: 300px;
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
}

.overlay-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.overlay-info {
  padding: 2rem;
  overflow-y: auto;
}

.overlay-title {
  font-size: 1.8rem;
  color: #2c3e50;
  margin-bottom: 0.5rem;
}

.overlay-author {
  color: #6c757d;
  font-size: 1.1rem;
  margin-bottom: 1.5rem;
}

.overlay-synopsis {
  color: #495057;
  line-height: 1.6;
  margin-bottom: 2rem;
}

.overlay-actions {
  display: flex;
  gap: 1rem;
  margin-top: 2rem;
}

.overlay-btn {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 0.75rem;
  border: none;
  border-radius: 4px;
  font-size: 0.9rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.borrow-btn {
  background: rgba(33, 158, 154, 0.1);
  color: #219e9a;
}

.borrow-btn:hover {
  background: #219e9a;
  color: white;
}

.favorite-btn {
  background: rgba(231, 76, 60, 0.1);
  color: #e74c3c;
}

.favorite-btn:hover {
  background: #e74c3c;
  color: white;
}

.favorite-btn.active {
  background: #219e9a;
  color: white;
}

.overlay-btn.disabled {
  background: #e9ecef;
  color: #adb5bd;
  cursor: not-allowed;
}

.overlay-btn svg {
  width: 16px;
  height: 16px;
}

/* Animations */
@keyframes rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Responsive Styles */
@media (max-width: 768px) {
  .book-grid {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  }

  .overlay-content {
    flex-direction: column;
  }

  .overlay-image-container {
    height: 200px;
  }

  .overlay-image {
    width: 150px;
    height: 225px;
  }

  .overlay-actions {
    flex-direction: column;
  }
}

@media (max-width: 480px) {
  .toolbar {
    flex-direction: column;
  }

  .category-filters {
    justify-content: center;
  }

  .sort-control {
    width: 100%;
  }

  .sort-select {
    width: 100%;
  }

  .overlay-details {
    width: 95%;
    max-height: 90vh;
  }

  .overlay-info {
    padding: 1.5rem;
  }
}
</style>