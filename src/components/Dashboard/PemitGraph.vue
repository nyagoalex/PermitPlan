<template>
    <div class="col-md-8 col-sm-12 pl-5">
        <div class=" bg-white p-3" style="border-radius: 0.5rem;">
            <div class="text-right">
                <b-form-select size="sm" style="width: 8rem;" v-model=" period" :options="periods"></b-form-select>
            </div>
            <line-chart v-if="loaded" :chart-data="chartData" :chart-labels="labels"></line-chart>
        </div>
        <div class="row no-gutters border-top border-bottom" style="background-color:rgba(0, 0, 0, 0.05)">
            <div class="col-3 py-4 text-center">
                <!-- Heading -->
                <h6 class="text-uppercase text-muted">All Permits </h6>
                <!-- Value -->
                <h2 class="mb-0 number-" id="permits_deposited">0</h2>

            </div>

            <div class="col-3 py-4 text-center border-left">
                <!-- Heading -->
                <h6 class="text-uppercase text-muted">Permits Deposited</h6>
                <!-- Value -->
                <h2 class="mb-0 number-" id="permits_sold">0</h2>
            </div>

            <div class="col-3 py-4 text-center border-left">
                <!-- Heading -->
                <h6 class="text-uppercase text-muted">Permits sold</h6>
                <!-- Value -->
                <h2 class="mb-0 number-" id="permits_sold">0</h2>
            </div>

            <div class="col-3 py-4 text-center border-left">
                <!-- Heading -->
                <h6 class="text-uppercase text-muted">Expiring soon</h6>
                <!-- Value -->
                <h2 class="mb-0" id="permits_expired">0</h2>
            </div>

        </div>
    </div>
</template>

<script>
// import axios from 'axios'
import LineChart from '@/components/Dashboard/LineChart.vue'
export default {
    components: {
        LineChart
    },
    props: {},
    data() {
        return {
            period: 'last-month',
            periods: [ // prettier-ignore
                {
                    value: 'last-day',
                    text: 'Last Day'
                },
                {
                    value: 'last-month',
                    text: 'Last Month'
                },
                {
                    value: 'last-year',
                    text: 'Last Year'
                }
            ],
            loaded: false,
            chartData: [],
            labels: [],
            mydata: {
                start: '2020-08-14',
                end: '2020-09-12',
                data: [ // prettier-ignore
                    {
                        chimp: 3000,
                        gor: 1024,
                        label: 'January'
                    },
                    {
                        chimp: 5678,
                        gor: 1009,
                        label: 'Febuary'
                    },
                    {
                        chimp: 3490,
                        gor: 36949,
                        label: 'March'
                    },
                    {
                        chimp: 3600,
                        gor: 3953,
                        label: 'April'
                    },
                    {
                        chimp: 4400,
                        gor: 3909,
                        label: 'May'
                    },
                    {
                        chimp: 3400,
                        gor: 3867,
                        label: 'June'
                    },
                    {
                        chimp: 3400,
                        gor: 3511,
                        label: 'July'
                    },
                    {
                        chimp: 3400,
                        gor: 1061,
                        label: 'August'
                    },
                    {
                        chimp: 3400,
                        gor: 9995,
                        label: 'September'
                    },
                    {
                        chimp: 3400,
                        gor: 3783,
                        label: 'October'
                    },
                    {
                        chimp: 3400,
                        gor: 4085,
                        label: 'November'
                    },
                    {
                        chimp: 3400,
                        gor: 40781,
                        label: 'December'
                    }
                ]
            }
        }
    },
    mounted() {
        this.requestData()
        // if (this.$route.params.package) {
        //     this.package1 = this.$route.params.package1
        //     this.requestData()
        // }
    },
    methods: {
        requestData() {
            // if (this.package1 === null || this.package1 === '' || this.package1 === 'undefined') {
            //     this.showError = true
            //     return
            // }
            this.loaded = false
            this.labels = this.mydata.data.map(download => download.label)
            this.chartData.gor = this.mydata.data.map(download => download.gor)
            this.chartData.chimp = this.mydata.data.map(download => download.chimp)

            // console.log(this.chartData)
            this.loaded = true
            //         this.packageName = response.data.package

            // axios.get(`https://api.npmjs.org/downloads/range/${this.period}`)
            //     .then(response => {
            //         console.log(response)
            //         this.downloads = response.data.downloads.map(download => download.downloads)
            //         this.labels = response.data.downloads.map(download => download.day)
            //         this.packageName = response.data.package
            //         this.setURL()
            //         this.loaded = true
            //     })
            //     .catch(err => {
            //         console.log(err)
            //         this.errorMessage = err.response.data.error
            //         this.showError = true
            //     })
        },
        setURL() {
            // history.pushState({
            //     info: `npm-stats ${this.package1}`
            // }, this.package1, `/#/${this.package1}`)
        }
    }
}
</script>

<style>
.linegraph {
    width: 700px;
    height: 350px;
}
</style>
