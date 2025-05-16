<template>
  <div class="borrow-book-container">
    <div v-if="book && location" class="borrow-book-content">
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

      <coffee-shops :shops="shops" />
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
import CoffeeShops from "@/ClientViews/Elements/CoffeeShops.vue";
import clientApi from "@/api/ClientApi";

export default {
  name: 'BorrowBook',
  components: { CoffeeShops },
  data() {
    return {
      book: null,
      location: null,
      shops: null,
      borrowQuantity: 1,
      loading: false,
      message: "",
      success: false,
      check: null
    };
  },
  methods: {
    fetchBookDetails() {
      // Your existing implementation
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
        } else {
          this.error = "No location or book data found.";
        }
        this.loading = false;
      }).catch(err => {
        console.error("Error fetching location details:", err);
      })
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
    this.fetchBookDetails();
    this.fetchLocationDetails();
  },
};
</script>

<style scoped>
.borrow-book-container {
  padding: 2rem 0;
  min-height: calc(100vh - 100px);
  background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
}

.borrow-book-content {
  justify-items: center;
  margin: 0 auto;
  padding: 0 1rem;
}

.borrow-card {
  width: 100%;
  max-width: 800px;
  background: white;
  border-radius: 12px;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
  overflow: hidden;
  margin-bottom: 2rem;
  border: 1px solid rgba(33, 158, 154, 0.1);
}

.card-header {
  padding: 1.5rem;
  background: linear-gradient(to right, rgba(33, 158, 154, 0.05), rgba(33, 158, 154, 0.02));
  border-bottom: 1px solid rgba(33, 158, 154, 0.1);
}

.card-header h2 {
  display: flex;
  align-items: center;
  gap: 0.75rem;
  margin: 0;
  color: #2c3e50;
  font-size: 1.5rem;
}

.book-title {
  color: #219e9a;
  font-weight: 600;
}

.card-body {
  padding: 1.5rem;
}

.section-title {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #2c3e50;
  margin: 0 0 1rem 0;
  font-size: 1.1rem;
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