<template>
  <div class="borrow-book-container mt-3">
    <div v-if="book && location" class="borrow-book-content">
      <!-- First Row - Split into two columns -->
      <div class="first-row">
        <!-- Borrowing Form Column -->
        <div class="borrow-column">
          <div class="borrow-card">
            <div class="card-header">
              <h2>
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#219e9a" width="28" height="28">
                  <path d="M18 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zM6 4h5v8l-2.5-1.5L6 12V4z"/>
                </svg>
                Borrow <span class="book-title">"{{ book.title }}"</span>
              </h2>
            </div>

        <div class="card-body">
          <div class="location-section">
            <h3 class="section-title">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#219e9a" width="20" height="20">
                <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
              </svg>
              Pickup Location
            </h3>

            <div class="location-info">
              <div class="info-item">
                <strong>Library:</strong>
                <p>{{ location.name }}</p>
              </div>

              <div class="info-item">
                <strong>Coordinates:</strong>
                <p>{{ location.latitude }}, {{ location.longitude }}</p>
              </div>

              <div class="info-item highlight">
                <strong>Available Copies:</strong>
                <p>{{ location.quantity }}</p>
              </div>
            </div>
          </div>

          <div class="quantity-section">
            <label for="quantity">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#219e9a" width="18" height="18">
                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 12h2v5H7zm4-7h2v12h-2zm4 5h2v7h-2z"/>
              </svg>
              Quantity to borrow:
            </label>
            <input
                type="number"
                id="quantity"
                v-model.number="borrowQuantity"
                min="1"
                :max="location.quantity"
                class="quantity-input"
                :class="{ 'input-error': borrowQuantity > location.quantity }"
            />
            <small v-if="borrowQuantity > location.quantity" class="error-text">
              Only {{ location.quantity }} copies available
            </small>
          </div>

          <button
              @click="borrowBook"
              class="borrow-button"
              :disabled="loading || borrowQuantity > location.quantity || borrowQuantity < 1"
          >
            <span v-if="!loading">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                <path d="M17 3H7c-1.1 0-2 .9-2 2v16l7-3 7 3V5c0-1.1-.9-2-2-2z"/>
              </svg>
              Borrow Book
            </span>
            <span v-else class="loading-text">
              <svg class="spinner" viewBox="0 0 50 50">
                <circle cx="25" cy="25" r="20" fill="none" stroke="currentColor" stroke-width="5"></circle>
              </svg>
              Processing...
            </span>
          </button>

              <div v-if="message" class="message-alert" :class="{'success': success, 'error': !success}">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18">
                  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" v-if="success"/>
                  <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z" v-else/>
                </svg>
                <div>
                  <p>{{ message }}</p>
                  <small v-if="check" class="check-number">Reference: {{ check }}</small>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Book Details Column -->
        <div class="book-details-column">
          <div class="book-details-card">
            <div class="book-cover-container">
              <img
                  :src="getImageUrl(book.cover_image)"
                  :alt="book.title"
                  @error="handleImageError"
                  class="book-cover"
              >
            </div>

            <div class="book-info">
              <h3 class="book-title">{{ book.title }}</h3>
              <p class="book-author">by {{ book.author }}</p>

              <div class="book-meta">
                <div class="meta-item">
                  <svg viewBox="0 0 24 24" width="16" height="16">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
                  </svg>
                  <span>Category: {{ book.category?.name || 'N/A' }}</span>
                </div>

                <div class="meta-item">
                  <svg viewBox="0 0 24 24" width="16" height="16">
                    <path d="M17.63 5.84C17.27 5.33 16.67 5 16 5L5 5.01C3.9 5.01 3 5.9 3 7v10c0 1.1.9 1.99 2 1.99L16 19c.67 0 1.27-.33 1.63-.84L22 12l-4.37-6.16zM16 17H5V7h11l3.55 5L16 17z"/>
                  </svg>
                  <span>Genres: {{ book.genres.map(x => x.name).join(', ') || 'N/A' }}</span>
                </div>

                <div class="meta-item">
                  <svg viewBox="0 0 24 24" width="16" height="16">
                    <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                    <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
                  </svg>
                  <span>Tags: {{ book.tags.map(x => x.name).join(', ') || 'N/A' }}</span>
                  <span class="rating">★ {{ getAverageRating(book.reviews) }} ({{ reviews_count }})</span>
                </div>
              </div>

              <div class="book-description">
                <h4>Description</h4>
                <p>{{ book.description || 'No description available' }}</p>
              </div>

              <div class="book-tags">
                <span
                    v-for="tag in book.tags"
                    :key="tag.id"
                    class="tag"
                >
                  {{ tag.name }}
                </span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <cafes-component :shops="shops" :borrowLoc="location"/>
      <!-- Second Row (will contain coffee shops component later) -->
      <!-- <coffee-shops :shops="shops" /> -->
    </div>

    <div v-else class="loading-state">
      <div class="loader">
        <svg viewBox="0 0 50 50">
          <circle cx="25" cy="25" r="20" fill="none" stroke="#219e9a" stroke-width="5"></circle>
        </svg>
        <p>Loading book details...</p>
      </div>
    </div>
  </div>
