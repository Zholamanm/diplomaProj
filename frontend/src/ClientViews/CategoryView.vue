<template>
  <slider-list />
  <div id="main-container" class="category-container">
    <div class="category-main">
      <div class="page-container">
        <!-- Category Header Section -->
        <div class="category-header">
          <h1 class="category-title">{{ category.name }}</h1>
          <p class="category-description">{{ categoryDescription }}</p>
          <div v-if="wikipedia.info" class="wikipedia-info compact">
            <div class="wikipedia-grid">
              <!-- About Section -->
              <div class="wikipedia-card">
                <h3 class="section-title">About {{ category.name }}</h3>
                <p class="wikipedia-text">{{ wikipedia.info.extract }}</p>
                <a :href="wikipedia.info.url" target="_blank" class="wikipedia-link">
                  Read more
                </a>
              </div>

              <!-- Notable Books -->
              <div v-if="wikipedia.notable_books" class="wikipedia-card">
                <h3 class="section-title">Notable Books</h3>
                <div class="compact-list">
        <span v-for="book in wikipedia.notable_books" :key="book.pageid" class="compact-item">
          {{ book.title.replace(/\(.*\)/, '') }}
        </span>
                </div>
              </div>

              <!-- Authors -->
              <div v-if="wikipedia.authors" class="wikipedia-card">
                <h3 class="section-title">Famous Authors</h3>
                <div class="compact-list">
        <span v-for="author in wikipedia.authors" :key="author.pageid" class="compact-item">
          {{ author.title.replace(/\(.*\)/, '') }}
        </span>
                </div>
              </div>
            </div>
          </div>

          <div v-else class="wikipedia-loading">
            <p>Loading additional information...</p>
          </div>
          <div class="genre-tags">
            <span
                v-for="genre in category.genres"
                :key="genre.id"
                class="genre-tag"
                @click="selectedGenre = genre.id"
            >
              {{ genre.name }}
            </span>
          </div>
        </div>

        <!-- Books Section -->
        <section class="book-list-section">
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
              <li class="book-item" v-for="book in books" :key="book.id" :id="'book' + book.id">
                <!-- Same book item structure as your catalog -->
                <div class="book-cover-container">
                  <div class="book-3d">
                    <div class="bk-book">
                      <div class="bk-front">
                        <div
                            class="bk-cover"
                            :style="{ backgroundImage: `url('https://diplomaproj.byethost3.com/storage/${book.cover_image}')` }"
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
                  <button class="details-btn" @click="showBookDetails(book.id)">
                    View Details
                  </button>
                </div>

                <!-- Same overlay details as your catalog -->
                <div class="overlay-details">
                  <!-- ... (copy the overlay structure from your catalog) ... -->
                </div>
              </li>
            </ul>
          </div>
        </section>
      </div>
    </div>

    <div class="overlay-backdrop"></div>
  </div>
</template>

<script>
import $ from 'jquery';
import clientApi from "@/api/ClientApi";
import SliderList from "@/ClientViews/Elements/SliderList.vue";

