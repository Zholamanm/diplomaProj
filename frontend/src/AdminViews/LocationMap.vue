<template>
  <div class="content-wrapper" v-if="location">
    <div class="container pt-5">
      <div class="card card-primary container">
        <h2 class="mt-3">Manage Books for {{ location.name }}</h2>

        <div class="card card-primary">
          <div class="card-body">
            <button @click="addBookField" class="btn btn-success mb-3">+ Add Book</button>

            <div v-for="(bookEntry, index) in selectedBooks" :key="bookEntry.uniqueId" class="book-entry">
              <!-- Select Book -->
              <select
                  :ref="'bookSelect' + index"
                  class="form-control select2bs4 location-select"
                  @change="updateSelectedBook(index, $event)"
                  :disabled="bookEntry.isExisting"
              >
                <option v-if="!bookEntry.isExisting" selected disabled>Select a book</option>
                <option v-else selected disabled :value="bookEntry.book.id">{{ bookEntry.book.title }} by {{ bookEntry.book.author }}</option>
                <option v-for="book in allBooks" :key="book.id" :value="book.id">
                  {{ book.title }} by {{ book.author }}
                </option>
              </select>

              <!-- Enter Quantity -->
              <input
                  type="number"
                  v-model.number="bookEntry.quantity"
                  min="1"
                  class="form-control"
                  placeholder="Quantity"
              />

              <!-- Remove Book Entry -->
              <button @click="removeBookField(index)" class="btn btn-danger" style="width: 45%;">
                {{ bookEntry.isExisting ? "Remove from Location" : "Remove" }}
              </button>
            </div>

            <button @click="submitBooks" class="btn btn-primary mt-3" :disabled="selectedBooks.length === 0" v-if="selectedBooks.length !== 0">
              Save Changes
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import bookApi from "@/api/Admin/BookApi";
import locationApi from "@/api/Admin/LocationApi";
import $ from "jquery";

window.$ = window.jQuery = $;

export default {
  data() {
    return {
      location: null,
      allBooks: [],
      selectedBooks: [],
      uniqueIdCounter: 0,
    };
  },
  methods: {
    async fetchLocation() {
      try {
        this.location = await locationApi.getById(this.$route.params.id);
      } catch (err) {
        console.error("Error fetching location:", err);
      }
    },
    async fetchAllBooks() {
      try {
        const res = await bookApi.get();
        this.allBooks = res || [];
      } catch (err) {
        console.error("Error fetching books:", err);
      }
    },
    async fetchLocationBooks() {
      try {
        const res = await locationApi.getBooks(this.$route.params.id);
        this.selectedBooks = res.map(book => ({
          book: this.allBooks.find(b => b.id === book.book_id) || { id: book.book_id, title: "Unknown" },
          quantity: book.quantity,
          isExisting: true,
          uniqueId: this.uniqueIdCounter++,
        }));
      } catch (err) {
        console.error("Error fetching location books:", err);
      }
    },
    addBookField() {
      this.selectedBooks.push({
        book: null,
        quantity: 1,
        isExisting: false,
        uniqueId: this.uniqueIdCounter++,
      });

      this.$nextTick(() => {
        this.initSelect2(this.selectedBooks.length - 1);
      });
    },
    removeBookField(index) {
      const bookEntry = this.selectedBooks[index];

      if (bookEntry.isExisting) {
        locationApi.removeBook(this.location.id, bookEntry.book.id).then(() => {
          this.selectedBooks.splice(index, 1);
        }).catch(err => console.error("Error removing book:", err));
      } else {
        this.selectedBooks.splice(index, 1);
      }
    },
    submitBooks() {
      if (this.selectedBooks.some(bookEntry => !bookEntry.book && bookEntry.quantity < 1)) {
        return;
      }

      const locationId = this.$route.params.id;

      const payload =  this.selectedBooks.map(bookEntry => ({
        book_id: bookEntry.book.id,
        quantity: bookEntry.quantity,
      }))

      try {
        locationApi.addBooks(locationId, payload);
        this.fetchLocationBooks();
      } catch (err) {
        console.error("Error adding books to location:", err);
      }
    },
    initSelect2(index) {
      this.$nextTick(() => {
        const refName = `bookSelect${index}`;
        if (this.$refs[refName]) {
          $(this.$refs[refName]).select2({
            theme: "bootstrap4",
            minimumResultsForSearch: Infinity
          }).on("change", (event) => {
            this.updateSelectedBook(index, event);
          });
        }
      });
    },
    updateSelectedBook(index, event) {
      const selectedBookId = Number(event.target.value);
      const selectedBook = this.allBooks.find(book => book.id === selectedBookId);
      if (selectedBook) {
        this.selectedBooks[index].book = selectedBook;
      }
    }
  },
  mounted() {
    this.fetchLocation();
    this.fetchAllBooks().then(() => {
      this.fetchLocationBooks();
    });
  }
};
</script>

