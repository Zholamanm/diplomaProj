<template>
  <slider-list />
  <div id="genre-container" class="genre-container">
    <div class="genre-main">
      <div class="page-container">
        <!-- Genre Header Section -->
        <div class="genre-header">
          <div class="genre-info-card">
            <div class="genre-cover"
                 :style="{ backgroundImage: `url('https://diplomaproj.byethost3.com/storage/${topBook?.cover_image}')` }">
              <div class="genre-overlay"></div>
              <div class="genre-meta">
                <h1 class="genre-title">{{ genre.name }}</h1>
                <div class="genre-stats">
                  <span class="stat-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#FFD700">
                      <path
                          d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                    {{ averageRating.toFixed(1) }} ({{ totalReviews }} reviews)
                  </span>
                  <span class="stat-item">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#219e9a">
                      <path
                          d="M3 5v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2H5c-1.11 0-2 .9-2 2zm12 4c0 1.66-1.34 3-3 3s-3-1.34-3-3 1.34-3 3-3 3 1.34 3 3zm-9 8c0-2 4-3.1 6-3.1s6 1.1 6 3.1v1H6v-1z"/>
                    </svg>
                    {{ books.length }} top books
                  </span>
                </div>
              </div>
            </div>
            <div class="genre-description">
              <p>{{ genreDescription }}</p>
              <div v-if="wikipedia.info" class="wikipedia-excerpt">
                <p>{{ wikipedia.info.extract }}</p>
                <a :href="wikipedia.info.url" target="_blank" class="read-more">Read more on Wikipedia</a>
              </div>
              <div v-if="wikipedia.authors" class="wikipedia-excerpt mt-2">
                <h3 class="section-title">Famous Authors</h3>
                <div class="compact-list">
                    <span v-for="(author, index) in wikipedia.authors.slice(1, 9)" :key="author.pageid" class="compact-item">
                      {{ author.title.replace(/\(.*\)/, '') + (wikipedia.authors.length === (index + 2) ? '' : ', ')}}
                    </span>
                </div>
              </div>
              <div v-if="wikipedia.notable_books" class="wikipedia-excerpt mt-2">
                <h3 class="section-title">Notable Books</h3>
                <div class="compact-list">
                    <span v-for="(book, index) in wikipedia.notable_books" :key="book.pageid" class="compact-item">
                      {{ book.title.replace(/\(.*\)/, '') + (wikipedia.notable_books.length === (index + 1) ? '' : ', ')}}
                    </span>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Top Books Section -->
        <section class="top-books-section">
          <h2 class="section-title">Top 10 {{ genre.name }} Books</h2>

          <div v-if="loading" class="loading-state">
            <div class="loader">
              <svg viewBox="0 0 50 50">
                <circle cx="25" cy="25" r="20" fill="none" stroke="#219e9a" stroke-width="5"></circle>
              </svg>
              <p>Loading top books...</p>
            </div>
          </div>

          <div v-else class="top-books-grid">
            <div class="top-book-card" v-for="(book, index) in books" :key="book.id">
              <div class="book-rank">{{ index + 1 }}</div>
              <div class="book-cover"
                   :style="{ backgroundImage: `url('https://diplomaproj.byethost3.com/storage/${book.cover_image}')` }"
                   @error="handleImageError">
              </div>
              <div class="book-details">
                <h3 class="book-title">{{ book.title }}</h3>
                <p class="book-author">{{ book.author }}</p>
                <div class="book-rating">
                  <div class="stars">
                    <span v-for="i in 5" :key="i"
                          :class="{ 'filled': i <= Math.round(calculateRating(book.reviews)) }">
                      ★
                    </span>
                  </div>
                  <span class="rating-value">
                    {{ calculateRating(book.reviews).toFixed(1) }} ({{ book.reviews?.length || 0 }})
                  </span>
                </div>
                <p class="book-description">{{ truncateDescription(book.description) }}</p>
                <button class="view-btn" @click="showBookDetails(book.id)">
                  View Details
                </button>
              </div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>
</template>

<script>
import clientApi from "@/api/ClientApi";
import SliderList from "@/ClientViews/Elements/SliderList.vue";

export default {
  name: 'GenreView',
  components: {SliderList},
  data() {
    return {
      genre: {
        id: null,
        name: '',
      },
      books: [],
      loading: false,
      wikipedia: {
        info: null,
      },
    };
  },
  computed: {
    genreDescription() {
      return `Explore the most popular books in the ${this.genre.name} genre. These top-rated selections have been loved by readers worldwide.`;
    },
    topBook() {
      return this.books.length > 0 ? this.books[0] : null;
    },
    averageRating() {
      if (this.books.length === 0) return 0;
      const sum = this.books.reduce((total, book) => {
        return total + this.calculateRating(book.reviews);
      }, 0);
      return sum / this.books.length;
    },
    totalReviews() {
      return this.books.reduce((total, book) => {
        return total + (book.reviews?.length || 0);
      }, 0);
    }
  },
  methods: {
    calculateRating(reviews) {
      if (!reviews || reviews.length === 0) return 0;
      const sum = reviews.reduce((total, review) => total + review.rating, 0);
      return sum / reviews.length;
    },
    truncateDescription(desc) {
      if (!desc) return '';
      return desc.length > 120 ? desc.substring(0, 120) + '...' : desc;
    },
    handleImageError(e) {
      e.target.style.backgroundImage = "url('https://diplomaproj.byethost3.com/defaults/default-cover.jpg')";
    },
    showBookDetails(id) {
      this.$router.push({name: 'BookView', params: {id}});
    },
    fetchGenreTopBooks() {
      this.loading = true;
      const genreId = this.$route.params.id;

      clientApi.getTopBooksByGenre(genreId)
          .then(response => {
            this.genre = response.genre;
            this.books = response.books.slice(0, 10); // Get top 10
            this.wikipedia = response.wikipedia || {};
          })
          .catch(error => {
            console.error('Error fetching genre top books:', error);
          })
          .finally(() => {
            this.loading = false;
          });
    }
  },
  mounted() {
    this.fetchGenreTopBooks();
  },
  watch: {
    '$route.params.id': {
      handler: function () {
        this.fetchGenreTopBooks();
      },
      immediate: true
    }
  }
};
</script>

