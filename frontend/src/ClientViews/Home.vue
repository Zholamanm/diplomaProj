<template>
  <div class="dashboard-container">
    <!-- Hero Section with Animated Book Stack -->
    <div>
      <img src="https://diplomaproj.byethost3.com/storage/home/1747902338448.jpg" alt="" style="position: absolute; z-index: 0; width: 100%; height: 750px; left: 0">
      <section class="hero-section">
        <div class="hero-content" style="z-index: 1;">
          <h1 class="hero-title">Discover. Share. <span class="highlight">Read.</span></h1>
          <p class="hero-subtitle">Your gateway to a community-powered library</p>

          <div class="hero-search">
            <input
                type="text"
                placeholder="Search for your next adventure..."
                v-model="searchQuery"
                @keyup.enter="searchBooks"
            >
            <button @click="searchBooks">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
            </button>
          </div>
        </div>

        <div class="book-stack-animation">
          <div class="book" v-for="(book, index) in featuredBooks" :key="book.id"
               :style="{ '--delay': index * 0.1 + 's', 'z-index': 10 - index }">
            <div class="book-cover" :style="{ backgroundImage: book.cover_image ? `url(https://diplomaproj.byethost3.com/storage/${book.cover_image})` : 'url(https://diplomaproj.byethost3.com/defaults/default-cover.jpg)' }"></div>
          </div>
        </div>
      </section>
    </div>

    <!-- Stats Counter -->
    <section class="stats-section">
      <div class="stat-card">
        <div class="stat-number" ref="booksCounter">{{ bookCount }}</div>
        <div class="stat-label">Books Shared</div>
      </div>
      <div class="stat-card">
        <div class="stat-number" ref="usersCounter">{{ userCount }}</div>
        <div class="stat-label">Community Members</div>
      </div>
      <div class="stat-card">
        <div class="stat-number" ref="locationsCounter">{{ locationCount }}</div>
        <div class="stat-label">Pickup Locations</div>
      </div>
    </section>
    <categories-list />
    <top-list />
    <!-- Interactive Book Globe -->
<!--    <top-book-list />-->
    <!-- Personalized Recommendations -->
    <section class="personalized-section">
      <h2 class="section-title">Curated Just <span class="highlight">For You</span></h2>
      <div class="recommendation-cards">
        <div class="rec-card" v-for="rec in personalizedRecs" :key="rec.id"
             @click="viewBookDetails(rec.id)">
          <div class="rec-cover"
               :style="{ backgroundImage: rec.cover_image ? `url(https://diplomaproj.byethost3.com/storage/${rec.cover_image})` : 'url(https://diplomaproj.byethost3.com/defaults/default-cover.jpg)' }"></div>
          <div class="rec-details">
            <h3>{{ rec.title }}</h3>
            <p>{{ rec.author }}</p>
            <div class="rec-meta">
              <span class="genre">{{ rec.category }}</span>
              <span class="rating">★ {{ getAverageRating(rec.reviews) }} ({{ rec.reviews_count }})</span>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Community Activity Feed -->
    <section class="activity-section">
      <h2 class="section-title">Community <span class="highlight">Pulse</span></h2>
      <reviews-list />
<!--      <div class="activity-feed">-->
<!--        <div class="activity-card" v-for="activity in recentActivity" :key="activity.id">-->
<!--          <div class="activity-content">-->
<!--            <p><strong>{{ activity.user.name }}</strong> {{ activity.action }} <strong>{{ activity.book.title }}</strong></p>-->
<!--            <small>{{ formatTime(activity.timestamp) }}</small>-->
<!--          </div>-->
<!--        </div>-->
<!--      </div>-->
    </section>

    <!-- Call to Action -->
    <section class="cta-section">
      <h2>Ready to begin your <span class="highlight">reading journey</span>?</h2>
      <button class="cta-button" @click="exploreCatalog">
        Explore Full Catalog
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M5 12h14M12 5l7 7-7 7"/>
        </svg>
      </button>
    </section>
    <slider-list />
  </div>
</template>

<script>
import clientApi from "@/api/ClientApi";
import CategoriesList from "@/ClientViews/Elements/CategoriesList.vue";
import TopList from "@/ClientViews/Elements/TopList.vue";
import SliderList from "@/ClientViews/Elements/SliderList.vue";
import ReviewsList from "@/ClientViews/Elements/ReviewsList.vue";

