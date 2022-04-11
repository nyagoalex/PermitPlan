<template>
<div class="bg-white text-left mt-3 mx-4">
       <div v-if="loading" class="my-5 text-center"><b-icon icon="sun" animation="spin" font-scale="1"></b-icon><span style="font-size:15px;font-weight:800;"> Loading ...</span></div>
    <div v-else-if="!vehicles.length" class="my-5 text-center">
        <b-button
                    @click="newVehicleModal"
                    variant="btn btn-outline-success"
                    size="md"
                    >+ Add a vehicle</b-button
                >
<div class="container py-5" style="padding-left:100px;padding-right:100px;">

                <div class="">
                <div class="d-flex align-items-center rounded py-3 px-5 bg-info-light">
                    <span class="svg-icon svg-icon svg-icon-3x svg-icon-warning me-5" style="">
                        <svg width="50" height="50" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="mh-50px"><rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="orange"></rect><rect x="11" y="14" width="7" height="2" rx="1" transform="rotate(-90 11 14)" fill="orange"></rect><rect x="11" y="17" width="2" height="2" rx="1" transform="rotate(-90 11 17)" fill="orange"></rect>
                </svg>
                </span>
                <div class="" style="font-size:20px;padding-left:10px;color: #8e887a;">
                     No vehicles have been added to your system. Please add some vehicles
                </div>

                </div>
                </div>
                </div>
        </div>
    <div v-else>
    <b-table class="acc-tb" :striped="true" :outlined="true" :hover="true" :no-border-collapse="true" :items="vehicles" :fields="fields" caption-top :sort-by.sync="sortBy" :sort-desc.sync="sortDesc" sort-icon-left responsive="sm" sticky-header @row-clicked="item=>$set(item, '_showDetails', !item._showDetails)">
        <template v-slot:table-caption>
            <b-row>
                <b-col><span class='font-weight-bold'>Vehicles</span></b-col>
                <b-col class='text-center'>
                    <b-button @click="newVehicleModal" size="lg" variant="success">
                        <b-icon icon="plus"></b-icon> Add Vehicle
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
                    <b-badge pill :variant="`${(filters.status === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != null, 'ml-2': true }" @click="filters.status = null">All</b-badge>
                    <b-badge pill :variant="`${(filters.status === 'ready') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'ready', 'ml-2': true }" @click="filters.status = 'ready'">Ready</b-badge>
                    <b-badge pill :variant="`${(filters.status === 'disposed_off') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'disposed_off', 'ml-2': true }" @click="filters.status = 'disposed_off'">Disposed Off</b-badge>
                    <b-badge pill :variant="`${(filters.status === 'too_old') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'too_old', 'ml-2': true }" @click="filters.status = 'too_old'">Too Old</b-badge>
                    <b-badge pill :variant="`${(filters.status === 'has_issues') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'has_issues', 'ml-2': true }" @click="filters.status = 'has_issues'">Has issues</b-badge>

                </b-col>
                <b-col class="text-right">
                    <b>Owner: </b>
                    <b-badge pill :variant="`${(filters.ownership === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.ownership != null, 'ml-2': true }" @click="filters.ownership = null">All</b-badge>
                    <b-badge pill :variant="`${(filters.ownership === 'company') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.ownership != 'company', 'ml-2': true }" @click="filters.ownership = 'company'">Company</b-badge>
                    <b-badge pill :variant="`${(filters.ownership === 'hired') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.ownership != 'hired', 'ml-2': true }" @click="filters.ownership = 'hired'">Hired</b-badge>

                </b-col>
            </b-row>
        </template>
        <template v-slot:cell(#)="row">
            {{ row.index + 1 }}
        </template>
        <template v-slot:cell(status)="row">
            <span :class="{ badge: true, 'badge-success': row.item.status == 'ready', 'badge-danger': row.item.status == 'disposed_off', 'badge-info': row.item.status == 'too_old', 'badge-warning': row.item.status == 'has_issues'}">
                {{ row.item.status.replace("_", " ")}}</span>
        </template>
        <template v-slot:row-details="row">
            <b-row>
                <b-col><strong>Ownership: </strong> {{row.item.ownership}}</b-col>
                <b-col><strong>Registration Number: </strong> {{row.item.reg_no}}</b-col>
                <b-col><strong>Color: </strong>
                    <b-badge pill size="lg" variant="success"> {{row.item.color}} </b-badge>
                </b-col>
                <b-col class="text-center">
                    <b-button pill size="lg" variant="warning" @click="editVehicleModal(row.item)" class="mr-4">Edit</b-button>
                    <b-button pill size="lg" variant="danger" @click="deleteVehicle(row.item.id)"> Delete</b-button>
                </b-col>
            </b-row>
        </template>
    </b-table>
    <div>
        <label>Sorting By: <b>{{ sortBy }}</b>, Sort Direction:
            <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b></label>
        <b-pagination class="float-right" v-model="current_page" :total-rows="total" :per-page="per_page" last-number @input="getVehicles(current_page)"></b-pagination>
    </div>
    </div>
    <AddVehicle v-bind:vehicle="vehicle" v-bind:mode="mode" />
</div>
</template>

<script>
import AddVehicle from '@/components/Modals/AddVehicle.vue'
import EventBus from '@/Events/EventBus.js'

export default {
    data() {
        return {
            sortBy: 'code',
            sortDesc: false,
            filters: {
                status: null,
                ownership: null,
                page: 1,
                search: null
            },
            show_filters: false,
            fields: [
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'code',
                    sortable: true
                },
                // { key: 'reg_number', sortable: true },
                {
                    key: 'type',
                    sortable: true
                },
                // { key: 'color', sortable: true },
                {
                    key: 'no_of_seats',
                    sortable: true
                },
                {
                    key: 'cost_per_day',
                    sortable: true
                },
                // { key: 'ownership', sortable: true },
                {
                    key: 'status'
                }
            ],
            vehicles: [],
            vehicle: this.resetModal(),
            mode: '',
            current_page: process.env.VUE_APP_CURRENTPAGE,
            per_page: process.env.VUE_APP_PERPAGE,
            total: process.env.VUE_APP_TOTALROWS,
            loading: false
        }
    },
    components: {
        AddVehicle
    },
    methods: {
        getVehicles(page = 1) {
            this.loading = true
            const filters = this.filters
            filters.page = page
            this.$http.get('/vehicles', {
                params: filters
            }).then(vehicles => {
                this.vehicles = vehicles.data.data
                const meta = vehicles.data.meta
                this.current_page = meta.current_page
                this.per_page = meta.per_page
                this.total = meta.total
                this.loading = false
            })
        },
        deleteVehicle(id) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http.delete('/vehicles/' + id).then(() => {
                        this.vehicles = this.vehicles.filter(item => item.id !== id)
                        this.$swal.fire('Deleted!', 'Vehicle has been deleted.', 'success')
                    })
                }
            })
        },
        newVehicleModal() {
            this.vehicle = this.resetModal()
            this.mode = 'create'
            this.$bvModal.show('new-vehicle')
        },
        editVehicleModal(vehicle) {
            this.vehicle = vehicle
            this.mode = 'update'
            this.$bvModal.show('new-vehicle')
        },
        resetModal() {
            return {
                reg_no: '',
                color: '',
                no_of_seats: '',
                type: '',
                status: '',
                ownership: '',
                cost_per_day: '',
                code: ''
            }
        }
    },
    mounted() {
        this.getVehicles()
        EventBus.$on('EVENT_SEARCH', (search) => {
            if (this.$route.name === 'Vehicles') {
                this.filters.search = search
            }
        })
    },
    watch: {
        'filters.status': function (val, oldVal) {
            this.getVehicles()
        },
        'filters.search': function (val, oldVal) {
            this.getVehicles()
        }
    }
}
</script>
