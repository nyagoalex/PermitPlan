<template>
    <div>
        <b-modal id="view-departure-permits" :title="`Departure Permits For ${tour.name}`" size="xl" hide-footer>
            <b-table :items="tour.permits" :fields="permit_fields" :striped="true" :responsive="true" no-border-collapse sticky-header @row-clicked="permit=>$set(permit, '_showDetails', !permit._showDetails)" sort-by="number" sort-icon-left>
                <template v-slot:cell(#)="data">{{ data.index + 1 }}</template>
                <template v-slot:cell(type)="row"> {{ row.item.permit_type_name}} </template>
                <template v-slot:cell(preffered_sector)="row"> {{ row.item.sector}} </template>
                <template v-slot:cell(tracking_date)="row"> {{ row.item.tracking_date_format}} </template>
                <template v-slot:cell(status)="row">

                    <span class="badge badge-warning" v-if="!row.item.allocated" style="font-size:12px;">Available</span>
                    <span v-else :id="`tooltip-button-allocated-${row.item.id}`" class="d-inline-block" tabindex="0">
                        <span class="badge badge-success" style="font-size:12px;">Allocated To</span>
                    </span>
                    <b-tooltip :target="`tooltip-button-allocated-${row.item.id}`" triggers="hover" variant="dark">{{row.item.allocated_to}}</b-tooltip>
                </template>
                <template v-slot:cell(action)="row">
                    <div v-if="!row.item.allocated" class="text-right">
                        <span :id="`tooltip-button-tour-active-${row.item.id}`" class="d-inline-block" tabindex="0">
                            <b-button size="sm" class="mr-1" v-b-modal.bookings-modal @click="reschedule_permit = row.item" pill variant="outline-info" :disabled="!tour.active">Allocate</b-button>
                        </span>
                        <b-button size="sm" class="mr-1" v-b-modal.reschedule @click="reschedule_permit = row.item" pill variant="outline-dark">Reschedule</b-button>
                        <b-button size="sm" class="" @click="deletePermit(row.item.id)" pill variant="outline-danger">Delete</b-button>
                        <b-tooltip v-if="!tour.active" :target="`tooltip-button-tour-active-${row.item.id}`" triggers="hover" variant="info">Can't Allocate Permit, Tour Is Inactive </b-tooltip>
                    </div>
                </template>
            </b-table>
        </b-modal>
        <b-modal id="reschedule" :title="`Reschedule Permit: ${reschedule_permit.number}`">
            <div class="form-group">
                <input type="date" class="form-control place" v-model="reschedule_permit.tracking_date" :class="{ 'is-invalid': errors.tracking_date}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.tracking_date">
                    <li v-for="(error) in errors.tracking_date" :key="error">{{ error }}</li>
                </ul>
            </div>
            <template v-slot:modal-footer="{ cancel}">
                <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
                <b-button size="sm" variant="success" @click="reschedule">Reshedule Permit</b-button>
            </template>
        </b-modal>
        <b-modal id="bookings-modal" :title="`Allocate For Permit: ${reschedule_permit.number}`" size="lg" hide-footer>
            <b-table :striped="true" :outlined="true" :hover="true" :no-border-collapse="true" :items="bookings" :fields="booking_fields" sort-by="number" sort-icon-left responsive="sm" sticky-header>
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
                <template v-slot:cell(action)="row">
                    <div v-if="!row.item.allocated" class="text-right">
                        <b-button size="sm" pill variant="outline-success" @click="allocatePermit(row.item.id)">Choose <b-icon icon="check2-circle"></b-icon>
                        </b-button>
                    </div>
                </template>
            </b-table>
        </b-modal>
    </div>
</template>

<script>
export default {
    data() {
        return {
            reschedule_permit: {},
            errors: {},
            permit_fields: [ // prettier-ignore
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'number',
                    sortable: true
                },
                {
                    key: 'type',
                    sortable: true
                },
                {
                    key: 'cost',
                    sortable: true
                },
                {
                    key: 'preffered_sector',
                    sortable: true
                },
                {
                    key: 'status',
                    sortable: true
                },
                {
                    key: 'tracking_date',
                    sortable: true
                },
                {
                    key: 'action',
                    sortable: false
                }
            ],
            booking_fields: [ // prettier-ignore
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
                    key: 'arrival',
                    sortable: true
                },
                {
                    key: 'action',
                    sortable: false
                }
            ],
            bookings: []
        }
    },
    props: {
        tour: Object
    },
    methods: {
        reschedule() {
            this.errors = {}
            const id = this.reschedule_permit.id
            const index = this.tour.permits.findIndex(item => item.id === id)
            const param = {
                tracking_date: this.reschedule_permit.tracking_date
            }
            this.$http.patch('/departure-tours/' + this.tour.id + '/permits/' + id, param)
                .then(permit => {
                    this.toastSuccess('Successfully Updated')
                    this.$bvModal.hide('reschedule')
                    this.$set(this.tour.permits, index, permit.data.data)
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
        },
        deletePermit(id) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http.delete('/departure-tours/' + this.tour.id + '/permits/' + id).then(() => {
                        this.tour.permits = this.tour.permits.filter(item => item.id !== id)
                        this.$swal.fire('Deleted!', 'Permit has been deleted.', 'success')
                    })
                }
            })
        },
        allocatePermit(bookingId) {
            const id = this.reschedule_permit.id
            const index = this.tour.permits.findIndex(item => item.id === id)
            const param = {
                booking_id: bookingId
            }
            this.$http.post('/departure-tours/' + this.tour.id + '/permits/' + id + '/allocate', param).then(permit => {
                // this.tour.permits[index] = permit.data.data
                this.$set(this.tour.permits, index, permit.data.data)
                this.$bvModal.hide('bookings-modal')
                this.$swal.fire('Allocation!', 'Permit Allocated Successfully.', 'success')
            }).catch(errors => {
                this.toastError(errors.message)
            })
        },
        getBookings() {
            this.$http.get('/bookings').then(bookings => {
                this.bookings = bookings.data.data
            })
        }
    },
    mounted() {
        this.getBookings()
    }
}
</script>
