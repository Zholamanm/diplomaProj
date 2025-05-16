<template>
  <div class="coffee-shop mt-5">
    <h1 class="carousel-title">Discover Nearby Coffee Shops</h1>
    <p class="carousel-subtitle">Find your perfect brew near you</p>

    <div class="carousel mt-4" mask style="justify-self: center;"
         :style="{'--items': shops ? shops.length : 0, '--carousel-width': shops ? `calc(${shops.length} * (150px + 20px))` : '0px'}">
      <article v-for="(item, index) in shops" :key="index" class="shop-card" @mouseenter="hoverCard(index)" @mouseleave="unhoverCard(index)">
        <div class="card-header">
          <div class="rating-badge" v-if="item.properties.rating">
            ★ {{ item.properties.rating.toFixed(1) }}
          </div>
          <h2>{{ item.properties.address_line1 }}</h2>
          <div class="location-pin">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#219e9a" width="18px" height="18px">
              <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
            </svg>
            <span>{{ item.properties.city }}, {{ item.properties.country }}</span>
          </div>
        </div>

        <div class="card-body">
          <div class="info-section">
            <div class="info-item">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#219e9a" width="16px" height="16px">
                <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
              </svg>
              <span>{{ item.properties.street }} {{ item.properties.housenumber }}</span>
            </div>

            <div class="info-item" v-if="item.properties.contact">
              <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#219e9a" width="16px" height="16px">
                <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
              </svg>
              <span>{{ item.properties.contact.phone }}</span>
            </div>
          </div>

          <div class="features" v-if="item.properties.features">
            <span class="feature-tag" v-for="(feature, i) in item.properties.features" :key="i">
              {{ feature }}
            </span>
          </div>
        </div>

        <div class="card-footer">
          <a :href="item.properties.website || '#'" class="visit-btn" target="_blank">
            Visit Website
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="14px" height="14px">
              <path d="M19 19H5V5h7V3H5c-1.11 0-2 .9-2 2v14c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2v-7h-2v7zM14 3v2h3.59l-9.83 9.83 1.41 1.41L19 6.41V10h2V3h-7z"/>
            </svg>
          </a>
          <button class="directions-btn" @click="getDirections(item)">
            Get Directions
          </button>
        </div>
      </article>
    </div>
  </div>
</template>

<script>
import '../../assets/carousel.css'

export default {
  name: 'CoffeeShops',
  data() {
    return {
      errors: {},
      hoveredIndex: null
    };
  },
  props: {
    shops: {
      type: Array,
      default: null
    }
  },
  methods: {
    hoverCard(index) {
      this.hoveredIndex = index;
    },
    unhoverCard(index) {
      if (this.hoveredIndex === index) {
        this.hoveredIndex = null;
      }
    },
    getDirections(shop) {
      // Implement directions functionality
      console.log('Getting directions to:', shop.properties.address_line1);
    }
  }
};
</script>

<style scoped>
.coffee-shop {
  padding: 2rem 0;
}

.carousel-title {
  text-align: center;
  font-size: 2.2rem;
  color: #2a3f54;
  margin-bottom: 0.5rem;
  font-weight: 700;
  font-family: 'Roboto Slab', serif;
}

.carousel-subtitle {
  text-align: center;
  font-size: 1rem;
  color: #6c757d;
  margin-bottom: 2rem;
  font-weight: 300;
}

.coffee-shop .carousel {
  --items: 7;
  --carousel-duration: 40s;
  --carousel-width: min(90vw, 1400px);
  --carousel-item-width: 240px;
  --carousel-item-height: 340px;
  --carousel-item-gap: 20px;
  --clr-primary: #219e9a;
  --clr-secondary: #2a3f54;
  --clr-accent: #ff7b54;

  position: relative;
  width: var(--carousel-width);
  height: var(--carousel-item-height);
  overflow: clip;
  margin: 0 auto;
}

