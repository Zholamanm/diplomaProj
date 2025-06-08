<template>
  <div class="reviews-container">
    <h2 class="section-title">Recent Reviews</h2>
    <p class="section-subtitle">What readers are saying about these books</p>

    <div class="carousel-container">
      <div class="carousel">
        <article v-for="(review, index) in reviews" :key="index" class="review-card">
          <div class="reviewer-info">
            <img :src="getProfilePicture(review.user)" alt="Reviewer" class="reviewer-avatar" @click="$router.push({name: 'UserPage', params: { locale: $route.params.locale, id: review.user.id}})">
            <div>
              <h3 class="reviewer-name">{{ review.user.name }}</h3>
              <p class="review-date">{{ formatDate(review.created_at) }}</p>
            </div>
          </div>

          <div class="book-info">
            <img :src="getBookCover(review.book)" alt="Book cover" class="book-cover" @error="handleImageError">
            <div>
              <h4 class="book-title">{{ review.book.title }}</h4>
              <p class="book-author">{{ review.book.author }}</p>
            </div>
          </div>

          <div class="review-content">
            <div class="rating">
              <svg v-for="star in 5" :key="star" xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24"
                   :fill="star <= review.rating ? '#FFC107' : '#E0E0E0'">
                <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
              </svg>
            </div>
            <p class="review-text">{{ truncateText(review.comment) }}</p>
            <button class="read-more" @click="viewFullReview(review)" v-if="review.comment.length > 150">Read full review</button>
          </div>
        </article>
      </div>
    </div>
  </div>
</template>

<script>
import clientApi from "@/api/ClientApi";

export default {
  name: 'ReviewsList',
  data() {
    return {
      reviews: [],
      loading: false,
      expandedReviews: {}
    };
  },
  methods: {
    async fetchRecentReviews() {
      this.loading = true;
      try {
        const response = await clientApi.getRecentReviews();
        this.reviews = response.data;
      } catch (error) {
        console.error('Error fetching reviews:', error);
      } finally {
        this.loading = false;
      }
    },

    getProfilePicture(user) {
      return user.profile_picture
          ? `https://bookers.com.kz/public/storage/${user.profile_picture}`
          : 'https://bookers.com.kz/defaults/default-profile.jpg';
    },

    getBookCover(book) {
      return book.cover_image
          ? `https://bookers.com.kz/public/storage/${book.cover_image}`
          : 'https://bookers.com.kz/defaults/default-cover.jpg';
    },

    formatDate(dateString) {
      if (!dateString) return '';
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },

    truncateText(text) {
      if (this.expandedReviews[text]) return text;
      return text.length > 150 ? text.substring(0, 150) + '...' : text;
    },

    viewFullReview(review) {
      this.$set(this.expandedReviews, review.comment, true);
    },

    handleImageError(e) {
      e.target.src = 'https://bookers.com.kz/defaults/default-cover.jpg';
    }
  },
  mounted() {
    this.fetchRecentReviews();
  }
};
</script>

<style scoped>
.section-title {
  text-align: center;
  font-size: 1.8rem;
  color: #2c3e50;
  margin-bottom: 0.5rem;
  font-family: 'Roboto Slab', serif;
}

.section-subtitle {
  text-align: center;
  font-size: 1rem;
  color: #6c757d;
  margin-bottom: 2rem;
  font-weight: 300;
}

.carousel-container {
  width: 100%;
  overflow-x: auto;
  padding: 1rem 0;
  -webkit-overflow-scrolling: touch; /* For smooth scrolling on iOS */
}

.carousel {
  display: flex;
  gap: 20px;
  padding: 0 20px;
  width: 100%;
}

.review-card {
  width: 300px;
  min-width: 300px;
  height: 380px;
  background: white;
  border-radius: 10px;
  padding: 1.5rem;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  display: flex;
  flex-direction: column;
}

.review-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
}

.reviewer-info {
  display: flex;
  align-items: center;
  margin-bottom: 1.2rem;
}

.reviewer-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
  margin-right: 1rem;
  border: 2px solid #f0f0f0;
}

.reviewer-name {
  margin: 0;
  font-size: 1rem;
  color: #2c3e50;
  font-weight: 600;
}

.review-date {
  margin: 0.2rem 0 0;
  font-size: 0.8rem;
  color: #6c757d;
}

.book-info {
  display: flex;
  align-items: center;
  margin-bottom: 1.2rem;
  padding-bottom: 1rem;
  border-bottom: 1px solid #f0f0f0;
}

.book-cover {
  width: 50px;
  height: 70px;
  object-fit: cover;
  border-radius: 4px;
  margin-right: 1rem;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.book-title {
  margin: 0;
  font-size: 0.95rem;
  color: #2c3e50;
  font-weight: 600;
  line-height: 1.3;
}

.book-author {
  margin: 0.2rem 0 0;
  font-size: 0.85rem;
  color: #6c757d;
}

.review-content {
  flex: 1;
  display: flex;
  flex-direction: column;
}

.rating {
  display: flex;
  gap: 0.2rem;
  margin-bottom: 1rem;
}

.rating svg {
  width: 18px;
  height: 18px;
}

.review-text {
  margin: 0 0 1rem;
  color: #495057;
  line-height: 1.6;
  font-size: 0.9rem;
  flex: 1;
}

.read-more {
  align-self: flex-start;
  background: none;
  border: none;
  color: #219e9a;
  font-size: 0.85rem;
  padding: 0.2rem 0;
  cursor: pointer;
  transition: color 0.2s ease;
}

.read-more:hover {
  color: #1a7f7b;
  text-decoration: underline;
}

/* Hide scrollbar but keep functionality */
.carousel-container::-webkit-scrollbar {
  display: none;
}

@media (max-width: 768px) {
  .review-card {
    width: 280px;
    min-width: 280px;
    height: 400px;
    padding: 1.2rem;
  }

  .section-title {
    font-size: 1.5rem;
  }
}
</style>