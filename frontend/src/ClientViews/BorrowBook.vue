<template>
  <div class="content-wrapper" style="margin: 100px 0 150px 0" v-if="book && location">
    <div class="container pt-5">
      <div class="card card-primary" style="box-shadow: 20px 20px 20px 20px grey;">
        <h2 class="mt-3">Borrow "{{ book.title }}"</h2>

        <div class="card-body">
          <h4>Pickup Location</h4>
          <p><strong>LocationAddress: </strong> {{ location.name }}</p>
          <p><strong>Location: </strong> {{ location.latitude }} : {{ location.longitude }}s</p>
          <p><strong>Available Copies: </strong> {{ location.quantity }}</p>

          <label for="quantity">Quantity:</label>
          <input
              type="number"
              id="quantity"
              v-model.number="borrowQuantity"
              min="1"
              :max="location.quantity"
              class="form-control"
          />

          <button @click="borrowBook" class="btn btn-success mt-2" :disabled="loading">
            {{ loading ? "Processing..." : "Borrow Book" }}
          </button>

          <p v-if="message" class="alert" :class="{'alert-success': success, 'alert-danger': !success}">
            {{ message }}
            Your check: {{ check }}
          </p>
        </div>
      </div>
    </div>
  </div>
  <div v-else style="display: flex; flex-direction: column; gap: 15px;" class="profile__main">
    <div class="loader_wrapper">
      <div class="loader"></div>
    </div>
  </div>
</template>

<script>
import clientApi from "@/api/ClientApi";

export default {
  data() {
    return {
      book: null,
      location: null,
      borrowQuantity: 1,
      loading: false,
      message: "",
      success: false,
      check: null
    };
  },
  methods: {
    fetchBookDetails() {
      // clientApi.getBookById(this.$route.params.id).then(res => {
      //   this.book = res;
      // }).catch(err => {
      //   console.error("Error fetching book details:", err);
      // })
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
.loader_wrapper {
  width: 100%;
  min-height: 150px;
  display: flex;
  justify-content: center;
  align-items: center;

}

.loader {
  width: 50px;
  padding: 8px;
  aspect-ratio: 1;
  border-radius: 50%;
  background: #219e9a;
  --_m: conic-gradient(#0000 10%, #000),
  linear-gradient(#000 0 0) content-box;
  -webkit-mask: var(--_m);
  mask: var(--_m);
  -webkit-mask-composite: source-out;
  mask-composite: subtract;
  animation: l3 1s infinite linear;
}
@keyframes l3 {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}
button {
  padding: 8px 14px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}
button:disabled {
  background: grey;
  cursor: not-allowed;
}
.alert {
  margin-top: 10px;
  padding: 10px;
  border-radius: 5px;
}
.alert-success {
  background: #d4edda;
  color: #155724;
}
.alert-danger {
  background: #f8d7da;
  color: #721c24;
}
</style>
