<!-- @format -->

<template>
    <div class="bg-white text-left mt-3 mx-4">
        <b-table
            class="acc-tb"
            :striped="true"
            :outlined="true"
            :hover="true"
            :no-border-collapse="true"
            :items="itineraries"
            :fields="fields"
            caption-top
            :sort-by.sync="sortBy"
            :sort-desc.sync="sortDesc"
            sort-icon-left
            responsive="sm"
            @row-clicked="onRowClicked"
        >
            <template v-slot:table-caption>
                <b-row>
                    <b-col><span class="font-weight-bold">Itineraries</span></b-col>
                    <b-col class="text-center">
                        <b-button
                            size="sm"
                            variant="success"
                            v-b-modal.add-itinerary-modal
                            @click="resetModal"
                        >
                            <b-icon icon="plus"></b-icon>
                            Build New Itinerary
                        </b-button>
                    </b-col>
                    <b-col>
                        <b-button
                            :pressed.sync="show_filters"
                            class="float-right"
                            variant="link"
                        >
                            <b-icon icon="funnel"></b-icon> show filters
                        </b-button>
                    </b-col>
                </b-row>
                <b-row
                    v-show="show_filters"
                    class="pt-3"
                    style="height: 50px; background-color: #f5f9f7"
                >
                    <b-col>
                        <b>Status: </b>
                        <b-badge
                            pill
                            :variant="`${filters.active === null ? 'primary' : 'light'}`"
                            :class="{
                                'bg-white': !filters.active === null,
                                'ml-2': true
                            }"
                            @click="filters.active = null"
                            >All</b-badge
                        >
                        <b-badge
                            pill
                            :variant="`${filters.active === true ? 'primary' : 'light'}`"
                            :class="{
                                'bg-white': !filters.active === true,
                                'ml-2': true
                            }"
                            @click="filters.active = true"
                            >Active</b-badge
                        >
                        <b-badge
                            pill
                            :variant="`${filters.active === false ? 'primary' : 'light'}`"
                            :class="{
                                'bg-white': !filters.active === false,
                                'ml-2': true
                            }"
                            @click="filters.active = false"
                            >Inactive</b-badge
                        >
                    </b-col>
                    <b-col>
                        <DateRangePickerSlot :changeDateRange="changeDateRange"
                    /></b-col>
                    <b-col>
                        <b-badge
                            pill
                            variant="secondary"
                            class="ml-2 float-right"
                            @click="clearFilters"
                            >clear filters</b-badge
                        ></b-col
                    >
                </b-row>
            </template>
            <template v-slot:cell(#)="row">
                {{ row.index + 1 }}
            </template>
            <template v-slot:cell(date)="row">
                {{ row.date | displayDate }}
            </template>
            <template v-slot:cell(status)="row">
                <b-badge pill variant="success" v-if="row.item.active">Active</b-badge>
                <b-badge pill variant="danger" v-else>Inactive</b-badge>
            </template>
        </b-table>
        <div>
            <b-pagination
                class="float-right"
                v-model="current_page"
                :total-rows="total"
                :per-page="per_page"
                last-number
                @input="getItineraries(current_page)"
            ></b-pagination>
        </div>
        <b-modal id="add-itinerary-modal" title="New Itinerary">
            <form>
                <div class="form-group">
                    <label>Name </label>
                    <input
                        type="text"
                        class="form-control"
                        placeholder="Itinerary Title"
                        v-model="itinerary.title"
                        :class="{ 'is-invalid': errors.title }"
                    />
                    <ul class="list-unstyled invalid-feedback" v-if="errors.title">
                        <li v-for="error in errors.title" :key="error">{{ error }}</li>
                    </ul>
                </div>
                <br />
                <div class="form-group">
                    <label>Start Date</label>
                    <input
                        type="date"
                        class="form-control"
                        placeholder="Itinerary Start Date"
                        v-model="itinerary.date"
                        :class="{ 'is-invalid': errors.date }"
                    />
                    <ul class="list-unstyled invalid-feedback" v-if="errors.date">
                        <li v-for="error in errors.date" :key="error">{{ error }}</li>
                    </ul>
                </div>
            </form>

            <template v-slot:modal-footer="{ cancel }">
                <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()"
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
                        size="sm"
                        variant="success"
                        :disabled="loading"
                        @click="addIntinerary"
                        >Create</b-button
                    >
                </b-overlay>
            </template>
        </b-modal>
    </div>
</template>

<script>
import EventBus from '@/Events/EventBus.js'
import DateRangePickerSlot from '@/components/DateRangePickerSlot.vue'

export default {
    data() {
        return {
            sortBy: 'code',
            sortDesc: false,
            loading: false,
            show_filters: false,
            errors: {},
            filters: {
                active: null,
                search: null,
                date_range: null
            },
            fields: [
                // prettier-ignore
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'ref_no',
                    sortable: true
                },
                {
                    key: 'date',
                    sortable: true,
                    stickyColumn: true
                },
                {
                    key: 'title',
                    sortable: true
                },
                {
                    key: 'status'
                }
            ],
            itineraries: [],
            itinerary: this.resetModal(),
            mode: '',
            current_page: process.env.VUE_APP_CURRENTPAGE,
            per_page: process.env.VUE_APP_PERPAGE,
            total: process.env.VUE_APP_TOTALROWS
        }
    },
    components: { DateRangePickerSlot },
    methods: {
        getItineraries(page = 1) {
            const filters = this.filters
            filters.page = page
            this.$http
                .get('/itineraries', {
                    params: filters
                })
                .then((itineraries) => {
                    this.itineraries = itineraries.data.data
                    const meta = itineraries.data.meta
                    this.current_page = meta.current_page
                    this.per_page = meta.per_page
                    this.total = meta.total
                })
        },
        onRowClicked(item, index, event) {
            this.$router.push({
                name: 'OffTheSelfItineraryDetails',
                params: {
                    id: item.id
                }
            })
        },
        resetModal() {
            return {
                title: '',
                date: '',
                days: JSON.stringify([])
            }
        },
        addIntinerary() {
            this.loading = true
            this.errors = {}
            this.$http
                .post('/itineraries', this.itinerary)
                .then((response) => {
                    this.alertAddSuccess()
                    this.getItineraries()
                    this.$bvModal.hide('add-itinerary-modal')
                })
                .catch((errors) => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        changeDateRange(range) {
            this.filters.start_date = this.$moment(range.startDate).format('YYYY-MM-DD')
            this.filters.end_date = this.$moment(range.endDate).format('YYYY-MM-DD')
            console.log()
            this.getItineraries()
        },
        clearFilters() {
            this.filters = {
                active: null,
                search: null,
                date_range: null
            }
            this.getItineraries()
        }
    },
    mounted() {
        this.getItineraries()
        EventBus.$on('EVENT_SEARCH', (search) => {
            if (this.$route.name === 'Itineraries') {
                this.filters.search = search
            }
        })
    },
    watch: {
        'filters.active': function (val, oldVal) {
            this.getItineraries()
        },
        'filters.search': function (val, oldVal) {
            this.getItineraries()
        }
    }
}
</script>
