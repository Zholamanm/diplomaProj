<template>
  <div class="friends-container">
    <!-- Friends Section -->
    <div class="friends-section">
      <div class="section-header">
        <h2 class="section-title">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#219e9a">
            <path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/>
          </svg>
          Your Friends
          <span class="badge">{{ friends.length }}</span>
        </h2>
        <button class="refresh-btn" @click="fetchFriends" title="Refresh list">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#219e9a">
            <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
          </svg>
        </button>
      </div>

      <div v-if="friends.length > 0" class="friends-grid">
        <div
            v-for="friend in friends"
            :key="friend.id"
            class="friend-card"
            @mouseenter="hoverFriend = friend.id"
            @mouseleave="hoverFriend = null"
        >
          <div class="friend-avatar-container">
            <img
                :src="friend.profile_picture ? `https://bookers.com.kz/storage/${friend.profile_picture}` : 'https://bookers.com.kz/defaults/default-profile.jpg'"
                class="friend-avatar"
                :class="{ 'avatar-hover': hoverFriend === friend.id }"
            >
            <div class="online-indicator" v-if="friend.is_online"></div>
          </div>
          <div class="friend-info">
            <h3>{{ friend.name }}</h3>
            <UserOnlineIndicator v-if="$store.state.user.user.id" :user="friend" />
          </div>
          <div class="friend-actions">
            <button
                class="action-btn chat-btn"
                @click="startChat(friend)"
                title="Start chat"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#fff">
                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/>
              </svg>
            </button>
            <a
                @click="$router.push({name: 'UserPage', params: {locale: $route.params.locale, id: friend.id}})"
                class="action-btn profile-btn"
                title="View profile"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#fff">
                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 3c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm0 14.2c-2.5 0-4.71-1.28-6-3.22.03-1.99 4-3.08 6-3.08 1.99 0 5.97 1.09 6 3.08-1.29 1.94-3.5 3.22-6 3.22z"/>
              </svg>
            </a>
          </div>
        </div>
      </div>
      <div v-else class="empty-state">
        <img src="" alt="No friends" class="empty-illustration">
        <p>Your friends list is empty</p>
        <button class="find-friends-btn" @click="$router.push('/discover')">
          Find Friends
        </button>
      </div>
    </div>

    <!-- Pending Requests Section -->
    <div class="requests-section">
      <div class="section-header">
        <h2 class="section-title">
          <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="#FF9800">
            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.31-8.86c-1.77-.45-2.34-.94-2.34-1.67 0-.84.79-1.43 2.1-1.43 1.38 0 1.9.66 1.94 1.64h1.71c-.05-1.34-.87-2.57-2.49-2.97V5H10.9v1.69c-1.51.32-2.72 1.3-2.72 2.81 0 1.79 1.49 2.69 3.66 3.21 1.95.46 2.34 1.15 2.34 1.87 0 .53-.39 1.39-2.1 1.39-1.6 0-2.23-.72-2.32-1.64H8.04c.1 1.7 1.36 2.66 2.86 2.97V19h2.34v-1.67c1.52-.29 2.72-1.16 2.73-2.77-.01-2.2-1.9-2.96-3.66-3.42z"/>
          </svg>
          Pending Requests
          <span class="badge">{{ pendingRequests.length }}</span>
        </h2>
      </div>

      <div v-if="pendingRequests.length > 0" class="requests-list">
        <div
            v-for="request in pendingRequests"
            :key="request.id"
            class="request-card"
        >
          <div class="request-avatar-container">
            <img
                :src="request.profile_picture ? `https://bookers.com.kz/storage/${request.profile_picture}` : 'https://bookers.com.kz/defaults/default-profile.jpg'"
                class="request-avatar"
            >
          </div>
          <div class="request-info">
            <h3>{{ request.name }}</h3>
            <p class="request-date">Sent {{ formatRequestDate(request.created_at) }}</p>
          </div>
          <div class="request-actions">
            <button
                class="action-btn accept-btn"
                @click="acceptRequest(request)"
                title="Accept request"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#fff">
                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
              </svg>
            </button>
            <button
                class="action-btn reject-btn"
                @click="rejectRequest(request)"
                title="Decline request"
            >
              <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="#fff">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
              </svg>
            </button>
          </div>
        </div>
      </div>
      <div v-else class="empty-state">
        <img src="" alt="No requests" class="empty-illustration">
        <p>No pending friend requests</p>
      </div>
    </div>

    <!-- Loading Animation -->
    <div v-if="loading" class="loading-overlay">
      <div class="spinner"></div>
    </div>
  </div>
</template>

<script>
import clientApi from "@/api/ClientApi";
import UserOnlineIndicator from "@/ClientViews/Elements/UserOnlineIndicator.vue";

