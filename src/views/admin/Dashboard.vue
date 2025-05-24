<template>
  <div class="dashboard">
    <!-- Stats Cards -->
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-icon">
          <i class="fas fa-paw"></i>
        </div>
        <div class="stat-info">
          <h3>Total Pets</h3>
          <p>{{ stats.totalPets }}</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">
          <i class="fas fa-home"></i>
        </div>
        <div class="stat-info">
          <h3>Available for Adoption</h3>
          <p>{{ stats.availablePets }}</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">
          <i class="fas fa-file-alt"></i>
        </div>
        <div class="stat-info">
          <h3>Pending Applications</h3>
          <p>{{ stats.pendingApplications }}</p>
        </div>
      </div>
      <div class="stat-card">
        <div class="stat-icon">
          <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-info">
          <h3>Completed Adoptions</h3>
          <p>{{ stats.completedAdoptions }}</p>
        </div>
      </div>
    </div>

    <!-- Charts Section -->
    <div class="charts-grid">
      <div class="chart-card">
        <h3>Monthly Adoptions</h3>
        <div class="chart-container">
          <canvas ref="adoptionsChart"></canvas>
        </div>
      </div>
      <div class="chart-card">
        <h3>Pet Categories</h3>
        <div class="chart-container">
          <canvas ref="categoriesChart"></canvas>
        </div>
      </div>
    </div>

    <!-- Recent Activity -->
    <div class="recent-activity">
      <h3>Recent Activity</h3>
      <div class="activity-list">
        <div v-for="activity in recentActivities" :key="activity.id" class="activity-item">
          <div class="activity-icon" :class="activity.type">
            <i :class="activity.icon"></i>
          </div>
          <div class="activity-details">
            <p class="activity-text">{{ activity.text }}</p>
            <span class="activity-time">{{ activity.time }}</span>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Chart from 'chart.js/auto'

export default {
  name: 'AdminDashboard',
  data() {
    return {
      stats: {
        totalPets: 0,
        availablePets: 0,
        pendingApplications: 0,
        completedAdoptions: 0
      },
      recentActivities: [
        {
          id: 1,
          type: 'adoption',
          icon: 'fas fa-home',
          text: 'New adoption request for Max (Labrador)',
          time: '2 hours ago'
        },
        {
          id: 2,
          type: 'pet',
          icon: 'fas fa-paw',
          text: 'New pet added: Luna (Persian Cat)',
          time: '4 hours ago'
        },
        {
          id: 3,
          type: 'application',
          icon: 'fas fa-file-alt',
          text: 'Application approved for Bella (Golden Retriever)',
          time: '1 day ago'
        },
        {
          id: 4,
          type: 'appointment',
          icon: 'fas fa-calendar-check',
          text: 'New appointment scheduled for pet meet & greet',
          time: '1 day ago'
        }
      ]
    }
  },
  mounted() {
    this.fetchStats()
    this.initCharts()
  },
  methods: {
    async fetchStats() {
      try {
        // Replace with actual API call
        const response = await fetch('http://localhost/Pawfect-master/backend/admin/stats.php')
        const data = await response.json()
        this.stats = data
      } catch (error) {
        console.error('Error fetching stats:', error)
        // Fallback data
        this.stats = {
          totalPets: 2,
          availablePets: 3,
          pendingApplications: 1,
          completedAdoptions: 1
        }
      }
    },
    initCharts() {
      // Monthly Adoptions Chart
      const adoptionsCtx = this.$refs.adoptionsChart.getContext('2d')
      new Chart(adoptionsCtx, {
        type: 'line',
        data: {
          labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
          datasets: [{
            label: 'Adoptions',
            data: [0, 0, 2, 3, 2, 1],
            borderColor: '#f7871f',
            tension: 0.4,
            fill: false
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              display: false
            }
          },
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      })

      // Pet Categories Chart
      const categoriesCtx = this.$refs.categoriesChart.getContext('2d')
      new Chart(categoriesCtx, {
        type: 'doughnut',
        data: {
          labels: ['Dogs', 'Cats'],
          datasets: [{
            data: [1, 2],
            backgroundColor: ['#f7871f', '#4CAF50']
          }]
        },
        options: {
          responsive: true,
          maintainAspectRatio: false,
          plugins: {
            legend: {
              position: 'bottom'
            }
          }
        }
      })
    }
  }
}
</script>

<style scoped>
.dashboard {
  display: flex;
  flex-direction: column;
  gap: 2rem;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
  gap: 1.5rem;
}

.stat-card {
  background: #fff;
  border-radius: 12px;
  padding: 1.5rem;
  display: flex;
  align-items: center;
  gap: 1rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.stat-icon {
  width: 48px;
  height: 48px;
  border-radius: 12px;
  background: #fff5eb;
  color: #f7871f;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
}

.stat-info h3 {
  color: #666;
  font-size: 0.9rem;
  font-weight: 500;
  margin-bottom: 0.3rem;
}

.stat-info p {
  color: #222;
  font-size: 1.8rem;
  font-weight: 700;
}

.charts-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
  gap: 1.5rem;
}

.chart-card {
  background: #fff;
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.chart-card h3 {
  color: #222;
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 1rem;
}

.chart-container {
  height: 300px;
}

.recent-activity {
  background: #fff;
  border-radius: 12px;
  padding: 1.5rem;
  box-shadow: 0 2px 8px rgba(0,0,0,0.05);
}

.recent-activity h3 {
  color: #222;
  font-size: 1.1rem;
  font-weight: 600;
  margin-bottom: 1rem;
}

.activity-list {
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.activity-item {
  display: flex;
  align-items: center;
  gap: 1rem;
  padding: 1rem;
  border-radius: 8px;
  background: #f8f9fa;
}

.activity-icon {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.2rem;
}

.activity-icon.adoption {
  background: #e3f2fd;
  color: #2196F3;
}

.activity-icon.pet {
  background: #fff5eb;
  color: #f7871f;
}

.activity-icon.application {
  background: #e8f5e9;
  color: #4CAF50;
}

.activity-icon.appointment {
  background: #f3e5f5;
  color: #9C27B0;
}

.activity-details {
  flex: 1;
}

.activity-text {
  color: #333;
  font-size: 0.95rem;
  margin-bottom: 0.2rem;
}

.activity-time {
  color: #888;
  font-size: 0.85rem;
}

@media (max-width: 768px) {
  .charts-grid {
    grid-template-columns: 1fr;
  }

  .chart-container {
    height: 250px;
  }
}
</style>