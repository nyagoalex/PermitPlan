<!-- @format -->

<template>
    <div>
        <b-row class="px-4 pt-4" style="font-size: 14px">
            <div class="col-md-2 text-left border-right">
                <img
                    src="@/assets/image/pplanw.png"
                    alt="Kitten"
                    width="130"
                    height="50"
                />
            </div>
            <div class="col-md-3 text-left">
                {{ company.company_name }}<br />
                <small>
                    <a :href="`mailto:${company.email}`">{{ company.email }}</a></small
                >
            </div>
            <div class="col-md-7 text-right pt-2" style="color: green">
                <b-icon icon="printer-fill"></b-icon> PRINT
                <b-icon icon="download" class="ml-3"></b-icon> EXPORT
            </div>
        </b-row>
        <div class="pt-3 intinerary">
            <b-tabs content-class="mt-0" align="center">
                <b-tab title="OVERVIEW" active>
                    <Overview :itinerary="itinerary" />
                </b-tab>
                <b-tab title="ITINERARY">
                    <DayByDayDetails />
                </b-tab>
                <b-tab title="MAP">
                    <p>Map!</p>
                </b-tab>
                <b-tab title="STAYS">
                    <Stays :itinerary="itinerary" />
                </b-tab>
                <b-tab title="PRICING">
                    <Pricing :itinerary="itinerary" />
                </b-tab>
                <b-tab title="ABOUT US">
                    <p>About us!</p>
                </b-tab>
            </b-tabs>
        </div>
        <hr style="width: 75%" />
        <small>Premit plan {{ this.$moment().format('YYYY') }}</small>
    </div>
</template>

<script>
import Overview from '@/components/PreviewItinerary/Overview.vue'
import Pricing from '@/components/PreviewItinerary/Pricing.vue'
import Stays from '@/components/PreviewItinerary/Stays.vue'
import DayByDayDetails from '@/components/PreviewItinerary/DayByDay.vue'
export default {
    data() {
        return {
            fixed: false,
            itinerary: {},
            company: {}
        }
    },
    components: {
        Overview,
        Pricing,
        Stays,
        DayByDayDetails
    },
    methods: {
        handleScroll() {
            alert(6)
        },
        async getItinerary() {
            await this.$http
                .get('/bookings/' + this.$route.params.id + '/preview')
                .then((itinerary) => {
                    this.itinerary = itinerary.data.data
                })
        }
    },
    mounted() {
        this.getItinerary()
        this.company = JSON.parse(localStorage.getItem('settings'))
    }
}
</script>

<style>
.intinerary .nav-tabs {
    color: #495057;
    background: #fff !important;
}

.intinerary .nav-link.active {
    color: green !important;
    border-color: white white green !important;
    border-radius: 0px !important;
}

.intinerary .nav-link:hover {
    color: green !important;
    border: 0px !important;
}

.intinerary .nav-link {
    font-size: 12px !important;
}
</style>
