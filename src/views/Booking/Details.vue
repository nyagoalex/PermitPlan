<template>
    <div class="bg-light m-3 pt-5">
        <b-row class="mx-0">
            <b-col>
                <b-breadcrumb class="py-0 px-3 mb-0" style="background-color:inherit;" :items="breadcrumb_items"></b-breadcrumb>
            </b-col>
            <b-col>
                <small>created on: <b style="color: #80391e;">{{booking.created_at}}</b></small>
            </b-col>
            <b-col>
                <small>last modified on: <b style="color: #b97455;">{{booking.updated_at}}</b></small>
            </b-col>
            <b-col v-if="booking.status == 'tentative'" class="text-right">
                <b-button size="sm" pill variant="secondary" @click="cancel">Cancel</b-button>
                <b-button size="sm" pill variant="success" class="mx-3" @click="confirm">Confirm</b-button>
            </b-col>
        </b-row>
        <b-row class="mx-0" style="background-color:#e9ecef;">
            <b-col>
                <div class="pl-3 head-t p-2 text-left">
                    {{booking.number}}<small>({{booking.ref}})</small> - <span style="font-size:26px;color:#666;">{{booking.client_name}}</span>
                </div>
            </b-col>
            <b-col col lg="2">
                <b-dropdown id="dropdown-1" text="Booking Action" class="m-md-2" variant="outline-success">
                    <b-dropdown-item-button v-b-modal.new-permit>
                        <b-icon icon="plus-circle-fill"></b-icon> Add Permit
                    </b-dropdown-item-button>
                    <b-dropdown-divider></b-dropdown-divider>
                    <b-dropdown-item v-b-modal.new-guest>Add Guest</b-dropdown-item>
                    <b-dropdown-divider></b-dropdown-divider>
                    <b-dropdown-item v-b-modal.invoice-details>Add Invoice Details</b-dropdown-item>
                    <b-dropdown-divider></b-dropdown-divider>
                    <b-dropdown-item v-b-modal.invoice-preview active>Preview Invoice</b-dropdown-item>
                </b-dropdown>
            </b-col>
        </b-row>
        <b-row class="mt-3 mx-0">
            <b-container fluid>
                <b-row>
                    <SideDetails :booking="booking" />
                    <MainDetails :booking="booking" />
                </b-row>
            </b-container>
        </b-row>
        <AddPermit />
        <AddInvoiceDetails />
        <OverallPayment :balance="booking.balance" />
        <InvoicePreview />
        <EditBooking v-bind:booking="booking" />
    </div>
</template>

<script>
import SideDetails from '@/components/Bookings/SideDetails.vue'
import MainDetails from '@/components/Bookings/MainDetails.vue'
import AddPermit from '@/components/Bookings/Modals/AddPermit.vue'
import AddInvoiceDetails from '@/components/Bookings/Modals/AddInvoiceDetails.vue'
import InvoicePreview from '@/components/Bookings/Modals/InvoicePreview.vue'
import EditBooking from '@/components/Bookings/Modals/EditBooking.vue'
import OverallPayment from '@/components/Bookings/Modals/OverallPayment.vue'
export default {
    name: 'side_details',
    data() {
        return {
            booking: {},
            breadcrumb_items: this.breadcrumbItems()
        }
    },
    components: {
        SideDetails,
        MainDetails,
        AddPermit,
        AddInvoiceDetails,
        InvoicePreview,
        EditBooking,
        OverallPayment
    },
    methods: {
        async getBooking() {
            await this.$http.get('/bookings/' + this.$route.params.id).then(booking => {
                this.booking = booking.data.data
            })
        },

        breadcrumbItems: function () {
            return [ // prettier-ignore
                {
                    text: 'Dashboard',
                    to: {
                        name: 'Dashboard'
                    }
                },
                {
                    text: 'Bookings',
                    to: {
                        name: 'Bookings'
                    }
                },
                {
                    text: 'Details',
                    active: true
                }
            ]
        },
        confirm() {
            this.$swal.fire({
                title: 'Confirm Booking?',
                text: 'Are you sure you want to perform this action',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, confirm it!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    this.$http.post('/bookings/' + this.$route.params.id + '/confirm').then(booking => {
                        this.booking = booking.data.data
                        this.$swal.fire('Confirmed!', 'Booking has been confirmed.', 'success')
                    }).catch(errors => {
                        this.toastError(errors.message)
                    })
                }
            })
        },
        cancel() {
            this.$swal.fire({
                title: 'Cancel Booking?',
                text: 'Are you sure you want to perform this action',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, cancel it!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    this.$http.post('/bookings/' + this.$route.params.id + '/cancel').then(booking => {
                        this.booking = booking.data.data
                        this.$swal.fire('Canceled!', 'Booking has been Canceled.', 'success')
                    }).catch(errors => {
                        this.toastError(errors.message)
                    })
                }
            })
        }
    },
    mounted() {
        this.getBooking()
    }
}
</script>

<style>
.head-t {
    font-size: 30px;
    color: #687B6D;
}
</style>
