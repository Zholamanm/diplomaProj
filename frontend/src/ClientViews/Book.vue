<template>
  <div class="book-detail-container">
    <!-- Loading State -->
    <div v-if="loading" class="loading-state">
      <div class="loader">
        <svg viewBox="0 0 50 50">
          <circle cx="25" cy="25" r="20" fill="none" stroke="#219e9a" stroke-width="5"></circle>
        </svg>
        <p>Loading book details...</p>
      </div>
    </div>

    <!-- Main Content -->
    <div v-else-if="book" class="book-detail-content">
      <!-- Book Header -->
      <div class="book-header">
        <h1 class="book-title">{{ book.title }}</h1>
        <p class="book-author">by {{ book.author }}</p>
      </div>

      <!-- Book Main Content -->
      <div class="book-main">
        <!-- Book Media Section -->
        <div class="book-media">
          <div class="main-image">
            <img
                :src="book.cover_image ? `http://localhost:8000/storage/${book.cover_image}` : placeholderImage"
                :alt="`Cover of ${book.title}`"
                @error="handleImageError"
            >
          </div>
          <div v-if="similarBooks.length > 0" class="similar-books">
            <h3>Similar Books</h3>
            <div class="similar-books-grid">
              <div
                  v-for="similar in similarBooks.slice(0, 4)"
                  :key="similar.key"
                  class="similar-book"
              >
                <img
                    :src="`https://covers.openlibrary.org/b/olid/${similar.cover_edition_key}-M.jpg`"
                    :alt="similar.title"
                    @error="handleSimilarImageError"
                >
                <p>{{ similar.title }}</p>
              </div>
            </div>
          </div>
        </div>

        <!-- Book Info Section -->
        <div class="book-info">
          <!-- Description -->
          <div class="book-description">
            <h2>About This Book</h2>
            <p>{{ book.description || 'No description available.' }}</p>
          </div>

          <!-- Details -->
          <div class="book-details">
            <h2>Details</h2>
            <ul>
              <li v-if="details">
                <strong>First Published:</strong>
                <span>{{ details.first_publish_year || 'Unknown' }}</span>
              </li>
              <li>
                <strong>Category:</strong>
                <span>{{ getCategoryName(book.category_id) }}</span>
              </li>
              <li v-if="details && details.language">
                <strong>Languages:</strong>
                <span>{{ formatLanguages(details.language) }}</span>
              </li>
              <li v-if="details && details.ebook_access">
                <strong>Availability:</strong>
                <span class="availability">{{ formatAvailability(details.ebook_access) }}</span>
              </li>
            </ul>
          </div>

          <!-- Actions -->
          <div class="book-actions">
            <button
                class="borrow-btn"
                @click="handleBorrow(book.id)"
                :disabled="!isAuthorized"
            >
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/>
                <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
              </svg>
              Borrow This Book
            </button>

            <button
                class="favorite-btn"
                @click="handleFavourite(book.id)"
                :class="{ 'active': isFavorite }"
                :disabled="!isAuthorized"
            >
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
              </svg>
              {{ isFavorite ? 'Remove from Favorites' : 'Add to Favorites' }}
            </button>
          </div>

          <!-- Social Sharing -->
          <div class="social-sharing">
            <p>Share this book:</p>
            <div class="social-icons">
              <a href="#" class="social-icon facebook">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"/>
                </svg>
              </a>
              <a href="#" class="social-icon twitter">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                </svg>
              </a>
              <a href="#" class="social-icon whatsapp">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                  <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
              </a>
            </div>
          </div>
        </div>
      </div>

      <!-- Additional Information -->
      <div v-if="details" class="additional-info">
        <h2>Additional Information</h2>
        <div class="info-grid">
          <div class="info-card">
            <h3>Edition Details</h3>
            <p v-if="details.edition_count">Total Editions: {{ details.edition_count }}</p>
            <p v-if="details.first_publish_year">First Published: {{ details.first_publish_year }}</p>
          </div>

          <div class="info-card" v-if="details.language">
            <h3>Available Languages</h3>
            <div class="language-tags">
              <span v-for="lang in details.language.slice(0, 5)" :key="lang" class="language-tag">
                {{ getLanguageName(lang) }}
              </span>
              <span v-if="details.language.length > 5" class="language-tag">
                +{{ details.language.length - 5 }} more
              </span>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Error State -->
    <div v-else class="error-state">
      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#e63946" width="48" height="48">
        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/>
      </svg>
      <h2>Book Not Found</h2>
      <p>We couldn't find the book you're looking for.</p>
      <button class="back-btn" @click="$router.go(-1)">Go Back</button>
    </div>
  </div>
