<template>
  <div class="content-wrapper">
    <div class="container pt-5">
      <div class="card card-primary">
        <l-map
            :zoom="zoom"
            :center="center"
            style="height: 500px; width: 100%;"
            @click="addMarker"
        >
          <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" />
          <l-marker
              v-for="(location, index) in locations"
              :key="location.id || index"
              :lat-lng="[location.lat, location.lng]"
              @dragend="updateMarker(index, $event)"
              draggable
          >
            <l-popup>
              <div>
                <strong>Pickup Point</strong>
                <p>Latitude: {{ location.lat }}</p>
                <p>Longitude: {{ location.lng }}</p>

                <!-- Name Input -->
                <input
                    v-model="location.name"
                    placeholder="Enter location name"
                    class="form-control mt-2"
                    :readonly="location.saved && !location.editing"
                />

                <div class="d-flex justify-content-between mt-3">
                  <!-- Show 'Save' for new locations, 'Edit' for saved locations -->
                  <button
                      v-if="!location.saved"
                      @click="saveLocation(index)"
                      :disabled="!location.name"
                  >
                    Save
                  </button>

                  <button v-else @click="editLocation(index)">
                    {{ location.editing ? "Update" : "Edit" }}
                  </button>

                  <button v-if="location.saved" @click="$router.push({name: 'LocationMap', params: {id: location.id, locale: this.$route.params.locale}})">
                    Add Books
                  </button>

                  <button @click="removeMarker(index)">Remove</button>
                </div>
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
import locationApi from "@/api/Admin/LocationApi";

export default {
  name: 'MapComponent',
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
    };
  },
  methods: {
    async fetchLocations() {
      try {
        const res = await locationApi.get();
        this.locations = res.map(loc => ({
          id: loc.id,
          name: loc.name || "",
          lat: loc.latitude,
          lng: loc.longitude,
          saved: true,
          editing: false, // Track if location is being edited
        }));
      } catch (err) {
        console.error("Error fetching locations:", err);
      }
    },

    addMarker(event) {
      if (!this.$store.state.auth.authorized) {
        return;
      }

      const exists = this.locations.some(
          loc => loc.lat === event.latlng.lat && loc.lng === event.latlng.lng
      );

      if (exists) {
        return;
      }

      this.locations.push({
        name: "",
        lat: event.latlng.lat,
        lng: event.latlng.lng,
        saved: false,
        editing: false,
      });
    },

    updateMarker(index, event) {
      this.locations[index] = {
        ...this.locations[index],
        lat: event.target.getLatLng().lat,
        lng: event.target.getLatLng().lng,
        saved: false,
      };
    },

    async saveLocation(index) {
      if (!this.locations[index].name) {
        alert("Please enter a name before saving.");
        return;
      }

      try {
        const res = await locationApi.store({
          name: this.locations[index].name,
          lat: this.locations[index].lat,
          lng: this.locations[index].lng,
        });

        this.locations[index] = {
          ...this.locations[index],
          id: res.location.id,
          saved: true,
        };
      } catch (err) {
        console.error("Error saving location:", err);
      }
    },

    editLocation(index) {
      if (this.locations[index].editing) {
        // Save updated location
        locationApi.update(this.locations[index].id, {
          name: this.locations[index].name,
          lat: this.locations[index].lat,
          lng: this.locations[index].lng,
        }).then(() => {
          this.locations[index].editing = false;
        }).catch(err => console.error("Error updating location:", err));
      } else {
        // Enable editing
        this.locations[index].editing = true;
      }
    },

    async removeMarker(index) {
      if (this.locations[index].id) {
        try {
          await locationApi.delete(this.locations[index].id);
          this.locations.splice(index, 1);
        } catch (err) {
          console.error("Error deleting location:", err);
        }
      } else {
        this.locations.splice(index, 1);
      }
    }
  },
  mounted() {
    this.fetchLocations();
  }
};
</script>

<style scoped>
.content-wrapper {
  background-color: #f8fafc;
}

.container {
  max-width: 1200px;
  padding: 1.5rem;
}

.card-primary {
  border: none;
  border-radius: 12px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05),
  0 2px 4px -1px rgba(0, 0, 0, 0.02);
  overflow: hidden;
}

.map-container {
  height: 500px;
  border-radius: 8px;
  overflow: hidden;
  background-color: #f1f5f9;
}

/* Popup Styling */
.leaflet-popup-content {
  min-width: 220px;
  padding: 12px;
  font-family: 'Inter', sans-serif;
}

.leaflet-popup-content h4 {
  font-size: 1.1rem;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 8px;
}

.leaflet-popup-content p {
  font-size: 0.85rem;
  color: #64748b;
  margin-bottom: 4px;
}

/* Form Controls */
.form-control {
  padding: 8px 12px;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  font-size: 0.9rem;
  transition: all 0.2s;
  background-color: #fff;
}

.form-control:focus {
  outline: none;
  border-color: #60a5fa;
  box-shadow: 0 0 0 2px rgba(96, 165, 250, 0.2);
}

/* Buttons */
button {
  padding: 6px 12px;
  margin: 4px;
  border: none;
  border-radius: 6px;
  font-size: 0.85rem;
  font-weight: 500;
  cursor: pointer;
  transition: all 0.2s;
  display: inline-flex;
  align-items: center;
  justify-content: center;
}

button:not(:disabled):hover {
  transform: translateY(-1px);
}

button:disabled {
  opacity: 0.6;
  cursor: not-allowed;
}

/* Primary Action Button */
button:not([disabled]) {
  background-color: #3b82f6;
  color: white;
  box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
}

button:not([disabled]):hover {
  background-color: #2563eb;
}

/* Secondary Action Button */
button[disabled] {
  background-color: #e2e8f0;
  color: #64748b;
}

/* Danger Button */
button[type="button"]:last-child {
  background-color: #ef4444;
  color: white;
}

button[type="button"]:last-child:hover {
  background-color: #dc2626;
}

/* Button Group */
.d-flex {
  display: flex;
  gap: 6px;
  flex-wrap: wrap;
}

.justify-content-between {
  justify-content: space-between;
}

.mt-2 {
  margin-top: 0.5rem;
}

.mt-3 {
  margin-top: 0.75rem;
}

/* Leaflet Overrides */
.leaflet-bar {
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
  border-radius: 6px;
  overflow: hidden;
}

.leaflet-bar a {
  border-bottom: 1px solid #e2e8f0;
}

.leaflet-bar a:hover {
  background-color: #f1f5f9;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
  .container {
    padding: 1rem;
  }

  .map-container {
    height: 400px;
  }
}
</style>
