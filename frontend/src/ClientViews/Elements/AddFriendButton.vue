<template>
  <button @click="handleFriendAction" :class="['friend-btn', status]">
    {{ buttonText }}
  </button>
</template>

<script>
import client from "@/api";
import clientApi from "@/api/ClientApi";

export default {
  data() {
    return {
      status: 'none-status' // none, pending, friends
    }
  },
  computed: {
    buttonText() {
      switch(this.status) {
        case 'pending': return 'Pending';
        case 'friends': return 'Friends';
        default: return 'Add Friend';
      }
    }
  },
  methods: {
    checkStatus() {
      client.get(`/api/client/friendship-status/${this.$route.params.id}`)
          .then(response => {
            this.status = response.data.data.status || 'none-status';
          })
          .catch(error => {
            console.error('Error checking friend status:', error);
          });
    },
    async handleFriendAction() {
      try {
        if (this.status === 'none-status') {
          await clientApi.sendRequest(this.$route.params.id);
          this.status = 'pending';
        } else if (this.status === 'friends') {
          await clientApi.removeFriend(this.$route.params.id);
          this.status = 'none-status';
        }
      } catch (error) {
        console.error('Error handling friend action:', error);
        if (error.response && error.response.data.error) {
          alert(error.response.data.error);
        }
      }
    }
  },
  created() {
    if (this.$store.state.auth.authorized) {
      this.checkStatus();
    }
  }
}
</script>

<style scoped>
.friend-btn {
  padding: 5px 10px;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

.friend-btn.none-status {
  background: #219e9a;
  color: white;
}

.friend-btn.none-status:hover {
  background: #1a7f7b;
}

.friend-btn.pending {
  background: #FFC107;
  color: black;
}

.friend-btn.pending:hover {
  background: #e0a800;
}

.friend-btn.friends {
  background: #4CAF50;
  color: white;
}

.friend-btn.friends:hover {
  background: #3d8b40;
}
</style>