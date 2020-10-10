<script>
import {
    Line
} from 'vue-chartjs'
export default {
    extends: Line,
    props: {
        chartData: {
            type: Array,
            required: false
        },
        chartLabels: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
                        gridLines: {
                            display: true
                        }
                    }],
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                },
                legend: {
                    display: true
                },
                responsive: true,
                maintainAspectRatio: false,
                title: {
                    display: true,
                    text: 'Permits Sold Per season'
                }
            }
        }
    },
    mounted() {
        this.renderChart({
            labels: this.chartLabels,
            datasets: [ // prettier-ignore
                {
                    label: 'Chimp Permits',
                    borderColor: '#00adef',
                    borderWidth: 1.5,
                    data: this.chartData.chimp
                },
                {
                    label: 'Gorilla Permits',
                    borderColor: '#f68e1f',
                    borderWidth: 1.5,
                    data: this.chartData.gor
                }
            ]
        }, this.options)
    }
}
</script>
