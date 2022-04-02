<!-- @format -->

<template>
    <div class="col-md-9 p-0 pr-2 col-sm-12">
        <div class="pl-4 pr-4">
            <div class="accordion-panel text-left">
                <div class="buttons-wrapper">
                    <i class="plus-icon"></i>
                    <div class="open-btn">Open all</div>
                    <div class="close-btn hidden">Close all</div>
                </div>

                <dl class="accordion">
                    <dt>Permits <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <div class="mt-3 header-small pt-3 bg-white p-3">
                                <b-button
                                    size="sm"
                                    pill
                                    variant="outline-dark"
                                    class="float-left"
                                    v-b-modal.transfered-permits-modal
                                    :disabled="
                                        !booking.transfered_permits ||
                                        !booking.transfered_permits.length
                                    "
                                    >View Transferd Permits</b-button
                                >
                                <b-button
                                    size="sm"
                                    pill
                                    variant="outline-dark"
                                    class="float-right"
                                    v-b-modal.new-permit
                                    >+ Permits</b-button
                                >

                                <b-table
                                    :items="booking.permits"
                                    :fields="permit_fields"
                                    :striped="true"
                                    :responsive="true"
                                    no-border-collapse
                                    sticky-header
                                    @row-clicked="
                                        (permit) =>
                                            $set(
                                                permit,
                                                '_showDetails',
                                                !permit._showDetails
                                            )
                                    "
                                    sort-by="number"
                                    sort-icon-left
                                >
                                    <template v-slot:cell(#)="data">
                                        {{ data.index + 1 }}
                                    </template>
                                    <template v-slot:cell(type)="row">
                                        {{ row.item.permit_type_name }}
                                    </template>
                                    <template v-slot:cell(preffered_sector)="row">
                                        {{ row.item.sector }}
                                    </template>
                                    <template v-slot:cell(tracking_date)="row">
                                        {{ row.item.tracking_date_format }}
                                    </template>
                                    <template v-slot:cell(payment_status)="row">
                                        <span
                                            :id="`tooltip-button-payment-status-${row.item.id}`"
                                            :class="{
                                                'text-success':
                                                    row.item.payment_status == 'Cleared',
                                                'text-info':
                                                    row.item.payment_status ==
                                                    'Deposited',
                                                'text-danger':
                                                    row.item.payment_status ==
                                                    'Deposit Expired',
                                                'text-dark':
                                                    row.item.payment_status == 'Tentative'
                                            }"
                                        >
                                            {{ row.item.payment_status }}
                                        </span>
                                        <b-tooltip
                                            v-if="
                                                row.item.payment_status == 'Deposited' ||
                                                row.item.payment_status ==
                                                    'Deposit Expired'
                                            "
                                            :target="`tooltip-button-payment-status-${row.item.id}`"
                                            triggers="hover"
                                            variant="secondary"
                                            >Expires on
                                            {{ row.item.expired_date }}</b-tooltip
                                        >
                                    </template>
                                    <template v-slot:row-details="row">
                                        <b-row>
                                            <b-button
                                                size="sm"
                                                class="mx-3"
                                                pill
                                                variant="outline-dark"
                                                v-b-modal.transfer-permit
                                                @click="selected_permit = row.item"
                                                >Transfer</b-button
                                            >
                                            <b-button
                                                size="sm"
                                                class="mx-3"
                                                pill
                                                variant="outline-dark"
                                                v-b-modal.reschedule
                                                @click="selected_permit = row.item"
                                                >Reschedule</b-button
                                            >
                                            <b-button
                                                size="sm"
                                                class="mx-3"
                                                pill
                                                variant="outline-secondary"
                                                v-b-modal.item-payments-modal
                                                @click="
                                                    ;(payment_type = 'permit'),
                                                        (payment_types =
                                                            row.item.payments)
                                                "
                                                >Show Payments</b-button
                                            >
                                            <b-button
                                                size="sm"
                                                class="mx-3"
                                                pill
                                                variant="outline-secondary"
                                                v-b-modal.item-payment-modal
                                                @click="
                                                    ;(payment_type = 'permit'),
                                                        (selected_modal = row.item)
                                                "
                                                >Register Payment</b-button
                                            >
                                            <span
                                                :id="`tooltip-button-${row.item.number}`"
                                                class="d-inline-block"
                                                tabindex="0"
                                            >
                                                <b-button
                                                    size="sm"
                                                    class="mx-3"
                                                    pill
                                                    variant="outline-danger"
                                                    @click="deletePermit(row.item.id)"
                                                    :disabled="
                                                        row.item.payments.length > 0
                                                    "
                                                    >Remove</b-button
                                                >
                                            </span>
                                            <b-tooltip
                                                :target="`tooltip-button-${row.item.number}`"
                                                triggers="hover"
                                                variant="danger"
                                                >Permit Has Payments</b-tooltip
                                            >
                                            <small
                                                class="mx-3"
                                                v-if="row.item.rescheduled"
                                                >Rescheduled from:
                                                <b style="color: #b97455">{{
                                                    row.item.rescheduled_from
                                                }}</b></small
                                            >
                                        </b-row>
                                    </template>
                                </b-table>
                            </div>
                        </div>
                    </dd>
                    <dt>Payments <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <div class="mt-3 pt-3 header-small bg-white p-3">
                                <b-button
                                    v-b-modal.overall_payment_modal
                                    size="sm"
                                    pill
                                    variant="outline-secondary"
                                    class="float-right"
                                    >+ add payment</b-button
                                >

                                <b-table
                                    :items="booking.payments"
                                    :fields="payment_fields"
                                    :striped="true"
                                    :responsive="true"
                                    no-border-collapse
                                    sticky-header
                                    @row-clicked="
                                        (payment) =>
                                            $set(
                                                payment,
                                                '_showDetails',
                                                !payment._showDetails
                                            )
                                    "
                                    sort-by="number"
                                    sort-icon-left
                                >
                                    <template v-slot:cell(#)="data">
                                        {{ data.index + 1 }}
                                    </template>
                                    <template v-slot:cell(payment_date)="row">
                                        {{ row.item.date }}
                                    </template>
                                    <template v-slot:cell(paid_in_by)="row">
                                        {{ row.item.user }}
                                    </template>
                                    <template v-slot:cell(method)="row">
                                        {{ row.item.method.replace('_', ' ') }}
                                        <small v-if="row.item.method == 'cheque'"
                                            >(cheque no: {{ row.item.cheque_no }})</small
                                        >
                                        <small v-if="row.item.method == 'bank_transfer'"
                                            >(ref no: {{ row.item.ref_no }})</small
                                        >
                                    </template>
                                    <template v-slot:cell(action)="row">
                                        <b-button
                                            size="sm"
                                            class=""
                                            @click="deletePayment(row.item.id)"
                                            pill
                                            variant="outline-danger"
                                            >Delete</b-button
                                        >
                                    </template>
                                </b-table>
                            </div>
                            <br />
                        </div>
                    </dd>

                    <dt>Guests <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <div class="mt-3 header-small pt-3 bg-white p-3">
                                <b-button
                                    size="sm"
                                    pill
                                    variant="outline-dark"
                                    class="float-right"
                                    @click="newGuestModal"
                                    :disabled="no_of_guests >= booking.no_of_persons"
                                    >+ Guest</b-button
                                >
                                <b-table
                                    :items="booking.guests"
                                    :fields="guest_fields"
                                    :striped="true"
                                    :responsive="true"
                                    no-border-collapse
                                    sticky-header
                                    @row-clicked="
                                        (guest) =>
                                            $set(
                                                guest,
                                                '_showDetails',
                                                !guest._showDetails
                                            )
                                    "
                                    sort-by="number"
                                    sort-icon-left
                                >
                                    <template v-slot:cell(#)="data">
                                        {{ data.index + 1 }}
                                    </template>
                                    <template v-slot:cell(name)="row">
                                        {{ row.item.full_name }}
                                    </template>
                                    <template v-slot:cell(action)="row">
                                        <div>
                                            <b-button
                                                size="sm"
                                                class="mx-3"
                                                pill
                                                variant="outline-secondary"
                                                @click="editGuestModal(row.item)"
                                                >Edit</b-button
                                            >
                                            <span
                                                :id="`tooltip-button-${row.item.id}`"
                                                class="d-inline-block float-right"
                                                tabindex="0"
                                            >
                                                <b-button
                                                    size="sm"
                                                    class=""
                                                    @click="deleteGuest(row.item.id)"
                                                    pill
                                                    variant="outline-danger"
                                                    :disabled="
                                                        row.item.payments.length > 0
                                                    "
                                                    >Remove</b-button
                                                >
                                            </span>
                                            <b-tooltip
                                                :target="`tooltip-button-${row.item.id}`"
                                                triggers="hover"
                                                variant="danger"
                                                >Guest Has Payments</b-tooltip
                                            >
                                        </div>
                                    </template>
                                </b-table>
                            </div>
                        </div>
                    </dd>

                    <dt>Day to day Itinerary <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents p-3">
                            <div>
                                <span
                                    class="text-info"
                                    @click="bookingItinerary"
                                    style="cursor: pointer"
                                >
                                    <b-icon icon="arrow-left"></b-icon> edit itinerary
                                </span>
                                <a href="#" @click="previewItinerary" class="float-right">
                                    preview <b-icon icon="arrow-right"></b-icon
                                ></a>
                            </div>
                            <div v-if="booking.itinerary">
                                <b-button
                                    v-for="day in booking.itinerary.days"
                                    :key="day.name"
                                    pill
                                    variant="outline-secondary"
                                    class="m-2"
                                    @click="previewItinerary"
                                    ><span style="color: black">
                                        DAY {{ day.priority }}</span
                                    >
                                    - {{ day.name }}</b-button
                                >
                            </div>
                        </div>
                    </dd>

                    <dt>Accommodation summary <i class="plus-icon"></i></dt>
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

                    <dt>Guides <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <div class="mt-3 header-small pt-3 bg-white p-3">
                                <b-button
                                    size="sm"
                                    pill
                                    variant="outline-dark"
                                    class="float-right"
                                    v-b-modal.allocate-guides-modal
                                    >+ Guide</b-button
                                >
                                <b-table
                                    :items="booking.guides"
                                    :fields="guide_fields"
                                    :striped="true"
                                    :responsive="true"
                                    no-border-collapse
                                    sticky-header
                                    sort-by="name"
                                    sort-icon-left
                                >
                                    <template v-slot:cell(#)="data">
                                        {{ data.index + 1 }}
                                    </template>
                                    <template v-slot:cell(action)="row">
                                        <div>
                                            <b-button
                                                size="sm"
                                                class=""
                                                @click="removeGuide(row.item.id)"
                                                pill
                                                variant="outline-danger"
                                                >Remove</b-button
                                            >
                                        </div>
                                    </template>
                                </b-table>
                            </div>
                        </div>
                    </dd>

                    <dt>Vehicles <i class="plus-icon"></i></dt>
                    <dd>
                        <div class="contents">
                            <div class="mt-3 header-small pt-3 bg-white p-3">
                                <b-button
                                    size="sm"
                                    pill
                                    variant="outline-dark"
                                    class="float-right"
                                    v-b-modal.allocate-vehicles-modal
                                    >+ Vehicle</b-button
                                >
                                <b-table
                                    :items="booking.vehicles"
                                    :fields="vehicle_fields"
                                    :striped="true"
                                    :responsive="true"
                                    no-border-collapse
                                    sticky-header
                                    sort-by="name"
                                    sort-icon-left
                                >
                                    <template v-slot:cell(#)="data">
                                        {{ data.index + 1 }}
                                    </template>
                                    <template v-slot:cell(action)="row">
                                        <div>
                                            <b-button
                                                size="sm"
                                                class=""
                                                @click="removeVehicle(row.item.id)"
                                                pill
                                                variant="outline-danger"
                                                >Remove</b-button
                                            >
                                        </div>
                                    </template>
                                </b-table>
                            </div>
                        </div>
                    </dd>
                </dl>
            </div>
        </div>
        <br />

        <div class="pl-3">
            <h6 class="container w-100">
                <strong style="font-size: 20px; color: purple"
                    >Recent Activity {{ next_notify_link }}</strong
                >
                <small
                    class="float-right text-primary mr-3"
                    style="cursor: pointer"
                    @click="markAllAsRead"
                    >Mark All as Read</small
                >
            </h6>

            <div
                class="container"
                v-infinite-scroll="getNotifications"
                infinite-scroll-disabled="notify_busy"
                infinite-scroll-distance="10"
                style="max-height: 450px; overflow-y: auto"
            >
                <div
                    v-for="(notification, index) in notifications"
                    v-bind:key="index"
                    :class="[
                        { read: notification.read, unread: !notification.read },
                        'card mb-2',
                        'hover-shadow-lg',
                        'notif-div'
                    ]"
                    @click="markAsRead(index)"
                    :id="`popover-1-${notification.id}`"
                >
                    <div
                        class="card-body d-flex align-items-center flex-wrap flex-lg-nowrap py-0"
                    >
                        <b-icon
                            v-bind="mainProps"
                            :icon="notification.read ? 'check' : 'exclamation'"
                            variant="white"
                            :class="{
                                'rounded-circle': true,
                                'bg-success': notification.type == 'booking',
                                'bg-dark': notification.type == 'permit',
                                'bg-info': notification.type == 'payment',
                                'bg-warning': notification.type == 'guest',
                                'bg-secondary': notification.type == 4,
                                'bg-danger': notification.type == 5,
                                'bg-light': notification.type == 6
                            }"
                        ></b-icon>
                        <div
                            class="col-lg-2 col-8 pl-0 pl-md-3 pt-3 pt-lg-0 text-left"
                            style="
                                color: black;
                                font-size: 14px;
                                text-transform: capitalize;
                            "
                        >
                            {{ notification.type }}
                        </div>
                        <div class="col col-lg-2 text-right px-0 order-lg-4 pt-3 pt-lg-0">
                            <span class="text-muted text-sm">{{
                                notification.created_at
                            }}</span>
                        </div>
                        <div
                            class="col-12 col-lg-7 d-flex align-items-center position-static pb-3 py-lg-3 px-0"
                        >
                            <div class="col col-lg-11 position-static px-0">
                                <div
                                    class="d-flex flex-wrap flex-lg-nowrap align-items-center"
                                >
                                    <div
                                        class="col-12 col-lg pl-0 text-limit text-left text-sm text-muted d-none d-sm-block pl-lg-2"
                                    >
                                        {{ notification.data.message | truncate(80) }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <b-popover
                        :target="`popover-1-${notification.id}`"
                        placement="top"
                        :title="notification.type"
                        triggers="hover focus"
                        :content="`Placement ${notification.data.message}`"
                    ></b-popover>
                </div>
            </div>
        </div>
        <b-modal id="reschedule" :title="`Reschedule Permit: ${selected_permit.number}`">
            <div class="form-group">
                <input
                    type="date"
                    class="form-control place"
                    v-model="selected_permit.tracking_date"
                    :class="{ 'is-invalid': errors.tracking_date }"
                />
                <ul class="list-unstyled invalid-feedback" v-if="errors.tracking_date">
                    <li v-for="error in errors.tracking_date" :key="error">
                        {{ error }}
                    </li>
                </ul>
            </div>
            <template v-slot:modal-footer="{ cancel }">
                <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
                <b-button size="sm" variant="success" @click="reschedule"
                    >Reshedule Permit</b-button
                >
            </template>
        </b-modal>
        <b-modal
            id="transfer-permit"
            :title="`Transfer Permit: ${selected_permit.number}`"
        >
            <div class="form-group">
                Select Booking
                <model-select
                    :options="this.toBookings"
                    placeholder="select Booking"
                    class="form-control"
                    v-model="to_booking_id"
                    :class="{ 'is-invalid': errors.to_booking_id }"
                >
                </model-select>
                <ul class="list-unstyled invalid-feedback" v-if="errors.to_booking_id">
                    <li v-for="error in errors.to_booking_id" :key="error">
                        {{ error }}
                    </li>
                </ul>
            </div>
            <template v-slot:modal-footer="{ cancel }">
                <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
                <b-button size="sm" variant="success" @click="transferPermit"
                    >Transfer Permit</b-button
                >
            </template>
        </b-modal>
        <b-modal
            id="item-payments-modal"
            :title="`Payments For ${payment_type}`"
            size="lg"
            hide-footer
        >
            <b-table
                :items="payment_types"
                :fields="payment_fields"
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
                    <b-button
                        size="sm"
                        class=""
                        @click="deleteItemPayment(row.item.id)"
                        pill
                        variant="outline-danger"
                        >Delete</b-button
                    >
                </template>
            </b-table>
        </b-modal>
        <b-modal
            id="transfered-permits-modal"
            title="Transfered Permits"
            size="xl"
            hide-footer
        >
            <b-table
                :items="booking.transfered_permits"
                :fields="transfered_permit_fields"
                :striped="true"
                :responsive="true"
                no-border-collapse
                sticky-header
                sort-icon-left
            >
                <template v-slot:cell(#)="data">
                    {{ data.index + 1 }}
                </template>
                <template v-slot:cell(type)="row">
                    {{ row.item.permit_type_name }}
                </template>
                <template v-slot:cell(preffered_sector)="row">
                    {{ row.item.sector }}
                </template>
                <template v-slot:cell(tracking_date)="row">
                    {{ row.item.tracking_date_format }}
                </template>
                <template v-slot:cell(transfered_to)="row">
                    <a
                        href=""
                        @click="
                            $router.push({
                                name: 'BookingDetails',
                                params: { id: row.item.booking.id }
                            })
                        "
                    >
                        {{ row.item.booking.number }} - {{ row.item.booking.ref }}
                    </a>
                </template>
                <template v-slot:cell(payment_status)="row">
                    <span
                        :id="`tooltip-button-payment-status-${row.item.id}`"
                        :class="{
                            'text-success': row.item.payment_status == 'Cleared',
                            'text-info': row.item.payment_status == 'Deposited',
                            'text-danger': row.item.payment_status == 'Deposit Expired',
                            'text-dark': row.item.payment_status == 'Tentative'
                        }"
                    >
                        {{ row.item.payment_status }}
                    </span>
                    <b-tooltip
                        v-if="
                            row.item.payment_status == 'Deposited' ||
                            row.item.payment_status == 'Deposit Expired'
                        "
                        :target="`tooltip-button-payment-status-${row.item.id}`"
                        triggers="hover"
                        variant="secondary"
                        >Expires on {{ row.item.expired_date }}</b-tooltip
                    >
                </template>
            </b-table>
        </b-modal>
        <AddGuest :guest="guest" :mode="mode" />
        <AllocateGuide v-if="booking.guides" :allocatedGuides="booking.guides.map(i => i.id)" />
        <AllocateVehicle v-if="booking.vehicles" :allocatedVehicles="booking.vehicles.map(i => i.id)" />
        <ItemPayment :model_type="payment_type" :selected_modal="selected_modal" />
    </div>
</template>

<script>
import $ from 'jquery'
import AddGuest from '@/components/Bookings/Modals/AddGuest.vue'
import AllocateGuide from '@/components/Bookings/Modals/AllocateGuide'
import AllocateVehicle from '@/components/Bookings/Modals/AllocateVehicle'
import ItemPayment from '@/components/Bookings/Modals/ItemPayment.vue'
import infiniteScroll from 'vue-infinite-scroll'
import { ModelSelect } from 'vue-search-select'

export default {
    data() {
        return {
            mainProps: {
                width: 40,
                height: 40,
                class: 'm1'
            },
            notify_busy: false,
            notifications: [],
            permit_fields: [
                // prettier-ignore
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
            transfered_permit_fields: [
                // prettier-ignore
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
                },
                {
                    key: 'transfered_to',
                    sortable: true
                }
            ],
            permit_items: [],

            payment_fields: [
                // prettier-ignore

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
                    key: 'method',
                    sortable: true
                },
                {
                    key: 'paid_in_by',
                    sortable: true
                },
                {
                    key: 'action',
                    sortable: false
                }
            ],

            guest_fields: [
                // prettier-ignore
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
            guide_fields: [
                // prettier-ignore
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'full_name',
                    sortable: true
                },
                {
                    key: 'code',
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
                    key: 'experience',
                    sortable: true
                },
                {
                    key: 'action',
                    sortable: false
                }
            ],
            vehicle_fields: [
                // prettier-ignore
                {
                    key: '#',
                    sortable: false
                },
                {
                    key: 'full_name',
                    sortable: true
                },
                {
                    key: 'code',
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
                    key: 'experience',
                    sortable: true
                },
                {
                    key: 'action',
                    sortable: false
                }
            ],
            guest: this.resetGuestModal(),
            guest_items: [],
            selected_permit: {},
            payment_types: [],
            payment_type: '',
            selected_modal: {},
            errors: {},
            mode: '',
            next_notify_link: 1,
            to_booking_id: null,
            toBookings: []
        }
    },
    directives: {
        infiniteScroll
    },
    components: {
        AddGuest,
        ItemPayment,
        ModelSelect,
        AllocateGuide,
        AllocateVehicle
    },
    props: {
        booking: Object
    },
    computed: {
        no_of_guests() {
            return this.booking.guests === undefined ? 0 : this.booking.guests.length
        }
    },
    methods: {
        callBookings() {
            this.$parent.getBooking()
        },
        getPermits() {
            this.$http
                .get('/bookings/' + this.$route.params.id + '/permits')
                .then((permits) => {
                    this.permit_items = permits.data.data
                })
        },
        getGuests() {
            this.$http
                .get('/bookings/' + this.$route.params.id + '/guests')
                .then((guest) => {
                    this.booking.guests = guest.data.data
                })
        },
        getGuides() {
            this.$http
                .get('/bookings/' + this.$route.params.id + '/guides')
                .then((guides) => {
                    this.booking.guides = guides.data.data
                })
        },
        getVehicles() {
            this.$http
                .get('/bookings/' + this.$route.params.id + '/vehicles')
                .then((vehicles) => {
                    this.booking.vehicles = vehicles.data.data
                })
        },
        reschedule() {
            this.errors = {}
            const id = this.selected_permit.id
            const param = {
                tracking_date: this.selected_permit.tracking_date
            }
            this.$http
                .patch('/bookings/' + this.$route.params.id + '/permits/' + id, param)
                .then((booking) => {
                    this.toastSuccess('Successfully Updated')
                    this.$bvModal.hide('reschedule')
                    this.$parent.getBooking()
                })
                .catch((errors) => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
        },
        transferPermit() {
            this.errors = {}
            const id = this.selected_permit.id
            const param = {
                to_booking_id: this.to_booking_id
            }
            this.$http
                .post(
                    '/bookings/' + this.$route.params.id + '/permits/' + id + '/transfer',
                    param
                )
                .then((booking) => {
                    this.toastSuccess('Successfully Transfred')
                    this.$bvModal.hide('transfer-permit')
                    this.$parent.getBooking()
                })
                .catch((errors) => {
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
                    this.$http
                        .delete('/bookings/' + this.$route.params.id + '/guests/' + id)
                        .then(() => {
                            this.booking.guests = this.booking.guests.filter(
                                (item) => item.id !== id
                            )
                            this.$swal.fire(
                                'Deleted!',
                                'Guest has been deleted.',
                                'success'
                            )
                        })
                }
            })
        },
        deletePermit(id) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http
                        .delete('/bookings/' + this.$route.params.id + '/permits/' + id)
                        .then(() => {
                            this.booking.permits = this.booking.permits.filter(
                                (item) => item.id !== id
                            )
                            this.$swal.fire(
                                'Deleted!',
                                'Permit has been deleted.',
                                'success'
                            )
                        })
                }
            })
        },
        deletePayment(id) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http
                        .delete('/bookings/' + this.$route.params.id + '/payments/' + id)
                        .then(() => {
                            this.booking.payments = this.booking.payments.filter(
                                (item) => item.id !== id
                            )
                            this.$swal.fire(
                                'Deleted!',
                                'Payment has been deleted.',
                                'success'
                            )
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
                        this.$swal.fire(
                            'Deleted!',
                            'Payment has been deleted.',
                            'success'
                        )
                    })
                }
            })
        },
        getNotifications() {
            if (this.next_notify_link) {
                this.notify_busy = true
                const filters = {
                    page: this.next_notify_link
                }
                this.$http
                    .get('/bookings/' + this.$route.params.id + '/notifications', {
                        params: filters
                    })
                    .then((notifications) => {
                        this.notifications.push(...notifications.data.data)
                        const next = notifications.data.links.next
                        this.next_notify_link = next ? this.next_notify_link + 1 : null
                    })
                this.notify_busy = false
            }
        },
        markAsRead(index) {
            if (!this.notifications[index].read) {
                const id = this.notifications[index].id
                this.$http
                    .post(
                        '/bookings/' +
                            this.$route.params.id +
                            '/notifications/' +
                            id +
                            '/markasread'
                    )
                    .then(() => {
                        this.$set(this.notifications[index], 'read', true)
                    })
            }
        },
        markAllAsRead() {
            this.$http
                .post(
                    '/bookings/' + this.$route.params.id + '/notifications/markallasread'
                )
                .then((notifications) => {
                    this.notifications = notifications.data.data
                    this.next_notify_link = null
                })
        },
        previewItinerary() {
            const routeData = this.$router.resolve({
                name: 'ItineraryPreview',
                params: {
                    type: 'bookings',
                    id: this.$route.params.id
                }
            })
            window.open(routeData.href, '_blank')
        },
        bookingItinerary() {
            this.$router.push({
                name: 'BookingItineraryDetails',
                params: {
                    id: this.$route.params.id
                }
            })
        },
        getBookingsExcept() {
            this.$http
                .get('/bookings', {
                    params: {
                        except: this.$route.params.id
                    }
                })
                .then((bookings) => {
                    this.toBookings = bookings.data.data.map(function (num) {
                        return {
                            value: num.id,
                            text: num.number + ' (' + num.ref + ') - ' + num.client_name
                        }
                    })
                })
        },
        removeGuide(guideId) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http.delete('/bookings/' + this.$route.params.id + '/guides/' + guideId)
                        .then(response => {
                            this.alertAddSuccess()
                            this.booking.guides = response.data.data
                        })
                        .catch(errors => {
                            this.errors = errors.errors
                            this.toastError(errors.message)
                        })
                }
            })
        },
        removeVehicle(vehicleId) {
            this.ConfirmDelete().then((result) => {
                if (result.value) {
                    this.$http.delete('/bookings/' + this.$route.params.id + '/vehicles/' + vehicleId)
                        .then(response => {
                            this.alertAddSuccess()
                            this.booking.vehicles = response.data.data
                        })
                        .catch(errors => {
                            this.errors = errors.errors
                            this.toastError(errors.message)
                        })
                }
            })
        }
    },
    mounted() {
        this.getBookingsExcept()
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
                        var eachNewHeight = $(this)
                            .children('.contents')
                            .outerHeight(true)
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
                    } else {
                        // if we are on clicked target then remove the class
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

    box-shadow: 0 0 1.25rem rgba(31, 45, 61, 0.05);
}

.accordion-panel .accordion dd {
    height: 0;
    overflow: hidden;
    transition: height 0.35s ease-out;
    margin-left: 0;
    margin-bottom: 5px;
    background: #f4f4f4;
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

.notif-div {
    display: flex !important;
    flex-direction: column !important;
    min-width: 0 !important;
    word-wrap: break-word !important;
    background-clip: border-box !important;
    border: 1px solid #eff2f7 !important;
    border-radius: 0.25rem !important;
    cursor: pointer;
    transition-duration: 0.3s, 1s;
    transition-timing-function: linear, ease-in;
}

.notif-div:hover {
    background-color: lavender !important;
    box-shadow: 10px 10px 10px grey;
    -webkit-transform: translateX(-3px);
    transform: translateX(-3px);
}

.read {
    background-color: #fff !important;
}

.unread {
    background-color: #f2f3f5 !important;
}
</style>
