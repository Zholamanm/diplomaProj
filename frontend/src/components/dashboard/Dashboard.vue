<template>
  <div>
    <DashboardNavbar @logout="handleLogout" />
    <div class="container">
      <div class="row">
        <div class="col-md-3">
          <DashboardSidebar />
        </div>
        <div class="col-md-9">
          <div class="card mb-4">
            <div class="card-body">
              <h5 class="card-title">Welcome, {{ user.name }}!</h5>
              <p class="card-text">
                This is your dashboard where you can manage your account and access various features.
              </p>
            </div>
          </div>

          <!-- Statistics Section -->
          <div class="row">
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Profile Views</h5>
                  <p class="card-text display-4">{{ user.profileViews ? user.profileViews : 0}}</p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Messages</h5>
                  <p class="card-text display-4">{{ user.messagesCount ? user.messagesCount : 0 }}</p>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 mb-4">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Notifications</h5>
                  <p class="card-text display-4">{{ user.notificationsCount ? user.notificationsCount : 0 }}</p>
                </div>
              </div>
            </div>
          </div>

          
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import DashboardNavbar from '@/components/common/DasboardNavbar.vue';
import DashboardSidebar from '@/components/dashboard/DashboardSidebar.vue';

export default {
  name: 'DashboardPage',
  components: {
    DashboardNavbar,
    DashboardSidebar
  },
  data() {
    return {
      user: {
        name: '',
        profileViews: 0,
        messagesCount: 0,
        notificationsCount: 0,
        recentActivities: [],
      },
      quickLinks: [
        { name: 'Manage Account', url: '/account' },
        { name: 'View Messages', url: '/messages' },
        { name: 'Notifications', url: '/notifications' },
      ],
    };
  },
  created() {
    this.fetchUser();
  },
  methods: {
    fetchUser() {
      axios
        .get('http://localhost:8000/api/user', {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then((response) => {
          this.user = response.data;
        })
        .catch((error) => {
          console.error('Error fetching user data:', error);
          this.$router.push('/login');
        });
    },
    logout() {
      axios
        .post('http://localhost:8000/api/logout', {}, {
          headers: {
            Authorization: `Bearer ${localStorage.getItem('token')}`,
          },
        })
        .then(() => {
          localStorage.removeItem('token');
          this.$router.push('/login');
        })
        .catch((error) => {
          console.error('Error logging out:', error);
          this.$router.push('/login');
        });
    },
    handleLogout() {
      this.logout();
    }
  }
};
</script>

<style scoped>
.container, .container-lg, .container-md, .container-sm, .container-xl {
        max-width: 1342px;
    }

.card {
  margin-top: 20px;
}

.card-title {
  font-size: 1.2rem;
  font-weight: bold;
}

.display-4 {
  font-size: 2.5rem;
}

.btn-block {
  display: block;
  width: 100%;
}

.bg-primary, .bg-success, .bg-warning {
  color: #fff;
}
</style>
