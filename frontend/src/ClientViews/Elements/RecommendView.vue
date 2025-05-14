<template>
  <div class="carousel" mask style="justify-self: center">
    <article>
      <img src="https://images.pexels.com/photos/635699/pexels-photo-635699.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="">
      <h2>The Cross</h2>
      <div>
        <p>The Cross is a central symbol of Easter, representing the crucifixion of Jesus Christ and his sacrifice for humanity. It serves as a reminder of suffering, love, and redemption, and is often displayed during Holy Week and Easter Sunday to honor the foundation of Christian faith.</p>

        <a href="#">Read more</a>
      </div>
    </article>

    <article>
      <img src="https://images.pexels.com/photos/7168798/pexels-photo-7168798.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="easter eggs">
      <h2>Easter Eggs</h2>
      <div>
        <p>Easter eggs are a colorful symbol of new life and rebirth, often decorated and hidden for festive hunts. The tradition comes from ancient spring rituals and was later adopted into Easter celebrations to represent the resurrection.</p>

        <a href="#">Read more</a>
      </div>
    </article>

    <article>
      <img src="https://images.pexels.com/photos/4099179/pexels-photo-4099179.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="hot cross buns">
      <h2>Hot Cross Buns</h2>
      <div>
        <p>Hot cross buns are sweet, spiced buns marked with a cross on top, traditionally eaten on Good Friday. They originated in England and symbolize the crucifixion, with the cross representing Jesus and the spices recalling burial traditions.</p>

        <a href="#">Read more</a>
      </div>
    </article>

    <article>
      <img src="https://images.pexels.com/photos/5145/animal-easter-chick-chicken.jpg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="easter chick">
      <h2>Easter Chick</h2>
      <div>
        <p>Easter chicks are a cheerful symbol of new life and beginnings, often seen alongside eggs in spring decorations. They represent birth and renewal, tying into the themes of Easter and the arrival of spring.</p>

        <a href="#">Read more</a>
      </div>
    </article>

    <article>
      <img src="https://images.pexels.com/photos/2072158/pexels-photo-2072158.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="easter bunny">
      <h2>Easter Bunnies</h2>
      <div>
        <p>Easter bunnies are a popular symbol of spring and new life, often seen delivering colorful eggs to children.</p>

        <a href="#">Read more</a>
      </div>
    </article>

    <article>
      <img src="https://images.pexels.com/photos/12787666/pexels-photo-12787666.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1" alt="crown of thorms">
      <h2>Crown of Thorns</h2>
      <div>
        <p>The Crown of Thorns symbolizes the suffering of Jesus before his crucifixion. It represents the pain he endured for humanity’s salvation and is a reminder of his sacrifice during Easter.</p>

        <a href="#">Read more</a>
      </div>
    </article>

  </div>
</template>
<script>
import clientApi from "@/api/ClientApi";
import '../../assets/carousel.css'

export default {
  name: 'RecommendView',
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

    },
    getList() {
      this.loading = true;
      clientApi.getList({
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