<style scoped>
.content-wrapper {
  background-color: #f8fafc;
  min-height: calc(100vh - 56px);
}

.container {
  max-width: 1300px;
  padding: 2rem 1rem;
}

.card {
  border: none;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  overflow: hidden;
  margin-bottom: 1.5rem;
}

.card-primary {
  background-color: white;
  border: 1px solid #e2e8f0;
}

.card-body {
  padding: 1.5rem;
}

h2 {
  color: #1e293b;
  font-size: 1.5rem;
  font-weight: 600;
  margin-bottom: 1.5rem;
  padding-bottom: 0.75rem;
  border-bottom: 1px solid #e2e8f0;
}

/* Form Elements */
.form-control {
  padding: 0.625rem 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  font-size: 0.9375rem;
  transition: all 0.2s ease;
  background-color: white;
  flex: 1;
}

.form-control:focus {
  outline: none;
  border-color: #3b82f6;
  box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

select.form-control {
  appearance: none;
  background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
  background-position: right 0.75rem center;
  background-repeat: no-repeat;
  background-size: 1.5em 1.5em;
  padding-right: 2.5rem;
}

input[type="number"] {
  max-width: 120px;
}

/* Buttons */
.btn {
  padding: 0.625rem 1.25rem;
  border-radius: 8px;
  font-size: 0.9375rem;
  font-weight: 500;
  transition: all 0.2s ease;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  border: none;
}

.btn-success {
  background-color: #10b981;
  color: white;
}

.btn-success:hover {
  background-color: #059669;
}

.btn-primary {
  background-color: #3b82f6;
  color: white;
}

.btn-primary:hover {
  background-color: #2563eb;
}

.btn-primary:disabled {
  background-color: #cbd5e1;
  cursor: not-allowed;
}

.btn-danger {
  background-color: #ef4444;
  color: white;
  width: 45%;
}

.btn-danger:hover {
  background-color: #dc2626;
}

/* Book Entry Layout */
.book-entry {
  display: flex;
  gap: 0.75rem;
  align-items: center;
  margin-bottom: 1rem;
  padding: 0.75rem;
  background-color: #f8fafc;
  border-radius: 8px;
}

/* Responsive Adjustments */
@media (max-width: 640px) {
  .book-entry {
    flex-direction: column;
    align-items: stretch;
  }

  .btn-danger {
    width: 100%;
  }

  input[type="number"] {
    max-width: 100%;
  }
}

/* Select2 Overrides */
.select2-container .select2-selection--single {
  height: auto;
  padding: 0.625rem 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
}

.select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
  height: 100%;
  right: 8px;
}

.select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
  padding: 0;
  line-height: inherit;
}

.select2-container--bootstrap4 .select2-dropdown {
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.select2-container--bootstrap4 .select2-results__option[aria-selected=true] {
  background-color: #f1f5f9;
  color: #1e293b;
}

.select2-container--bootstrap4 .select2-results__option--highlighted[aria-selected] {
  background-color: #3b82f6;
  color: white;
}
</style>
