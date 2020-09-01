<template>
    <div class="col-md-9 p-0 pr-2 col-sm-12">
        <div class="pl-4 pr-4">
            <div class="accordion-panel  text-left">
                <div class="buttons-wrapper">
                    <i class="plus-icon"></i>
                    <div class="open-btn">
                        Open all
                    </div>
                    <div class="close-btn hidden">
                        Close all
                    </div>
                </div>

                <dl class="accordion">
                    <dt>Permits <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">

                            <div class="mt-3 header-small pt-3 bg-white  p-3">
                                <b-button size="sm" pill variant="outline-dark" class="float-right" v-b-modal.new-permit>+ Permits</b-button>

                                <b-table :items="booking.permits" :fields="permit_fields" :striped="true" :responsive="true" no-border-collapse sticky-header @row-clicked="permit=>$set(permit, '_showDetails', !permit._showDetails)" sort-by="number" sort-icon-left>
                                    <template v-slot:cell(#)="data">
                                        {{ data.index + 1 }}
                                    </template>
                                    <template v-slot:cell(type)="row"> {{ row.item.permit_type_name}} </template>
                                    <template v-slot:cell(preffered_sector)="row"> {{ row.item.sector}} </template>
                                    <template v-slot:cell(tracking_date)="row"> {{ row.item.tracking_date_format}} </template>
                                    <template v-slot:cell(payment_status)="row">
                                        <span :id="`tooltip-button-payment-status-${row.item.id}`" :class="{
                                            'text-success': row.item.payment_status == 'Cleared',
                                            'text-info': row.item.payment_status == 'Deposited',
                                            'text-danger': row.item.payment_status == 'Deposit Expired',
                                            'text-dark': row.item.payment_status == 'Tentative',
                                            }">
                                            {{ row.item.payment_status}}
                                        </span>
                                        <b-tooltip v-if="row.item.payment_status == 'Deposited' || row.item.payment_status == 'Deposit Expired'" :target="`tooltip-button-payment-status-${row.item.id}`" triggers="hover" variant="secondary">Expires on {{ row.item.expired_date}}</b-tooltip>
                                    </template>
                                    <template v-slot:row-details="row">
                                        <b-row>
                                            <b-button size="sm" class="mx-3" pill variant="outline-dark" v-b-modal.reschedule @click="reschedule_permit = row.item">Reschedule</b-button>
                                            <b-button size="sm" class="mx-3" pill variant="outline-secondary" v-b-modal.item-payments-modal @click="payment_type='permit', payment_types=row.item.payments">Show Payments</b-button>
                                            <b-button size="sm" class="mx-3" pill variant="outline-secondary" v-b-modal.item-payment-modal @click="payment_type='permit', selected_modal=row.item">Register Payment</b-button>
                                            <span :id="`tooltip-button-${row.item.number}`" class="d-inline-block" tabindex="0">
                                                <b-button size="sm" class="mx-3" pill variant="outline-danger" @click="deletePermit(row.item.id)" :disabled="row.item.payments.length > 0">Remove</b-button>
                                            </span>
                                            <b-tooltip :target="`tooltip-button-${row.item.number}`" triggers="hover" variant="danger">Permit Has Payments</b-tooltip>
                                            <small class="mx-3" v-if="row.item.rescheduled">Rescheduled from: <b style="color: #b97455;">{{row.item.rescheduled_from}}</b></small>
                                        </b-row>
                                    </template>
                                </b-table>
                            </div>
                        </div>

                    </dd>
                    <dt>Payments <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">

                            <div class="mt-3 pt-3 header-small bg-white  p-3">
                                <b-button v-b-modal.overall_payment_modal size="sm" pill variant="outline-secondary" class="float-right">+ add payment</b-button>

                                <b-table :items="booking.payments" :fields="payment_fields" :striped="true" :responsive="true" no-border-collapse sticky-header @row-clicked="payment=>$set(payment, '_showDetails', !payment._showDetails)" sort-by="number" sort-icon-left>
                                    <template v-slot:cell(#)="data">
                                        {{ data.index + 1 }}
                                    </template>
                                    <template v-slot:cell(payment_date)="row"> {{ row.item.date}} </template>
                                    <template v-slot:cell(created_by)="row"> {{ row.item.user}} </template>
                                    <template v-slot:cell(action)="row">
                                        <b-button size="sm" class="" @click="deletePayment(row.item.id)" pill variant="outline-danger">Delete</b-button>
                                    </template>
                                </b-table>

                            </div>
                            <br>
                        </div>
                    </dd>

                    <dt>Guests <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">

                            <div class="mt-3 header-small pt-3 bg-white  p-3">
                                <b-button size="sm" pill variant="outline-dark" class="float-right" @click="newGuestModal">+ Guest</b-button>
                                <b-table :items="booking.guests" :fields="guest_fields" :striped="true" :responsive="true" no-border-collapse sticky-header @row-clicked="guest=>$set(guest, '_showDetails', !guest._showDetails)" sort-by="number" sort-icon-left>
                                    <template v-slot:cell(#)="data">
                                        {{ data.index + 1 }}
                                    </template>
                                    <template v-slot:cell(name)="row"> {{ row.item.full_name}} </template>
                                    <template v-slot:cell(action)="row">
                                        <div>
                                            <b-button size="sm" class="mx-3" pill variant="outline-secondary" @click="editGuestModal(row.item)">Edit</b-button>
                                            <span :id="`tooltip-button-${row.item.id}`" class="d-inline-block float-right" tabindex="0">
                                                <b-button size="sm" class="" @click="deleteGuest(row.item.id)" pill variant="outline-danger" :disabled="row.item.payments.length > 0">Remove</b-button>
                                            </span>
                                            <b-tooltip :target="`tooltip-button-${row.item.id}`" triggers="hover" variant="danger">Guest Has Payments</b-tooltip>
                                        </div>
                                    </template>
                                </b-table>

                            </div>
                        </div>
                    </dd>

                    <dt>Day to day Itinerary (Coming Soon) <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <p>coming soon</p>
                        </div>
                    </dd>

                    <dt>Accommodation (Coming Soon) <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <p>coming soon</p>
                        </div>
                    </dd>

                    <dt>Activities (Coming Soon) <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <p>coming soon</p>
                        </div>
                    </dd>

                    <dt>Guide & Vehicle (Coming Soon) <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <p>coming soon</p>
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
        <br>

        <div class="pl-3 pr-3">
            <h6 class="container w-100" style="font-size:20px;color:purple;"><strong>Recent Activity</strong></h6>

            <div class="container">
                <div class="card mb-2 hover-shadow-lg" style="display: flex;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid #eff2f7;border-radius: .25rem;">
                    <div class="card-body d-flex align-items-center flex-wrap flex-lg-nowrap py-0">

                        <div class="col-lg-2 col-8 pl-0 pl-md-2 pt-3 pt-lg-0"><span class="h6 text-sm">Aaliyah Haworth</span></div>
                        <div class="col col-lg-1 text-right px-0 order-lg-4 pt-3 pt-lg-0"><span class="text-muted text-sm">Dec 25</span></div>
                        <div class="col-12 col-lg-8 d-flex align-items-center position-static pb-3 py-lg-3 px-0">
                            <div class="col col-lg-11 position-static px-0">
                                <div class="d-flex flex-wrap flex-lg-nowrap align-items-center">
                                    <div class="col-12 col-lg pl-0 text-limit text-left text-sm text-muted d-none d-sm-block pl-lg-2">Today we are happy to announce Bit's public Beta support for Vue components between different apps.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-2 hover-shadow-lg" style="display: flex;flex-direction: column;min-width: 0;word-wrap: break-word;background-color: #fff;background-clip: border-box;border: 1px solid #eff2f7;border-radius: .25rem;">
                    <div class="card-body d-flex align-items-center flex-wrap flex-lg-nowrap py-0">

                        <div class="col-lg-2 col-8 pl-0 pl-md-2 pt-3 pt-lg-0"><span class="h6 text-sm">Alex Nyago</span></div>
                        <div class="col col-lg-1 text-right px-0 order-lg-4 pt-3 pt-lg-0"><span class="text-muted text-sm">Dec 25</span></div>
                        <div class="col-12 col-lg-8 d-flex align-items-center position-static pb-3 py-lg-3 px-0">
                            <div class="col col-lg-11 position-static px-0">
                                <div class="d-flex flex-wrap flex-lg-nowrap align-items-center">
                                    <div class="col-12 col-lg pl-0 text-limit text-left text-sm text-muted d-none d-sm-block pl-lg-2">Today we are happy to announce Bit's public Beta support for Vue components between different apps.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
        <b-modal id="item-payments-modal" :title="`Payments For ${payment_type}`" size="lg" hide-footer>
            <b-table :items="payment_types" :fields="payment_fields" :striped="true" :responsive="true" no-border-collapse sticky-header sort-icon-left>
                <template v-slot:cell(#)="data">
                    {{ data.index + 1 }}
                </template>
                <template v-slot:cell(payment_date)="row"> {{ row.item.date}} </template>
                <template v-slot:cell(created_by)="row"> {{ row.item.user}} </template>
                <template v-slot:cell(action)="row">
                    <b-button size="sm" class="" @click="deleteItemPayment(row.item.id)" pill variant="outline-danger">Delete</b-button>
                </template>
            </b-table>
        </b-modal>
        <AddGuest :guest="guest" :mode="mode" />
        <ItemPayment :model_type="payment_type" :selected_modal="selected_modal" />
    </div>
</template>

<script>
import $ from 'jquery'
import AddGuest from '@/components/Bookings/Modals/AddGuest.vue'
import ItemPayment from '@/components/Bookings/Modals/ItemPayment.vue'

export default {
    data() {
        return {
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
                    key: 'balance',
                    sortable: true
                },
                {
                    key: 'payment_status',
                    sortable: true
                },
                {
                    key: 'preffered_sector',
                    sortable: true
                },
                {
                    key: 'tracking_date',
                    sortable: true
                }
            ],
            permit_items: [],

            payment_fields: [ // prettier-ignore

                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'payment_date',
                    sortable: true
                },
                {
                    key: 'amount',
                    sortable: true
                },
                {
                    key: 'created_by',
                    sortable: true
                },
                {
                    key: 'action',
                    sortable: false
                }
            ],

            guest_fields: [ // prettier-ignore
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'name',
                    sortable: true
                },
                {
                    key: 'age',
                    sortable: true
                },
                {
                    key: 'nationality',
                    sortable: true
                },
                {
                    key: 'passport',
                    sortable: false
                },
                {
                    key: 'action',
                    sortable: false
                }
            ],
            guest: this.resetGuestModal(),
            guest_items: [],
            reschedule_permit: {},
            payment_types: [],
            payment_type: '',
            selected_modal: {},
            errors: {},
            mode: ''
        }
    },
    components: {
        AddGuest,
        ItemPayment
    },
    props: {
        booking: Object
    },
    methods: {
        callBookings() {
            this.$parent.getBooking()
        },
        getPermits() {
            this.$http.get('/bookings/' + this.$route.params.id + '/permits')
                .then(permits => {
                    this.permit_items = permits.data.data
                })
        },
        getGuests() {
            this.$http.get('/bookings/' + this.$route.params.id + '/guests')
                .then(guest => {
                    this.booking.guests = guest.data.data
                })
        },
        reschedule() {
            this.errors = {}
            const id = this.reschedule_permit.id
            const param = {
                tracking_date: this.reschedule_permit.tracking_date
            }
            this.$http.patch('/bookings/' + this.$route.params.id + '/permits/' + id, param)
                .then(booking => {
                    this.toastSuccess('Successfully Updated')
                    this.$bvModal.hide('reschedule')
                    this.$parent.getBooking()
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
        },
        newGuestModal() {
            this.guest = this.resetGuestModal()
            this.mode = 'create'
            this.$bvModal.show('new-guest')
        },
        editGuestModal(guest) {
            this.guest = guest
            this.mode = 'update'
            this.$bvModal.show('new-guest')
        },
        resetGuestModal() {
            return {
                first_name: '',
                last_name: '',
                dob: '',
                nationality: '',
                passport: ''
            }
        },
        deleteGuest(id) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http.delete('/bookings/' + this.$route.params.id + '/guests/' + id).then(() => {
                        this.booking.guests = this.booking.guests.filter(item => item.id !== id)
                        this.$swal.fire('Deleted!', 'Guest has been deleted.', 'success')
                    })
                }
            })
        },
        deletePermit(id) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http.delete('/bookings/' + this.$route.params.id + '/permits/' + id).then(() => {
                        this.booking.permits = this.booking.permits.filter(item => item.id !== id)
                        this.$swal.fire('Deleted!', 'Permit has been deleted.', 'success')
                    })
                }
            })
        },
        deletePayment(id) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http.delete('/bookings/' + this.$route.params.id + '/payments/' + id).then(() => {
                        this.booking.payments = this.booking.payments.filter(item => item.id !== id)
                        this.$swal.fire('Deleted!', 'Payment has been deleted.', 'success')
                    })
                }
            })
        },
        deleteItemPayment(id) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http.delete('/item-payments/' + id).then(() => {
                        this.$bvModal.hide('item-payments-modal')
                        this.$parent.getBooking()
                        this.$swal.fire('Deleted!', 'Payment has been deleted.', 'success')
                    })
                }
            })
        }
    },
    mounted() {
        $(document).ready(function () {
            var bodyEl = $('body')
            var accordionDT = $('.accordion').find('dt')
            var accordionDD = accordionDT.next('dd')
            var accordionPanel = $('.accordion-panel')
            var buttonsWrapper = accordionPanel.find('.buttons-wrapper')
            var openBtn = accordionPanel.find('.open-btn')
            var closeBtn = accordionPanel.find('.close-btn')

            bodyEl.on('click', function (argument) {
                var totalItems = $('.accordion').children('dt').length
                var totalItemsOpen = $('.accordion').children('dt.is-open').length

                if (totalItems === totalItemsOpen) {
                    openBtn.addClass('hidden')
                    closeBtn.removeClass('hidden')
                    buttonsWrapper.addClass('is-open')
                } else {
                    openBtn.removeClass('hidden')
                    closeBtn.addClass('hidden')
                    buttonsWrapper.removeClass('is-open')
                }
            })

            function openAll() {
                openBtn.on('click', function (argument) {
                    accordionDD.each(function (argument) {
                        var eachNewHeight = $(this).children('.contents').outerHeight(true)
                        $(this).css({
                            height: eachNewHeight
                        })
                    })
                    accordionDT.addClass('is-open')
                })
            }

            function closeAll() {
                closeBtn.on('click', function (argument) {
                    accordionDD.css({
                        height: 0
                    })
                    accordionDT.removeClass('is-open')
                })
            }

            function openCloseItem() {
                accordionDT.on('click', function () {
                    var el = $(this)
                    var target = el.next('dd')
                    var parentHeight = target.height()
                    var childHeight = target.children('.contents').outerHeight(true)
                    var newHeight = parentHeight > 0 ? 0 : childHeight

                    // animate to new height
                    target.css({
                        height: newHeight
                    })

                    // remove existing classes & add class to clicked target
                    if (!el.hasClass('is-open')) {
                        el.addClass('is-open')
                    } else { // if we are on clicked target then remove the class
                        el.removeClass('is-open')
                    }
                })
            }

            openAll()
            closeAll()
            openCloseItem()
        })
    }
}
</script>

