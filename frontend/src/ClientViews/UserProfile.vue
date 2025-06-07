<template>
  <div class="profile-container">
    <!-- User Info Section -->
    <div class="profile-header">
      <div class="profile-picture-container">
        <img :src="userProfilePicture" alt="Profile Picture" class="profile-picture">
        <button class="edit-picture-btn" @click="openImageCropper">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="#fff">
            <path d="M3 17.25V21h3.75L17.81 9.94l-3.75-3.75L3 17.25zM20.71 7.04c.39-.39.39-1.02 0-1.41l-2.34-2.34c-.39-.39-1.02-.39-1.41 0l-1.83 1.83 3.75 3.75 1.83-1.83z"/>
          </svg>
        </button>
      </div>
      <div class="user-info">
        <h1>{{ user.name }}</h1>
        <p class="user-email">{{ user.email }}</p>
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
          <div class="meta-item" v-if="user.phone">
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
        <!-- Edit Profile Tab -->
        <div v-if="activeTab === 0" class="edit-profile">
          <form @submit.prevent="updateProfile">
            <div class="form-row">
              <div class="form-group">
                <label>Full Name</label>
                <input type="text" v-model="editForm.name">
              </div>
              <div class="form-group">
                <label>Email</label>
                <input type="email" v-model="editForm.email" disabled>
              </div>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label>Date of Birth</label>
                <input type="date" v-model="editForm.date_of_birth">
              </div>
              <div class="form-group">
                <label>Nationality</label>
                <input type="text" v-model="editForm.nationality">
              </div>
            </div>

            <div class="form-group">
              <label>Phone Number</label>
              <input type="tel" v-model="editForm.phone">
            </div>

            <div class="form-group">
              <label>Address</label>
              <textarea v-model="editForm.address" rows="3"></textarea>
            </div>

            <div class="form-group">
              <label>Bio</label>
              <textarea v-model="editForm.bio" rows="3" placeholder="Tell us about yourself..."></textarea>
            </div>

            <div class="form-actions">
              <button type="button" class="cancel-btn" @click="resetEditForm">Cancel</button>
              <button type="submit" class="save-btn">Save Changes</button>
            </div>
          </form>
        </div>

        <!-- Favorites Tab -->
        <div v-if="activeTab === 1" class="favorites-tab">
          <div v-if="favorites.length > 0" class="favorites-list">
            <div v-for="book in favorites" :key="book.id" class="book-item">
              <img :src="getBookCover(book)" alt="Book Cover" class="book-cover">
              <div class="book-info">
                <h3>{{ book.title }}</h3>
                <p>{{ book.author }}</p>
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
                <h3>{{ review.book.title }}</h3>
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

    <!-- Image Cropper Modal -->
    <div v-if="showCropper" class="modal-overlay">
      <div class="modal-container">
        <div class="modal-header">
          <h3>Crop Profile Picture</h3>
          <button class="close-btn" @click="showCropper = false">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#6c757d">
              <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
            </svg>
          </button>
        </div>
        <div class="modal-body">
          <vueCropper
              :aspectRatio="1/1"
              :initialAspectRatio="1/1"
              :auto-crop-area="0.8"
              :movable="true"
              :zoomable="true"
              :guides="true"
              v-if="showCropper && imageSrc"
              ref="cropper"
              :img="imageSrc"
              :outputSize="1"
              style="width:400px; height:400px; margin:auto;display: block;"
          ></vueCropper>
        </div>
        <div class="modal-footer">
          <input type="file" id="fileInput" accept="image/*" @change="setImage" style="display: none;">
          <label for="fileInput" class="change-btn">Change Image</label>
          <button class="cancel-btn" @click="showCropper = false">Cancel</button>
          <button class="save-btn" @click="cropImage">Save</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import clientApi from "@/api/ClientApi";

