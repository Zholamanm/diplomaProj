<template>
  <section class="top-list-section">
    <h2 class="section-title">Top <span class="highlight">10 Lists</span></h2>
    <div class="genre-carousel-container">
      <div class="genre-carousel" ref="carousel">
        <div
            v-for="genre in genres"
            :key="genre.id"
            class="genre-block"
            @click="$router.push({
            name: 'TopView',
            params: {
              locale: $route.params.locale,
              genre: genre.id
            }
          })"
        >
          <div class="genre-content">
            <div class="genre-header">
              <h3 class="genre-title">{{ genre.name }}</h3>
              <div class="top-badge">TOP 10</div>
            </div>
            <div class="book-stack">
              <div
                  v-for="n in 4"
                  :key="n"
                  class="book-cover"
                  :style="{
          transform: `rotate(${-2 + n * 1.5}deg)`,
          zIndex: 5 - n,
          ...(n === 1 ? {
            backgroundImage: `url('${genre.book ? getImageUrl(genre.book.cover_image) : 'http://localhost:8000/defaults/default-cover.jpg'}')`,
            backgroundSize: 'cover',
            backgroundPosition: 'center'
          } : {})
        }"
              ></div>
            </div>
            <div class="view-button">View List</div>
          </div>
        </div>
      </div>
      <button class="carousel-nav prev" @click="scroll(-1)">‹</button>
      <button class="carousel-nav next" @click="scroll(1)">›</button>
    </div>
  </section>
</template>

<script>
import clientApi from "@/api/ClientApi";

export default {
  name: 'TopList',
  data() {
    return {
      genres: null,
      scrollInterval: null,
      currentScroll: 0
    }
  },
  methods: {
    startAutoScroll() {
      this.scrollInterval = setInterval(() => {
        this.scroll(1);
      }, 5000); // Scroll every 5 seconds
    },
    getImageUrl(path) {
      return path ? `http://localhost:8000/storage/${path}` : 'http://localhost:8000/defaults/default-cover.jpg';
    },
    handleImageError(e) {
      // This won't work for background images, we'll need a different approach
      e.target.style.backgroundImage = "url('http://localhost:8000/defaults/default-cover.jpg')";
    },
    fetchGenres() {
      clientApi.getTopsLists()
          .then(response => {
            this.genres = response;
            this.startAutoScroll()
          })
          .catch(error => {
            console.error('Error fetching genres:', error);
          });
    },
    scroll(direction) {
      const carousel = this.$refs.carousel;
      const itemWidth = 320; // Width of each genre block
      const maxScroll = carousel.scrollWidth - carousel.clientWidth;

      this.currentScroll += direction * itemWidth * 2; // Scroll 2 items at a time

      // Handle boundaries
      if (this.currentScroll < 0) {
        this.currentScroll = maxScroll;
      } else if (this.currentScroll > maxScroll) {
        this.currentScroll = 0;
      }

      carousel.scrollTo({
        left: this.currentScroll,
        behavior: 'smooth'
      });
    }
  },
  mounted() {
    this.fetchGenres();
  },
  beforeUnmount() {
    clearInterval(this.scrollInterval);
  }
}
</script>

<style scoped>
.top-list-section {
  padding: 60px 0;
  background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
}

.section-title {
  text-align: center;
  font-size: 2.2rem;
  margin-bottom: 50px;
  font-family: 'Roboto Slab', serif;
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

.genre-carousel-container {
  position: relative;
  max-width: 1600px;
  margin: 0 auto;
  padding: 0 40px;
}

.genre-carousel {
  display: flex;
  gap: 25px;
  overflow-x: auto;
  scroll-snap-type: x mandatory;
  padding: 20px 0;
  scrollbar-width: none; /* Hide scrollbar for Firefox */
  -ms-overflow-style: none; /* Hide scrollbar for IE/Edge */
}

.genre-carousel::-webkit-scrollbar {
  display: none; /* Hide scrollbar for Chrome/Safari */
}

.genre-block {
  flex: 0 0 300px;
  scroll-snap-align: start;
  cursor: pointer;
  transition: transform 0.3s ease;
}

.genre-block:hover {
  transform: translateY(-10px);
}

.genre-content {
  background: white;
  border-radius: 12px;
  overflow: hidden;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  height: 100%;
  display: flex;
  flex-direction: column;
  padding: 25px;
  border: 1px solid rgba(33, 158, 154, 0.2);
}

.genre-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.genre-title {
  font-size: 1.4rem;
  color: #2c3e50;
  margin: 0;
  font-weight: 600;
}

.top-badge {
  background: #219e9a;
  color: white;
  padding: 5px 10px;
  border-radius: 20px;
  font-size: 0.8rem;
  font-weight: bold;
}

.book-stack {
  position: relative;
  height: 180px;
  margin: 20px 0;
}

.book-cover {
  position: absolute;
  width: 80%;
  height: 100%;
  border-radius: 4px 8px 8px 4px;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
  left: 10%;
  top: 0;
  border-left: 5px solid #219e9a;
  background-size: cover;
  background-position: center;
}

.book-cover:nth-child(2) {
  background: linear-gradient(45deg, #a1c4fd, #c2e9fb) !important;
}

.book-cover:nth-child(3) {
  background: linear-gradient(45deg, #ffecd2, #fcb69f) !important;
}

.book-cover:nth-child(4) {
  background: linear-gradient(45deg, #84fab0, #8fd3f4) !important;
}

.view-button {
  margin-top: auto;
  text-align: center;
  padding: 12px;
  background: rgba(33, 158, 154, 0.1);
  color: #219e9a;
  border-radius: 6px;
  font-weight: 600;
  transition: all 0.3s ease;
}

.genre-block:hover .view-button {
  background: #219e9a;
  color: white;
}

.carousel-nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 40px;
  height: 40px;
  background: white;
  border: none;
  border-radius: 50%;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  font-size: 1.5rem;
  color: #219e9a;
  cursor: pointer;
  z-index: 10;
  display: flex;
  align-items: center;
  justify-content: center;
}

.carousel-nav:hover {
  background: #219e9a;
  color: white;
}

.prev {
  left: -5%;
}

.next {
  right: -5%;
}

@media (max-width: 768px) {
  .genre-carousel-container {
    padding: 0 20px;
  }

  .genre-block {
    flex: 0 0 260px;
  }

  .carousel-nav {
    display: none;
  }
}
</style>