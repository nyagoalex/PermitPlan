<!-- @format -->

<template>
    <div>
        <div v-if="!itinerary.days.length" class="my-5 text-center">
            <h2 class="text-muted">NO DAY BY DAY DETAILS ADDED YET</h2>
        </div>
        <b-row class="pl-3 mt-1">
            <b-col cols="2" class="pr-1">
                <draggable
                    v-model="itinerary.days"
                    v-bind="dragOptions1"
                    @start="drag = true"
                    @end="drag = false"
                    class="to-scroll"
                >
                    <div
                        class="my-1 d-flex"
                        v-for="(day, index) in itinerary.days"
                        :key="index"
                        :item="day"
                        v-b-popover.hover.top="'Drag to reorder'"
                    >
                        <b-button
                            pill
                            size="lg"
                            class="w-75 d-flex justify-content-between"
                            :variant="
                                sel_day_index === index
                                    ? 'secondary'
                                    : 'outline-secondary'
                            "
                            @click="daySelect(index)"
                            ><span>Day {{ day.priority }}</span> <span>{{$moment(bookingDate).add(day.priority, 'days').format('DD-MMM-YYYY')}}</span>
                        </b-button>
                        <b-button variant="link">
                            <b-icon
                                icon="trash"
                                aria-hidden="true"
                                @click="removeDay(index)"
                                variant="danger"
                            ></b-icon>
                        </b-button>
                    </div>
                </draggable>
                <b-button pill variant="info" class="mx-3 mt-3" v-b-modal.add-day-modal
                    >Add Day</b-button
                >
            </b-col>
            <b-col cols="5" v-if="!!sel_day">
                <div class="p-0">
                    <div class="heading text-center" slot="header">
                        <h4>
                            Day {{ sel_day.priority }} -
                            {{ sel_day.name | truncate(50) }}
                        </h4>
                    </div>
                    <draggable
                        v-model="sel_day.items"
                        v-bind="dragOptions2"
                        @start="drag = true"
                        @end="drag = false"
                        class="to-scroll"
                    >
                        <div
                            class="card task-item"
                            v-for="(item, index) in sel_day.items"
                            :key="index"
                            :item="item"
                            v-b-popover.hover.top="'Drag to reorder'"
                        >
                            <div class="card-body">
                                <b-row>
                                    <b-col cols="2">
                                        <b-icon
                                            font-scale="3"
                                            icon="exclamation-circle-fill"
                                            variant="success"
                                        ></b-icon>
                                    </b-col>
                                    <b-col class="text-left px-0">
                                        <span
                                            style="
                                                font-size: 1.3rem;
                                                text-transform: capitalize;
                                            "
                                        >
                                            {{ item.type }}</span
                                        >
                                        <small class="ml-3">
                                            <b-icon
                                                icon="stopwatch"
                                                variant="success"
                                            ></b-icon>
                                            {{ item.duration }} mins
                                            <b-icon
                                                class="ml-1"
                                                icon="person"
                                                variant="success"
                                            ></b-icon>
                                            {{ item.children }} children
                                            <b-icon
                                                class="ml-1"
                                                icon="people"
                                                variant="success"
                                            ></b-icon>
                                            {{ item.adults }} adults </small
                                        ><br />
                                        <small class="text-muted">
                                            Cost: {{ item.cost | moneyFormat }}</small
                                        ><br />
                                        <label class="text-muted">{{
                                            item.text | truncate(100)
                                        }}</label>
                                    </b-col>
                                    <b-col cols="1" class="p-0">
                                        <b-button variant="link">
                                            <b-icon
                                                icon="pen"
                                                variant="info"
                                                v-b-modal.edit-day-activity
                                                @click="
                                                    ;(sel_activity = item),
                                                        (use_range = false)
                                                "
                                            ></b-icon>
                                        </b-button>
                                        <b-button variant="link">
                                            <b-icon
                                                icon="x"
                                                variant="danger"
                                                @click="removeDayActivity(index)"
                                            ></b-icon>
                                        </b-button>
                                    </b-col>
                                </b-row>
                            </div>
                        </div>
                    </draggable>
                </div>
            </b-col>
            <b-col cols="5" class="px-4" v-if="!!sel_day">
                <div class="row activity-heading text-center mx-0">
                    <b-col>
                        <h4>{{ actSelected }}</h4>
                    </b-col>
                    <b-col cols="4">
                        <b-form-select
                            v-model="actSelected"
                            :options="actOptions"
                        ></b-form-select>
                    </b-col>
                </div>
                <RoadTransferComp
                    v-if="actSelected === 'road transfers'"
                    :sel_day="sel_day"
                />
                <FlightTransferComp
                    v-if="actSelected === 'flight transfers'"
                    :sel_day="sel_day"
                />
                <AccomodationsComp
                    v-if="actSelected === 'accomodations'"
                    :sel_day="sel_day"
                    :arrival_date="itinerary.date"
                />
                <ActivitiesComp v-if="actSelected === 'activities'" :sel_day="sel_day" />
            </b-col>
        </b-row>
        <b-modal
            id="edit-day-activity"
            :title="`Update ${sel_activity.type} Activity`"
            hide-footer
        >
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
            </form> </b-modal
        ><b-modal id="add-day-modal" title="Add A Day">
            <form>
                <div class="form-group">
                    <label>Name </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Day Title"
                        v-model="new_day.name"
                    />
                </div>
                <br />
                <div class="form-group">
                    <label>Description</label>
                    <textarea
                        class="form-control"
                        placeholder="Say something about the day"
                        rows="6"
                        v-model="new_day.description"
                    ></textarea>
                </div>
            </form>

            <template v-slot:modal-footer="{ cancel }">
                <b-button size="lg" variant="danger" :disabled="loading" @click="cancel()"
                    >Cancel</b-button
                >
                <b-overlay
                    :show="loading"
                    rounded
                    opacity="0.6"
                    spinner-small
                    class="d-inline-block"
                >
                    <b-button
                        size="lg"
                        variant="success"
                        :disabled="loading"
                        @click="addDay"
                        >Add Day</b-button
                    >
                </b-overlay>
            </template>
        </b-modal>
    </div>