export default {
  name: 'HomeView',
  components: {ReviewsList, SliderList, TopList, CategoriesList},
  data() {
    return {
      searchQuery: '',
      featuredBooks: [],
      globeBooks: [],
      personalizedRecs: [],
      recentActivity: [],
      globeRotation: { x: 0, y: 0 }
    };
  },
  computed: {
    bookCount() {
      return this.$store.state.common.data?.stats.books || 0
    },
    userCount() {
      return this.$store.state.common.data?.stats.users || 0
    },
    locationCount() {
      return this.$store.state.common.data?.stats.locations || 0
    },
  },
  methods: {
    getAverageRating(reviews) {
      if (!reviews || reviews.length === 0) return '0';
      const total = reviews.reduce((sum, review) => sum + (review.rating || 0), 0);
      const avg = total / reviews.length;
      return avg.toFixed(1);
    },
    async fetchData() {
      try {
        const [featured, globe, recs, activity] = await Promise.all([
          clientApi.getFeaturedList(),
          clientApi.getRecentList(),
          clientApi.getRecommendList(),
          clientApi.getRecentList()
        ]);
        this.featuredBooks = featured.slice(0, 1);
        this.globeBooks = globe;
        this.personalizedRecs = recs;
        this.recentActivity = activity;
      } catch (error) {
        console.error("Error fetching dashboard data:", error);
      }
    },
    searchBooks() {
      this.$emit('update-search', this.searchQuery);
      if (this.searchQuery.trim()) {
        this.$router.push({
          name: 'CatalogView',
          params: { locale: this.$route.params.locale }
        });
      }
    },
    viewBookDetails(id) {
      this.$router.push({ name: 'BookView', params: { id } });
    },
    exploreCatalog() {
      this.$router.push({ name: 'CatalogView' });
    },
  },
  mounted() {
    this.fetchData();
  }
};
</script>

<style scoped>
.dashboard-container {
  margin: 0 auto;
  padding: 0 20px;
  color: #2c3e50;
}

/* Hero Section */
.hero-section {
  max-width: 1600px;
  margin: auto;
  display: flex;
  align-items: center;
  justify-content: space-between;
  min-height: 70vh;
  padding: 40px 0;
}

.hero-content {
  border-radius: 25px;
  z-index: 1;
  background: rgb(255 255 255 / 0.7);
  padding: 40px;
  max-width: 600px;
}

.hero-title {
  font-size: 3.5rem;
  font-weight: 800;
  line-height: 1.2;
  margin-bottom: 1.5rem;
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

.hero-subtitle {
  font-size: 1.5rem;
  color: #6c757d;
  margin-bottom: 2.5rem;
}

.hero-search {
  display: flex;
  max-width: 500px;
}

.hero-search input {
  flex: 1;
  padding: 15px 20px;
  border: 2px solid #e9ecef;
  border-radius: 50px 0 0 50px;
  font-size: 1.1rem;
  transition: all 0.3s ease;
}

.hero-search input:focus {
  outline: none;
  border-color: #219e9a;
  box-shadow: 0 0 0 3px rgba(33, 158, 154, 0.2);
}

.hero-search button {
  width: 60px;
  background: #219e9a;
  color: white;
  border: none;
  border-radius: 0 50px 50px 0;
  cursor: pointer;
  transition: all 0.3s ease;
}

.hero-search button:hover {
  background: #1a7f7b;
}

.hero-search button svg {
  width: 24px;
  height: 24px;
}

/* Book Stack Animation */
.book-stack-animation {
  position: relative;
  width: 300px;
  height: 400px;
  perspective: 1000px;
}

.book {
  position: absolute;
  width: 100%;
  height: 100%;
  transform-style: preserve-3d;
  transition: transform 0.5s ease;
  animation: float 3s ease-in-out infinite alternate;
  animation-delay: var(--delay);
}

.book-cover {
  width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  border-radius: 5px 8px 8px 5px;
  box-shadow: 0 10px 20px 15px rgba(0, 0, 0, 0.6);
  transform: rotateY(-10deg);
}

@keyframes float {
  0% { transform: translateY(0) rotateY(-10deg); }
  100% { transform: translateY(-20px) rotateY(-10deg); }
}

/* Stats Section */
.stats-section {
  display: flex;
  justify-content: space-around;
  padding: 60px 0;
  background: rgba(33, 158, 154, 0.05);
  border-radius: 15px;
  margin: 40px 0;
}

.stat-card {
  text-align: center;
}

.stat-number {
  font-size: 3.5rem;
  font-weight: 700;
  color: #219e9a;
  margin-bottom: 10px;
  font-family: 'Roboto Slab', serif;
}

.stat-label {
  font-size: 1.1rem;
  color: #6c757d;
}

/* Globe Section */
.globe-section {
  text-align: center;
  margin: 80px 0;
}

.section-title {
  font-size: 2.2rem;
  margin-bottom: 50px;
  font-family: 'Roboto Slab', serif;
}

.book-globe {
  position: relative;
  width: 300px;
  height: 300px;
  margin: 0 auto;
  transform-style: preserve-3d;
  transition: transform 0.1s ease;
}

.globe-inner {
  position: relative;
  width: 100%;
  height: 100%;
  transform-style: preserve-3d;
}

.book-point {
  position: absolute;
  width: 20px;
  height: 20px;
  background: #219e9a;
  border-radius: 50%;
  transform-style: preserve-3d;
  transition: transform 0.5s ease, opacity 0.5s ease;
}

.book-point::before {
  content: '';
  position: absolute;
  width: 100%;
  height: 100%;
  background: inherit;
  border-radius: inherit;
  transform: translateZ(-1px);
}

.book-tooltip {
  position: absolute;
  bottom: 100%;
  left: 50%;
  transform: translateX(-50%);
  background: white;
  padding: 5px 10px;
  border-radius: 4px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.1);
  font-size: 0.8rem;
  white-space: nowrap;
  opacity: 0;
  transition: opacity 0.3s ease;
  pointer-events: none;
}