export default {
  components: {UserOnlineIndicator},
  data() {
    return {
      friends: [],
      pendingRequests: [],
      hoverFriend: null,
      loading: false
    }
  },
  methods: {
    async fetchFriends() {
      this.loading = true;
      try {
        const response = await clientApi.getFriends(this.$store.state.user.user.id);
        this.friends = response.user.friends ?? [];
        this.pendingRequests = response.user.pending_friends ?? [];

        // Simulate online status for demo (replace with real data)
        this.friends.forEach(friend => {
          friend.is_online = Math.random() > 0.5;
          if (!friend.is_online) {
            friend.last_seen = new Date(Date.now() - Math.floor(Math.random() * 48) * 3600000).toISOString();
          }
        });
      } catch (error) {
        console.error("Error fetching friends:", error);
      } finally {
        this.loading = false;
      }
    },
    async acceptRequest(friend) {
      try {
        await clientApi.acceptRequest(friend.id);
        this.$toast.success(`You are now friends with ${friend.name}!`, {
          position: "top-right",
          duration: 3000
        });
        this.fetchFriends();
      } catch (error) {
        this.$toast.error("Failed to accept friend request", {
          position: "top-right"
        });
      }
    },
    async rejectRequest(friend) {
      try {
        await clientApi.declineRequest(friend.id);
        this.$toast.info(`Declined friend request from ${friend.name}`, {
          position: "top-right",
          duration: 3000
        });
        this.fetchFriends();
      } catch (error) {
        this.$toast.error("Failed to decline friend request", {
          position: "top-right"
        });
      }
    },
    startChat(friend) {
      this.$router.push({ name: 'chat', params: { userId: friend.id } });
    },
    formatLastSeen(dateString) {
      if (!dateString) return "recently";
      const now = new Date();
      const lastSeen = new Date(dateString);
      const diffInHours = Math.floor((now - lastSeen) / (1000 * 60 * 60));

      if (diffInHours < 1) return "less than an hour ago";
      if (diffInHours < 24) return `${diffInHours} hours ago`;

      const diffInDays = Math.floor(diffInHours / 24);
      return `${diffInDays} day${diffInDays > 1 ? 's' : ''} ago`;
    },
    formatRequestDate(dateString) {
      if (!dateString) return "";
      const options = { year: 'numeric', month: 'short', day: 'numeric' };
      return new Date(dateString).toLocaleDateString(undefined, options);
    }
  },
  mounted() {
    this.fetchFriends();
  }
}
</script>

<style scoped>
.friends-container {
  max-width: 900px;
  margin: 0 auto;
  padding: 20px;
  display: grid;
  grid-template-columns: 1fr;
  gap: 30px;
}

.section-header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
  padding-bottom: 10px;
  border-bottom: 1px solid #e0e0e0;
}

.section-title {
  display: flex;
  align-items: center;
  gap: 10px;
  margin: 0;
  color: #333;
  font-size: 1.5rem;
}

.badge {
  background-color: #219e9a;
  color: white;
  border-radius: 50%;
  width: 24px;
  height: 24px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 0.8rem;
}

.refresh-btn {
  background: none;
  border: none;
  cursor: pointer;
  padding: 5px;
  border-radius: 50%;
  transition: all 0.3s ease;
}

.refresh-btn:hover {
  background-color: #f0f0f0;
  transform: rotate(360deg);
}

/* Friends Grid */
.friends-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
}

.friend-card {
  background: white;
  border-radius: 10px;
  padding: 15px;
  display: flex;
  align-items: center;
  gap: 15px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.friend-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.friend-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 4px;
  height: 100%;
  background-color: #219e9a;
  border-radius: 10px 0 0 10px;
}

.friend-avatar-container {
  position: relative;
  flex-shrink: 0;
}

.friend-avatar {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;
  border: 3px solid #e0e0e0;
  transition: all 0.3s ease;
}

.avatar-hover {
  transform: scale(1.1);
  border-color: #219e9a;
}

.online-indicator {
  position: absolute;
  bottom: 5px;
  right: 5px;
  width: 12px;
  height: 12px;
  background-color: #4CAF50;
  border-radius: 50%;
  border: 2px solid white;
}

.friend-info {
  flex: 1;
  min-width: 0;
}

.friend-info h3 {
  margin: 0;
  font-size: 1rem;
  color: #333;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.friend-status {
  margin: 5px 0 0;
  font-size: 0.8rem;
  color: #666;
}

.friend-actions {
  display: flex;
  gap: 5px;
}

.action-btn {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  border: none;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
}

.action-btn:hover {
  transform: scale(1.1);
}

.chat-btn {
  background-color: #219e9a;
}

.profile-btn {
  background-color: #607d8b;
}

.accept-btn {
  background-color: #4CAF50;
}

.reject-btn {
  background-color: #f44336;
}

/* Requests List */
.requests-list {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
}

.request-card {
  background: white;
  border-radius: 10px;
  padding: 15px;
  display: flex;
  align-items: center;
  gap: 15px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
  transition: all 0.3s ease;
  position: relative;
  overflow: hidden;
}

.request-card::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  width: 4px;
  height: 100%;
  background-color: #FF9800;
  border-radius: 10px 0 0 10px;
}

.request-avatar {
  width: 50px;
  height: 50px;
  border-radius: 50%;
  object-fit: cover;
  border: 2px solid #FF9800;
}

.request-date {
  margin: 5px 0 0;
  font-size: 0.8rem;
  color: #666;
}

.request-actions {
  display: flex;
  gap: 5px;
  margin-left: auto;
}

/* Empty States */
.empty-state {
  text-align: center;
  padding: 30px;
  background: #f9f9f9;
  border-radius: 10px;
}

.empty-illustration {
  width: 150px;
  height: 150px;
  margin-bottom: 20px;
  opacity: 0.7;
}

.empty-state p {
  color: #666;
  margin-bottom: 20px;
}

.find-friends-btn {
  background-color: #219e9a;
  color: white;
  border: none;
  padding: 10px 20px;
  border-radius: 5px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.find-friends-btn:hover {
  background-color: #1a7f7b;
  transform: translateY(-2px);
}

/* Loading Overlay */
.loading-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background: rgba(255, 255, 255, 0.8);
  display: flex;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

.spinner {
  width: 50px;
  height: 50px;
  border: 5px solid #f3f3f3;
  border-top: 5px solid #219e9a;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

/* Responsive Design */
@media (max-width: 768px) {
  .friends-grid, .requests-list {
    grid-template-columns: 1fr;
  }

  .section-title {
    font-size: 1.2rem;
  }
}
</style>