</template>

<script>
import clientApi from "@/api/ClientApi";
import CafesComponent from "@/ClientViews/Elements/CafesComponent.vue";

export default {
  name: 'BorrowBook',
  components: {CafesComponent},
  data() {
    return {
      book: null,
      location: null,
      shops: null,
      borrowQuantity: 1,
      loading: false,
      message: "",
      success: false,
      check: null,
      reviews_count: null,
    };
  },
  methods: {
    getImageUrl(path) {
      return path ? `https://bookers.com.kz/public/storage/${path}` : 'https://bookers.com.kz/defaults/default-cover.jpg';
    },
    handleImageError(e) {
      e.target.src = 'https://bookers.com.kz/defaults/default-cover.jpg';
    },
    fetchLocationDetails() {
      this.loading = false;
      clientApi.getLocationBookById({
        id: this.$route.params.locId,
        bookId: this.$route.params.id
      }).then(res => {
        if (res && res.length > 0) {
          const data = res[0];
          this.location = data.location;
          this.shops = data.shops.original;
          this.book = data.book;
          this.reviews_count = data.reviews_count;
        } else {
          this.error = "No location or book data found.";
        }
        this.loading = false;
      }).catch(err => {
        console.error("Error fetching location details:", err);
      })
    },
    getAverageRating(reviews) {
      if (!reviews || reviews.length === 0) return '0';
      const total = reviews.reduce((sum, review) => sum + (review.rating || 0), 0);
      const avg = total / reviews.length;
      return avg.toFixed(1);
    },
    borrowBook() {
      if (!this.location || this.borrowQuantity < 1) {
        return;
      }

      this.loading = true;
      this.message = "";

      clientApi.borrowBook(this.book.id, {
        book_id: this.book.id,
        location_id: this.location.id,
        quantity: this.borrowQuantity,
      }).then(res => {
        this.success = true;
        this.message = res.message;
        this.check = res.borrow_check;
        this.location.quantity -= this.borrowQuantity;
      }).catch(err => {
        this.success = false;
        this.message = err.response?.data?.message || "Failed to borrow the book.";
      }).finally(() => {
        this.loading = false;
      })
    },
  },
  mounted() {
    this.fetchLocationDetails();
  },
};
</script>

<style scoped>
.borrow-book-container{
  max-width: 1600px;
  margin: auto;
}
/* Enhanced styles for first-row columns */
.first-row {
  display: flex;
  gap: 2rem;
  margin-bottom: 2rem;
  align-items: stretch; /* Make both columns equal height */
}

.borrow-column {
  flex: 1;
  min-width: 0;
  display: flex;
}

.book-details-column {
  flex: 1;
  min-width: 0;
  display: flex;
}

