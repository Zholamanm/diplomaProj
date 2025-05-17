<template>
  <section class="location-visualization">
    <h2>Discover Books <span class="highlight">Near You</span></h2>

    <div class="visualization-container">
      <!-- Time Slider -->
      <div class="time-slider">
        <input type="range"
               v-model="timeRange"
               min="0"
               max="24"
               step="1"
               @input="updateVisualization">
        <div class="time-labels">
          <span v-for="hour in [0,6,12,18,24]" :key="hour">
            {{ formatHour(hour) }}
          </span>
        </div>
      </div>

      <!-- Canvas Visualization -->
      <div class="canvas-container">
        <canvas ref="heatmapCanvas"></canvas>
        <div v-for="book in visibleBooks"
             :key="book.id"
             class="book-marker"
             :style="getMarkerStyle(book)">
          <div class="marker-tooltip">
            <img :src="book.cover_image" alt="Book cover">
            <div>
              <h4>{{ book.title }}</h4>
              <p>{{ book.author }}</p>
<!--              <small>Available: {{ book.available_copies }}</small>-->
            </div>
          </div>
        </div>
      </div>

      <!-- Location Stats -->
      <div class="location-stats">
        <div class="stat-card">
          <div class="stat-value">{{ nearestBooks.length }}</div>
          <div class="stat-label">Books Nearby</div>
        </div>
        <div class="stat-card">
          <div class="stat-value">{{ activeLocations }}</div>
          <div class="stat-label">Active Locations</div>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
import ClientApi from '@/api/ClientApi';

export default {
  data() {
    return {
      timeRange: 12,
      allBooks: [],
      visibleBooks: [],
      nearestBooks: [],
      activeLocations: 0,
      canvasSize: { width: 0, height: 0 },
      userLocation: null
    };
  },
  methods: {
    async fetchBookData() {
      try {
        const response = await ClientApi.getLocations();
        this.allBooks = response.data.map(book => ({
          ...book,
          x: this.longToX(book.longitude),
          y: this.latToY(book.latitude),
          time: this.getBookTimeValue(book.last_activity)
        }));

        this.updateVisualization();
        this.initHeatmap();

        // Get approximate user location (if permitted)
        this.getUserLocation();
      } catch (error) {
        console.error("Error fetching book data:", error);
      }
    },

    longToX(longitude) {
      // Convert longitude to 0-100% scale
      return ((longitude + 180) / 360) * 100;
    },

    latToY(latitude) {
      // Convert latitude to 0-100% scale (inverted)
      return 100 - ((latitude + 90) / 180) * 100;
    },

    getBookTimeValue(timestamp) {
      // Extract hour from timestamp (0-23)
      const date = new Date(timestamp);
      return date.getHours();
    },

    updateVisualization() {
      // Filter books by time proximity
      this.visibleBooks = this.allBooks.filter(book => {
        const timeDiff = Math.abs(book.time - this.timeRange);
        return timeDiff <= 3 || (24 - timeDiff) <= 3;
      });

      this.activeLocations = new Set(
          this.visibleBooks.map(book => book.location_id)
      ).size;

      this.updateNearestBooks();
      this.drawHeatmap();
    },

    getUserLocation() {
      if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            position => {
              this.userLocation = {
                lat: position.coords.latitude,
                lng: position.coords.longitude
              };
              this.updateNearestBooks();
            },
            () => {
              // Default to a central location if denied
              this.userLocation = { lat: 20, lng: 0 };
            }
        );
      }
    },

    updateNearestBooks() {
      if (!this.userLocation) return;

      this.nearestBooks = [...this.visibleBooks]
          .map(book => ({
            ...book,
            distance: this.calculateDistance(
                this.userLocation.lat,
                this.userLocation.lng,
                book.latitude,
                book.longitude
            )
          }))
          .sort((a, b) => a.distance - b.distance)
          .slice(0, 5);
    },

    calculateDistance(lat1, lon1, lat2, lon2) {
      // Haversine formula
      const R = 6371; // Earth radius in km
      const dLat = (lat2 - lat1) * Math.PI / 180;
      const dLon = (lon2 - lon1) * Math.PI / 180;
      const a =
          Math.sin(dLat/2) * Math.sin(dLat/2) +
          Math.cos(lat1 * Math.PI / 180) *
          Math.cos(lat2 * Math.PI / 180) *
          Math.sin(dLon/2) * Math.sin(dLon/2);
      return R * 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
    },

    getMarkerStyle(book) {
      const timeDiff = Math.min(
          Math.abs(book.time - this.timeRange),
          24 - Math.abs(book.time - this.timeRange)
      );
      const opacity = 1 - (timeDiff / 4);

      return {
        left: `${book.x}%`,
        top: `${book.y}%`,
        opacity: opacity,
        transform: `translate(-50%, -50%) scale(${0.8 + opacity * 0.4})`,
        zIndex: Math.floor(opacity * 100)
      };
    },

    initHeatmap() {
      const canvas = this.$refs.heatmapCanvas;
      const container = canvas.parentElement;
      this.canvasSize = {
        width: container.offsetWidth,
        height: container.offsetHeight
      };
      canvas.width = this.canvasSize.width;
      canvas.height = this.canvasSize.height;
    },

    drawHeatmap() {
      const canvas = this.$refs.heatmapCanvas;
      const ctx = canvas.getContext('2d');

      // Clear canvas
      ctx.clearRect(0, 0, canvas.width, canvas.height);

      // Draw heatmap
      this.visibleBooks.forEach(book => {
        const x = (book.x / 100) * canvas.width;
        const y = (book.y / 100) * canvas.height;
        const radius = 30 + (book.available_copies * 5);

        const gradient = ctx.createRadialGradient(x, y, 0, x, y, radius);
        gradient.addColorStop(0, 'rgba(33, 158, 154, 0.8)');
        gradient.addColorStop(1, 'rgba(33, 158, 154, 0)');

        ctx.fillStyle = gradient;
        ctx.beginPath();
        ctx.arc(x, y, radius, 0, Math.PI * 2);
        ctx.fill();
      });
    },

    formatHour(hour) {
      return hour === 0 ? '12AM' :
          hour === 12 ? '12PM' :
              hour === 24 ? '12AM' :
                  hour < 12 ? `${hour}AM` : `${hour-12}PM`;
    }
  },
  mounted() {
    this.fetchBookData();
    window.addEventListener('resize', this.initHeatmap);
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.initHeatmap);
  }
};
</script>

