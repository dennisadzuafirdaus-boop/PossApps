/**
 * Dashboard Chart Service
 * Handles all chart initialization and configuration
 */

export class DashboardChartService {
  /**
   * Initialize sales and receipt chart
   * @param {Object} chartData - Chart data from server
   */
  static initSalesChart(chartData) {
    const ctx = document.getElementById('chartPenjualan');
    if (!ctx) return;

    const gradient1 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
    gradient1.addColorStop(0, 'rgba(102, 126, 234, 0.5)');
    gradient1.addColorStop(1, 'rgba(102, 126, 234, 0.0)');

    const gradient2 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
    gradient2.addColorStop(0, 'rgba(17, 153, 142, 0.5)');
    gradient2.addColorStop(1, 'rgba(17, 153, 142, 0.0)');

    return new Chart(ctx.getContext('2d'), {
      type: 'bar',
      data: {
        labels: chartData.labels,
        datasets: [
          {
            label: 'Penjualan (Rp)',
            data: chartData.penjualan,
            backgroundColor: gradient1,
            borderColor: 'rgba(102, 126, 234, 1)',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
          },
          {
            label: 'Penerimaan (Qty)',
            data: chartData.penerimaan,
            backgroundColor: gradient2,
            borderColor: 'rgba(17, 153, 142, 1)',
            borderWidth: 2,
            borderRadius: 8,
            borderSkipped: false,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'top' } },
        scales: {
          y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
          x: { grid: { display: false } },
        },
        animation: { duration: 1500, easing: 'easeOutQuart' },
      },
    });
  }

  /**
   * Initialize profit vs expense chart
   * @param {Object} chartKeuntungan - Profit/expense chart data
   */
  static initProfitChart(chartKeuntungan) {
    const ctx = document.getElementById('chartKeuntungan');
    if (!ctx) return;

    const gradient3 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
    gradient3.addColorStop(0, 'rgba(0, 230, 118, 0.4)');
    gradient3.addColorStop(1, 'rgba(0, 230, 118, 0.0)');

    const gradient4 = ctx.getContext('2d').createLinearGradient(0, 0, 0, 300);
    gradient4.addColorStop(0, 'rgba(255, 8, 68, 0.4)');
    gradient4.addColorStop(1, 'rgba(255, 8, 68, 0.0)');

    return new Chart(ctx.getContext('2d'), {
      type: 'line',
      data: {
        labels: chartKeuntungan.labels,
        datasets: [
          {
            label: 'Keuntungan (Rp)',
            data: chartKeuntungan.keuntungan,
            borderColor: 'rgba(0, 230, 118, 1)',
            backgroundColor: gradient3,
            fill: true,
            tension: 0.4,
            borderWidth: 3,
            pointBackgroundColor: 'rgba(0, 230, 118, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
          },
          {
            label: 'Pengeluaran (Rp)',
            data: chartKeuntungan.pengeluaran,
            borderColor: 'rgba(255, 8, 68, 1)',
            backgroundColor: gradient4,
            fill: true,
            tension: 0.4,
            borderWidth: 3,
            pointBackgroundColor: 'rgba(255, 8, 68, 1)',
            pointBorderColor: '#fff',
            pointBorderWidth: 2,
            pointRadius: 5,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { position: 'top' } },
        scales: {
          y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.05)' } },
          x: { grid: { display: false } },
        },
        animation: { duration: 1500, easing: 'easeOutQuart' },
      },
    });
  }

  /**
   * Initialize all dashboard charts
   * @param {Object} chartData - Sales/receipt data
   * @param {Object} chartKeuntungan - Profit/expense data
   */
  static initAllCharts(chartData, chartKeuntungan) {
    this.initSalesChart(chartData);
    this.initProfitChart(chartKeuntungan);
  }
}

export default DashboardChartService;