<style>
/*bookings details accordion panel*/
.accordion-panel {

    margin: 0px auto;
    /*  max-width: 560px;*/
}

.accordion-panel .accordion {
    padding-top: 30px;
}

.accordion-panel .accordion dt {
    display: block;
    padding: 19px;
    background: #fff;
    color: #555;
    cursor: pointer;
    position: relative;
    user-select: none;
    border-radius: 3px;
    border: 1px solid #eff2f7;

    box-shadow: 0 0 1.25rem rgba(31, 45, 61, .05);
}

.accordion-panel .accordion dd {
    height: 0;
    overflow: hidden;
    transition: height .35s ease-out;
    margin-left: 0;
    margin-bottom: 5px;
    background: #F4F4F4;
}

.accordion-panel .accordion .contents {
    /*  padding: 25px;*/
    overflow: auto;
}

.accordion-panel .plus-icon {
    display: inline-block;
    width: 15px;
    height: 15px;
    position: relative;
    transition: transform 0.35s ease-out;
    position: absolute;
    right: 35px;
    top: 50%;
    margin-top: -12px;
}

.accordion-panel .plus-icon:before,
.accordion-panel .plus-icon:after {
    content: '';
    background: #6bbf49;
    position: absolute;
}

.accordion-panel .plus-icon:before {
    width: 2px;
    height: 15px;
    margin-left: -0.5px;
    left: 50%;
}

.accordion-panel .plus-icon:after {
    width: 15px;
    height: 2px;
    margin-top: -0.5px;
    top: 50%;
    opacity: 1;
    transition: opacity 0.35s ease-out;
}

.accordion-panel .is-open .plus-icon {
    transform: rotate(90deg);
}

.accordion-panel .is-open .plus-icon:after {
    opacity: 0;
}

.accordion-panel .hidden {
    display: none;
}

.accordion-panel .open-btn,
.accordion-panel .close-btn {
    cursor: pointer;
    position: absolute;
    right: 0;
    width: 90px;
}

.accordion-panel .buttons-wrapper {
    position: relative;
}

.accordion-panel .buttons-wrapper .plus-icon {
    position: absolute;
    right: 10px;
    top: 12px;
}

.header-small {
    font-size: 13px;
}
</style>
