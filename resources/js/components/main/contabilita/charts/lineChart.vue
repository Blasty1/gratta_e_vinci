<script>
import { Line } from "vue-chartjs";
export default {
    extends: Line,
    props: {
        dateY: Array,
        dateX: Array
    },
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
    mounted()
    {
                        this.renderChart(this.chartData, this.options);

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
    watch: {
        dateX: {
            deep: true,
            handler() {
                this._data._chart.destroy()
                this.renderChart(this.chartData, this.options);
            }
        }
    }
};
</script>
