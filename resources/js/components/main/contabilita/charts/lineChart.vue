<template>
    <LineChartGenerator :chart-data="chartData"     :chart-options="options" /> 
</template>
<script>
import { Line as LineChartGenerator } from 'vue-chartjs/legacy'

import {
  Chart as ChartJS,
  Title,
  Tooltip,
  Legend,
  LineElement,
  LinearScale,
  CategoryScale,
  PointElement
} from 'chart.js'

ChartJS.register(
  Title,
  Tooltip,
  Legend,
  LineElement,
  LinearScale,
  CategoryScale,
  PointElement
)
export default {
    props: {
        dateY: Array,
        dateX: Array
    },
      components: { LineChartGenerator },
    data() {
        return {
            options: {
                animations: {
                    tension: {
                        duration: 1000,
                        easing: "linear",
                        from: 0.7,
                        to: 0,
                        loop: true
                    }
                },

                scales: {
                    y: {
                        ticks: {
                            beginAtZero: true,
                            color: "#FFFFFFBA"
                        },
                        gridLines: {
                            display: true
                        }
                    },
                    x: {
                        ticks: {
                            color: "#FFFFFFBA"
                        },
                        gridLines: {
                            display: false
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    }
                },
                responsive: true,
                maintainAspectRatio: true
            }
        };
    },
    computed : {
        chartData(){
            return {
                labels: this.dateX.reverse(),
                datasets: [
                    {
                        data: this.dateY.reverse(),
                        fill: false,
                        borderColor: "#FFFFFF",
                        backgroundColor: "#FFFFFF",
                        borderWidth: 0.5
                    }
                ]
            }
    },
    },
};
</script>
