<!-- @format -->

<template>
    <div
        class="bg-light to-scroll"
        v-infinite-scroll="getTransfers"
        infinite-scroll-disabled="busy"
        infinite-scroll-distance="10"
    >
        <h4 v-if="!transfers.length" class="mt-5">No Flight Transfers Available</h4>
        <div class="card task-item" v-for="(transfer, index) in transfers" :key="index">
            <div class="card-body">
                <b-row>
                    <b-col cols="1" class="pl-0 text-left">
                        <b-button
                            variant="link"
                            class="p-0"
                            v-b-modal.add-day-activity
                            @click="sel_activity = transfer"
                            v-b-popover.hover.topright="
                                'Add flight transfer to day activity'
                            "
                        >
                            <b-icon font-scale="2" icon="arrow-left-circle"></b-icon>
                        </b-button>
                    </b-col>
                    <b-col class="text-left">
                        <span style="font-size: 1rem; text-transform: capitalize">
                            {{ transfer.name }}</span
                        >
                        <small class="ml-3">
                            <b-icon icon="stopwatch" variant="success"></b-icon>
                            {{ transfer.est_time }} Hrs
                            <b-icon class="ml-1" icon="truck" variant="success"></b-icon>
                            {{ transfer.distance }} Km </small
                        ><br />
                        <label class="text-muted"
                            >{{ transfer.starting_point }}
                            <b-icon
                                icon="arrow-right"
                                variant="primary"
                                animation="cylon"
                            ></b-icon>
                            {{ transfer.destination }} <br />
                            <small>{{ transfer.flight_type }} </small>
                        </label>
                    </b-col>
                </b-row>
            </div>
        </div>
        <b-modal id="add-day-activity" title=" Road Transfer">
            <form>
                <div class="form-group">
                    <label>Duration </label>
                    <b-input-group append="hours" class="mb-2 mr-sm-2 mb-sm-0">
                        <b-input
                            type="text"
                            class="form-control"
                            :value="sel_activity.est_time"
                            :disabled="true"
                        ></b-input>
                    </b-input-group>
                </div>
                <br />
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Children</label>
                        <input
                            type="number"
                            class="form-control"
                            placeholder="0"
                            v-model="sel_activity.children"
                        />
                    </div>
                    <div class="form-group col-md-6">
                        <label>Adults</label>
                        <input
                            type="number"
                            class="form-control"
                            placeholder="0"
                            v-model="sel_activity.adults"
                        />
                    </div>
                </div>
                <div class="form-row">
                    <small class="col-md-6 text-secondary"
                        >Cost Per Person:
                        {{ sel_activity.cost_per_person | moneyFormat }}</small
                    ><br />
                    <label class="col-md-6 text-right"
                        >Total Amount: {{ total_amount | moneyFormat }}</label
                    >
                </div>
            </form>

            <template v-slot:modal-footer="{ cancel }">
                <b-button size="lg" variant="danger" :disabled="busy" @click="cancel()"
                    >Cancel</b-button
                >
                <b-overlay
                    :show="busy"
                    rounded
                    opacity="0.6"
                    spinner-small
                    class="d-inline-block"
                >
                    <b-button
                        size="lg"
                        variant="success"
                        :disabled="busy"
                        @click="addDayActivity()"
                        >Add Activity</b-button
                    >
                </b-overlay>
            </template>
        </b-modal>
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
            sel_activity: {},
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
                this.$http
                    .get('/flight-transfers', {
                        params: filters
                    })
                    .then((transfers) => {
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
        },
        addDayActivity(index) {
            var item = this.sel_activity
            this.sel_day.items.push({
                type: 'flight transfer',
                type_id: item.id,
                priority: 0,
                duration: this.$moment.duration(item.est_time).asMinutes(),
                children: item.children ?? 0,
                adults: item.adults ?? 0,
                cost: this.total_amount,
                text: 'Flight from ' + item.starting_point + ' to ' + item.destination
            })
            this.$bvModal.hide('add-day-activity')
        }
    },
    props: {
        sel_day: Object
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
    },
    computed: {
        total_amount: function () {
            return (
                this.sel_activity.cost_per_person *
                (parseInt(this.sel_activity.adults ?? 0) + parseInt(this.sel_activity.children ?? 0))
            )
        }
    }
}
</script>