/* Enhanced Borrow Card */
.borrow-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  border: 1px solid rgba(33, 158, 154, 0.15);
  height: 100%;
  width: 100%;
  display: flex;
  flex-direction: column;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.borrow-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.card-header {
  background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
  padding: 1.5rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.card-header h2 {
  margin: 0;
  color: #2c3e50;
  font-size: 1.5rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
}

.card-header svg {
  flex-shrink: 0;
}

.book-title {
  color: #219e9a;
  font-weight: 600;
}

.card-body {
  padding: 1.5rem;
  flex: 1;
  display: flex;
  flex-direction: column;
}

/* Enhanced Book Details Card */
.book-details-card {
  background: white;
  border-radius: 16px;
  box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
  overflow: hidden;
  border: 1px solid rgba(33, 158, 154, 0.15);
  height: 100%;
  width: 100%;
  padding: 1.75rem;
  display: flex;
  gap: 2rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.book-details-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
}

.book-cover-container {
  flex: 0 0 220px;
  display: flex;
  align-items: flex-start;
}

.book-cover {
  width: 100%;
  height: auto;
  max-height: 300px;
  object-fit: contain;
  border-radius: 10px;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.book-cover:hover {
  transform: scale(1.03);
}

.book-info {
  flex: 1;
  min-width: 0;
}

.book-title {
  margin-top: 0;
  color: #2c3e50;
  font-size: 1.75rem;
  font-weight: 700;
  line-height: 1.3;
}

.book-author {
  color: #6c757d;
  margin-bottom: 1.75rem;
  font-size: 1.1rem;
  font-style: italic;
}

.book-meta {
  margin-bottom: 2rem;
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
  gap: 1rem;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  color: #495057;
  font-size: 0.95rem;
  background: rgba(33, 158, 154, 0.05);
  padding: 0.75rem;
  border-radius: 8px;
}

.meta-item svg {
  fill: #219e9a;
  flex-shrink: 0;
}

.book-description {
  margin-bottom: 2rem;
  background: #f8f9fa;
  padding: 1.25rem;
  border-radius: 10px;
}

.book-description h4 {
  margin-bottom: 0.75rem;
  color: #2c3e50;
  font-size: 1.2rem;
  font-weight: 600;
}

.book-description p {
  color: #495057;
  line-height: 1.7;
  margin: 0;
  font-size: 0.95rem;
}

.book-tags {
  display: flex;
  flex-wrap: wrap;
  gap: 0.75rem;
  margin-top: auto;
}

.tag {
  background: rgba(33, 158, 154, 0.1);
  color: #219e9a;
  padding: 0.4rem 1rem;
  border-radius: 50px;
  font-size: 0.85rem;
  font-weight: 500;
  transition: all 0.2s ease;
}

.tag:hover {
  background: rgba(33, 158, 154, 0.2);
  transform: translateY(-2px);
}

/* Responsive adjustments */
@media (max-width: 1200px) {
  .first-row {
    gap: 1.5rem;
  }

  .book-details-card {
    gap: 1.5rem;
    padding: 1.5rem;
  }

  .book-cover-container {
    flex: 0 0 180px;
  }
}

@media (max-width: 992px) {
  .first-row {
    flex-direction: column;
  }

  .book-details-card {
    flex-direction: column;
  }

  .book-cover-container {
    flex: 0 0 auto;
    justify-content: center;
    margin-bottom: 1.5rem;
  }

  .book-cover {
    max-height: 250px;
    width: auto;
    max-width: 100%;
  }
}

@media (max-width: 768px) {
  .book-details-card {
    padding: 1.25rem;
  }

  .book-title {
    font-size: 1.5rem;
  }

  .book-meta {
    grid-template-columns: 1fr;
  }
}

@keyframes rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Responsive adjustments */
@media (max-width: 992px) {
  .first-row {
    flex-direction: column;
  }

  .book-details-card {
    flex-direction: column;
  }

  .book-cover-container {
    flex: 0 0 auto;
    margin-bottom: 1.5rem;
  }
}

@media (max-width: 768px) {
  .borrow-card, .book-details-card {
    margin: 0 -1rem;
    border-radius: 0;
  }

  .card-header, .card-body {
    padding: 1.25rem;
  }
}

.location-info {
  margin-bottom: 1.5rem;
}

.info-item {
  margin-bottom: 1rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.info-item.highlight {
  background: rgba(33, 158, 154, 0.05);
  padding: 0.75rem;
  border-radius: 6px;
  border-left: 3px solid #219e9a;
}

.info-item strong {
  display: block;
  color: #219e9a;
  font-size: 0.85rem;
  margin-bottom: 0.25rem;
}

.info-item p {
  margin: 0;
  color: #495057;
}

.quantity-section {
  margin-bottom: 1.5rem;
}

.quantity-section label {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  margin-bottom: 0.5rem;
  color: #219e9a;
  font-weight: 500;
}

.quantity-input {
  width: 80px;
  padding: 0.5rem 0.75rem;
  border: 1px solid #dee2e6;
  border-radius: 6px;
  font-size: 1rem;
}

.quantity-input:focus {
  outline: none;
  border-color: #219e9a;
  box-shadow: 0 0 0 2px rgba(33, 158, 154, 0.25);
}

.quantity-input.input-error {
  border-color: #e63946;
}

.error-text {
  display: block;
  margin-top: 0.5rem;
  color: #e63946;
  font-size: 0.85rem;
}

.borrow-button {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  width: 100%;
  padding: 0.75rem;
  background: linear-gradient(to right, #219e9a, #1a7f7b);
  color: white;
  border: none;
  border-radius: 6px;
  font-size: 1rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s ease;
}

.borrow-button:hover:not(:disabled) {
  background: linear-gradient(to right, #1a7f7b, #136963);
  transform: translateY(-1px);
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.borrow-button:disabled {
  background: #adb5bd;
  cursor: not-allowed;
  opacity: 0.7;
}

.loading-text {
  display: flex;
  align-items: center;
  gap: 0.5rem;
}

.spinner {
  animation: rotate 1s linear infinite;
  width: 18px;
  height: 18px;
}

@keyframes rotate {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

.message-alert {
  display: flex;
  align-items: flex-start;
  gap: 0.75rem;
  padding: 1rem;
  border-radius: 6px;
  margin-top: 1rem;
  font-size: 0.95rem;
}

.message-alert.success {
  background: rgba(40, 167, 69, 0.1);
  color: #28a745;
  border-left: 3px solid #28a745;
}

.message-alert.error {
  background: rgba(220, 53, 69, 0.1);
  color: #dc3545;
  border-left: 3px solid #dc3545;
}

.check-number {
  display: block;
  margin-top: 0.5rem;
  font-size: 0.85rem;
  opacity: 0.8;
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

.coffee-shops-section {
  margin-top: 3rem;
}

@media (max-width: 768px) {
  .borrow-card {
    margin: 0 -1rem;
    border-radius: 0;
  }

  .card-header, .card-body {
    padding: 1.25rem;
  }
}

</style>