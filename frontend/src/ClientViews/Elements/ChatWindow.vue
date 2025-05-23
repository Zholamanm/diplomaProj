<template>
  <div class="chat-container">
    <div class="chat-header">
      <h3>Chat with {{ receiver.name }}</h3>
    </div>
    <div class="chat-messages" ref="messagesContainer">
      <div v-for="message in messages" :key="message.id"
           :class="['message', message.sender_id === $store.state.user.user.id ? 'sent' : 'received']">
        <div class="message-content">
          <p>{{ message.message }}</p>
          <span class="message-time">{{ formatTime(message.created_at) }}</span>
        </div>
      </div>
    </div>
    <div class="chat-input">
      <input v-model="newMessage" @keyup.enter="sendMessage" placeholder="Type your message...">
      <button @click="sendMessage">Send</button>
    </div>
  </div>
</template>

<script>
import client from "@/api";

export default {
  props: ['userId'],
  data() {
    return {
      messages: [],
      newMessage: '',
      receiver: {},
      channel: null
    }
  },
  methods: {
    fetchMessages() {
      client.get(`/api/client/chat/${this.$route.params.userId}`).then(response => {
        this.receiver = response.data.user;
        this.messages = response.data.messages;
        this.scrollToBottom();
      });
    },
    sendMessage() {
      if (this.newMessage.trim() === '') return;
      this.messages.push({
        sender_id: this.$store.state.user.user.id,
        receiver_id: this.receiver.id,
        message: this.newMessage,
        read: 0,
        created_at: new Date(),
        updated_at: new Date()
    })
      let message = this.newMessage
      this.newMessage = '';
      client.post(`/api/client/chat/${this.$route.params.userId}/send`, {
        message: message
      }).then(() => {
        this.fetchMessages()
      });
    },
    formatTime(time) {
      return new Date(time).toLocaleTimeString([], {hour: '2-digit', minute: '2-digit'});
    },
    scrollToBottom() {
      this.$nextTick(() => {
        const container = this.$refs.messagesContainer;
        container.scrollTop = container.scrollHeight;
      });
    }
  },
  mounted() {
    this.fetchMessages();

    // Setup Pusher channel
    console.log(this.$store.state.user);
    const ids = [this.$store.state.user.user.id, this.$route.params.userId].sort((a, b) => a - b);
    this.channel = window.Echo.private(`chat.${ids[0]}.${ids[1]}`);

    this.channel.listen('NewChatMessage', (data) => {
      this.messages.push(data.message);
      this.scrollToBottom();
    });
  },
  beforeUnmount() {
    if (this.channel) {
      this.channel.stopListening('NewChatMessage');
    }
  }
}
</script>

<style scoped>
.chat-container {
  display: flex;
  flex-direction: column;
  height: 80vh;
  max-width: 600px;
  margin: 0 auto;
  border: 1px solid #ddd;
  border-radius: 8px;
  overflow: hidden;
}

.chat-header {
  padding: 15px;
  background: #219e9a;
  color: white;
}

.chat-messages {
  flex: 1;
  padding: 15px;
  overflow-y: auto;
  background: #f9f9f9;
}

.message {
  margin-bottom: 15px;
  display: flex;
}

.message.sent {
  justify-content: flex-end;
}

.message.received {
  justify-content: flex-start;
}

.message-content {
  max-width: 70%;
  padding: 10px 15px;
  border-radius: 18px;
  position: relative;
}

.sent .message-content {
  background: #219e9a;
  color: white;
}

.received .message-content {
  background: white;
  border: 1px solid #ddd;
}

.message-time {
  font-size: 0.7rem;
  opacity: 0.8;
  display: block;
  text-align: right;
  margin-top: 5px;
}

.chat-input {
  display: flex;
  padding: 10px;
  background: white;
  border-top: 1px solid #ddd;
}

.chat-input input {
  flex: 1;
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 20px;
  outline: none;
}

.chat-input button {
  margin-left: 10px;
  padding: 10px 15px;
  background: #219e9a;
  color: white;
  border: none;
  border-radius: 20px;
  cursor: pointer;
}
</style>