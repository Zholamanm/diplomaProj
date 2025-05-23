<template>
  <div class="online-indicator" :class="status">
    <span class="tooltip">{{ statusText }}</span>
  </div>
</template>

<script>
export default {
  props: {
    user: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      isOnline: this.user.is_online,
      lastSeen: this.user.last_seen_at
    };
  },
  computed: {
    status() {
      if (this.isOnline) return 'online';
      if (!this.lastSeen) return 'unknown';

      const minutesAgo = Math.floor((new Date() - new Date(this.lastSeen)) / (1000 * 60));
      return minutesAgo < 5 ? 'recently-online' : 'offline';
    },
    statusText() {
      switch(this.status) {
        case 'online': return 'Online now';
        case 'recently-online': return 'Recently online';
        case 'offline': return 'Offline';
        default: return 'Status unknown';
      }
    }
  },
  mounted() {
    // Listen for real-time updates
    window.Echo.join('presence-online')
        .here(users => {
          this.isOnline = users.some(u => u.id === this.user.id);
        })
        .joining(user => {
          if (user.id === this.user.id) this.isOnline = true;
        })
        .leaving(user => {
          if (user.id === this.user.id) this.isOnline = false;
        });
  }
}
</script>

<style scoped>
.online-indicator {
  display: inline-block;
  width: 10px;
  height: 10px;
  border-radius: 50%;
  position: relative;
}

.online-indicator.online {
  background-color: #4CAF50;
}

.online-indicator.recently-online {
  background-color: #FFC107;
}

.online-indicator.offline {
  background-color: #F44336;
}

.online-indicator.unknown {
  background-color: #9E9E9E;
}

.tooltip {
  visibility: hidden;
  width: 120px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  margin-left: -60px;
  opacity: 0;
  transition: opacity 0.3s;
}

.online-indicator:hover .tooltip {
  visibility: visible;
  opacity: 1;
}
</style>