</template>

<script>
import draggable from 'vuedraggable'
// import { itinerary } from '@/Constants/itinerary.js'
import RoadTransferComp from '@/components/ItineraryDetails/RoadTransfers.vue'
import FlightTransferComp from '@/components/ItineraryDetails/FlightTransfers.vue'
import AccomodationsComp from '@/components/ItineraryDetails/Accomodations.vue'
import ActivitiesComp from '@/components/ItineraryDetails/Activities.vue'

export default {
    name: 'itinerary_details',
    data() {
        return {
            start_time: this.$moment().format('HH:mm'),
            end_time: this.$moment().format('HH:mm'),
            use_range: false,
            sel_activity: {},
            loading: false,
            errors: {},
            season: {},
            sel_day_index: 0,
            sel_day: null,
            new_day: {},
            breadcrumb_items: this.breadcrumbItems(),
            actSelected: 'accomodations',
            actOptions: [
                // prettier-ignore
                {
                    value: 'road transfers',
                    text: 'Road Transfers'
                },
                {
                    value: 'flight transfers',
                    text: 'Flight Transfers'
                },
                {
                    value: 'accomodations',
                    text: 'Accomodations'
                },
                {
                    value: 'activities',
                    text: 'Activities'
                }
            ]
        }
    },
    props: {
        itinerary: Object,
        bookingDate: String
    },
    components: {
        draggable,
        RoadTransferComp,
        FlightTransferComp,
        AccomodationsComp,
        ActivitiesComp
    },
    methods: {
        daySelect(index = 0) {
            this.sel_day_index = index
            this.sel_day = this.itinerary.days[index]
        },
        removeDayActivity(index) {
            this.sel_day.items.splice(index, 1)
            this.daySelect()
        },
        addDay() {
            if (!this.new_day.name) {
                this.toastError('title of order not specified')
                return false
            }
            if (!this.new_day.description) {
                this.toastError('description of order not specified')
                return false
            }
            const count = this.itinerary.days.length + 1
            this.itinerary.days.push({
                name: this.new_day.name,
                description: this.new_day.description,
                items: []
            })
            this.daySelect(count - 1)
            this.new_day = {}
            this.$bvModal.hide('add-day-modal')
        },
        removeDay(index) {
            this.itinerary.days.splice(index, 1)
            this.daySelect()
        },
        breadcrumbItems: function () {
            return [
                // prettier-ignore
                {
                    text: 'Dashboard',
                    to: {
                        name: 'Dashboard'
                    }
                },
                {
                    text: 'Itineraries',
                    to: {
                        name: 'Itineraries',
                        params: {
                            id: this.$route.params.id
                        }
                    }
                },
                {
                    text: 'Details',
                    active: true
                }
            ]
        }
    },
    computed: {
        dragOptions1() {
            return {
                animation: '200',
                ghostClass: 'ghost',
                group: 'day-list-items'
            }
        },
        dragOptions2() {
            return {
                animation: '200',
                ghostClass: 'ghost',
                group: 'day-list'
            }
        }
    },
    mounted() {
        this.daySelect()
    },
    watch: {
        'sel_day.items': function (newval) {
            if (newval === undefined) {
                return false
            }
            this.sel_day.items.map(function (item, index) {
                item.priority = index + 1
                return item
            })
        },
        'itinerary.days': function () {
            this.itinerary.days.map(function (item, index) {
                item.priority = index + 1
                return item
            })
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
    }
}
</script>

<style scoped>
.heading {
    padding: 15px 0 5px 0;
    color: #ffffffcc;
    font-family: 'Gugi', cursive;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    text-transform: uppercase;
    cursor: grab;
    background-color: #607d8b;
}

.activity-heading {
    padding: 15px 0 5px 0;
    color: #607d8b;
    font-family: 'Gugi', cursive;
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    text-transform: uppercase;
    background-color: #e3e7e9;
}

.list-width {
    width: 300px;
    border-radius: 10px;
}

.ghost {
    opacity: 0.5;
    background-color: #dfeef266;
}
</style>
<style>
.task-item {
    font-size: 0.9rem;
    cursor: grab;
    margin-bottom: 2px;
    height: 6.3rem;
}

.to-scroll {
    max-height: 450px;
    overflow-y: auto;
}
</style>
