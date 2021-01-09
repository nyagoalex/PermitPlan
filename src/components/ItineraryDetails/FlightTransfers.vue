<template>
    <div class="bg-light to-scroll" v-infinite-scroll="getTransfers" infinite-scroll-disabled="busy" infinite-scroll-distance="10">
        <h4 v-if="!transfers.length" class="mt-5"> No Flight Transfers Available</h4>
        <div class="card task-item" v-for="(transfer,index) in transfers" :key="index">
            <div class="card-body">
                <b-row>
                    <b-col cols="1" class="pl-0 text-left">
                        <b-button variant="link" class="p-0" @click="addDayActivity('flight transfer')" v-b-popover.hover.topright="'Add flight transfer to day activity'">
                            <b-icon font-scale="2" icon="arrow-left-circle"></b-icon>
                        </b-button>
                    </b-col>
                    <b-col class="text-left">
                        <span style="font-size: 1rem; text-transform:capitalize ;"> {{transfer.name}}</span>
                        <small class="ml-3">
                            <b-icon icon="stopwatch" variant="success"></b-icon> {{transfer.est_time}} Hrs
                            <b-icon class="ml-1" icon="truck" variant="success"></b-icon> {{transfer.distance}} Km
                        </small><br>
                        <label class="text-muted">{{transfer.starting_point}}
                            <b-icon icon="arrow-right" variant="primary" animation="cylon"></b-icon> {{transfer.destination}} <br>
                            <small>{{transfer.flight_type}} </small>
                        </label>

                    </b-col>
                </b-row>
            </div>
        </div>
    </div>
</template>

<script>
import infiniteScroll from 'vue-infinite-scroll'
import EventBus from '@/Events/EventBus.js'
export default {
    data() {
        return {
            transfers: [],
            busy: false,
            next_page: 1,
            filters: {
                search: null
            }
        }
    },
    methods: {
        getTransfers() {
            if (this.next_page) {
                this.busy = true
                const filters = this.filters
                filters.page = this.next_page
                this.$http.get('/flight-transfers', {
                    params: filters
                }).then(transfers => {
                    if (this.next_page === 1) {
                        this.transfers = transfers.data.data
                    } else {
                        this.transfers.push(...transfers.data.data)
                    }
                    const next = transfers.data.links.next
                    this.next_page = next ? this.next_page + 1 : null
                })
                this.busy = false
            }
        }
    },
    props: {
        addDayActivity: Function
    },
    directives: {
        infiniteScroll
    },
    mounted() {
        EventBus.$on('EVENT_SEARCH', (search) => {
            if (this.$route.name === 'ItineraryDetails') {
                this.next_page = 1
                this.filters.search = search
            }
        })
    },
    watch: {
        'filters.search': function (val, oldVal) {
            this.getTransfers()
        }
    }
}
</script>
