<template>
  <div class="location-picker-wrapper">
    <div class="location-picker-container">
      <div class="location-card">
        <div class="location-header">
          <h2 class="location-title">Select Pickup Location</h2>
          <p class="location-subtitle">Choose where to get your book from available locations</p>

          <div class="search-box">
            <input
                type="text"
                placeholder="Search locations..."
                v-model="searchQuery"
                @input="filterLocations"
            >
            <svg class="search-icon" viewBox="0 0 24 24">
              <path d="M15.5 14h-.79l-.28-.27a6.5 6.5 0 0 0 1.48-5.34c-.47-2.78-2.79-5-5.59-5.34a6.505 6.505 0 0 0-7.27 7.27c.34 2.8 2.56 5.12 5.34 5.59a6.5 6.5 0 0 0 5.34-1.48l.27.28v.79l4.25 4.25c.41.41 1.08.41 1.49 0 .41-.41.41-1.08 0-1.49L15.5 14zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
            </svg>
          </div>
        </div>

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
                    'high': location.quantity > 3,
                    'medium': location.quantity > 0 && location.quantity <= 3,
                    'low': location.quantity === 1
                  }">
                    {{ location.quantity }} available
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
                  'high': location.quantity > 3,
                  'medium': location.quantity > 0 && location.quantity <= 3,
                  'low': location.quantity === 1
                }">
                  {{ location.quantity }} available
                </span>
              </div>
            </div>
          </div>

        </div>
      </div>
      <book-list-view :locations="locations.map(loc => loc.id)"/>
    </div>
  </div>
</template>

<script>
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
import L from 'leaflet';
import "leaflet/dist/leaflet.css";
import clientApi from "@/api/ClientApi";
import BookListView from "@/ClientViews/Elements/BookListView.vue";

export default {
  name: 'BorrowMap',
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LPopup,
    BookListView
  },
  data() {
    return {
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
  methods: {
    async fetchAvailableLocations() {
      this.isLoading = true;
      const bookId = this.$route.params.id;

      try {
        const res = await clientApi.getLocations(bookId);
        this.locations = res
            .filter(loc => loc.quantity > 0)
            .map(loc => ({
              id: loc.id,
              name: loc.name,
              address: loc.address,
              lat: loc.latitude,
              lng: loc.longitude,
              quantity: loc.quantity,
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
  background: #47cbf6;
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
      if (quantity > 3) return '#4CAF50'; // Green for high availability
      if (quantity > 1) return '#FFC107'; // Yellow for medium
      return '#F44336'; // Red for low
    }
  },
  mounted() {
    this.fetchAvailableLocations();
  },
  watch: {
    filteredLocations() {
      this.centerOnLocations();
    }
  }
};
</script>

<style scoped>
/* Base Styles */
.location-picker-wrapper {
  padding: 2rem 0;
  background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
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