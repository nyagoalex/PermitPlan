<template>

<div class="pt-3" style="background-color:#f6f9fc;">

<div class="container-fluid">

<div class="col-md-12 col-12" style="background-color:#e5edfc;border-radius:6px;">
    <div class="row" >
        <div class="col-md-9 p-3 text-left" >
        <h4 style="font-weight:700;color: #676153;">
       Good afternoon Edgar!</h4>
        </div>
       <div class="col-md-3 p-3 pull-right">
<h5>Date range picker</h5>
  </div>
       </div>
</div>

<div class="pt-3">
<div class="container-fluid">

<div class="row">
<div  class="col-md-3 col-12">
    <div class="py-4 dash-item" style="">
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="text-right pt-2">
            <b-icon icon="bookmark-check" font-scale="3" style="color:#456332;"></b-icon>
        </div>
        </div>
        <div class="col-md-8 col-12 text-left">
            <div class="">
                <h3 style="font-size:35px;font-weight:800;">1,029</h3>
                <h5 class="" style="font-size:18px;">Confirmed Safaris</h5>
            </div>
        </div>
    </div>
    </div>
</div>

<div  class="col-md-3 col-12">
    <div class="py-4 dash-item" style="">
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="text-right pt-2">
             <b-icon icon="exclamation-diamond" font-scale="3" style="color:#456332;"></b-icon>
            </div>
        </div>
        <div class="col-md-8 col-12 text-left">
            <div class="">
                <h3 style="font-size:35px;font-weight:800;">4,529</h3>
                <h5 class="" style="font-size:18px;">Tentative Bookings</h5>
            </div>
        </div>
    </div>
    </div>
</div>
<div  class="col-md-3 col-12">
    <div class="py-4 dash-item" style="">
    <div class="row">
        <div class="col-md-4 col-12">
            <div class="text-right pt-2">
             <b-icon icon="emoji-frown" font-scale="3" style="color:#c70039;"></b-icon>
            </div>
        </div>
        <div class="col-md-8 col-12 text-left">
            <div class="">
                <h3 style="font-size:35px;font-weight:800;">1,029</h3>
                <h5 class="" style="font-size:18px;">Cancelled Bookings</h5>
            </div>
        </div>
    </div>
    </div>
</div>

<div  class="col-md-3 col-12">
    <div class="py-4 dash-item" style="">
     <div class="row">
        <div class="col-md-4 col-12">
            <div class="text-right pt-2">
              <b-icon icon="people" animation="" font-scale="3" style="color:#456332;"></b-icon>
            </div>
        </div>
        <div class="col-md-8 col-12 text-left">
            <div class="">
                <h3 style="font-size:35px;font-weight:800;">12,029</h3>
                <h5 class="" style="font-size:18px;">Total Guests</h5>
            </div>
        </div>
    </div>
    </div>
</div>

</div>
</div>
</div>

<section class="">

<div class="">

</div>

</section>

        <Summary :permits="permits_totals" />
        <b-row class="mt-2">
            <PemitGraph />
            <Notifications />
        </b-row>
    </div>

<div class="">

</div>

</div>
</template>

<script>

import PemitGraph from '@/components/Dashboard/PemitGraph.vue'
import Notifications from '@/components/Dashboard/Notifications.vue'
import Summary from '@/components/Dashboard/TotalSummary.vue'
export default {
    name: 'Dashboard',
    data() {
        return {
            permits_totals: {}
        }
    },
    components: {
        Summary,
        PemitGraph,
        Notifications
    },
    methods: {
        getTotalPermits() {
            this.$http.get('reports/permits-total')
                .then(totals => {
                    this.permits_totals = totals.data
                })
        }
    },
    mounted() {
        this.getTotalPermits()
    }

}

</script>
