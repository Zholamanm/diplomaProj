<template>
  <section class="mb-5">
    <h2 class="section-title">Popular <span class="highlight">Categories</span></h2>
    <div class="stories-block">
      <div class="custom-stories-widget">
        <div class="custom-stories">
          <div class="app-story">
            <div class="circle-container">
              <ul class="circle-list">
                <li v-for="category in categories" :key="category.id" class="circle-item" @click="$router.push({
                    name: 'CategoryView',
                    params: { locale: this.$route.params.locale, id: category.id }
                  });">
                  <div class="circle-preview">
                    <img
                        v-if="category.book"
                        class="circle-image"
                        :src="getImageUrl(category.book.cover_image)"
                        :alt="category.name"
                    >
                    <div v-else class="default-circle-image">
                      {{ category.name.charAt(0) }}
                    </div>
                  </div>
                  <div class="circle-name">{{ category.name }}</div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import clientApi from "@/api/ClientApi";

export default {
  name: 'CategoriesList',
  data() {
    return {
      categories: []
    }
  },
  methods: {
    getImageUrl(path) {
      return path ? `https://bookers.com.kz/storage/${path}` : '';
    },
    fetchCategories() {
      clientApi.getCategoriesWithMostBorrowed()
          .then(response => {
            this.categories = response;
          })
          .catch(error => {
            console.error('Error fetching categories:', error);
          });
    }
  },
  mounted() {
    this.fetchCategories();
  }
}
</script>

<style scoped>
.stories-block {
  min-height: 130px;
  height: 100%;
  margin-top: 45px;
}

.custom-stories-widget {
  overflow-x: auto;
  overflow-y: hidden;
  margin: 0 auto;
  max-width: 1600px;
}

.custom-stories {
  display: flex;
  justify-content: center;
}

.circle-container {
  width: 100%;
}

.circle-list {
  display: flex;
  gap: 20px;
  padding: 0;
  margin: 0;
  list-style: none;
  justify-content: space-evenly;
}

.circle-item {
  cursor: pointer;
  padding: 15px;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 120px;
}

.circle-preview {
  box-shadow: 0px 0px 10px 4px #219e9a;
  width: 120px;
  height: 120px;
  border-radius: 50%;
  overflow: hidden;
  border: 2px solid #ddd;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #f5f5f5;
}

.circle-image {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.default-circle-image {
  font-size: 24px;
  font-weight: bold;
  color: #555;
}

.circle-name {
  margin-top: 8px;
  font-size: 20px;
  text-align: center;
  color: #333;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  max-width: 100%;
}

@media screen and (max-width: 992px) {
  .stories-block {
    margin-top: 20px;
    min-height: 119px;
  }
}

@media screen and (max-width: 768px) {
  .custom-stories-widget {
    max-width: 768px;
    overflow-x: auto;
    max-width: 479px;
    margin-left: 12px;
    margin-right: 12px;
  }

  .custom-stories {
    justify-content: flex-start !important;
  }

  .circle-list {
    column-gap: 12px !important;
    padding: 0 12px;
  }
}

.app-story {
  width: 100%;
}

@media screen and (max-width: 600px) {
  .stories-block {
    margin-top: 40px;
    order: -1;
    min-height: 102px;
  }
}

.highlight {
  color: #219e9a;
  position: relative;
}

.highlight::after {
  content: '';
  position: absolute;
  bottom: 5px;
  left: 0;
  width: 100%;
  height: 12px;
  background: rgba(33, 158, 154, 0.2);
  z-index: -1;
}

.section-title {
  font-size: 2.2rem;
  margin-bottom: 50px;
  font-family: 'Roboto Slab', serif;
}

.circle-preview:hover {
  transform: scale(1.05);
  transition: 0.3s;
}
</style>