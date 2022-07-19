<script>
import { Line } from "vue-chartjs";
export default {
    extends: Line,
    props : {
        dateY : Array,
        dateX : Array,
    },
    data() {
        return {
            chartData: {
                labels: [
                    "Babol",
                    "Cabanatuan",
                    "Daegu",
                    "Jerusalem",
                    "Fairfield",
                    "New York",
                    "Gangtok",
                    "Buenos Aires",
                    "Hafar Al-Batin",
                    "Idlib"
                ],
                datasets: [
                    {
                        label: "Line Chart",
                        data: [
                            600,
                            1150,
                            342,
                            6050,
                            2522,
                            3241,
                            1259,
                            157,
                            1545,
                            9841
                        ],
                        fill: false,
                        borderColor: "#FFFFFF",
                        backgroundColor: "#FFFFFF",
                        borderWidth: 0.5
                    }
                ]
            },
            options: {
                 animations: {
      tension: {
        duration: 1000,
        easing: 'linear',
        from: 1,
        to: 0,
        loop: true
      }
    },

                scales: {
                   
                    y: 
                        {
                            ticks: {
                                beginAtZero: true,
                                color: "#FFFFFFBA"
                            },
                            gridLines: {
                                display: true
                            }
                        },
                    x: 
                        {
                            ticks: {
                                color: "#FFFFFFBA",
                                
                            },
                            gridLines: {
                                display: false
                            }
                        }
                
                },
                plugins : {
                legend: {
                    display: false
                }
                },
                responsive: true,
                maintainAspectRatio: true
            }
        };
    },
    mounted() {
        this.renderChart(this.chartData, this.options);
    }
};
</script>
