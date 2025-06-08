<template>
  <div class="container pt-5">
    <!-- Most Borrowed Book -->
    <div class="card card-primary">
      <div class="card-header">
        <h3 class="card-title">Most Popular Book</h3>
      </div>
      <div class="card-body">
        <div v-if="mostBorrowedBook" class="featured-book">
          <div class="book-cover">
            <img
                :src="mostBorrowedBook.preview_image || '/images/default-book-cover.jpg'"
                :alt="mostBorrowedBook.title"
                class="book-image"
            >
          </div>
          <div class="book-details">
            <h4>{{ mostBorrowedBook.title }}</h4>
            <p class="author">by {{ mostBorrowedBook.author }}</p>
            <div class="stats">
              <div class="stat-item">
                <span class="stat-value">{{ mostBorrowedBook.borrowed_books_count }}</span>
                <span class="stat-label">Total Borrows</span>
              </div>
              <div class="stat-item">
                <span class="stat-value">{{ mostBorrowedBook.available_copies }}</span>
                <span class="stat-label">Available Copies</span>
              </div>
            </div>
            <button
                class="btn btn-primary"
                @click="viewBook(mostBorrowedBook.id)"
            >
              View Details
            </button>
          </div>
        </div>
        <div v-else class="no-books">
          <p>No books data available</p>
        </div>
      </div>
    </div>

    <!-- Books Borrowing Chart -->
    <div class="card card-primary mt-4">
      <div class="card-header">
        <h3 class="card-title">Top Borrowed Books</h3>
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
import clientApi from "@/api/ClientApi";
import Chart from 'chart.js/auto';

export default {
  name: 'BookDashboard',
  data() {
    return {
      books: [],
      chart: null,
      chartInitialized: false
    };
  },
  computed: {
    mostBorrowedBook() {
      if (!this.books.length) return null;
      return [...this.books].sort((a, b) => b.borrowed_books_count - a.borrowed_books_count)[0];
    },
    chartData() {
      const topBooks = [...this.books]
          .sort((a, b) => b.borrowed_books_count - a.borrowed_books_count)
          .slice(0, 10); // Show top 10

      return {
        labels: topBooks.map(book => book.title),
        datasets: [{
          label: 'Borrow Count',
          data: topBooks.map(book => book.borrowed_books_count),
          backgroundColor: '#10b981',
          borderColor: '#059669',
          borderWidth: 1
        }]
      };
    }
  },
  methods: {
    async fetchBooks() {
      try {
        const response = await clientApi.getRecentList();
        this.books = Array.isArray(response) ? response : [];
        this.$nextTick(this.safeInitChart);
      } catch (err) {
        console.error("Error fetching books:", err);
      }
    },
    viewBook(bookId) {
      this.$router.push({
        name: 'BookDetails',
        params: { id: bookId, locale: this.$route.params.locale }
      });
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
        this.chart.data = this.chartData;
        this.chart.update('none');
      } catch (error) {
        console.error('Chart update failed:', error);
        this.destroyChart();
        this.initializeChart();
      }
    },
    destroyChart() {
      if (this.chart) {
        try {
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
        indexAxis: 'y', // Horizontal bars
        animation: {
          duration: 0
        },
        scales: {
          x: {
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
                return `${context.parsed.x} borrow${context.parsed.x !== 1 ? 's' : ''}`;
              }
            }
          }
        }
      };
    },
    safeInitChart() {
      try {
        this.initializeChart();
      } catch (err) {
        console.error('Chart initialization error:', err);
      }
    }
  },
  mounted() {
    this.fetchBooks();
  },
  beforeUnmount() {
    this.destroyChart();
  },
  watch: {
    books: {
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
.container {
  max-width: 1200px;
  padding: 2rem 1rem;
}

.card {
  border: none;
  border-radius: 12px;
  box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
  overflow: hidden;
  margin-bottom: 1.5rem;
}

.card-primary {
  background-color: white;
  border: 1px solid #e2e8f0;
}

.card-header {
  background-color: white;
  border-bottom: 1px solid #e2e8f0;
  padding: 1.25rem 1.5rem;
}

.card-title {
  font-size: 1.25rem;
  font-weight: 600;
  color: #1e293b;
  margin: 0;
}

.card-body {
  padding: 1.5rem;
}

.featured-book {
  display: flex;
  gap: 2rem;
  align-items: center;
}

.book-cover {
  flex: 0 0 200px;
}

.book-image {
  width: 100%;
  height: auto;
  border-radius: 8px;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
}

.book-details {
  flex: 1;
}

.book-details h4 {
  font-size: 1.5rem;
  font-weight: 600;
  color: #1e293b;
  margin-bottom: 0.5rem;
}

.author {
  color: #64748b;
  margin-bottom: 1.5rem;
}

.stats {
  display: flex;
  gap: 2rem;
  margin-bottom: 1.5rem;
}

.stat-item {
  text-align: center;
}

.stat-value {
  display: block;
  font-size: 1.75rem;
  font-weight: 700;
  color: #10b981;
}

.stat-label {
  display: block;
  font-size: 0.875rem;
  color: #64748b;
  text-transform: uppercase;
  letter-spacing: 0.05em;
}

.btn {
  padding: 0.625rem 1.25rem;
  border-radius: 8px;
  font-size: 0.9375rem;
  font-weight: 500;
  transition: all 0.2s ease;
  cursor: pointer;
  border: none;
}

.btn-primary {
  background-color: #3b82f6;
  color: white;
}

.btn-primary:hover {
  background-color: #2563eb;
}

.chart-container {
  position: relative;
  height: 400px;
  width: 100%;
}

.no-books {
  text-align: center;
  padding: 2rem;
  color: #64748b;
}

@media (max-width: 768px) {
  .featured-book {
    flex-direction: column;
    gap: 1.5rem;
  }

  .book-cover {
    flex: 0 0 auto;
    width: 150px;
  }

  .stats {
    gap: 1rem;
  }

  .stat-value {
    font-size: 1.5rem;
  }
}
</style>