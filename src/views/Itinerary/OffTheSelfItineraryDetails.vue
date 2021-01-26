<!-- @format -->

<template>
    <div>
        <b-row class="bg-light pt-2 px-3" align-v="end">
            <b-col>
                <b-breadcrumb
                    class="py-0 px-3 mb-0"
                    style="background-color: inherit"
                    :items="breadcrumb_items"
                ></b-breadcrumb>
            </b-col>
            <b-col>
                <small
                    ><b style="color: #6bccdf"
                        >Start date: {{ itinerary.date | displayDate }}
                    </b></small
                >
            </b-col>
            <b-col>
                <small
                    ><b style="color: #b97455">ref: {{ itinerary.ref_no }}</b></small
                >
            </b-col>
            <b-col>
                <small
                    ><b style="color: #b97455"
                        >Total Itinerary Cost: {{ total_cost | moneyFormat }}</b
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
        <b-row class="bg-white pt-2 px-3 my-0 pb-0">
            <b-col class="text-right">
                <h4 class="text-muted">NO DAY BY DAY DETAILS ADDED YET</h4>
            </b-col>
            <b-col class="text-right">
                <b-button
                    size="sm"
                    pill
                    variant="success"
                    v-b-popover.hover.bottomleft="'Click to activate all itinerary'"
                    @click="saveAll"
                    >Activate</b-button
                >
            </b-col>
        </b-row>
        <GeneralDetails v-if="after_fetch" :itinerary="itinerary" />
    </div>
</template>

<script>
import GeneralDetails from '@/components/ItineraryDetails/GeneralDetails.vue'

export default {
    name: 'itinerary_details',
    data() {
        return {
            itinerary: { days: [] },
            after_fetch: false,
            breadcrumb_items: [
                // prettier-ignore
                {
                    text: 'Dashboard',
                    to: {
                        name: 'Dashboard'
                    }
                },
                {
                    text: 'Itineraries',
                    to: {
                        name: 'Itineraries',
                        params: {
                            id: this.$route.params.id
                        }
                    }
                },
                {
                    text: 'Details',
                    active: true
                }
            ]
        }
    },
    components: {
        GeneralDetails
    },
    methods: {
        async getItinerary() {
            await this.$http
                .get('/itineraries/' + this.$route.params.id)
                .then((itinerary) => {
                    this.itinerary = itinerary.data.data
                })
            this.after_fetch = true
        },
        saveAll() {
            // alert(JSON.stringify(this.itinerary))
            this.itinerary.total_cost = this.total_cost
            // this.$http
            //     .patch('/bookings/' + this.$route.params.id + '/itinerary', {
            //         itinerary: JSON.stringify(this.itinerary)
            //     })
            //     .then(() => {
            //         this.toastSuccess('Itinerary Successfully Updated')
            //     })
            var data = {
                days: JSON.stringify(this.itinerary.days),
                title: 'title',
                date: '2021-01-02'
            }
            this.$http.patch('/itineraries/' + this.$route.params.id, data).then(() => {
                this.toastSuccess('Itinerary Successfully Updated')
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
        this.getItinerary()
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
