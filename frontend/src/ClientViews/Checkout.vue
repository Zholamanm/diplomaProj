<template>
  <div class="back"><a href="#">&#11178; shop</a></div>
  <h1>Your Checkouts</h1>
  <div class="container-fluid mt-5">
    <div class="row align-items-start" style="justify-content: center;">
      <div class="col-12 col-sm-8 items">
        <div v-for="(item, index) in list" :key="index">
          <div class="cartItem row align-items-start">
            <div class="col-3 mb-2">
              <img class="w-100" :src="`http://localhost:8000/storage/${item.book.cover_image}`" alt="art image">
            </div>
            <div class="col-5 mb-2">
              <h6 class="">{{ item.book.title }}</h6>
              <p class="pl-1 mb-0">{{ item.book.author }}</p>
              <p class="pl-1 mb-0">{{ item.location.name }}</p>
            </div>
            <div class="col-2">
              <p class="cartItemQuantity p-1 text-center">{{ item.quantity }}</p>
            </div>
            <div class="col-2">
              <p id="cartItem1Price">{{ item.borrow_check }}</p>
            </div>
          </div>
          <hr>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import clientApi from "@/api/ClientApi";

export default {
  name: 'CheckoutView',
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
      this.filters.selectedCategory = id
    },
    setSort(id) {
      this.filters.sortBy = id
    },
    handleBorrow(id) {
      if (this.isAuthorized) {
        this.$router.push({name: 'BorrowMap', params: {id: id, locale: this.$route.params.locale}})
      }
    },
    getList() {
      clientApi.getCheckoutList({
        ...this.filters,
        search: this.searchQuery,
        page: this.page,
      }).then(res => {
        this.list = res.data
        this.loading = false;
      }).catch(err => {
        console.log('error', err);
      })
    }
  },
  mounted() {
    this.getList()
  },
};
</script>
<style>
@import url(https://fonts.googleapis.com/css?family=Lato:400,300,700,900);
@import url(https://fonts.googleapis.com/css?family=Roboto+Slab:400,700);
@import url("https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css");
</style>
<style scoped>
#cart {
  max-width: 1440px;
  padding-top: 60px;
  margin: auto;
}

.form div {
  margin-bottom: 0.4em;
}

.cartItem {
  --bs-gutter-x: 1.5rem;
}

.cartItemQuantity,
.proceed {
  background: #f4f4f4;
}

.items {
  padding-right: 30px;
}

#btn-checkout {
  min-width: 100%;
}

/* stasysiia.com */
@import url("https://fonts.googleapis.com/css2?family=Exo&display=swap");
body {
  background-color: #fff;
  font-family: "Exo", sans-serif;
  font-size: 22px;
  margin: 0;
  padding: 0;
  color: #111111;
  justify-content: center;
  align-items: center;
}

a {
  color: #0e1111;
  text-decoration: none;
}

.btn-check:focus + .btn-primary,
.btn-primary:focus {
  color: #fff;
  background-color: #111;
  border-color: transparent;
  box-shadow: 0 0 0 0.25rem rgb(49 132 253 / 50%);
}

button:hover,
.btn:hover {
  box-shadow: 5px 5px 7px #c8c8c8, -5px -5px 7px white;
}

button:active {
  box-shadow: 2px 2px 2px #c8c8c8, -2px -2px 2px white;
}

/*PREVENT BROWSER SELECTION*/
a:focus,
button:focus,
input:focus,
textarea:focus {
  outline: none;
}

/*main*/
main:before {
  content: "";
  display: block;
  height: 88px;
}

h1 {
  font-size: 2.4em;
  font-weight: 600;
  letter-spacing: 0.15rem;
  text-align: center;
  margin: 30px 6px;
}

h2 {
  color: rgb(37, 44, 54);
  font-weight: 700;
  font-size: 2.5em;
}

h3 {
  border-bottom: solid 2px #000;
}

h5 {
  padding: 0;
  font-weight: bold;
  color: #92afcc;
}

p {
  color: #333;
  font-family: "Roboto", sans-serif;
  margin: 0.6em 0;
}

h1,
h2,
h4 {
  text-align: center;
  padding-top: 16px;
}

/* yukito bloody */
.back {
  position: relative;
  top: -30px;
  font-size: 16px;
  margin: 10px 10px 3px 15px;
}

.inline {
  display: inline-block;
}

.shopnow,
.contact {
  background-color: #000;
  padding: 10px 20px;
  font-size: 30px;
  color: white;
  text-transform: uppercase;
  letter-spacing: 1px;
  transition: all 0.5s;
  cursor: pointer;
}

.shopnow:hover {
  text-decoration: none;
  color: white;
  background-color: #c41505;
}

/* for button animation*/
.shopnow span {
  cursor: pointer;
  display: inline-block;
  position: relative;
  transition: all 0.5s;
}

.shopnow span:after {
  content: url("https://badux.co/smc/codepen/caticon.png");
  position: absolute;
  font-size: 30px;
  opacity: 0;
  top: 2px;
  right: -6px;
  transition: all 0.5s;
}

.shopnow:hover span {
  padding-right: 25px;
}

.shopnow:hover span:after {
  opacity: 1;
  top: 2px;
  right: -6px;
}

.ma {
  margin: auto;
}

.price {
  color: slategrey;
  font-size: 2em;
}

#mycart {
  min-width: 90px;
}

#cartItems {
  font-size: 17px;
}

#product .container .row .pr4 {
  padding-right: 15px;
}

#product .container .row .pl4 {
  padding-left: 15px;
}

</style>