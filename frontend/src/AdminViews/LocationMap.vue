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
        this.allBooks = res.data || [];
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
      if (this.selectedBooks.some(bookEntry => !bookEntry.book || bookEntry.quantity < 1)) {
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
.book-entry {
  display: flex;
  gap: 10px;
  align-items: center;
  margin-bottom: 10px;
}
</style>
