<!-- @format -->

<template>
    <div
        class="bg-light to-scroll"
        v-infinite-scroll="getLodges"
        infinite-scroll-disabled="busy"
        infinite-scroll-distance="10"
    >
        <h4 v-if="!lodges.length" class="mt-5">No Lodges Available</h4>
        <div class="card task-item" v-for="(lodge, index) in lodges" :key="index">
            <div class="card-body">
                <b-row>
                    <b-col cols="1" class="pl-0 text-left">
                        <b-button
                            variant="link"
                            class="p-0"
                            v-b-modal.add-day-activity
                            @click="sel_activity = lodge"
                            v-b-popover.hover.topright="'Add lodge to day activity'"
                        >
                            <b-icon font-scale="2" icon="arrow-left-circle"></b-icon>
                        </b-button>
                    </b-col>
                    <b-col class="text-left">
                        <span style="font-size: 1rem; text-transform: capitalize">
                            {{ lodge.name }}</span
                        >
                        <small class="ml-3">{{ lodge.code }}</small
                        ><br />
                        <label class="text-muted"
                            >{{ lodge.location }} - {{ lodge.country }} <br />
                            <star-rating
                                :rating="lodge.star_rating"
                                :star-size="13"
                                :read-only="true"
                                :increment="0.01"
                                :show-rating="false"
                            ></star-rating>
                        </label>
                    </b-col>
                </b-row>
            </div>
            <b-modal id="add-day-activity" title="Accomodation" size="lg">
                <form>
                    <div class="form-group">
                        <label>Duration </label>
                        <b-input-group append="days" class="mb-2 mr-sm-2 mb-sm-0">
                            <b-input
                                type="text"
                                class="form-control"
                                value="1 night"
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
                    <center
                        class="text-danger"
                        v-if="
                            !sel_activity.seasonal_prices ||
                            !sel_activity.seasonal_prices.length
                        "
                    >
                        Lodge has no room seasonal prices
                    </center>
                    <center v-else>
                        Rooms in Season
                        <span class="float-right"
                            >Total Amount: {{ total_amount | moneyFormat }}</span
                        >
                    </center>

                    <div class="container">
                        <b-table-simple sticky-header>
                            <b-thead head-variant="light">
                                <b-tr>
                                    <b-th>#</b-th>
                                    <b-th>Room</b-th>
                                    <b-th>Cost Per Person</b-th>
                                    <b-th>Number of rooms</b-th>
                                    <b-th>Amount</b-th>
                                </b-tr>
                            </b-thead>
                            <b-tbody>
                                <b-tr
                                    v-for="(item, index) in sel_activity.seasonal_prices"
                                    :key="index"
                                >
                                    <b-td
                                        ><b-form-checkbox v-model="item.selected">
                                            {{ index + 1 }}
                                        </b-form-checkbox></b-td
                                    >
                                    <b-td>{{ item.room_name }}</b-td>
                                    <b-td>{{ item.amount }}</b-td>
                                    <b-td>
                                        <input
                                            type="number"
                                            style="max-height: 30px; max-width: 100px"
                                            v-model="item.qty"
                                        />
                                    </b-td>
                                    <b-td>{{
                                        item.amount * (!item.qty ? 0 : item.qty)
                                    }}</b-td>
                                </b-tr>
                            </b-tbody>
                        </b-table-simple>
                    </div>
                </form>

                <template v-slot:modal-footer="{ cancel }">
                    <b-button
                        size="lg"
                        variant="danger"
                        :disabled="busy"
                        @click="cancel()"
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
                            >Add Accomodation</b-button
                        >
                    </b-overlay>
                </template>
            </b-modal>
        </div>
    </div>
</template>

<script>
import infiniteScroll from 'vue-infinite-scroll'
import EventBus from '@/Events/EventBus.js'
import StarRating from 'vue-star-rating'
export default {
    data() {
        return {
            lodges: [],
            busy: false,
            next_page: 1,
            sel_activity: {},
            filters: {
                search: null
            }
        }
    },
    components: {
        StarRating
    },
    methods: {
        getLodges() {
            if (this.next_page) {
                this.busy = true
                const filters = this.filters
                filters.page = this.next_page
                filters.date = this.arrival_date
                this.$http
                    .get('/lodge-seasonal-prices', {
                        params: filters
                    })
                    .then((lodges) => {
                        if (this.next_page === 1) {
                            this.lodges = lodges.data.data
                        } else {
                            this.lodges.push(...lodges.data.data)
                        }
                        const next = lodges.data.links.next
                        this.next_page = next ? this.next_page + 1 : null
                    })
                this.busy = false
            }
        },
        addDayActivity(index) {
            var item = this.sel_activity
            var rooms = item.seasonal_prices.filter((room) => room.selected === true)
            rooms = rooms.map(function (room) {
                delete room.selected
                return room
            })

            this.sel_day.items.push({
                type: 'accomodation',
                type_id: item.id,
                priority: 0,
                duration: '1 night',
                children: item.children ?? 0,
                adults: item.adults ?? 0,
                cost: this.total_amount,
                text: item.name + ' ~ ' + item.location,
                rooms: rooms
            })
            this.$bvModal.hide('add-day-activity')
        }
    },
    props: {
        sel_day: Object,
        arrival_date: String
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
            this.getLodges()
        }
    },
    computed: {
        total_amount: function () {
            if (!this.sel_activity.seasonal_prices) {
                return 0
            }
            var sel = this.sel_activity.seasonal_prices.filter(
                (item) => item.selected === true
            )
            // prettier-ignore
            return sel.reduce(
                (partialSum, item) =>
                    partialSum + parseFloat(item.amount) * parseFloat((!item.qty ? 0 : item.qty)),
                0
            )
        }
    }
}
</script>