<style scoped>
.genre-container {
  padding: 2rem 0;
  background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
  min-height: 100vh;
}

.genre-main {
  max-width: 1600px;
  margin: 0 auto;
  padding: 0 1rem;
}

/* Genre Header Styles */
.genre-header {
  margin-bottom: 3rem;
}

.genre-info-card {
  display: flex;
  flex-direction: column;
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 8px 24px rgba(0, 0, 0, 0.08);
}

.genre-cover {
  position: relative;
  height: 300px;
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: flex-end;
}

.genre-overlay {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: linear-gradient(to top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.3) 100%);
}

.genre-meta {
  position: relative;
  z-index: 2;
  padding: 2rem;
  color: white;
  width: 100%;
}

.genre-title {
  font-size: 2.5rem;
  margin: 0 0 0.5rem 0;
  font-family: 'Roboto Slab', serif;
  text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
}

.genre-stats {
  display: flex;
  gap: 1.5rem;
}

.stat-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 1rem;
}

.stat-item svg {
  width: 20px;
  height: 20px;
}

.genre-description {
  padding: 2rem;
}

.genre-description p {
  font-size: 1.1rem;
  line-height: 1.6;
  color: #495057;
  margin-bottom: 1.5rem;
}

.wikipedia-excerpt {
  background: #f8f9fa;
  padding: 1rem;
  border-radius: 8px;
  border-left: 4px solid #219e9a;
}

.wikipedia-excerpt p {
  font-size: 0.95rem;
  margin-bottom: 0.5rem;
}

.read-more {
  color: #219e9a;
  font-size: 0.9rem;
  text-decoration: none;
  font-weight: 500;
}

.read-more:hover {
  text-decoration: underline;
}

/* Top Books Section */
.top-books-section {
  margin-top: 2rem;
}

.section-title {
  font-size: 1.8rem;
  color: #2c3e50;
  margin-bottom: 2rem;
  font-family: 'Roboto Slab', serif;
  padding-bottom: 0.5rem;
  border-bottom: 2px solid rgba(33, 158, 154, 0.2);
}

.top-books-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
  gap: 2rem;
}

.top-book-card {
  display: flex;
  background: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  position: relative;
}

.top-book-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.book-rank {
  position: absolute;
  top: -10px;
  left: -10px;
  width: 40px;
  height: 40px;
  background: #219e9a;
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  font-size: 1.2rem;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
  z-index: 2;
}

.book-cover {
  width: 120px;
  height: 180px;
  background-size: cover;
  background-position: center;
  flex-shrink: 0;
}

.book-details {
  padding: 1.5rem;
  flex-grow: 1;
}

.book-title {
  font-size: 1.1rem;
  color: #2c3e50;
  margin: 0 0 0.25rem 0;
  line-height: 1.3;
}

.book-author {
  color: #6c757d;
  font-size: 0.9rem;
  margin: 0 0 0.75rem 0;
}

.book-rating {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.75rem;
}

.stars {
  color: #ddd;
}

.stars .filled {
  color: #FFD700;
}

.rating-value {
  font-size: 0.85rem;
  color: #6c757d;
}

.book-description {
  color: #495057;
  font-size: 0.9rem;
  line-height: 1.5;
  margin-bottom: 1rem;
  display: -webkit-box;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
}

.view-btn {
  padding: 0.5rem 1rem;
  background: rgba(33, 158, 154, 0.1);
  color: #219e9a;
  border: 1px solid #219e9a;
  border-radius: 4px;
  font-size: 0.85rem;
  cursor: pointer;
  transition: all 0.2s ease;
}

.view-btn:hover {
  background: #219e9a;
  color: white;
}

/* Loading State */
.loading-state {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 200px;
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

@keyframes rotate {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

/* Responsive Styles */
@media (max-width: 768px) {
  .genre-info-card {
    flex-direction: column;
  }

  .genre-cover {
    height: 200px;
  }

  .genre-title {
    font-size: 2rem;
  }

  .top-books-grid {
    grid-template-columns: 1fr;
  }

  .top-book-card {
    flex-direction: column;
  }

  .book-cover {
    width: 100%;
    height: 200px;
  }
}

@media (max-width: 480px) {
  .genre-title {
    font-size: 1.8rem;
  }

  .genre-stats {
    flex-direction: column;
    gap: 0.5rem;
  }
}
</style>