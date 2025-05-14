<template>
  <div id="main-container" class="main-container nav-effect-1">
    <div class="main clearfix">
      <div class="page-container">
        <div class="page-title category-title">
        </div>
        <section id="book_list">

          <div class="toolbar row">
            <div class="filter-options small-12 medium-9 columns mb-3">
              <a href="#" class="filter-item" :class="filters.selectedCategory === null ? 'active' : ''" @click="setCategory(null)" data-group="all">All Categories</a>
              <a v-for="category in categories" :key="category.id" href="#" class="filter-item" :class="filters.selectedCategory === category.id ? 'active' : ''" @click="setCategory(category.id)" data-group="fantasy">{{ category.name }}</a>
            </div>

            <div class="small-12 medium-3 columns">
              <select class="sort-options" v-model="filters.sortBy">
                <option value="" disabled selected>Sort by</option>
                <option v-for="(sort, index) in sortBy" :key="index" :value="sort.value" >{{ sort.label }}</option>
              </select>
            </div>
          </div>

          <div class="grid-shuffle">
            <div v-if="!loading">
              <ul id="grid" class="row" style="display: flex;">

                <li class="book-item small-12 medium-6 columns" v-for="item in list" :key="item.id" :id="'book' + item.book.id">
                  <div class="bk-img" style="z-index: 0;">
                    <div class="bk-wrapper">
                      <div class="bk-book bk-bookdefault">
                        <div class="bk-front">
                          <div class="bk-cover"
                               :style="{ backgroundImage: `url('http://localhost:8000/storage/${item.book.cover_image}')` }">
                          </div>
                        </div>
                        <div class="bk-back"></div>
                        <div class="bk-left"></div>
                      </div>
                    </div>
                  </div>
                  <div class="item-details">
                    <h3 class="book-item_title">{{ item.book.title }}</h3>
                    <p class="author">{{ item.book.author }}</p>
                    <p>{{ item.book.description }}</p>
                    <a href="#" class="button">Details</a>
                  </div>

                  <div class="overlay-details">
                    <a href="#" class="close-overlay-btn">Close</a>
                    <div class="overlay-image">
                      <img :src="'http://localhost:8000/storage/' + item.book.cover_image" alt="Book Cover">
                      <div class="back-color"></div>
                    </div>
                    <div class="overlay-desc activated">
                      <h2 class="overlay_title">{{ item.book.title }}</h2>
                      <p class="author">{{ item.book.author }}</p>
                      <p class="synopsis">{{ item.book.description }}</p>

                      <div class="d-flex justify-content-between mt-5">
                        <a
                            href="#"
                            class="overlay_borrow button"
                            :id="'location' + item.book.id"
                            :class="{ disabled: !isAuthorized }"
                            @click.prevent="handleBorrow(item.book.id)"
                        >
                          Borrow
                        </a>
                        <a
                            href="#"
                            class="button"
                            :class="{ disabled: !isAuthorized }"
                            @click.prevent="handleFavourite"
                        >
                          Add to Favourites
                        </a>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
              <recommend-view :list="list"/>
            </div>
            <div v-else style="display: flex; flex-direction: column; gap: 15px;" class="profile__main">
              <div class="loader_wrapper">
                <div class="loader"></div>
              </div>
            </div>
          </div>

        </section>

      </div>
    </div>
    <div class="main-overlay">
      <div class="overlay-full"></div>
    </div>
  </div>
</template>
<script>
import $ from 'jquery';
import clientApi from "@/api/ClientApi";
import RecommendView from "@/ClientViews/Elements/RecommendView.vue";

