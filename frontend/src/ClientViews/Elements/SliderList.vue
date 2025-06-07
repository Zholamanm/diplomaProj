<template>
  <section class="slider-section" v-if="activeSliders.length > 0">
    <div class="slider-container">
      <div class="slider-track" :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
        <div
            class="slide"
            v-for="(slider) in activeSliders"
            :key="slider.id"
            :style="{ backgroundImage: `url(https://diplomaproj.byethost3.com/storage/${slider.cover_image})` }"
        >
          <!-- You can add slider content here if needed -->
        </div>
      </div>

      <button class="slider-nav prev" @click="prevSlide">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
      </button>
      <button class="slider-nav next" @click="nextSlide">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
        </svg>
      </button>

      <div class="slider-dots">
        <button
            v-for="(slider, index) in activeSliders"
            :key="'dot-' + slider.id"
            :class="{ active: currentIndex === index }"
            @click="goToSlide(index)"
        ></button>
      </div>
    </div>
  </section>
</template>

<script>
export default {
  name: 'SliderList',
  data() {
    return {
      currentIndex: 0,
      interval: null
    }
  },
  computed: {
    sliders() {
      return this.$store.state.common.data?.sliders || [];
    },
    activeSliders() {
      const now = new Date();
      return this.sliders.filter(slider => {
        // Check if slider is enabled and within date range
        return slider.enabled === 1 &&
            new Date(slider.start_date) <= now &&
            new Date(slider.end_date) >= now;
      });
    }
  },
  methods: {
    nextSlide() {
      this.currentIndex = (this.currentIndex + 1) % this.activeSliders.length;
      this.resetAutoSlide();
    },
    prevSlide() {
      this.currentIndex = (this.currentIndex - 1 + this.activeSliders.length) % this.activeSliders.length;
      this.resetAutoSlide();
    },
    goToSlide(index) {
      this.currentIndex = index;
      this.resetAutoSlide();
    },
    startAutoSlide() {
      this.interval = setInterval(() => {
        this.nextSlide();
      }, 5000);
    },
    resetAutoSlide() {
      clearInterval(this.interval);
      this.startAutoSlide();
    }
  },
  mounted() {
    if (this.activeSliders.length > 1) {
      this.startAutoSlide();
    }
  },
  beforeUnmount() {
    clearInterval(this.interval);
  }
}
</script>

<style scoped>
.slider-section {
  width: 100%;
}

.slider-container {
  position: relative;
  width: 100%;
  height: 500px;
  overflow: hidden;
  border-radius: 10px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
}

.slider-track {
  display: flex;
  height: 100%;
  transition: transform 0.5s ease;
}

.slide {
  min-width: 100%;
  height: 100%;
  background-size: cover;
  background-position: center;
  background-repeat: no-repeat;
}

.slider-nav {
  position: absolute;
  top: 50%;
  transform: translateY(-50%);
  width: 50px;
  height: 50px;
  background: rgba(255,255,255,0.7);
  border: none;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  z-index: 10;
}

.slider-nav:hover {
  background: rgba(255,255,255,0.9);
}

.slider-nav svg {
  width: 24px;
  height: 24px;
  stroke-width: 2;
}

.prev {
  left: 20px;
}

.next {
  right: 20px;
}

.slider-dots {
  position: absolute;
  bottom: 20px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  gap: 10px;
  z-index: 10;
}

.slider-dots button {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  border: none;
  background: rgba(255,255,255,0.5);
  cursor: pointer;
  transition: all 0.3s ease;
}

.slider-dots button.active {
  background: white;
  transform: scale(1.2);
}

@media (max-width: 768px) {
  .slider-container {
    height: 300px;
  }

  .slider-nav {
    width: 40px;
    height: 40px;
  }
}
</style>