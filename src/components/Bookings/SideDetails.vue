<!-- @format -->

<template>
    <div class="col-md-3 pr-3 col-sm-12">
        <div class="pl-3">
        <div class="card p-4 bg-gray">
            <div class="row">
                <div class="col">
                    <label>Amount Paid</label>
                    <h4>${{ booking.total_paid }}</h4>
                </div>
                <div class="col border-left">
                    <label>Balance</label>
                    <h4>${{ booking.balance }}</h4>
                </div>
            </div>
                            <div
                                class="progress-circle progress-lg mx-auto my-3"
                                id="progress-performance-1"
                                data-progress="72"
                                data-trailwidth="4"
                                data-text="72%"
                                data-textclass="h3"
                                data-color="#2059AD;"
                                style="position: relative; width:60%"
                            >
                                <svg viewBox="0 0 100 100" style="display: block">
                                    <path
                                        d="M 50,50 m 0,-46.5 a 46.5,46.5 0 1 1 0,93 a 46.5,46.5 0 1 1 0,-93"
                                        stroke="#d8d8d8"
                                        stroke-width="1"
                                        fill-opacity="0"
                                    ></path>
                                    <path
                                        d="M 50,50 m 0,-46.5 a 46.5,46.5 0 1 1 0,93 a 46.5,46.5 0 1 1 0,-93"
                                        stroke="#2059AD;"
                                        stroke-width="3"
                                        fill-opacity="0"
                                        style="
                                            stroke-dasharray: 292.273;
                                            stroke-dashoffset: 100.8366;
                                        "
                                    ></path>
                                </svg>
                                <div
                                    class="text-accent"
                                    style="
                                        position: absolute;
                                        left: 50%;
                                        top: 50%;
                                        padding: 0px;
                                        margin: 0px;
                                        transform: translate(-50%, -50%);
                                        color: rgb(185, 119, 14);
                                        font-size: 45px;
                                    "
                                >
                                    {{ perc_paid }}%
                                </div>
                            </div>
            <button class="btn btn-outline-primary w-auto rounded"   v-b-modal.overall_payment_modal ><i class="uil uil-pen"></i> Add Payment</button>
            <a class="alink">View Payment History</a>
        </div>
       </div>

        <div class="pl-3 pt-5">
            <div class="card p-4 bg-white shadow">
                <div class="card-body p-0">
                    <!-- List group -->
                    <h4>Trip Details</h4>
                    <div class="tag tag-green"><i class="uil uil-check"></i> Booking Confirmed</div>
                    <div class="list-group list-group-flush ">
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <!-- Title -->
                                    <h5 class="mb-0">Arrival Date</h5>
                                </div>
                                <div class="col-auto">
                                    <!-- Time -->
                                    <time class="small text-muted" datetime="1988-10-24">
                                        {{ booking.arrival_date }}
                                    </time>
                                </div>
                            </div>
                            <!-- / .row -->
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <!-- Title -->
                                    <h5 class="mb-0">Departure Date</h5>
                                </div>
                                <div class="col-auto">
                                    <!-- Time -->
                                    <time class="small text-muted" datetime="2018-10-28">
                                        {{ booking.departure_date }}
                                    </time>
                                </div>
                            </div>
                            <!-- / .row -->
                        </div>
                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <!-- Title -->
                                    <h5 class="mb-0">Booking status</h5>
                                </div>
                                <div class="col-auto">
                                    <span
                                        class="badge badge-warning"
                                        v-if="booking.status == 'tentative'"
                                        style="font-size: 12px"
                                        >Tentative</span
                                    >
                                    <span
                                        class="badge badge-success"
                                        v-if="booking.status == 'confirmed'"
                                        style="font-size: 12px"
                                        >Confirmed</span
                                    >
                                    <span
                                        class="badge badge-danger"
                                        v-if="booking.status == 'cancelled'"
                                        style="font-size: 12px"
                                        >Cancelled</span
                                    >
                                </div>
                            </div>
                            <!-- / .row -->
                        </div>

                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <!-- Title -->
                                    <h5 class="mb-0">Pax.</h5>
                                </div>
                                <div class="col-auto">
                                    <!-- Text -->
                                    <small class="text-muted" style="font-size: 15px">
                                        {{ booking.no_of_persons }}
                                    </small>
                                </div>
                            </div>
                            <!-- / .row -->
                        </div>

                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <!-- Title -->
                                    <h5 class="mb-0">No. of Days</h5>
                                </div>
                                <div class="col-auto">
                                    <!-- Text -->
                                    <small class="text-muted" style="font-size: 15px">
                                        {{ booking.number_of_days }}
                                    </small>
                                </div>
                            </div>
                            <!-- / .row -->
                        </div>

                        <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">
                                    <!-- Title -->
                                    <h5 class="mb-0">Booking Source</h5>
                                </div>
                                <div class="col-auto">
                                    <!-- Link -->
                                    <a href="#!" class="small">
                                        {{ booking.source }}
                                    </a>
                                </div>
                            </div>
                            <!-- / .row -->
                        </div>

                        <!-- <div class="list-group-item">
                            <div class="row align-items-center">
                                <div class="col">

                                    <h5 class="mb-0">
                                        Cost per person
                                    </h5>

                                </div>
                                <div class="col-auto">

                                    <a href="#!" class="small text-info" style="font-size:17px;">
                                        USD
                                        {{booking.cost_per_person}}
                                    </a>
                                </div>
                            </div>
                        </div> -->
                    </div>
                    <div class="p-2">
                        <b-button size="lg" pill variant="danger" class="float-left"
                            >Delete</b-button
                        >
                        <b-button
                            size="lg"
                            pill
                            variant="info"
                            class="float-right"
                            v-b-modal.edit-booking
                            >Edit</b-button
                        >
                    </div>
                </div>
            </div>
        </div>
        <div class="pl-4 pt-2">
            <label class="float-left" style="color: black">Client's Message</label>
            <b-form-textarea
                style="overflow: hidden; overflow-wrap: break-word; height: 150px"
                id="textarea-no-resize"
                placeholder="type here the message from the client ..."
                rows="3"
                no-resize
                v-model="booking.comment"
                :class="{ 'is-invalid': errors.comment }"
            ></b-form-textarea>
            <ul class="list-unstyled invalid-feedback" v-if="errors.comment">
                <li v-for="error in errors.comment" :key="error">{{ error }}</li>
            </ul>
            <b-button
                size="lg"
                pill
                variant="outline-success"
                class="float-right my-1"
                @click="updateComment"
                >Update</b-button
            >
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            errors: {}
        }
    },
    props: {
        booking: Object
    },
    computed: {
        perc_paid: function () {
            return parseInt(this.booking.total_cost) === 0
                ? 0
                : Math.round((this.booking.total_paid / this.booking.total_cost) * 100)
        }
    },
    methods: {
        updateComment() {
            this.loading = true
            this.errors = {}
            const comment = {
                comment: this.booking.comment
            }
            this.$http
                .patch('/bookings/' + this.$route.params.id + '/comment', comment)
                .then((booking) => {
                    this.toastSuccess('Comment Successfully Updated')
                    this.booking = booking.data.data
                })
                .catch((errors) => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        }
    }
}
</script>

<style>
.card {
    margin-bottom: 1.5rem;
    border-color: #edf2f9;
    box-shadow: 0 0.75rem 1.5rem rgba(18, 38, 63, 0.03);
}

.text-sm {
    font-size: 12px;
    font-size: 12px !important;
    text-align: left;
    color: black;
}

.text-detail-bold {
    font-size: 20px;
    font-weight: bold;
}

.list-group .list-group-item h5 {
    font-size: 15px !important;
    text-align: left;
}
</style>
