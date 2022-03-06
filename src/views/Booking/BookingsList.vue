<template>
    <b-container class="bg-white text-left mt-3" fluid>
             <div v-if="loading" class="my-5 text-center"><b-icon icon="arrow-clockwise" animation="spin" font-scale="4"></b-icon>Loading ...</div>
    <div v-else-if="!bookings.length" class="my-5 text-center">
        <b-button
                    v-b-modal.new-booking
                    variant="btn btn-outline-success"
                    size="lg"
                    >+ Add a booking</b-button
                >

            <h2 class="text-muted mt-5">NO BOOKINGS ADDED YET</h2>
        </div>
    <div v-else>
        <b-table :striped="true" :outlined="true" :hover="true" :no-border-collapse="true" :items="bookings" :fields="fields" caption-top :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" sort-icon-left responsive="sm" @row-clicked="onRowClicked" class="acc-tb" sticky-header>
            <template v-slot:table-caption>
                <b-row>
                    <b-col><span class='font-weight-bold'>Bookings</span></b-col>
                    <b-col>
                        <b-button :pressed.sync="show_filters" class='float-right' variant="link">
                            <b-icon icon="funnel"></b-icon> show filters
                        </b-button>
                    </b-col>
                </b-row>
                <b-row v-show="show_filters" class="pt-3" style="height: 50px; background-color:#F5F9F7;">
                    <b-col class="text-left">
                        <b>Status: </b>
                        <b-badge pill :variant="`${(filters.status === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != null, 'ml-2': true }" @click="filters.status = null">All</b-badge>
                        <b-badge pill :variant="`${(filters.status === 'confirmed') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'confirmed', 'ml-2': true }" @click="filters.status = 'confirmed'">Confirmed</b-badge>
                        <b-badge pill :variant="`${(filters.status === 'tentative') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'tentative', 'ml-2': true }" @click="filters.status = 'tentative'">Tentative</b-badge>
                        <b-badge pill :variant="`${(filters.status === 'cancelled') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'cancelled', 'ml-2': true }" @click="filters.status = 'cancelled'">Cancelled</b-badge>
                    </b-col>
                    <b-col class="text-center">
                        <b>Source: </b>
                        <b-badge pill :variant="`${(filters.source === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.source != null, 'ml-2': true }" @click="filters.source = null">All</b-badge>
                        <b-badge pill :variant="`${(filters.source === 'agent') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.source != 'agent', 'ml-2': true }" @click="filters.source = 'agent'">Agent</b-badge>
                        <b-badge pill :variant="`${(filters.source === 'direct') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.source != 'direct', 'ml-2': true }" @click="filters.source = 'direct'">Direct</b-badge>
                    </b-col>
                    <b-col class="text-right">
                        <b>Payment: </b>
                        <b-badge pill :variant="`${(filters.payment_status === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.payment_status != null, 'ml-2': true }" @click="filters.payment_status = null">All</b-badge>
                        <b-badge pill :variant="`${(filters.payment_status === 'cleared') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.payment_status != 'cleared', 'ml-2': true }" @click="filters.payment_status = 'cleared'">Cleared</b-badge>
                        <b-badge pill :variant="`${(filters.payment_status === 'outstanding') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.payment_status != 'outstanding', 'ml-2': true }" @click="filters.payment_status = 'outstanding'">Outstanding</b-badge>
                    </b-col>
                </b-row>
            </template>
            <template v-slot:cell(#)="row">
                {{ row.index + 1 }}
            </template>
            <template v-slot:cell(permits)="row"> {{ row.item.permits_count}} </template>
            <template v-slot:cell(persons)="row"> {{ row.item.no_of_persons}} </template>
            <template v-slot:cell(status)="row">
                <b-badge pill variant="info" v-if="row.item.status == 'tentative'">Tentative</b-badge>
                <b-badge pill variant="success" v-if="row.item.status == 'confirmed'">Confirmed</b-badge>
                <b-badge pill variant="danger" v-if="row.item.status == 'cancelled'">Cancelled</b-badge>
            </template>
        </b-table>
        <div>
            <label>Sorting By: <b>{{ sortBy }}</b>, Sort Direction:
                <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b></label>
            <b-pagination class="float-right" v-model="current_page" :total-rows="total" :per-page="per_page" last-number @input="getBookings(current_page)"></b-pagination>
        </div>
    </div>
    </b-container>
</template>

<script>
import EventBus from '@/Events/EventBus.js'

export default {
    data() {
        return {
            sortBy: 'number',
            sortDesc: false,
            show_filters: false,
            filters: {
                status: null,
                source: null,
                payment_status: null,
                search: null
            },
            fields: [ // prettier-ignore
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'number',
                    sortable: true
                },
                {
                    key: 'ref',
                    sortable: true
                },
                {
                    key: 'source',
                    sortable: true
                },
                {
                    key: 'status',
                    sortable: true
                },
                {
                    key: 'persons',
                    sortable: true
                },
                {
                    key: 'permits',
                    sortable: true
                },
                {
                    key: 'total_cost',
                    sortable: true
                },
                {
                    key: 'balance',
                    sortable: true
                },
                {
                    key: 'arrival',
                    sortable: true
                }
            ],
            bookings: [],
            mode: '',
            current_page: process.env.VUE_APP_CURRENTPAGE,
            per_page: process.env.VUE_APP_PERPAGE,
            total: process.env.VUE_APP_TOTALROWS,
            loading: false
        }
    },
    computed: {
        rows() {
            return this.items.length
        }
    },
    methods: {
        getBookings(page = 1) {
            this.loading = true
            const filters = this.filters
            filters.page = page
            this.$http.get('/bookings', {
                params: filters
            }).then(bookings => {
                this.bookings = bookings.data.data
                const meta = bookings.data.meta
                this.current_page = meta.current_page
                this.per_page = meta.per_page
                this.total = meta.total
                this.loading = false
            })
        },
        onRowClicked(item, index, event) {
            this.$router.push({
                name: 'BookingDetails',
                params: {
                    id: item.id
                }
            })
        }
    },
    mounted() {
        this.getBookings()
        EventBus.$on('EVENT_SEARCH', (search) => {
            if (this.$route.name === 'Bookings') {
                this.filters.search = search
            }
        })
    },
    watch: {
        'filters.status': function (val, oldVal) {
            this.getBookings()
        },
        'filters.source': function (val, oldVal) {
            this.getBookings()
        },
        'filters.payment_status': function (val, oldVal) {
            this.getBookings()
        },
        'filters.search': function (val, oldVal) {
            this.getBookings()
        }
    }
}
</script>