.book-point:hover .book-tooltip {
  opacity: 1;
}

/* Personalized Recommendations */
.personalized-section {
  max-width: 1600px;
  margin: 80px auto;
}

.recommendation-cards {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
  gap: 30px;
  margin-top: 40px;
}

.rec-card {
  background: white;
  border-radius: 10px;
  overflow: hidden;
  box-shadow: 0 5px 15px rgba(0,0,0,0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.rec-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.12);
}

.rec-cover {
  height: 200px;
  background-size: cover;
  background-position: center;
}

.rec-details {
  padding: 20px;
}

.rec-details h3 {
  font-size: 1.2rem;
  margin-bottom: 5px;
  color: #2c3e50;
}

.rec-details p {
  color: #6c757d;
  margin-bottom: 15px;
}

.rec-meta {
  display: flex;
  justify-content: space-between;
}

.genre {
  background: rgba(33, 158, 154, 0.1);
  color: #219e9a;
  padding: 3px 8px;
  border-radius: 4px;
  font-size: 0.8rem;
}

.rating {
  color: #ffc107;
  font-weight: bold;
}

/* Activity Feed */
.activity-section {
  margin: 80px 0;
}

.activity-feed {
  max-width: 800px;
  margin: 0 auto;
  background: white;
  border-radius: 10px;
  padding: 20px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.05);
}

.activity-card {
  display: flex;
  align-items: center;
  padding: 15px;
  border-bottom: 1px solid #f1f1f1;
  transition: background 0.3s ease;
}

.activity-card:last-child {
  border-bottom: none;
}

.activity-card:hover {
  background: rgba(33, 158, 154, 0.03);
}

.user-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  background-size: cover;
  background-position: center;
  margin-right: 15px;
  flex-shrink: 0;
}

.activity-content p {
  margin: 0;
  color: #495057;
}

.activity-content small {
  color: #adb5bd;
  font-size: 0.8rem;
}

/* CTA Section */
.cta-section {
  text-align: center;
  padding: 80px 0;
  background: linear-gradient(135deg, rgba(33, 158, 154, 0.05) 0%, rgba(33, 158, 154, 0.02) 100%);
  border-radius: 15px;
}

.cta-section h2 {
  font-size: 2.2rem;
  margin-bottom: 30px;
  font-family: 'Roboto Slab', serif;
}

.cta-button {
  display: inline-flex;
  align-items: center;
  gap: 10px;
  padding: 15px 30px;
  background: #219e9a;
  color: white;
  border: none;
  border-radius: 50px;
  font-size: 1.1rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.cta-button:hover {
  background: #1a7f7b;
  transform: translateY(-3px);
  box-shadow: 0 10px 20px rgba(0,0,0,0.1);
}

.cta-button svg {
  width: 20px;
  height: 20px;
}

/* Responsive Design */
@media (max-width: 1024px) {
  .hero-section {
    flex-direction: column;
    text-align: center;
    padding: 60px 0;
  }

  .hero-content {
    margin-bottom: 50px;
  }

  .hero-search {
    margin: 0 auto;
  }

  .stats-section {
    flex-direction: column;
    gap: 30px;
  }
}

@media (max-width: 768px) {
  .hero-title {
    font-size: 2.5rem;
  }

  .section-title {
    font-size: 1.8rem;
  }

  .recommendation-cards {
    grid-template-columns: 1fr;
  }
}

.book-globe {
  position: relative;
  width: 400px;
  height: 400px;
  margin: 0 auto;
}

.globe-base {
  position: absolute;
  width: 100%;
  height: 100%;
  background: radial-gradient(circle at center,
  rgba(33, 158, 154, 0.1) 0%,
  transparent 70%);
  border-radius: 50%;
  border: 2px dashed rgba(33, 158, 154, 0.3);
}

.map-texture {
  opacity: 0.3;
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.book-point {
  /* ... existing styles ... */
  background: hsl(var(--hue), 70%, 50%);
  box-shadow: 0 0 10px hsl(var(--hue), 70%, 50%);
}

.tooltip-cover {
  width: 40px;
  height: 60px;
  object-fit: cover;
  margin-right: 10px;
}
</style>