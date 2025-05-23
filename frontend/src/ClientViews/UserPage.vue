<template>
  <div class="profile-container">
    <!-- User Info Section -->
    <div class="profile-header">
      <div class="profile-picture-container">
        <img :src="userProfilePicture" alt="Profile Picture" class="profile-picture">
      </div>
      <div class="user-info">
        <h1>{{ user.name }}</h1>
        <div class="user-meta">
          <div class="meta-item" v-if="user.date_of_birth">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#219e9a">
              <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
            </svg>
            <span>{{ formatDate(user.date_of_birth) }}</span>
          </div>
          <div class="meta-item" v-if="user.nationality">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#219e9a">
              <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-1 17.93c-3.95-.49-7-3.85-7-7.93 0-.62.08-1.21.21-1.79L9 15v1c0 1.1.9 2 2 2v1.93zm6.9-2.54c-.26-.81-1-1.39-1.9-1.39h-1v-3c0-.55-.45-1-1-1H8v-2h2c.55 0 1-.45 1-1V7h2c1.1 0 2-.9 2-2v-.41c2.93 1.19 5 4.06 5 7.41 0 2.08-.8 3.97-2.1 5.39z"/>
            </svg>
            <span>{{ user.nationality }}</span>
          </div>
          <div class="meta-item" v-if="user.phone && user.show_phone">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#219e9a">
              <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
            </svg>
            <span>{{ user.phone }}</span>
          </div>
        </div>
        <div class="user-bio" v-if="user.bio">
          <p>{{ user.bio }}</p>
        </div>
      </div>
      <add-friend-button />
    </div>

    <!-- Tabs Section -->
    <div class="profile-tabs">
      <ul class="tab-list">
        <li
            v-for="(tab, index) in tabs"
            :key="index"
            :class="{ 'active': activeTab === index }"
            @click="activeTab = index"
        >
          {{ tab }}
        </li>
      </ul>

      <div class="tab-content">
        <!-- About Tab -->
        <div v-if="activeTab === 0" class="about-tab">
          <div class="info-section" v-if="user.address">
            <h3>Address</h3>
            <p>{{ user.address }}</p>
          </div>

          <div class="info-section" v-if="user.joined_at">
            <h3>Member Since</h3>
            <p>{{ formatDate(user.joined_at) }}</p>
          </div>

          <div class="info-section" v-if="user.last_seen">
            <h3>Last Active</h3>
            <p>{{ formatDateTime(user.last_seen) }}</p>
          </div>
        </div>

        <!-- Favorites Tab -->
        <div v-if="activeTab === 1" class="favorites-tab">
          <div v-if="favorites.length > 0" class="favorites-list">
            <div v-for="book in favorites" :key="book.id" class="book-item">
              <img :src="getBookCover(book)" alt="Book Cover" class="book-cover">
              <div class="book-info">
                <h3>{{ book.title }}</h3>
                <p>{{ book.author }}</p>
                <router-link :to="`/books/${book.id}`" class="view-link">View Book</router-link>
              </div>
            </div>
          </div>
          <div v-else class="empty-state">
            <p>No favorite books yet</p>
          </div>
        </div>

        <!-- Reviews Tab -->
        <div v-if="activeTab === 2" class="reviews-tab">
          <div v-if="reviews.length > 0" class="reviews-list">
            <div v-for="review in reviews" :key="review.id" class="review-item">
              <div class="review-header">
                <h3>
                  <router-link :to="`/books/${review.book.id}`">{{ review.book.title }}</router-link>
                </h3>
                <div class="rating">
                  <span v-for="star in 5" :key="star">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        width="16"
                        height="16"
                        viewBox="0 0 24 24"
                        :fill="star <= review.rating ? '#FFC107' : '#E0E0E0'"
                    >
                      <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                    </svg>
                  </span>
                </div>
              </div>
              <p class="review-date">{{ formatDate(review.created_at) }}</p>
              <p class="review-content">{{ review.comment }}</p>
            </div>
          </div>
          <div v-else class="empty-state">
            <p>No reviews yet</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import clientApi from "@/api/ClientApi";
import AddFriendButton from "@/ClientViews/Elements/AddFriendButton.vue";

