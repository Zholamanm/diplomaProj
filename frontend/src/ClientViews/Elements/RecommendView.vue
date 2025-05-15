<template>
  <div class="carousel" mask style="justify-self: center">
    <article v-for="(item, index) in list" :key="index" style="color: #219e9a; border: 1px #219e9a solid;">
      <img :src="`http://localhost:8000/storage/${item.cover_image}`" alt="">
      <h2>{{ item.title }}</h2>
      <h3>{{ item.author }}</h3>
      <div>
        <p>{{ item.desc }}</p>

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
      clientApi.getRecommendList({
        ...this.filters,
        search: this.searchQuery,
        page: this.page,
      }).then( res => {
        this.list = res
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
