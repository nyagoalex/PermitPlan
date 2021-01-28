<!-- @format -->

<template>
    <div>
        <b-row class="bg-light pt-2 px-3" align-v="end">
            <b-col cols="3">
                <b-breadcrumb
                    class="py-0 px-3 mb-0"
                    style="background-color: inherit"
                    :items="breadcrumb_items"
                ></b-breadcrumb>
            </b-col>
            <b-col>
                <small
                    ><b style="color: #6bccdf"
                        >Booking number: {{ booking.number }}</b
                    ></small
                >
            </b-col>
            <b-col>
                <small
                    ><b style="color: #b97455">booking ref: {{ booking.ref }}</b></small
                >
            </b-col>
            <b-col>
                <small
                    ><b style="color: #b97455"
                        >Total Booking Cost: {{ total_cost | moneyFormat }}</b
                    ></small
                >
            </b-col>

            <b-col class="text-right">
                <b-button
                    size="sm"
                    pill
                    variant="primary"
                    class="glow mx-3"
                    v-b-popover.hover.bottomleft="
                        'Click to update  all itinerary details'
                    "
                    @click="saveAll"
                    >Update</b-button
                >
            </b-col>
        </b-row>
        <GeneralDetails v-if="after_fetch" :itinerary="itinerary" />

        <b-row class="mt-2">
            <b-col>
                <b-button size="sm" pill variant="outline-success" @click="useAsTemplate"
                    >use itinerary as template</b-button
                >
            </b-col>
            <b-col>
                <b-button size="sm" pill variant="outline-dark"
                    >fill itinerary from template</b-button
                >
            </b-col>
        </b-row>
    </div>
</template>

<script>
import GeneralDetails from '@/components/ItineraryDetails/GeneralDetails.vue'

export default {
    name: 'itinerary_details',
    data() {
        return {
            after_fetch: false,
            itinerary: { days: [] },
            booking: {},
            breadcrumb_items: [
                // prettier-ignore
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
                    to: {
                        name: 'BookingDetails',
                        params: {
                            id: this.$route.params.id
                        }
                    }
                },
                {
                    text: 'Itinerary',
                    active: true
                }
            ]
        }
    },
    components: {
        GeneralDetails
    },
    methods: {
        async getBooking() {
            await this.$http.get('/bookings/' + this.$route.params.id).then((booking) => {
                this.booking = booking.data.data
                this.itinerary = booking.data.data.itinerary
            })
            this.after_fetch = true
        },
        saveAll() {
            // alert(JSON.stringify(this.itinerary))
            this.itinerary.total_cost = this.total_cost
            this.$http
                .patch('/bookings/' + this.$route.params.id + '/itinerary', {
                    itinerary: JSON.stringify(this.itinerary)
                })
                .then(() => {
                    this.toastSuccess('Itinerary Successfully Updated')
                })
        },
        useAsTemplate(id) {
            this.$swal
                .fire({
                    title: 'Use As Itinerary Template?',
                    text: 'Are you sure you want to perform this action',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, use it!',
                    reverseButtons: true
                })
                .then((result) => {
                    if (result.value) {
                        var data = {
                            date: this.booking.arrival_date,
                            title: 'Template from Booking Number ' + this.booking.number,
                            days: JSON.stringify(this.itinerary.days)
                        }
                        this.$http.post('/itineraries', data).then((response) => {
                            this.alertAddSuccess(
                                'Itinerary succeessfully created as template'
                            )
                        })
                    }
                })
        }
    },
    computed: {
        total_cost() {
            var cost = 0
            this.itinerary.days.forEach(function (day, index) {
                cost += day.items.reduce(
                    (partialSum, value) => partialSum + parseFloat(value.cost),
                    0
                )
            })
            return cost
        }
    },
    mounted() {
        this.getBooking()
    }
}
</script>

<style scoped>
/* glow Shadow */
@-moz-keyframes glow {
    0%,
    100% {
        -moz-box-shadow: 1px 0px 19px 4px #0069d9, inset 0px 0px 10px #ffffff80;
        box-shadow: 1px 0px 19px 4px #0069d9, inset 0px 0px 10px #ffffff80;
    }

    50% {
        -moz-box-shadow: 0px 0px 0px 0px #fff50300, inset 0px 0px 0px #ffffff00;
        box-shadow: 0px 0px 0px 0px #fff50300, inset 0px 0px 0px #ffffff00;
    }
}

@-webkit-keyframes glow {
    0%,
    100% {
        -webkit-box-shadow: 1px 0px 19px 4px #0069d9, inset 0px 0px 10px #ffffff80;
        box-shadow: 1px 0px 19px 4px #0069d9, inset 0px 0px 10px #ffffff80;
    }

    50% {
        -webkit-box-shadow: 0px 0px 0px 0px #fff50300, inset 0px 0px 0px #ffffff00;
        box-shadow: 0px 0px 0px 0px #fff50300, inset 0px 0px 0px #ffffff00;
    }
}

@-o-keyframes glow {
    0%,
    100% {
        box-shadow: 1px 0px 19px 4px #0069d9, inset 0px 0px 10px #ffffff80;
    }

    50% {
        box-shadow: 0px 0px 0px 0px #fff50300, inset 0px 0px 0px #ffffff00;
    }
}

@keyframes glow {
    0%,
    100% {
        box-shadow: 1px 0px 19px 4px #0069d9, inset 0px 0px 10px #ffffff80;
    }

    50% {
        box-shadow: 0px 0px 0px 0px #fff50300, inset 0px 0px 0px #ffffff00;
    }
}

/* glow Background */
.glow {
    text-shadow: 0px 1px 0px #c7f2ff;
    background-image: -webkit-linear-gradient(top, #007bff, #6b9af1);
    background-image: -moz-linear-gradient(top, #007bff, #6b9af1);
    background-image: -o-linear-gradient(top, #007bff, #6b9af1);
    background-image: linear-gradient(to bottom, #007bff, #6b9af1);
    -webkit-animation: glow 2s infinite;
    -moz-animation: glow 2s infinite;
    -o-animation: glow 2s infinite;
    animation: glow 2s infinite;
}
</style>