.coffee-shop .carousel[mask] {
  mask-image: linear-gradient(to right, transparent, black 5% 95%, transparent);
}

.shop-card {
  position: absolute;
  top: 20px;
  left: calc(100% + var(--carousel-item-gap));
  width: var(--carousel-item-width);
  height: 300px;
  display: flex;
  flex-direction: column;
  gap: 0.75rem;
  border: 1px solid rgba(33, 158, 154, 0.3);
  padding: 1.2rem;
  border-radius: 12px;
  background: white;
  color: var(--clr-secondary);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
  transition: all 0.3s ease;
  will-change: transform;
  animation-name: marquee;
  animation-duration: var(--carousel-duration);
  animation-timing-function: linear;
  animation-iteration-count: infinite;
  animation-delay: calc(var(--carousel-duration) / var(--items) * var(--i) * -1);
}

.shop-card:hover {
  transform: translateY(-5px) scale(1.02);
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
  border-color: var(--clr-primary);
}

.card-header {
  position: relative;
  padding-bottom: 0.5rem;
  border-bottom: 1px solid rgba(33, 158, 154, 0.1);
}

.rating-badge {
  position: absolute;
  top: -0.5rem;
  right: -0.5rem;
  background: var(--clr-accent);
  color: white;
  padding: 0.25rem 0.5rem;
  border-radius: 12px;
  font-size: 0.8rem;
  font-weight: bold;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.card-header h2 {
  font-size: 1.1rem;
  font-weight: 600;
  margin: 0.5rem 0 0.75rem;
  color: var(--clr-secondary);
}

.location-pin {
  display: flex;
  align-items: center;
  gap: 0.3rem;
  font-size: 0.85rem;
  color: #6c757d;
}

.card-body {
  flex: 1;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.info-section {
  display: flex;
  flex-direction: column;
  gap: 0.7rem;
}

.info-item {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  font-size: 0.85rem;
}

.features {
  display: flex;
  flex-wrap: wrap;
  gap: 0.4rem;
  margin-top: auto;
}

.feature-tag {
  background: rgba(33, 158, 154, 0.1);
  color: var(--clr-primary);
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.7rem;
}

.card-footer {
  display: flex;
  gap: 0.5rem;
}

.visit-btn, .directions-btn {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.3rem;
  padding: 0.5rem;
  border-radius: 6px;
  font-size: 0.8rem;
  cursor: pointer;
  transition: all 0.2s ease;
}

.visit-btn {
  background: white;
  color: var(--clr-primary);
  border: 1px solid var(--clr-primary);
  text-decoration: none;
}

.visit-btn:hover {
  background: var(--clr-primary);
  color: white;
}

.directions-btn {
  background: var(--clr-primary);
  color: white;
  border: 1px solid var(--clr-primary);
}

.directions-btn:hover {
  background: #1a7f7b;
}

/* Animation delays for each card */
.coffee-shop .carousel > article:nth-child(1) { --i: 0; }
.coffee-shop .carousel > article:nth-child(2) { --i: 1; }
.coffee-shop .carousel > article:nth-child(3) { --i: 2; }
.coffee-shop .carousel > article:nth-child(4) { --i: 3; }
.coffee-shop .carousel > article:nth-child(5) { --i: 4; }
.coffee-shop .carousel > article:nth-child(6) { --i: 5; }
.coffee-shop .carousel > article:nth-child(7) { --i: 6; }
.coffee-shop .carousel > article:nth-child(8) { --i: 7; }

@keyframes marquee {
  100% {
    transform: translateX(calc(var(--items) * (var(--carousel-item-width) + var(--carousel-item-gap)) * -1));
  }
}

/* Responsive adjustments */
@media (max-width: 768px) {
  .carousel-title {
    font-size: 1.8rem;
  }

  .coffee-shop .carousel {
    --carousel-item-width: 220px;
    --carousel-item-height: 320px;
  }
}
</style>