</template>

<script>
import clientApi from "@/api/ClientApi";

export default {
  name: 'BookView',
  data() {
    return {
      book: null,
      similar: null,
      details: null,
      errors: {},
      loading: false,
      placeholderImage: 'https://via.placeholder.com/300x450?text=No+Cover',
      similarPlaceholder: 'https://via.placeholder.com/100x150?text=No+Cover'
    };
  },
  computed: {
    isAuthorized() {
      return this.$store.state.auth.authorized;
    },
    isFavorite() {
      // This would need to be implemented based on your favorites logic
      return false;
    },
    similarBooks() {
      return this.similar?.original?.docs || [];
    }
  },
  methods: {
    handleImageError(e) {
      e.target.src = this.placeholderImage;
    },
    handleSimilarImageError(e) {
      e.target.src = this.similarPlaceholder;
    },
    getCategoryName() {
      // Implement category name lookup based on your categories data
      return 'Fantasy'; // Placeholder
    },
    formatAvailability(access) {
      switch(access) {
        case 'borrowable': return 'Available to borrow';
        case 'public': return 'Publicly available';
        case 'restricted': return 'Restricted access';
        default: return 'Availability unknown';
      }
    },
    formatLanguages(languages) {
      if (!languages || languages.length === 0) return 'Unknown';
      if (languages.length <= 3) {
        return languages.map(lang => this.getLanguageName(lang)).join(', ');
      }
      return `${this.getLanguageName(languages[0])}, ${this.getLanguageName(languages[1])} and ${languages.length - 2} more`;
    },
    getLanguageName(code) {
      const languageNames = {
        eng: 'English',
        spa: 'Spanish',
        fre: 'French',
        ger: 'German',
        ita: 'Italian',
        por: 'Portuguese',
        rus: 'Russian',
        jpn: 'Japanese',
        chi: 'Chinese',
        // Add more language codes as needed
      };
      return languageNames[code] || code;
    },
    handleBorrow(id) {
      if (this.isAuthorized) {
        this.$router.push({name: 'BorrowMap', params: {id: id, locale: this.$route.params.locale}});
      } else {
        // Show login modal or redirect to login
        alert('Please login to borrow books');
      }
    },
    handleFavourite(id) {
      if (this.isAuthorized) {
        this.loading = true;
        if (this.isFavorite) {
          clientApi.removeFromFavourite(id).then(() => {
            this.loading = false;
            // Update UI to reflect removal
          });
        } else {
          clientApi.addToFavourite(id).then(() => {
            this.loading = false;
            // Update UI to reflect addition
          });
        }
      } else {
        // Show login modal or redirect to login
        alert('Please login to add favorites');
      }
    },
    getBook() {
      this.loading = true;
      clientApi.getBookById(this.$route.params.id).then(res => {
        this.book = res.book;
        this.similar = res.similar;
        this.details = res.details.original.docs[0];
        this.loading = false;
      }).catch(err => {
        console.error('Error fetching book:', err);
        this.loading = false;
      });
    }
  },
  mounted() {
    this.getBook();
  }
};
</script>

<style scoped>
/* Base Styles */
.book-detail-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem 1rem;
  font-family: 'Lato', sans-serif;
  color: #2c3e50;
}

.loading-state, .error-state {
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  min-height: 50vh;
  text-align: center;
}

.loader {
  text-align: center;
}

.loader svg {
  width: 50px;
  height: 50px;
  animation: rotate 1s linear infinite;
}

.loader p, .error-state p {
  margin-top: 1rem;
  color: #219e9a;
  font-weight: 500;
}

.error-state svg {
  margin-bottom: 1rem;
}

.error-state h2 {
  color: #e63946;
  margin-bottom: 0.5rem;
}

.back-btn {
  margin-top: 1rem;
  padding: 0.75rem 1.5rem;
  background: #219e9a;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  cursor: pointer;
  transition: all 0.2s ease;
}

.back-btn:hover {
  background: #1a7f7b;
}

/* Book Header */
.book-header {
  text-align: center;
  margin-bottom: 2rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid rgba(33, 158, 154, 0.2);
}

.book-title {
  font-size: 2.2rem;
  color: #12263a;
  margin-bottom: 0.5rem;
  font-family: 'Roboto Slab', serif;
}

.book-author {
  font-size: 1.2rem;
  color: #6c757d;
  font-weight: 400;
}

