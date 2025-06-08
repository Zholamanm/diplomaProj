<template>
    <div class="container pt-5">
      <!-- Map Visualization -->
      <div class="card card-primary">
        <div class="card-header">
          <h3 class="card-title">Books Distribution by Location</h3>
        </div>
        <div class="card-body p-0">
          <div class="map-container">
            <l-map
                :zoom="zoom"
                :center="center"
                style="height: 500px; width: 100%;"
            >
              <l-tile-layer url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png" />
              <l-marker
                  v-for="location in locations"
                  :key="location.id"
                  :lat-lng="[location.latitude, location.longitude]"
              >
                <l-popup>
                  <div class="location-popup">
                    <h4>{{ location.name }}</h4>
                    <p>Total Books: <strong>{{ location.books_count || 0 }}</strong></p>
                    <button
                        class="btn btn-sm btn-primary mt-2"
                        @click="viewLocation(location.id)"
                    >
                      View Details
                    </button>
                  </div>
                </l-popup>

                <l-icon
                    :icon-size="getMarkerSize(location.books_count)"
                    :icon-anchor="[20, 40]"
                >
                  <div class="custom-marker" :class="getMarkerClass(location.books_count)">
                    {{ location.books_count || 0 }}
                  </div>
                </l-icon>
              </l-marker>
            </l-map>
          </div>
        </div>
      </div>

      <!-- Bar Chart Visualization -->
      <div class="card card-primary mt-4">
        <div class="card-header">
          <h3 class="card-title">Books Count by Location</h3>
        </div>
        <div class="card-body">
          <div class="chart-container">
            <canvas ref="booksChart" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>
</template>

<script>
import { LMap, LTileLayer, LMarker, LPopup, LIcon } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css";
import locationApi from "@/api/Admin/LocationApi";
import Chart from 'chart.js/auto';

