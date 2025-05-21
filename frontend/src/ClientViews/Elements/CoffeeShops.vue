<template>
  <div style="display: flex; gap: 60px">
    <div class="location-picker-wrapper" style="width: 50%">
      <div class="location-picker-container">
        <div class="location-card">
          <div v-if="isLoading" class="loading-state">
            <div class="loading-animation">
              <div class="loading-book"></div>
              <div class="loading-dots">
                <span></span>
                <span></span>
                <span></span>
              </div>
            </div>
            <p>Finding available locations...</p>
          </div>

          <div v-else-if="filteredLocations.length === 0" class="empty-state">
            <div class="empty-animation">
              <svg class="empty-icon" viewBox="0 0 24 24">
                <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
              </svg>
            </div>
            <p>No available locations found</p>
            <button class="refresh-btn" @click="fetchAvailableLocations">
              <svg viewBox="0 0 24 24">
                <path d="M17.65 6.35C16.2 4.9 14.21 4 12 4c-4.42 0-7.99 3.58-7.99 8s3.57 8 7.99 8c3.73 0 6.84-2.55 7.73-6h-2.08c-.82 2.33-3.04 4-5.65 4-3.31 0-6-2.69-6-6s2.69-6 6-6c1.66 0 3.14.69 4.22 1.78L13 11h7V4l-2.35 2.35z"/>
              </svg>
              Try Again
            </button>
          </div>

          <div v-else class="map-container">
            <l-map
                ref="map"
                :zoom="zoom"
                :center="center"
                :options="{ zoomControl: false }"
                @ready="mapReady"
            >
              <l-tile-layer
                  url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                  :options="{ attribution: '&copy; <a href=\'https://www.openstreetmap.org/copyright\'>OpenStreetMap</a> contributors' }"
              />

              <l-marker
                  v-for="location in filteredLocations"
                  :key="location.id"
                  :lat-lng="[location.lat, location.lng]"
                  :icon="locationIcon(location.quantity)"
              >
                <l-popup class="location-popup">
                  <div class="popup-content">
                    <h3>{{ location.name }}</h3>
                    <p class="popup-address">{{ location.address }}</p>

                    <div class="availability-badge" :class="{
                    'high': location.quantity < 500,
                    'medium': location.quantity > 500 && location.quantity <= 2500,
                    'low': location.quantity > 2500
                  }">
                      {{ location.quantity }} m
                    </div>

                    <button
                        class="select-btn"
                        @click="selectLocation(location)"
                    >
                      Select This Location
                      <svg viewBox="0 0 24 24">
                        <path d="M12 4l-1.41 1.41L16.17 11H4v2h12.17l-5.58 5.59L12 20l8-8z"/>
                      </svg>
                    </button>
                  </div>
                </l-popup>
              </l-marker>
            </l-map>

            <div class="location-list">
              <div
                  v-for="location in filteredLocations"
                  :key="location.id"
                  class="location-item"
                  @click="flyToLocation(location)"
                  :class="{ 'highlighted': highlightedLocation === location.id }"
              >
                <div class="location-marker" :style="{ backgroundColor: getMarkerColor(location.quantity) }"></div>
                <div class="location-info">
                  <h4>{{ location.name }}</h4>
                  <p>{{ location.address }}</p>
                </div>
                <div class="location-availability">
                <span :class="{
                    'high': location.quantity < 500,
                    'medium': location.quantity > 500 && location.quantity <= 2500,
                    'low': location.quantity > 2500
                  }">
                  {{ location.quantity }} meters away
                </span>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>
    <div style="width: 50%" class="coffee-shop mt-5">
      <h1 class="carousel-title">Discover Nearby Coffee Shops</h1>
      <p class="carousel-subtitle">Find your perfect brew near you</p>

      <div class="carousel mt-4" mask style="justify-self: center;"
           :style="{'--items': shops ? shops.length : 0, '--carousel-width': shops ? `calc(${shops.length} * (100px + 20px))` : '0px'}">
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
  </div>
</template>

<script>
import '../../assets/carousel.css'
import L from "leaflet";
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";

