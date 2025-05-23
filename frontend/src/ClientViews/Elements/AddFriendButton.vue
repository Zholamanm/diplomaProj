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
      status: 'none' // none, pending, friends
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
      client.get(`/api/client/friendship-status/${this.$route.params.id}`).then(response => {
        this.status = response.data.data.status;
      });
    },
    handleFriendAction() {
      if (!this.status) {
        clientApi.sendRequest(this.$route.params.id).then(() => {
          this.status = 'pending';
        });
      } else if (this.status === 'friends') {
        clientApi.removeFriend(this.$route.params.id).then(() => {
          this.status = 'none';
        });
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
}

.friend-btn.none {
  background: #219e9a;
  color: white;
}

.friend-btn.pending {
  background: #FFC107;
  color: black;
}

.friend-btn.friends {
  background: #4CAF50;
  color: white;
}
</style>