<template>
    <b-modal id="allocate-vehicles-modal" title="Allocate Vehicles" size="lg" hide-footer>
        <b-table
            :items="vehicles"
            :fields="all_vehicles_fields"
            :striped="true"
            :responsive="true"
            no-border-collapse
            sticky-header
            sort-icon-left
        >
            <template v-slot:cell(#)="data">
                {{ data.index + 1 }}
            </template>
            <template v-slot:cell(payment_date)="row"> {{ row.item.date }} </template>
            <template v-slot:cell(paid_in_by)="row"> {{ row.item.user }} </template>
            <template v-slot:cell(action)="row">
                <span
                    class="badge badge-success"
                    v-if="allocatedVehicles.includes(row.item.id)"
                    style="font-size: 12px"
                    >Allocated</span
                >
                <b-button v-else
                    size="lg"
                    class=""
                    @click="allocateVehicle(row.item.id)"
                    pill
                    variant="outline-info"
                    >Allocate</b-button
                >
            </template>
        </b-table>
    </b-modal>
</template>

<script>

export default {
    data() {
        return {
            vehicles: [],
            loading: false,
            errors: {},
            all_vehicles_fields: [
                // prettier-ignore
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'code',
                    sortable: true
                },
                {
                    key: 'type',
                    sortable: true
                },
                {
                    key: 'no_of_seats',
                    sortable: true
                },
                {
                    key: 'cost_per_day',
                    sortable: true
                },
                {
                    key: 'status',
                    sortable: true
                },
                {
                    key: 'action',
                    sortable: false
                }
            ]
        }
    },
    props: {
        allocatedVehicles: Array
    },
    methods: {
        getVehicles() {
            this.$http.get('/vehicles').then((vehicles) => {
                this.vehicles = vehicles.data.data
            })
        },
        allocateVehicle(vehicleId) {
            this.loading = true
            this.errors = {}
            this.$http.post('/bookings/' + this.$route.params.id + '/vehicles/' + vehicleId)
                .then(response => {
                    this.alertAddSuccess()
                    this.allocatedVehicles = response.data.data.map(i => i.id)
                    this.$parent.callBookings()
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    mounted() {
        this.getVehicles()
    }
}
</script>