export default {
  name: 'FavouriteView',
  components: {RecommendView},
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
      // if (!this.isAuthorized) return;
      this.$router.push({name: 'BorrowMap', params: {id: id, locale: this.$route.params.locale}})
    },
    handleFavourite() {
      if (!this.isAuthorized) return;
      console.log("Added to favourites:", this.book.title);
    },
    loadCatalog() {
      const vm = this;

      $("li.book-item").each(function () {
        const $this = $(this);

        $this.find(".bk-front > div").css('background-color', $(this).data("color"));
        $this.find(".bk-left").css('background-color', $(this).data("color"));
        $this.find(".back-color").css('background-color', $(this).data("color"));

        $this.find(".item-details a.button").on('click', function () {
          displayBookDetails($this);
        });
      });

      function displayBookDetails(el) {
        var $this = $(el);
        $('.main-container').addClass('prevent-scroll');
        $('.main-overlay').fadeIn();

        $this.find('.overlay-details').clone().prependTo('.main-overlay');

        $('a.close-overlay-btn').on('click', function () {
          $('.main-container').removeClass('prevent-scroll');
          $('.main-overlay').fadeOut();
          $('.main-overlay').find('.overlay-details').remove();
        });
        $('.overlay_borrow').on('click', function () {
          const fullId = $(this).attr('id');
          const bookId = fullId.replace('location', '');
          vm.handleBorrow(bookId);
        });
      }

      $('.overlay-full').on('click', function () {
        $('.main-container').removeClass('prevent-scroll');
        $(this).parent().fadeOut();
        $(this).parent().find('.overlay-details').remove();
      });
    },
    getList() {
      this.loading = true;
      clientApi.getFavourites({
        ...this.filters,
        search: this.searchQuery,
        page: this.page,
      }).then( res => {
        this.list = res.data
        this.$nextTick(() => {
          this.loadCatalog();
        });
        this.loading = false;
      }).catch(() => {
        console.log('error');
      })
    }
  },
  mounted() {
    this.getList()
  },
  updated() {
    this.loadCatalog()
  }
};
</script>
<style>
@import url(https://fonts.googleapis.com/css?family=Lato:400,300,700,900);
@import url(https://fonts.googleapis.com/css?family=Roboto+Slab:400,700);
@import url("https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.min.css");
</style>
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
html,
body,
.main,
.main-container {
  height: 100%;
}
.button {
  padding: 10px 15px;
  font-size: 14px;
  font-weight: 600;
  border-radius: 3px;
  background-color: #219e9a;
  color: white;
  text-align: center;
  transition: all 0.3s ease;
  text-decoration: none;
}

.button:hover {
  background-color: #1a7e7b;
}

/* Disabled State */
.button.disabled {
  background-color: #ccc;
  cursor: not-allowed;
  pointer-events: none;
}

body {
  font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
  color: #313131;
  background: #ecf0f1;
}

/*
 *  Typography
*/
body,
p,
a,
li {
  font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
  font-size: 15px;
}

a {
  color: #219e9a;
}

h2,
h3 {
  margin-top: 6px;
  margin-bottom: 6px;
  font-size: 28px;
  font-weight: bold;
  letter-spacing: -1px;
  color: #313131;
}

h2 {
  font-size: 28px;
}

h3 {
  font-size: 24px;
}

h4 {
  margin-bottom: 12px;
  font-size: 22px;
  line-height: 40px;
  color: rgba(49, 49, 49, 0.7);
}

p:not(.author) {
  font-size: 15px;
  font-weight: 300;
  line-height: 1.4;
}

p.author {
  margin-bottom: 10px;
  letter-spacing: -1px;
  font-weight: 400;
  color: rgba(49, 49, 49, 0.5);
}

/*
 *  Button
*/
a.button {
  margin-bottom: 0;
  padding: 8px 14px;
  font-size: 14px;
  font-weight: 600;
  border-radius: 3px;
  background-color: rgba(49, 49, 49, 0.5);
}
a.button:hover, a.button:focus {
  background-color: #219e9a;
}

/*
 *  Header
*/
.page-header {
  position: relative;
  margin-bottom: 55px;
  width: 100%;
  border-bottom: 1px solid #d2d6d5;
  background-color: #fff;
}

.main-logo {
  display: inline-block;
  padding: 1em;
  width: auto;
}
.main-logo a.logo {
  display: block;
  width: 150px;
  height: 40px;
  text-indent: -9999px;
  background-color: #fff;
  transition: background-color 250ms ease-out;
}
.main-logo a.logo:hover, .main-logo a.logo:focus {
  background-color: #ecf0f1;
}

.menu-search {
  float: right;
  width: calc(100% - 200px);
}

/*
 *  Search Input
*/
.catalog-search {
  position: relative;
  margin: 0 20px;
  max-width: 275px;
  width: calc(100% - 2em);
  vertical-align: top;
  overflow: hidden;
  float: right;
}

.input_field {
  position: relative;
  display: block;
  float: right;
  margin-top: 10px;
  padding: 14px 7px 0;
  width: 100%;
  border: none;
  border-radius: 0;
  color: #313131;
  font-weight: normal;
  font-family: "Lato", "Helvetica Neue", Helvetica, Arial, sans-serif;
  background: none;
  box-shadow: none;
  -webkit-appearance: none;
  /* for box shadows to show on iOS */
}
.input_field:focus {
  outline: none;
  border: none;
  background: none;
  box-shadow: none;
  -webkit-appearance: none;
}
.input_field:focus .input_label-content {
  bottom: 20px;
}

.input_label {
  position: absolute;
  display: inline-block;
  bottom: 0;
  left: 0;
  padding: 0 0.25em;
  width: 100%;
  height: calc(100% - 1em);
  color: #d2d6d5;
  font-weight: light;
  font-size: 15px;
  text-align: left;
  pointer-events: none;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  -webkit-touch-callout: none;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.input_label:before {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: calc(100% - 10px);
  border-bottom: 1px solid rgba(49, 49, 49, 0.45);
}
.input_label:after {
  content: "";
  position: absolute;
  top: 0;
  left: 0;
  margin-top: 2px;
  width: 100%;
  height: calc(100% - 10px);
  border-bottom: 3px solid #219e9a;
  transform: translate3d(-100%, 0, 0);
  transition: transform 0.3s;
}

.input_label-content {
  position: absolute;
  width: 100%;
  bottom: 14px;
}

.input_label-search {
  position: relative;
  display: block;
  color: rgba(49, 49, 49, 0.45);
}
.input_label-search:after {
  content: "";
  position: absolute;
  top: 7px;
  right: 5px;
  font-family: "fontawesome";
}

.input_field:focus + .input_label::after,
.input--filled .input_label::after {
  transform: translate3d(0, 0, 0);
}

.toolbar {
  margin-bottom: 30px;
  border-bottom: 1px solid #d2d6d5;
}
.toolbar select {
  margin-bottom: 7px;
  color: #313131;
  font-size: 14px;
  border: none;
  background-color: transparent;
}
.toolbar .filter-options {
  line-height: 40px;
}
.toolbar a.filter-item {
  margin-right: 16px;
  padding-bottom: 18px;
  font-size: 14px;
  color: #313131;
  border-bottom: 0px solid transparent;
  transition: all 250ms ease-out;
}
.toolbar a.filter-item:last-child {
  margin-right: 0;
}
.toolbar a.filter-item.active {
  padding-bottom: 15px;
  color: #219e9a;
  font-weight: bold;
  border-bottom: 3px solid #219e9a;
}

#grid {
  margin-bottom: 60px;
}

.book-item {
  left: unset !important;
  width: 50%;
  margin: 15px 0;
  padding: 15px;
  list-style-type: none;
}
.book-item:hover .item-img img {
  box-shadow: 0px 0px 10px 0px rgba(49, 49, 49, 0.25);
}
.book-item:hover a.button {
  background-color: #219e9a;
}
.book-item:hover .bk-bookdefault {
  transform: rotate3d(0, 1, 0, 25deg);
}
.book-item:hover .bk-back {
  opacity: 1;
}
.book-item .item-img {
  display: inline-block;
  float: left;
  padding-right: 30px;
}
.book-item .item-img img {
  box-shadow: 0 0 0 0 transparent;
  transition: all 250ms ease-out;
}
.book-item .item-details {
  padding-right: 30px;
}
.book-item h3 {
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}
.book-item p:not(.author) {
  display: block;
  display: -webkit-box;
  height: 63px;
  /* Fallback for non-webkit */
  font-size: 15px;
  line-height: 1.4;
  -webkit-line-clamp: 3;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
}

/*
 *  Book Rotate
*/
.bk-img {
  position: relative;
  display: inline-block;
  float: left;
  padding-right: 30px;
  list-style: none;
  /* Individual style & artwork */
}
.bk-img .bk-wrapper {
  position: relative;
  width: 150px;
  height: 215px;
  float: left;
  z-index: 1;
  perspective: 1400px;
}
.bk-img .bk-wrapper:last-child {
  margin-right: 0;
}
.bk-img .bk-book {
  position: absolute;
  width: 100%;
  height: 215px;
  transform-style: preserve-3d;
  transition: transform 0.5s;
}
.bk-img .bk-book > div,
.bk-img .bk-front > div {
  display: block;
  position: absolute;
}
.bk-img .bk-front {
  transform-style: preserve-3d;
  transform-origin: 0% 50%;
  transition: transform 0.5s;
  transform: translate3d(0, 0, 20px);
  z-index: 10;
}
.bk-img .bk-front > div {
  z-index: 1;
  -webkit-backface-visibility: hidden;
  backface-visibility: hidden;
  transform-style: preserve-3d;
  border-radius: 0 3px 3px 0;
  box-shadow: inset 4px 0 10px rgba(0, 0, 0, 0.1);
}
.bk-img .bk-front:after {
  content: "";
  position: absolute;
  top: 1px;
  bottom: 1px;
  left: -1px;
  width: 1px;
}
.bk-img .bk-front,
.bk-img .bk-back,
.bk-img .bk-front > div {
  width: 150px;
  height: 215px;
}
.bk-img .bk-left,
.bk-img .bk-right {
  width: 40px;
  left: -20px;
}
.bk-img .bk-back {
  transform: rotate3d(0, 1, 0, -180deg) translate3d(0, 0, 20px);
  box-shadow: 5px 7px 15px rgba(0, 0, 0, 0.3);
  border-radius: 3px 0 0 3px;
  opacity: 0;
  transition: opacity 250ms ease-out;
}
.bk-img .bk-back:after {
  content: "";
  position: absolute;
  top: 0;
  left: 10px;
  bottom: 0;
  width: 3px;
  background: rgba(0, 0, 0, 0.06);
  box-shadow: 1px 0 3px rgba(255, 255, 255, 0.1);
}
.bk-img .bk-left {
  height: 215px;
  transform: rotate3d(0, 1, 0, -90deg);
}
.bk-img .bk-left h2 {
  width: 215px;
  height: 40px;
  transform-origin: 0 0;
  transform: rotate(90deg) translateY(-40px);
}
.bk-cover {
  background-size: contain;  /* Ensures the image covers the entire div */
  background-position: center; /* Centers the image */
  background-repeat: no-repeat; /* Prevents repeating */
  width: 100%;  /* Ensure the div takes full width */
  height: 100%; /* Ensure the div takes full height */
}

.bk-img .bk-cover:after {
  content: "";
  position: absolute;
  top: 0;
  left: 10px;
  bottom: 0;
  width: 3px;
  background: rgba(0, 0, 0, 0.06);
  box-shadow: 1px 0 3px rgba(255, 255, 255, 0.1);
}
.bk-img .bk-cover {
  background-repeat: no-repeat;
  background-position: center !important;
}
.bk-img .bk-front > div,
.bk-img .bk-left {
  background-color: #219e9a;
}

/*
 *  Lightbox
*/
.main-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: none;
  background-color: rgba(49, 49, 49, 0.65);
}
.main-overlay .overlay-full {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
}
.main-overlay .overlay-details {
  position: absolute;
  display: flex;
  z-index: 1;
  top: 50%;
  left: 50%;
  width: 100%;
  max-width: 800px;
  max-height: 480px;
  padding: 40px;
  overflow: hidden;
  border-radius: 3px;
  background-color: #fff;
  box-shadow: 0px 2px 1px 2px rgba(0, 0, 0, 0.3);
  transform: translate(-50%, -50%);
}
.main-overlay .overlay-image {
  display: inline-block;
  margin-right: 30px;
  max-width: 275px;
  height: 340px; /* Ensure it takes full height */
  vertical-align: top;
  overflow: hidden; /* Prevents image from overflowing */
  position: relative;
}

.main-overlay .overlay-image img {
  position: relative; /* Allows the image to fill the div */
  top: 0;
  left: 0;
  width: 100%; /* Fills the width of .overlay-image */
  height: 100%; /* Fills the height of .overlay-image */
  object-fit: contain; /* Ensures the image covers the whole div */
  z-index: 1;
  box-shadow: -12px 12px 15px -5px rgba(0, 0, 0, 0.3);
}

.main-overlay .overlay-image .back-color {
  position: absolute;
  top: 0;
  left: 0;
  width: 275px;
  height: 100%;
  border-top-left-radius: 3px;
  border-bottom-left-radius: 3px;
  background-color: green;
  z-index: 0; /* Keeps background behind the image */
}

.main-overlay .close-overlay-btn {
  position: absolute;
  top: 15px;
  right: 15px;
  width: 30px;
  height: 30px;
  opacity: 0.3;
  text-indent: -9999px;
  transition: opacity 250ms ease-out;
}
.main-overlay .close-overlay-btn:hover {
  opacity: 1;
}
.main-overlay .close-overlay-btn:before {
  content: " ";
  position: absolute;
  left: 15px;
  width: 2px;
  height: 33px;
  background-color: #313131;
}
.main-overlay .close-overlay-btn:after {
  content: " ";
  position: absolute;
  left: 15px;
  width: 2px;
  height: 33px;
  background-color: #313131;
}
.main-overlay .close-overlay-btn:before {
  transform: rotate(45deg);
}
.main-overlay .close-overlay-btn:after {
  transform: rotate(-45deg);
}
.main-overlay .back-preview-btn {
  position: absolute;
  top: 7px;
  left: -34px;
  width: 30px;
  height: 30px;
  opacity: 0.3;
  text-indent: -9999px;
  transition: opacity 250ms ease-out;
}
.main-overlay .back-preview-btn:hover {
  opacity: 1;
}
.main-overlay .back-preview-btn:before {
  content: " ";
  position: absolute;
  left: 15px;
  width: 2px;
  height: 15px;
  background-color: #313131;
}
.main-overlay .back-preview-btn:after {
  content: " ";
  position: absolute;
  top: 10px;
  left: 15px;
  width: 2px;
  height: 15px;
  background-color: #313131;
}
.main-overlay .back-preview-btn:before {
  transform: rotate(45deg);
}
.main-overlay .back-preview-btn:after {
  transform: rotate(-45deg);
}
.main-overlay .overlay-desc {
  align-content: center;
  display: inline;
  margin-top: -400px;
  width: calc(100% - 320px);
  vertical-align: top;
  transition: all 500ms ease-out;
}
.main-overlay .overlay-desc.activated {
  display: inline-block;
  margin-top: 0;
}
.main-overlay .overlay-preview {
  position: relative;
  display: inline-block;
  float: right;
  margin-top: 40px;
  width: calc(100% - 310px);
  vertical-align: top;
  transition: all 500ms ease-out;
}
.main-overlay .overlay-preview.activated {
  margin-top: -430px;
}
.main-overlay .preview-content {
  padding-right: 24px;
  padding-top: 10px;
  display: block;
  display: -webkit-box;
  height: 360px;
  /* Fallback for non-webkit */
  font-size: 15px;
  line-height: 1.5;
  -webkit-line-clamp: 16;
  -webkit-box-orient: vertical;
  overflow: hidden;
  text-overflow: ellipsis;
  overflow: scroll;
  text-overflow: clip;
  font-weight: 400;
}
.main-overlay .preview-content h5,
.main-overlay .preview-content p {
  font-family: "Roboto Slab", serif;
}
.main-overlay .preview-content h5 {
  font-weight: bold;
}
.main-overlay .preview-content p {
  font-weight: normal;
}
.main-overlay .preview-content:before {
  content: "";
  position: absolute;
  left: 0;
  top: 40px;
  width: 100%;
  heightheight: 30px;
  background: rgba(255, 255, 255, 0);
  background: linear-gradient(to top, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.8) 30%, white 80%);
}
.main-overlay .preview-content:after {
  content: "";
  position: absolute;
  left: 0;
  bottom: 0;
  width: 100%;
  height: 50px;
  background: rgba(255, 255, 255, 0);
  background: linear-gradient(to bottom, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0) 0%, rgba(255, 255, 255, 0.8) 30%, white 80%);
}

.overlay-details {
  display: none;
}

/*
 *  Footer
*/
#footer {
  margin-top: 60px;
  padding: 15px 0 20px;
  border-top: 1px solid #fff;
  background-color: rgba(49, 49, 49, 0.5);
}
#footer div,
#footer a,
#footer p {
  color: #fff;
  font-size: 12px;
  text-align: center;
}
</style>