export default {
  name: 'CategoryView',
  components: {SliderList},
  data() {
    return {
      category: {
        id: null,
        name: '',
        description: '',
        genres: []
      },
      wikipedia: {
        info: null,
        history: null,
        notable_books: null,
        authors: null
      },
      books: [],
      loading: false,
      selectedBook: null,
      selectedGenre: null,
      total: 0,
      page: 1,
      last_page: null
    };
  },
  computed: {
    categoryDescription() {
      // You can customize descriptions per category or use a generic one
      return `Explore our collection of ${this.category.name} books. ${this.category.name} offers a wide range of stories and knowledge.`;
    },
    isAuthorized() {
      return this.$store.state.auth.authorized;
    }
  },
  methods: {
    dropList() {
      this.books = [];
      this.page = 1;
      this.total = 0;
      this.last_page = null;
      this.loading = false;
      this.$nextTick(() => {
        this.handleLoad();
      });
    },
    handleLoad() {
      if (!this.loading && this.page !== this.last_page) this.getBooks();
    },
    truncateDescription(desc) {
      if (!desc) return '';
      return desc.length > 100 ? desc.substring(0, 100) + '...' : desc;
    },
    handleImageError(e) {
      e.target.src = 'https://diplomaproj.byethost3.com/defaults/default-cover.jpg';
    },
    showBookDetails(id) {
      this.$router.push({name: 'BookView', params: {locale: this.$route.params.locale, id: id}})
    },
    handleBorrow(id) {
      if (this.isAuthorized) {
        this.$router.push({name: 'BorrowMap', params: {id: id, locale: this.$route.params.locale}});
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
    },
    fetchCategory() {
      this.loading = true;
      const categoryId = this.$route.params.id;

      clientApi.getCategoryWithBooks(categoryId)
          .then(response => {
            this.category = response.data.category;
            this.wikipedia = response.data.wikipedia;
            this.getBooks()
            this.$nextTick(() => {
              this.initBookAnimations();
            });
          })
          .catch(error => {
            console.error('Error fetching category:', error);
            this.$router.push({ name: 'NotFound' });
          })
          .finally(() => {
            this.loading = false;
          });
    },
    getBooks() {
      this.loading = true
      clientApi.getGuestList({
        selectedCategory: this.$route.params.id,
        genre_id: this.selectedGenre,
        page: this.page,
      }).then(res => {
        this.books = res.data;
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
  mounted() {
    this.fetchCategory();
  },
  watch: {
    '$route.params.id': {
      handler: function() {
        this.fetchCategory();
      },
      immediate: true
    },
    "selectedGenre": {
      handler: function (to, from) {
        if (to != from) {
          this.dropList();
        }
      },
      deep: true,
    },
  }
};
</script>

<style scoped>
/* Base Styles - Inherit from catalog but with some modifications */
.category-container {
  padding: 2rem 0;
  background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
  min-height: 100vh;
}

.category-main {
  max-width: 1600px;
  margin: 0 auto;
  padding: 0 1rem;
}

/* Category Header Styles */
.category-header {
  text-align: center;
  margin-bottom: 3rem;
  padding-bottom: 2rem;
  border-bottom: 1px solid rgba(33, 158, 154, 0.2);
}

.category-title {
  font-size: 2.5rem;
  color: #2c3e50;
  font-family: 'Roboto Slab', serif;
  margin-bottom: 1rem;
}

.category-description {
  font-size: 1.1rem;
  color: #495057;
  line-height: 1.6;
  max-width: 800px;
  margin: 0 auto 1.5rem;
}

/* Genre Tags Styles */
.genre-tags {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 0.5rem;
  margin-top: 1.5rem;
}

.genre-tag {
  padding: 0.5rem 1rem;
  background: rgba(33, 158, 154, 0.1);
  color: #219e9a;
  border-radius: 20px;
  font-size: 0.9rem;
  transition: all 0.2s ease;
}

.genre-tag:hover {
  background: rgba(33, 158, 154, 0.2);
  transform: translateY(-2px);
}

/* Book Grid - Same as catalog */
.book-list-section {
  margin-top: 2rem;
}

/* Responsive Styles */
@media (max-width: 768px) {
  .category-title {
    font-size: 2rem;
  }

  .category-description {
    font-size: 1rem;
    padding: 0 1rem;
  }
}

@media (max-width: 480px) {
  .category-title {
    font-size: 1.8rem;
  }

  .genre-tags {
    justify-content: flex-start;
    padding: 0 1rem;
  }
}
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

.close-overlay-btn svg {
  width: 20px;
  height: 20px;
  stroke: #2c3e50;
}

.overlay-image img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.overlay-btn svg {
  width: 16px;
  height: 16px;
}

@keyframes rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@media (max-width: 768px) {
  .book-grid {
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  }
}

@media (max-width: 480px) {
  .overlay-details {
    width: 95%;
    max-height: 90vh;
  }
}

/* Compact Wikipedia Styles */
.wikipedia-info.compact {
  padding: 1rem;
  margin-top: 1.5rem;
  background: #f8f9fa;
  border-radius: 8px;
  border: 1px solid #e9ecef;
}

.wikipedia-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 1rem;
}

.wikipedia-card {
  background: white;
  padding: 1rem;
  border-radius: 6px;
  box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.compact .section-title {
  font-size: 1.1rem;
  margin-bottom: 0.5rem;
  color: #219e9a;
  padding-bottom: 0.25rem;
  border-bottom: 1px solid rgba(33, 158, 154, 0.2);
}

.compact .wikipedia-text {
  font-size: 0.9rem;
  line-height: 1.4;
  margin-bottom: 0.5rem;
}

.compact .wikipedia-link {
  font-size: 0.8rem;
  display: inline-block;
  margin-top: 0.25rem;
}

.compact-list {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.compact-item {
  font-size: 0.85rem;
  padding: 0.25rem 0.5rem;
  background: #f1f3f5;
  border-radius: 4px;
  display: inline-block;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .wikipedia-grid {
    grid-template-columns: 1fr;
  }

  .wikipedia-card {
    padding: 0.75rem;
  }
}
</style>