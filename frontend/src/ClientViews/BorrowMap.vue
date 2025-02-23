<template>
  <div class="content-wrapper">
    <div class="container pt-5">
      <div class="card card-primary">
        <h2 class="mt-3">Select Pickup Location</h2>
        <p>Choose a location where the book is available.</p>

        <div v-if="isLoading" class="loading">
          <p>Loading available locations...</p>
        </div>

        <div v-else-if="locations.length === 0" class="no-results">
          <p>No locations have this book available.</p>
        </div>

        <l-map
            v-else
            :zoom="zoom"
            :center="center"
            style="height: 500px; width: 100%;"
        >
          <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" />

          <l-marker
              v-for="location in locations"
              :key="location.id"
              :lat-lng="[location.lat, location.lng]"
          >
            <l-popup>
              <div>
                <strong>{{ location.name }}</strong>
                <p>{{ location.address }}</p>
                <p><strong>Available Copies: </strong> {{ location.quantity }}</p>

                <button
                    @click="selectLocation(location)"
                    class="btn btn-primary mt-2"
                    :disabled="location.quantity === 0"
                >
                  Select Location
                </button>
              </div>
            </l-popup>
          </l-marker>
        </l-map>
      </div>
    </div>
  </div>
</template>

<script>
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";
import locationApi from "@/api/ClientApi"; // Client API

export default {
  name: 'BorrowMap',
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LPopup,
  },
  data() {
    return {
      zoom: 5,
      center: [51.1657, 71.4506], // Kazakhstan default center
      locations: [],
      isLoading: true,
    };
  },
  methods: {
    async fetchAvailableLocations() {
      this.isLoading = true;
      const bookId = this.$route.params.id;

      try {
        const res = await locationApi.getLocations(bookId);

        // Filter locations where the book is available
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
      } catch (err) {
        console.error("Error fetching locations:", err);
      } finally {
        this.isLoading = false;
      }
    },

    selectLocation(location) {
      this.$router.push({
        name: "BorrowBook",
        params: {
          id: this.$route.params.id,
          locId: location.id
        }
      });
    }
  },
  mounted() {
    this.fetchAvailableLocations();
  }
};
</script>

<style scoped>
.loading,
.no-results {
  text-align: center;
  font-size: 16px;
  color: #666;
}
button {
  padding: 8px 14px;
  border: none;
  cursor: pointer;
  background: #2196F3;
  color: white;
  border-radius: 3px;
}
button:disabled {
  background: grey;
  cursor: not-allowed;
}
button:hover {
  background: #0d8af3;
}
</style>
