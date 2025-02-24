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
button {
  padding: 5px 10px;
  margin: 5px;
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

input {
  width: 100%;
  padding: 5px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 3px;
}
</style>
