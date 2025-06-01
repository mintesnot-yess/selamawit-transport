<!-- src/components/SalesChart.vue -->
<template>
    <canvas ref="chartCanvas"></canvas>
</template>

<script setup>
import { ref, onMounted, onBeforeUnmount } from 'vue'
import { Chart } from 'chart.js/auto'

const chartCanvas = ref(null)
let chartInstance = null

onMounted(() => {
    if (chartCanvas.value) {
        const ctx = chartCanvas.value.getContext('2d')

        chartInstance = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec', 'Jan', 'Feb', 'Apr', 'May'],
                datasets: [
                    {
                        label: 'Income',
                        data: [3200, 4200, 5100, 4800, 5900, 5200, 6700, 3323, 3121, 5167, 5122, 1221],
                        borderColor: '#6366f1',
                        backgroundColor: 'rgba(99, 102, 241, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    },
                    {
                        label: 'Expenses',
                        data: [2800, 3700, 4100, 3600, 4900, 4300, 5400, 2323, 1121, 2067, 5122, 1210],
                        borderColor: '#cbd5e1',
                        backgroundColor: 'rgba(203, 213, 225, 0.1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: false,
                        grid: {
                            drawBorder: false,
                            color: '#e2e8f0'
                        },
                        ticks: {
                            callback: function (value) {
                                return '$' + value.toLocaleString()
                            }
                        }
                    },
                    x: {
                        grid: {
                            display: false,
                            drawBorder: false
                        }
                    }
                }
            }
        })
    }
})

onBeforeUnmount(() => {
    if (chartInstance) {
        chartInstance.destroy()
    }
})
</script>

<style scoped>
.chart-container {
    position: relative;
    height: 350px;
    width: 100%;
}
</style>