export default {
  name: 'UserPage',
  components: {AddFriendButton},
  data() {
    return {
      user: {
        name: '',
        profile_picture: null,
        date_of_birth: null,
        nationality: '',
        address: '',
        phone: '',
        bio: '',
        show_phone: false,
        joined_at: null,
        last_seen: null
      },
      activeTab: 0,
      tabs: ['About', 'Favorites', 'Reviews'],
      favorites: [],
      reviews: [],
      isLoading: true
    };
  },
  computed: {
    userProfilePicture() {
      return this.user?.profile_picture
          ? `http://localhost:8000/storage/${this.user?.profile_picture}`
          : 'http://localhost:8000/defaults/default-profile.jpg';
    }
  },
  methods: {
    fetchUserData() {
      clientApi.getUserProfile(this.$route.params.id)
          .then(response => {
            this.user = response.data;
          })
          .catch(error => {
            console.error('Error fetching user profile:', error);
            this.$router.push('/not-found');
          });
    },

    fetchFavorites() {
      clientApi.getUserFavorites(this.$route.params.id)
          .then(response => {
            this.favorites = response.data;
          })
          .catch(error => {
            console.error('Error fetching user favorites:', error);
          });
    },

    fetchReviews() {
      clientApi.getUserPublicReviews(this.$route.params.id)
          .then(response => {
            this.reviews = response.data;
          })
          .catch(error => {
            console.error('Error fetching user reviews:', error);
          });
    },

    formatDate(dateString) {
      if (!dateString) return '';
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },

    formatDateTime(datetimeString) {
      if (!datetimeString) return '';
      const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit'
      };
      return new Date(datetimeString).toLocaleDateString(undefined, options);
    },

    getBookCover(book) {
      return book.cover_image
          ? `http://localhost:8000/storage/${book.cover_image}`
          : 'http://localhost:8000/defaults/default-cover.jpg';
    }
  },
  mounted() {
    this.fetchUserData();
    this.fetchFavorites();
    this.fetchReviews();
  },
  watch: {
    '$route.params.id': {
      handler: function() {
        this.fetchUserData();
        this.fetchFavorites();
        this.fetchReviews();
      },
      immediate: true
    },
  }
};
</script>

<style scoped>
/* Reuse most styles from the profile page */
.profile-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 2rem;
}

.profile-header {
  display: flex;
  flex-direction: column;
  align-items: center;
  margin-bottom: 2rem;
  padding-bottom: 2rem;
  border-bottom: 1px solid #eee;
}

.profile-picture-container {
  position: relative;
  width: 150px;
  height: 150px;
  margin-bottom: 1.5rem;
}

.profile-picture {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #219e9a;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.user-info {
  text-align: center;
}

.user-info h1 {
  margin: 0;
  color: #2c3e50;
  font-size: 2rem;
}

.user-meta {
  display: flex;
  flex-wrap: wrap;
  justify-content: center;
  gap: 1.5rem;
  margin-bottom: 1.5rem;
}

.meta-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  color: #495057;
}

.user-bio {
  max-width: 600px;
  margin: 0 auto;
  color: #495057;
  line-height: 1.6;
}

.profile-tabs {
  margin-top: 2rem;
}

.tab-list {
  display: flex;
  list-style: none;
  padding: 0;
  margin: 0 0 2rem;
  border-bottom: 1px solid #ddd;
}

.tab-list li {
  padding: 0.75rem 1.5rem;
  cursor: pointer;
  font-weight: 500;
  color: #6c757d;
  transition: all 0.3s ease;
}

.tab-list li:hover {
  color: #219e9a;
}

.tab-list li.active {
  color: #219e9a;
  border-bottom: 2px solid #219e9a;
}

/* About Tab Styles */
.about-tab {
  padding: 1rem;
}

.info-section {
  margin-bottom: 1.5rem;
}

.info-section h3 {
  margin-bottom: 0.5rem;
  color: #2c3e50;
  font-size: 1.1rem;
}

.info-section p {
  margin: 0;
  color: #495057;
  line-height: 1.6;
}

/* Favorites and Reviews tabs (reuse styles from profile) */
.favorites-list,
.reviews-list {
  display: flex;
  flex-direction: column;
  gap: 1.5rem;
}

.book-item {
  display: flex;
  align-items: center;
  gap: 1.5rem;
  padding: 1rem;
  border-radius: 8px;
  background: white;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.book-cover {
  width: 60px;
  height: 90px;
  object-fit: cover;
  border-radius: 4px;
}

.book-info {
  flex: 1;
}

.book-info h3 {
  margin: 0 0 0.25rem;
  font-size: 1rem;
  color: #2c3e50;
}

.book-info p {
  margin: 0;
  color: #6c757d;
  font-size: 0.9rem;
}

.view-link {
  display: inline-block;
  margin-top: 0.5rem;
  color: #219e9a;
  font-size: 0.9rem;
  text-decoration: none;
}

.view-link:hover {
  text-decoration: underline;
}

.review-item {
  padding: 1.5rem;
  border-radius: 8px;
  background: white;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}

.review-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 0.5rem;
}

.review-header h3 {
  margin: 0;
  font-size: 1rem;
}

.review-header h3 a {
  color: #2c3e50;
  text-decoration: none;
}

.review-header h3 a:hover {
  text-decoration: underline;
}

.rating {
  display: flex;
  gap: 0.25rem;
}

.review-date {
  margin: 0 0 0.75rem;
  color: #6c757d;
  font-size: 0.85rem;
}

.review-content {
  margin: 0;
  color: #495057;
  line-height: 1.6;
}

.empty-state {
  text-align: center;
  padding: 2rem;
  color: #6c757d;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .profile-header {
    flex-direction: column;
    text-align: center;
  }

  .tab-list {
    overflow-x: auto;
    white-space: nowrap;
  }
}
</style>