/* Book Main Content */
.book-main {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.book-media {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.main-image {
  width: 100%;
  max-width: 400px;
  margin: 0 auto;
  box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
}

.main-image img {
  width: 100%;
  height: auto;
  border-radius: 4px;
}

.similar-books h3 {
  font-size: 1.2rem;
  margin-bottom: 1rem;
  color: #12263a;
  border-bottom: 1px solid rgba(33, 158, 154, 0.2);
  padding-bottom: 0.5rem;
}

.similar-books-grid {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 1rem;
}

.similar-book {
  cursor: pointer;
  transition: transform 0.2s ease;
}

.similar-book:hover {
  transform: translateY(-5px);
}

.similar-book img {
  width: 100%;
  height: 150px;
  object-fit: cover;
  border-radius: 4px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.similar-book p {
  font-size: 0.8rem;
  margin-top: 0.5rem;
  text-align: center;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

/* Book Info */
.book-info {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.book-description h2,
.book-details h2 {
  font-size: 1.5rem;
  color: #12263a;
  margin-bottom: 1rem;
  font-family: 'Roboto Slab', serif;
}

.book-description p {
  line-height: 1.6;
  color: #495057;
}

.book-details ul {
  list-style: none;
  padding: 0;
}

.book-details li {
  margin-bottom: 0.75rem;
  padding-left: 1.5rem;
  position: relative;
  line-height: 1.5;
}

.book-details li:before {
  content: "•";
  color: #219e9a;
  font-weight: bold;
  position: absolute;
  left: 0;
}

.book-details strong {
  color: #12263a;
}

.availability {
  color: #219e9a;
  font-weight: 500;
}

/* Actions */
.book-actions {
  display: flex;
  flex-direction: column;
  gap: 1rem;
  margin-top: 2rem;
}

.borrow-btn, .favorite-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  padding: 1rem;
  border: none;
  border-radius: 4px;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.borrow-btn {
  background: #219e9a;
  color: white;
}

.borrow-btn:hover {
  background: #1a7f7b;
}

.borrow-btn:disabled {
  background: #95a5a6;
  cursor: not-allowed;
}

.favorite-btn {
  background: rgba(231, 76, 60, 0.1);
  color: #e74c3c;
  border: 1px solid #e74c3c;
}

.favorite-btn:hover {
  background: #e74c3c;
  color: white;
}

.favorite-btn.active {
  background: #219e9a;
  border-color: #219e9a;
  color: white;
}

.favorite-btn:disabled {
  background: #e9ecef;
  color: #adb5bd;
  border-color: #adb5bd;
  cursor: not-allowed;
}

.book-actions svg {
  width: 18px;
  height: 18px;
}

/* Social Sharing */
.social-sharing {
  margin-top: 2rem;
}

.social-sharing p {
  margin-bottom: 1rem;
  color: #6c757d;
}

.social-icons {
  display: flex;
  gap: 1rem;
}

.social-icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  color: white;
  transition: all 0.2s ease;
}

.social-icon svg {
  width: 20px;
  height: 20px;
}

.facebook {
  background: #3b5998;
}

.facebook:hover {
  background: #2d4373;
}

.twitter {
  background: #1da1f2;
}

.twitter:hover {
  background: #0d8ddc;
}

.whatsapp {
  background: #25d366;
}

.whatsapp:hover {
  background: #1da851;
}

/* Additional Info */
.additional-info {
  margin-top: 3rem;
  padding-top: 2rem;
  border-top: 1px solid rgba(33, 158, 154, 0.2);
}

.additional-info h2 {
  font-size: 1.8rem;
  color: #12263a;
  margin-bottom: 1.5rem;
  font-family: 'Roboto Slab', serif;
}

.info-grid {
  display: grid;
  grid-template-columns: 1fr;
  gap: 1.5rem;
}

.info-card {
  background: rgba(33, 158, 154, 0.05);
  padding: 1.5rem;
  border-radius: 8px;
  border-left: 4px solid #219e9a;
}

.info-card h3 {
  font-size: 1.2rem;
  color: #12263a;
  margin-bottom: 1rem;
}

.info-card p {
  margin-bottom: 0.5rem;
  color: #495057;
}

.language-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.5rem;
}

.language-tag {
  background: rgba(33, 158, 154, 0.1);
  color: #219e9a;
  padding: 0.3rem 0.8rem;
  border-radius: 20px;
  font-size: 0.8rem;
}

/* Animations */
@keyframes rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Responsive Styles */
@media (min-width: 768px) {
  .book-main {
    flex-direction: row;
  }

  .book-media {
    flex: 0 0 40%;
  }

  .book-info {
    flex: 1;
  }

  .book-actions {
    flex-direction: row;
  }

  .info-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (min-width: 992px) {
  .book-media {
    flex: 0 0 35%;
  }
}
</style>