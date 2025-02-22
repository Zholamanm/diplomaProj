<template>
  <div v-if="modalVisible" id="popup-modal" class="modal-overlay" tabindex="-1">
    <!-- Modal Content -->
    <div class="modal-container">
      <div class="modal-box">

        <!-- Modal Header -->
        <div class="modal-header">
          <h3 v-if="title" class="modal-title">
            {{ title }}
          </h3>
          <button type="button" class="modal-close" @click="hideModal">
            <svg class="close-icon" aria-hidden="true" fill="none" viewBox="0 0 14 14" width="14" height="14">
              <path d="M1 1l6 6m0 0l6 6M7 7l6-6M7 7L1 13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="sr-only">Close modal</span>
          </button>
        </div>

        <!-- Modal Body -->
        <div class="modal-body" :class="text_align">
          <slot></slot>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "AdminModal",
  props: {
    title: {
      type: String,
      default: null
    },
    text_align: {
      type: String,
      default: 'text-center'
    }
  },
  data() {
    return {
      modalVisible: false
    };
  },
  methods: {
    showModal() {
      this.modalVisible = true;
    },
    hideModal() {
      this.modalVisible = false;
      this.$emit('closed');
    }
  }
};
</script>

<style scoped>
/* === Modal Overlay === */
.modal-overlay {
  position: fixed;
  inset: 0;
  z-index: 50;
  display: flex;
  align-items: center;
  justify-content: center;
  background-color: rgba(0, 0, 0, 0.5); /* Dark overlay */
}

/* === Modal Container === */
.modal-container {
  width: 100%;
  max-width: 400px; /* Adjust width as needed */
  padding: 16px;
}

/* === Modal Box === */
.modal-box {
  background-color: white;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
  overflow: hidden;
}

/* === Modal Header === */
.modal-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 16px;
  border-bottom: 1px solid #e5e7eb;
}

/* Title */
.modal-title {
  font-size: 1.125rem; /* 18px */
  font-weight: 600;
  color: #1f2937; /* Dark gray */
}

/* Close Button */
.modal-close {
  background: transparent;
  border: none;
  cursor: pointer;
  padding: 8px;
  border-radius: 50%;
  transition: background 0.2s;
}

.modal-close:hover {
  background-color: #e5e7eb; /* Light gray on hover */
}

/* Close Icon */
.close-icon {
  width: 16px;
  height: 16px;
  stroke: #6b7280; /* Gray */
}

/* === Modal Body === */
.modal-body {
  padding: 16px;
  text-align: center;
}
</style>