export default {
  name: 'LocationBooksDashboard',
  components: {
    LMap,
    LTileLayer,
    LMarker,
    LPopup,
    LIcon
  },
  data() {
    return {
      zoom: 5,
      center: [51.1657, 71.4506],
      locations: [],
      chart: null,
      chartError: null
    };
  },
  computed: {
    chartData() {
      if (!Array.isArray(this.locations)) {
        return {
          labels: [],
          datasets: [{
            data: [],
            backgroundColor: '#4361ee'
          }]
        };
      }

      const locationsWithBooks = this.locations.filter(loc =>
          loc && typeof loc.books_count === 'number' && loc.books_count > 0
      );

      return {
        labels: locationsWithBooks.map(loc => loc.name || 'Unnamed Location'),
        datasets: [{
          label: 'Number of Books',
          data: locationsWithBooks.map(loc => loc.books_count),
          backgroundColor: '#4361ee',
          borderColor: '#3a56d4',
          borderWidth: 1
        }]
      };
    }
  },
  methods: {
    async fetchLocations() {
      try {
        const response = await locationApi.get();
        this.locations = Array.isArray(response) ? response : [];

        if (this.locations.length > 0) {
          this.center = [
            parseFloat(this.locations[0].latitude) || 51.1657,
            parseFloat(this.locations[0].longitude) || 71.4506
          ];
        }

        this.$nextTick(() => {
          if (!this.chartInitialized) {
            this.initializeChart();
          } else {
            this.updateChart();
          }
        });
      } catch (err) {
        console.error("Error fetching locations:", err);
      }
    },

    initializeChart() {
      if (this.chartInitialized || !this.$refs.booksChart) return;

      try {
        const ctx = this.$refs.booksChart.getContext('2d');
        if (!ctx) return;

        this.chart = new Chart(ctx, {
          type: 'bar',
          data: this.chartData,
          options: this.getChartOptions()
        });

        this.chartInitialized = true;
      } catch (error) {
        console.error('Chart initialization failed:', error);
      }
    },

    updateChart() {
      if (!this.chart || !this.chartInitialized) return;

      try {
        // Safely update chart data
        this.chart.data = this.chartData;
        this.chart.update('none'); // Update without animation
      } catch (error) {
        console.error('Chart update failed:', error);
        // Fallback to full reinitialization
        this.destroyChart();
        this.initializeChart();
      }
    },

    destroyChart() {
      if (this.chart) {
        try {
          // Remove all event listeners first
          this.chart.stop();
          this.chart.destroy();
        } catch (error) {
          console.error('Error destroying chart:', error);
        } finally {
          this.chart = null;
          this.chartInitialized = false;
        }
      }
    },

    getChartOptions() {
      return {
        responsive: true,
        maintainAspectRatio: false,
        animation: {
          duration: 0, // Disable animations to prevent render issues
          onComplete: () => {
            if (!this.chart) return;
            this.chart.resize();
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            ticks: {
              stepSize: 1,
              precision: 0
            }
          }
        },
        plugins: {
          legend: {
            display: false
          }
        }
      };
    },
    getMarkerSize(bookCount) {
      bookCount = bookCount || 0;
      if (bookCount > 50) return [40, 40];
      if (bookCount > 20) return [35, 35];
      if (bookCount > 10) return [30, 30];
      return [25, 25];
    },
    getMarkerClass(bookCount) {
      bookCount = bookCount || 0;
      if (bookCount > 50) return 'large-marker';
      if (bookCount > 20) return 'medium-marker';
      if (bookCount > 10) return 'small-marker';
      return 'tiny-marker';
    },
    viewLocation(locationId) {
      this.$router.push({
        name: 'LocationMap',
        params: { id: locationId, locale: this.$route.params.locale }
      });
    },
    safeInitChart() {
      try {
        this.initChart();
      } catch (err) {
        console.error('Chart initialization error:', err);
        this.chartError = err.message;
      }
    },
    initChart() {
      // Clean up previous chart if exists
      if (this.chart) {
        this.chart.destroy();
        this.chart = null;
      }

      // Check if canvas element exists
      if (!this.$refs.booksChart) {
        console.warn('Chart canvas not found');
        return;
      }

      const ctx = this.$refs.booksChart.getContext('2d');
      if (!ctx) {
        console.warn('Could not get canvas context');
        return;
      }

      // Initialize new chart
      this.chart = new Chart(ctx, {
        type: 'bar',
        data: this.chartData,
        options: {
          responsive: true,
          maintainAspectRatio: false,
          animation: {
            duration: 1000,
            onComplete: () => {
              console.log('Chart rendered successfully');
            }
          },
          scales: {
            y: {
              beginAtZero: true,
              ticks: {
                stepSize: 1,
                precision: 0
              }
            }
          },
          plugins: {
            legend: {
              display: false
            },
            tooltip: {
              callbacks: {
                label: (context) => {
                  return `${context.parsed.y} book${context.parsed.y !== 1 ? 's' : ''}`;
                }
              }
            }
          }
        }
      });
    }
  },
  mounted() {
    this.fetchLocations();
    window.addEventListener('resize', this.handleResize);
  },

  beforeUnmount() {
    this.destroyChart();
    window.removeEventListener('resize', this.handleResize);
  },

  watch: {
    locations: {
      handler() {
        if (this.chartInitialized) {
          this.$nextTick(this.updateChart);
        }
      },
      deep: true
    }
  }
};
</script>

<style scoped>
/* Your existing styles remain unchanged */
.map-container {
  border-radius: 8px;
  overflow: hidden;
}

.location-popup {
  padding: 5px;
  min-width: 200px;
}

.location-popup h4 {
  font-size: 1.1rem;
  margin-bottom: 5px;
  color: #2c3e50;
}

.custom-marker {
  width: 100%;
  height: 100%;
  border-radius: 50%;
  background: #4361ee;
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  font-weight: bold;
  box-shadow: 0 2px 5px rgba(0,0,0,0.2);
  border: 2px solid white;
  transition: all 0.3s ease;
}

.custom-marker:hover {
  transform: scale(1.1);
  box-shadow: 0 4px 10px rgba(0,0,0,0.3);
}

.large-marker {
  font-size: 14px;
  background: #3a0ca3;
}

.medium-marker {
  font-size: 12px;
  background: #4361ee;
}

.small-marker {
  font-size: 10px;
  background: #4895ef;
}

.tiny-marker {
  font-size: 8px;
  background: #4cc9f0;
}

.chart-container {
  position: relative;
  height: 300px;
  width: 100%;
}

.card {
  border: none;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.card-header {
  background-color: white;
  border-bottom: 1px solid rgba(0,0,0,0.05);
  padding: 15px 20px;
}

.card-title {
  font-size: 1.2rem;
  font-weight: 600;
  color: #2c3e50;
  margin: 0;
}

.card-body {
  padding: 20px;
}

.btn {
  padding: 0.375rem 0.75rem;
  font-size: 0.875rem;
  border-radius: 0.25rem;
}

.btn-primary {
  background-color: #4361ee;
  border-color: #4361ee;
}

.btn-primary:hover {
  background-color: #3a56d4;
  border-color: #3a56d4;
}
</style>