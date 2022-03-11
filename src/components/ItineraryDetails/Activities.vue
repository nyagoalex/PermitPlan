<!-- @format -->

<template>
    <div
        class="bg-light to-scroll"
        v-infinite-scroll="getActivities"
        infinite-scroll-disabled="busy"
        infinite-scroll-distance="10"
    >
        <h4 v-if="!activities.length" class="mt-5">No Activities Available</h4>
        <div class="card task-item" v-for="(activity, index) in activities" :key="index">
            <div class="card-body">
                <b-row>
                    <b-col cols="1" class="pl-0 text-left">
                        <b-button
                            variant="link"
                            class="p-0"
                            v-b-modal.add-day-activity
                            @click="sel_activity = activity"
                            v-b-popover.hover.topright="'Add activity to day activity'"
                        >
                            <b-icon font-scale="2" icon="arrow-left-circle"></b-icon>
                        </b-button>
                    </b-col>
                    <b-col class="text-left">
                        <span style="font-size: 1rem; text-transform: capitalize">
                            {{ activity.name }}</span
                        >
                        <p class="text-muted">
                            {{ activity.location }} <br />
                            <small>{{ activity.description | truncate(70) }}</small>
                        </p>
                    </b-col>
                </b-row>
            </div>
        </div>
        <b-modal id="add-day-activity" title=" Activity">
            <form>
                <b-form-checkbox class="float-right" v-model="use_range" switch>
                    use range
                </b-form-checkbox>
                <div class="form-group" v-show="!use_range">
                    <label>Duration </label>
                    <b-input-group append="minutes" class="mb-2 mr-sm-2 mb-sm-0">
                        <b-input
                            type="number"
                            class="form-control"
                            placeholder="30"
                            v-model="sel_activity.duration"
                        ></b-input>
                    </b-input-group>
                </div>
                <br />
                <div class="form-row" v-if="use_range">
                    <div class="form-group col-md-6">
                        <label>Start Time</label>
                        <input
                            type="time"
                            class="form-control"
                            placeholder="0"
                            v-model="start_time"
                        />
                    </div>
                    <div class="form-group col-md-6">
                        <label>End Time</label>
                        <input
                            type="time"
                            class="form-control"
                            placeholder="0"
                            v-model="end_time"
                        />
                    </div>
                </div>
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
                <b-button size="sm" variant="danger" :disabled="busy" @click="cancel()"
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
                        size="sm"
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
            activities: [],
            busy: false,
            next_page: 1,
            use_range: false,
            sel_activity: {},
            filters: {
                search: null
            },
            start_time: this.$moment().format('HH:mm'),
            end_time: this.$moment().format('HH:mm')
        }
    },
    methods: {
        getActivities() {
            if (this.next_page) {
                this.busy = true
                const filters = this.filters
                filters.page = this.next_page
                this.$http
                    .get('/activities', {
                        params: filters
                    })
                    .then((activities) => {
                        if (this.next_page === 1) {
                            this.activities = activities.data.data
                        } else {
                            this.activities.push(...activities.data.data)
                        }
                        const next = activities.data.links.next
                        this.next_page = next ? this.next_page + 1 : null
                    })
                this.busy = false
            }
        },
        addDayActivity(index) {
            var item = this.sel_activity
            this.sel_day.items.push({
                type: 'activity',
                type_id: item.id,
                priority: 0,
                duration: item.duration ?? 0,
                children: item.children ?? 0,
                adults: item.adults ?? 0,
                cost: this.total_amount,
                text: item.name + ' ~ ' + item.location
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
            this.getActivities()
        },
        end_time: function (newval, oldVal) {
            var endtime = this.$moment(this.end_time, 'HH:mm')
            var starttime = this.$moment(this.start_time, 'HH:mm')
            var duration = endtime.diff(starttime, 'minutes')
            if (duration < 0) {
                this.toastError(
                    'End time: ' +
                        this.end_time +
                        ' is selected is less than start time: ' +
                        this.start_time
                )
                this.end_time = oldVal
            }
            this.sel_activity.duration = duration
        },
        start_time: function (newVal, oldVal) {
            var endtime = this.$moment(this.end_time, 'HH:mm')
            var starttime = this.$moment(this.start_time, 'HH:mm')
            var duration = endtime.diff(starttime, 'minutes')
            if (duration < 0) {
                this.toastError(
                    'Start time: ' +
                        this.start_time +
                        ' is selected is greater than end time: ' +
                        this.end_time
                )
                this.start_time = oldVal
            }
            this.sel_activity.duration = duration
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
