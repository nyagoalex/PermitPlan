<template>
    <div class="bg-white text-left mt-3 mx-4">
        <b-table class="acc-tb" :striped="true" :outlined="true" :hover="true" :no-border-collapse="true" :items="tours" :fields="fields" caption-top :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" sort-icon-left responsive="sm" sticky-header @row-clicked="tour=>$set(tour, '_showDetails', !tour._showDetails)">
            <template v-slot:table-caption>
                <b-row>
                    <b-col><span class='font-weight-bold'>Departure Tours</span></b-col>
                    <b-col class='text-center'>
                        <b-button size="sm" variant="success" @click="newTourModal">
                            <b-icon icon="plus"></b-icon> Add Departure Tour
                        </b-button>
                    </b-col>
                    <b-col>
                        <b-button :pressed.sync="show_filters" class='float-right' variant="link">
                            <b-icon icon="funnel"></b-icon> show filters
                        </b-button>
                    </b-col>
                </b-row>
                <b-row v-show="show_filters" class="pt-3" style="height: 50px; background-color:#F5F9F7;">
                    <b-col>
                        <b>Status: </b>
                        <b-badge pill :variant="`${(filters.active === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': !filters.active === null, 'ml-2': true }" @click="filters.active = null">All</b-badge>
                        <b-badge pill :variant="`${(filters.active === true) ? 'primary' : 'light'}`" :class="{ 'bg-white': !filters.active === true, 'ml-2': true }" @click="filters.active = true">Active</b-badge>
                        <b-badge pill :variant="`${(filters.active === false) ? 'primary' : 'light'}`" :class="{ 'bg-white': !filters.active === false, 'ml-2': true }" @click="filters.active = false">Inactive</b-badge>

                    </b-col>
                </b-row>
            </template>
            <template v-slot:cell(#)="row">{{ row.index + 1 }}</template>
            <template v-slot:cell(permits)="row">{{ row.item.permits_count }}</template>
            <template v-slot:cell(status)="row">
                <b-badge pill variant="success" v-if="row.item.active">Active</b-badge>
                <b-badge pill variant="dark" v-else>Inactive</b-badge>
            </template>
            <template v-slot:row-details="row">
                <div class="text-center">
                    <b-button size="sm" class="mx-3" pill variant="outline-dark" v-b-modal.new-permit @click="selected_tour=row.item">Add Permits</b-button>
                    <span :id="`tooltip-button-show-permits-${row.item.id}`" class="d-inline-block" tabindex="0">
                        <b-button size="sm" class="mx-3" pill variant="outline-secondary" v-b-modal.view-departure-permits @click="selected_tour=row.item" :disabled="row.item.permits_count == 0">Show Permits</b-button>
                    </span>
                    <b-button pill size="sm" class="mx-3" variant="outline-warning" v-if="row.item.active" @click="deactivateTour(row.item.id)">Deactivate</b-button>
                    <b-button pill size="sm" class="mx-3" variant="outline-success" v-else @click="activateTour(row.item.id)">Activate</b-button>
                    <b-button size="sm" class="mx-3" pill variant="outline-info" @click="editTourModal(row.item)">Edit</b-button>
                    <span :id="`tooltip-button-${row.item.id}`" class="d-inline-block" tabindex="0">
                        <b-button size="sm" class="mx-3" pill variant="outline-danger">Remove</b-button>
                    </span>
                    <b-tooltip v-if="false" :target="`tooltip-button-${row.item.id}`" triggers="hover" variant="danger">Tour Has Allocated Pemits</b-tooltip>
                    <b-tooltip v-if="row.item.permits_count == 0" :target="`tooltip-button-show-permits-${row.item.id}`" triggers="hover" variant="dark">Tour Has No Pemits</b-tooltip>
                </div>
            </template>
        </b-table>
        <div>
            <label>Sorting By: <b>{{ sortBy }}</b>, Sort Direction:
                <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b></label>
            <b-pagination class="float-right" v-model="current_page" :total-rows="total" :per-page="per_page" last-number @input="getTours(current_page)"></b-pagination>
        </div>
        <AddDeparturePermit :tour_id="selected_tour.id" />
        <AddDepartureTour :tour="selected_tour" :mode="mode" />
        <ViewDeparturePermits :tour="selected_tour" />
    </div>
</template>

<script>
import EventBus from '@/Events/EventBus.js'
import AddDeparturePermit from '@/components/Modals/AddDeparturePermit.vue'
import AddDepartureTour from '@/components/Modals/AddDepartureTour.vue'
import ViewDeparturePermits from '@/components/Modals/ViewDeparturePermits.vue'

export default {
    data() {
        return {
            sortBy: 'arrival_date',
            sortDesc: false,
            show_filters: false,
            filters: {
                active: null,
                search: null
            },
            fields: [ // prettier-ignore
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'name',
                    sortable: true
                },
                {
                    key: 'arrival_date',
                    sortable: true
                },
                {
                    key: 'departure_date',
                    sortable: true
                },
                {
                    key: 'permits',
                    sortable: true
                },
                {
                    key: 'user',
                    sortable: true
                },
                {
                    key: 'status'
                }
            ],
            selected_tour: {},
            tours: [],
            mode: '',
            current_page: process.env.VUE_APP_CURRENTPAGE,
            per_page: process.env.VUE_APP_PERPAGE,
            total: process.env.VUE_APP_TOTALROWS
        }
    },
    components: {
        AddDeparturePermit,
        AddDepartureTour,
        ViewDeparturePermits
    },
    methods: {
        getTours(page = 1) {
            const filters = this.filters
            filters.page = page
            this.$http.get('/departure-tours', {
                params: filters
            }).then(tours => {
                this.tours = tours.data.data
                const meta = tours.data.meta
                this.current_page = meta.current_page
                this.per_page = meta.per_page
                this.total = meta.total
            })
        },
        activateTour(id) {
            const index = this.tours.findIndex(item => item.id === id)
            this.$swal.fire({
                title: 'Activate Departure Tour?',
                text: 'Are you sure you want to perform this action',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, activate it!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    this.$http.post('/departure-tours/' + id + '/activate').then(() => {
                        this.$set(this.tours[index], 'active', true)
                        this.$swal.fire('Activated!', 'Tour has been activated.', 'success')
                    })
                }
            })
        },
        deactivateTour(id) {
            const index = this.tours.findIndex(item => item.id === id)
            this.$swal.fire({
                title: 'Deactivate Departure Tour?',
                text: 'Are you sure you want to perform this action',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, deactivate it!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    this.$http.delete('/departure-tours/' + id + '/deactivate').then(() => {
                        this.$set(this.tours[index], 'active', false)
                        this.$swal.fire('Deactivated!', 'Tour has been deactivated.', 'success')
                    })
                }
            })
        },
        newTourModal() {
            this.selected_tour = this.resetModal()
            this.mode = 'create'
            this.$bvModal.show('new-departure-tour')
        },
        editTourModal(tour) {
            this.selected_tour = tour
            this.mode = 'update'
            this.$bvModal.show('new-departure-tour')
        },
        resetModal() {
            return {
                name: '',
                arrival_date: '',
                departure_date: ''
            }
        }
    },
    mounted() {
        this.getTours()
        EventBus.$on('EVENT_SEARCH', (search) => {
            if (this.$route.name === 'GroupPermits') {
                this.filters.search = search
            }
        })
    },
    watch: {
        'filters.active': function (val, oldVal) {
            this.getTours()
        },
        'filters.search': function (val, oldVal) {
            this.getTours()
        }
    }
}
</script>