export default {
  name: 'UserProfile',

  data() {
    return {
      user: {
        name: '',
        email: '',
        profile_picture: null,
        date_of_birth: null,
        nationality: '',
        address: '',
        phone: '',
        bio: ''
      },
      editForm: {
        name: '',
        email: '',
        date_of_birth: null,
        nationality: '',
        address: '',
        phone: '',
        bio: ''
      },
      activeTab: 0,
      tabs: ['Edit Profile', 'Favorites', 'Reviews'],
      favorites: [],
      reviews: [],
      showCropper: false,
      imageSrc: '',
      croppedImage: null,
      isLoading: true
    };
  },
  computed: {
    userProfilePicture() {
      return this.user?.profile_picture
          ? `https://bookers.com.kz/storage/${this.user?.profile_picture}`
          : 'https://bookers.com.kz/defaults/default-profile.jpg';
    }
  },
  methods: {
    fetchUserData() {
      clientApi.getProfile()
          .then(response => {
            this.user = response.data;
            // Initialize edit form with user data
            this.editForm = {
              name: this.user.name,
              email: this.user.email,
              date_of_birth: this.user.date_of_birth,
              nationality: this.user.nationality,
              address: this.user.address,
              phone: this.user.phone,
              bio: this.user.bio
            };
          })
          .catch(error => {
            console.error('Error fetching profile:', error);
          });
    },

    fetchFavorites() {
      clientApi.getFavourites()
          .then(response => {
            this.favorites = response.data;
          })
          .catch(error => {
            console.error('Error fetching favorites:', error);
          });
    },

    fetchReviews() {
      clientApi.getUserReviews()
          .then(response => {
            this.reviews = response.data;
          })
          .catch(error => {
            console.error('Error fetching reviews:', error);
          });
    },

    formatDate(dateString) {
      if (!dateString) return '';
      const options = { year: 'numeric', month: 'long', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    },

    getBookCover(book) {
      return book.cover_image
          ? `https://bookers.com.kz/storage/${book.cover_image}`
          : 'https://bookers.com.kz/defaults/default-cover.jpg';
    },

    openImageCropper() {
      this.imageSrc = this.userProfilePicture;
      this.showCropper = true;
    },

    setImage(e) {
      const file = e.target.files[0];
      if (!file) return;

      if (file.type.match('image.*')) {
        const reader = new FileReader();
        reader.onload = (event) => {
            this.imageSrc = event.target.result;
          // Use the correct method name - setCanvasData instead of replace
          this.$nextTick(() => {
            const wrapper = this.$refs.cropper;
            if (wrapper && wrapper.cropper && typeof wrapper.cropper.replace === 'function') {
              wrapper.cropper.replace(this.imageSrc);
            }
          });
        };
        reader.readAsDataURL(file);
      }
    },
    async cropImage() {
      try {
        // Convert canvas to blob
        this.$refs.cropper.getCropBlob((blob) => {
          // You get the blob here
          const formData = new FormData();
          formData.append('profile_picture', blob, 'profile.jpg');

          clientApi.updateProfilePicture(formData)
              .then(response => {
                this.user.profile_picture = response.data.profile_picture;
                this.showCropper = false;
              })
              .catch(err => {
                console.error(err);
              });
        });
        // 90% quality
      } catch (error) {
        console.error('Error cropping image:', error);
      }
    },
    updateProfile() {
      clientApi.updateProfile(this.editForm)
          .then(response => {
            this.user = response.data;
            this.$toast.success('Profile updated successfully!');
          })
          .catch(error => {
            console.error('Error updating profile:', error);
            this.$toast.error('Failed to update profile');
          });
    },

    resetEditForm() {
      this.editForm = {
        name: this.user.name,
        email: this.user.email,
        date_of_birth: this.user.date_of_birth,
        nationality: this.user.nationality,
        address: this.user.address,
        phone: this.user.phone,
        bio: this.user.bio
      };
    }
  },
  created() {
    this.fetchUserData();
    this.fetchFavorites();
    this.fetchReviews();
  }
};
</script>

<style scoped>
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

.cropper {
  display: block;
  width: 100%;
  height: 400px;
  background: #eee;
}

.modal-body {
  padding: 0;
}

.modal-container {
  max-width: 800px;
}

.edit-picture-btn {
  position: absolute;
  bottom: 10px;
  right: 10px;
  width: 36px;
  height: 36px;
  background-color: #219e9a;
  border: none;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
}

.edit-picture-btn:hover {
  background-color: #1a7f7b;
  transform: scale(1.1);
}

.user-info {
  text-align: center;
}

.user-info h1 {
  margin: 0;
  color: #2c3e50;
  font-size: 2rem;
}

.user-email {
  color: #6c757d;
  margin: 0.5rem 0 1.5rem;
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

.form-row {
  display: flex;
  gap: 1.5rem;
  margin-bottom: 1.5rem;
}

.form-group {
  flex: 1;
  margin-bottom: 1.5rem;
}

.form-group label {
  display: block;
  margin-bottom: 0.5rem;
  font-weight: 500;
  color: #495057;
}

.form-group input,
.form-group textarea {
  width: 100%;
  padding: 0.75rem;
  border: 1px solid #ced4da;
  border-radius: 4px;
  font-size: 1rem;
}

.form-group textarea {
  min-height: 100px;
}

.form-actions {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  margin-top: 2rem;
}

.cancel-btn,
.save-btn {
  padding: 0.75rem 1.5rem;
  border-radius: 4px;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.3s ease;
}

.cancel-btn {
  background: white;
  border: 1px solid #ddd;
  color: #6c757d;
}

.cancel-btn:hover {
  background: #f8f9fa;
}

.save-btn {
  background: #219e9a;
  border: 1px solid #219e9a;
  color: white;
}

.save-btn:hover {
  background: #1a7f7b;
}

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
  color: #2c3e50;
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

/* Modal Styles */
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(0, 0, 0, 0.5);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.modal-container {
  background: white;
  border-radius: 8px;
  width: 90%;
  max-width: 800px;
  max-height: 90vh;
  overflow: hidden;
  box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
}

.modal-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding: 1.5rem;
  border-bottom: 1px solid #eee;
}

.modal-header h3 {
  margin: 0;
  color: #2c3e50;
}

.close-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 0.5rem;
}

.modal-body {
  padding: 1.5rem;
}

.modal-footer {
  display: flex;
  justify-content: flex-end;
  gap: 1rem;
  padding: 1rem 1.5rem;
  border-top: 1px solid #eee;
}

.change-btn {
  padding: 0.5rem 1rem;
  background: #f8f9fa;
  border: 1px solid #ddd;
  border-radius: 4px;
  cursor: pointer;
  margin-right: auto;
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .profile-header {
    flex-direction: column;
    text-align: center;
  }

  .form-row {
    flex-direction: column;
    gap: 1rem;
  }

  .tab-list {
    overflow-x: auto;
    white-space: nowrap;
  }

  .modal-container {
    width: 95%;
  }
}
</style>