<style scoped>
.location-visualization {
  padding: 3rem 1rem;
  background: linear-gradient(to bottom, #f8f9fa, #e9ecef);
}

.visualization-container {
  max-width: 900px;
  margin: 0 auto;
  background: white;
  border-radius: 12px;
  box-shadow: 0 5px 20px rgba(0,0,0,0.08);
  padding: 2rem;
  position: relative;
}

.time-slider {
  margin-bottom: 2rem;
}

.time-slider input[type="range"] {
  width: 100%;
  height: 6px;
  -webkit-appearance: none;
  background: linear-gradient(to right,
  #e9ecef 0%,
  #219e9a 50%,
  #e9ecef 100%);
  border-radius: 3px;
  outline: none;
}

.time-slider input[type="range"]::-webkit-slider-thumb {
  -webkit-appearance: none;
  width: 20px;
  height: 20px;
  background: #219e9a;
  border-radius: 50%;
  cursor: pointer;
  box-shadow: 0 0 5px rgba(0,0,0,0.2);
}

.time-labels {
  display: flex;
  justify-content: space-between;
  margin-top: 0.5rem;
  color: #6c757d;
  font-size: 0.9rem;
}

.canvas-container {
  position: relative;
  height: 400px;
  margin: 1rem 0;
  border: 1px solid #e9ecef;
  border-radius: 8px;
  overflow: hidden;
}

canvas {
  width: 100%;
  height: 100%;
  background: #f8f9fa;
}

.book-marker {
  position: absolute;
  width: 12px;
  height: 12px;
  background: #e74c3c;
  border-radius: 50%;
  transform: translate(-50%, -50%);
  transition: all 0.3s ease;
  cursor: pointer;
  box-shadow: 0 0 0 2px white;
}

.book-marker:hover {
  transform: translate(-50%, -50%) scale(2);
  z-index: 10;
}

.marker-tooltip {
  position: absolute;
  bottom: 100%;
  left: 50%;
  transform: translateX(-50%);
  width: 200px;
  background: white;
  border-radius: 8px;
  box-shadow: 0 5px 15px rgba(0,0,0,0.1);
  padding: 1rem;
  display: none;
  flex-direction: row;
  gap: 1rem;
}

.book-marker:hover .marker-tooltip {
  display: flex;
}

.marker-tooltip img {
  width: 50px;
  height: 75px;
  object-fit: cover;
  border-radius: 4px;
}

.marker-tooltip h4 {
  margin: 0 0 0.3rem 0;
  font-size: 0.9rem;
}

.marker-tooltip p {
  margin: 0 0 0.5rem 0;
  color: #6c757d;
  font-size: 0.8rem;
}

.marker-tooltip small {
  color: #219e9a;
  font-size: 0.7rem;
}

.location-stats {
  display: flex;
  justify-content: center;
  gap: 2rem;
  margin-top: 2rem;
}

.stat-card {
  text-align: center;
  padding: 1rem 2rem;
  background: rgba(33, 158, 154, 0.1);
  border-radius: 8px;
}

.stat-value {
  font-size: 1.8rem;
  font-weight: bold;
  color: #219e9a;
}

.stat-label {
  font-size: 0.9rem;
  color: #6c757d;
}

@media (max-width: 768px) {
  .visualization-container {
    padding: 1rem;
  }

  .canvas-container {
    height: 300px;
  }
}
</style>