export default {
  name: 'CoffeeShops',
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LPopup,
  },
  data() {
    return {
      errors: {},
      hoveredIndex: null,
      zoom: 12,
      center: [51.1657, 71.4506],
      locations: [],
      filteredLocations: [],
      isLoading: true,
      searchQuery: '',
      highlightedLocation: null,
      map: null
    };
  },
  props: {
    shops: {
      type: Array,
      default: null
    },
    borrowLoc: {
      default: null
    }
  },
  watch: {
    filteredLocations() {
      this.centerOnLocations();
    }
  },
  methods: {
    fetchAvailableLocations() {
      this.isLoading = true;
      console.log(this.shops);
      try {
        this.locations = this.shops
            .map(loc => ({
              name: loc.properties.address_line1,
              address: loc.properties.address_line2,
              lat: loc.properties.lat,
              lng: loc.properties.lon,
              quantity: loc.properties.distance
            }));

        this.filteredLocations = [...this.locations];

        // Adjust map view if we have locations
        if (this.locations.length > 0) {
          this.centerOnLocations();
        }
      } catch (err) {
        console.error("Error fetching locations:", err);
      } finally {
        this.isLoading = false;
      }
    },
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
    },
    filterLocations() {
      if (!this.searchQuery) {
        this.filteredLocations = [...this.locations];
        return;
      }

      const query = this.searchQuery.toLowerCase();
      this.filteredLocations = this.locations.filter(loc =>
          loc.name.toLowerCase().includes(query) ||
          loc.address.toLowerCase().includes(query)
      );
    },

    selectLocation(location) {
      this.$router.push({
        name: "BorrowBook",
        params: {
          id: this.$route.params.id,
          locId: location.id
        }
      });
    },

    centerOnLocations() {
      if (!this.map || this.filteredLocations.length === 0) return;

      const bounds = L.latLngBounds(
          this.filteredLocations.map(loc => [loc.lat, loc.lng])
      );
      this.map.flyToBounds(bounds, { padding: [50, 50] });
    },

    flyToLocation(location) {
      this.highlightedLocation = location.id;
      this.map.flyTo([location.lat, location.lng], 15);

      setTimeout(() => {
        this.highlightedLocation = null;
      }, 2000);
    },

    mapReady() {
      console.log(this.$refs.map.leafletObject);
      this.map = this.$refs.map.leafletObject;
      if (this.filteredLocations.length > 0) {
        this.centerOnLocations();
      }
    },

    locationIcon(quantity) {
      return L.divIcon({
        html: `
          <div class="custom-marker" style="width: 30px;
  height: 30px;
  background: ${this.getMarkerColor(quantity)};
  border-radius: 25px; align-content: center;">
            <div class="marker-pin" style="background-color: ${this.getMarkerColor(quantity)}"></div>
            <div class="marker-label">${quantity}</div>
          </div>
        `,
        className: 'custom-marker-container',
        iconSize: [30, 42],
        iconAnchor: [15, 42]
      });
    },

    getMarkerColor(quantity) {
      if (quantity < 500) return '#4CAF50'; // Green for high availability
      if (quantity > 500 && quantity <= 2500) return '#FFC107'; // Yellow for medium
      return '#F44336'; // Red for low
    }
  },
  mounted() {
    this.fetchAvailableLocations()
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
.location-picker-wrapper {
  min-height: 100vh;
}

.location-picker-container {
  max-width: 1200px;
  margin: 0 auto;
  padding: 0 1rem;
}

.location-card {
  background: white;
  border-radius: 12px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  overflow: hidden;
}

.location-header {
  padding: 2rem;
  background: linear-gradient(to right, #2196F3, #03A9F4);
  color: white;
}

.location-title {
  font-size: 2rem;
  margin-bottom: 0.5rem;
  font-weight: 600;
}

.location-subtitle {
  opacity: 0.9;
  margin-bottom: 1.5rem;
}

.search-box {
  position: relative;
  max-width: 500px;
}

.search-box input {
  width: 100%;
  padding: 0.75rem 1rem 0.75rem 2.5rem;
  border-radius: 50px;
  border: none;
  font-size: 1rem;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

.search-icon {
  position: absolute;
  left: 1rem;
  top: 50%;
  transform: translateY(-50%);
  width: 1.2rem;
  height: 1.2rem;
  fill: #666;
}

/* Loading State */
.loading-state {
  padding: 3rem;
  text-align: center;
}

.loading-animation {
  margin-bottom: 1.5rem;
}

.loading-book {
  width: 60px;
  height: 80px;
  margin: 0 auto;
  background: #f0f0f0;
  border-radius: 4px;
  position: relative;
  animation: bookPulse 1.5s infinite ease-in-out;
}

.loading-dots {
  display: flex;
  justify-content: center;
  margin-top: 1rem;
}

.loading-dots span {
  width: 10px;
  height: 10px;
  margin: 0 5px;
  background: #2196F3;
  border-radius: 50%;
  animation: bounce 1.4s infinite ease-in-out;
}

.loading-dots span:nth-child(2) {
  animation-delay: 0.2s;
}

.loading-dots span:nth-child(3) {
  animation-delay: 0.4s;
}

@keyframes bookPulse {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.05); }
}

@keyframes bounce {
  0%, 80%, 100% { transform: translateY(0); }
  40% { transform: translateY(-15px); }
}

/* Empty State */
.empty-state {
  padding: 3rem;
  text-align: center;
}

.empty-animation {
  margin-bottom: 1.5rem;
}

.empty-icon {
  width: 60px;
  height: 60px;
  fill: #F44336;
  animation: shake 0.8s cubic-bezier(.36,.07,.19,.97) both;
}

.refresh-btn {
  margin-top: 1rem;
  padding: 0.75rem 1.5rem;
  background: #2196F3;
  color: white;
  border: none;
  border-radius: 50px;
  font-size: 1rem;
  display: inline-flex;
  align-items: center;
  gap: 0.5rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.refresh-btn:hover {
  background: #0d8af3;
  transform: translateY(-2px);
}

.refresh-btn svg {
  width: 18px;
  height: 18px;
  fill: white;
}

@keyframes shake {
  10%, 90% { transform: translate3d(-1px, 0, 0); }
  20%, 80% { transform: translate3d(2px, 0, 0); }
  30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
  40%, 60% { transform: translate3d(4px, 0, 0); }
}

/* Map Container */
.map-container {
  display: flex;
  flex-direction: column;
  height: 600px;
}

@media (min-width: 992px) {
  .map-container {
    flex-direction: row;
  }
}

/* Map Styles */
.location-popup {
  min-width: 250px;
}

.popup-content {
  padding: 0.5rem;
}

.popup-content h3 {
  margin-top: 0;
  color: #2196F3;
}

.popup-address {
  color: #666;
  margin: 0.5rem 0;
}

.availability-badge {
  display: inline-block;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-size: 0.8rem;
  font-weight: 500;
  margin-bottom: 0.5rem;
}

.availability-badge.high {
  background: #E8F5E9;
  color: #4CAF50;
}

.availability-badge.medium {
  background: #FFF8E1;
  color: #FFA000;
}

.availability-badge.low {
  background: #FFEBEE;
  color: #F44336;
}

.select-btn {
  width: 100%;
  padding: 0.5rem;
  background: #2196F3;
  color: white;
  border: none;
  border-radius: 4px;
  font-size: 0.9rem;
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 0.5rem;
  cursor: pointer;
  transition: all 0.3s ease;
}

.select-btn:hover {
  background: #0d8af3;
}

.select-btn svg {
  width: 16px;
  height: 16px;
  fill: white;
}

/* Location List */
.location-list {
  flex: 0 0 300px;
  overflow-y: auto;
  border-top: 1px solid #eee;
}

@media (min-width: 992px) {
  .location-list {
    border-top: none;
    border-left: 1px solid #eee;
  }
}

.location-item {
  padding: 1rem;
  border-bottom: 1px solid #eee;
  cursor: pointer;
  transition: all 0.3s ease;
  display: flex;
  align-items: center;
}

.location-item:hover {
  background: #f5f5f5;
}

.location-item.highlighted {
  background: #E3F2FD;
  animation: highlight 2s ease;
}

@keyframes highlight {
  0% { background: #E3F2FD; }
  100% { background: white; }
}

.location-marker {
  width: 12px;
  height: 12px;
  border-radius: 50%;
  margin-right: 1rem;
  flex-shrink: 0;
}

.location-info {
  flex: 1;
  min-width: 0;
}

.location-info h4 {
  margin: 0;
  font-size: 1rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.location-info p {
  margin: 0.25rem 0 0;
  font-size: 0.85rem;
  color: #666;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.location-availability span {
  font-size: 0.8rem;
  padding: 0.25rem 0.5rem;
  border-radius: 4px;
  font-weight: 500;
}

.location-availability .high {
  background: #E8F5E9;
  color: #4CAF50;
}

.location-availability .medium {
  background: #FFF8E1;
  color: #FFA000;
}

.location-availability .low {
  background: #FFEBEE;
  color: #F44336;
}

/* Custom Marker Styles */
.custom-marker-container {
  background: transparent;
  border: none;
}

.custom-marker {
  position: relative;
  width: 30px;
  height: 42px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.marker-pin {
  width: 30px;
  height: 30px;
  border-radius: 50% 50% 50% 0;
  transform: rotate(-45deg);
  position: absolute;
  left: 0;
  top: 0;
}

.marker-label {
  position: absolute;
  top: 5px;
  left: 0;
  width: 30px;
  text-align: center;
  color: white;
  font-weight: bold;
  font-size: 12px;
  transform: rotate(45deg);
}
</style>