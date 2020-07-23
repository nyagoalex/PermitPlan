<template>
<div id="settings">
  <b-card no-body >
    <b-tabs card pills vertical  variant='success' id='setting-nav'>
      <b-tab active>
        <template v-slot:title>
          <b-icon icon="people-fill"></b-icon> Company Details
        </template>
        <b-card-text><Company/></b-card-text>
      </b-tab>
      <b-tab>
       <template v-slot:title>
          <b-icon icon="person-plus-fill"></b-icon> Users
        </template>
        <b-card-text><Users/></b-card-text>
      </b-tab>
      <b-tab>
        <template v-slot:title>
          <b-icon icon="tag-fill"></b-icon> Tracking Sectors
        </template>
        <b-card-text><TrackingSectors/></b-card-text>
      </b-tab>
      <b-tab>
       <template v-slot:title>
          <b-icon icon="clock-history"></b-icon> Deposit Expiry
        </template>
        <b-card-text><DepositExpiry/></b-card-text>
      </b-tab>
      <b-tab title="$ Gorilla Permits Cost">
        <b-card-text><PermitCosts costTitle="gorilla tracking permits cost" v-bind:costs="permit_costs.gorilla_permits"/></b-card-text>
      </b-tab>
      <b-tab title="$ Chimp Permits Cost">
      <b-card-text><PermitCosts costTitle="chimp permits cost" v-bind:costs="permit_costs.chimpanzee_permits"/></b-card-text>
      </b-tab>
      <b-tab title="$ Gorilla Habituation Cost">
      <b-card-text><PermitCosts costTitle="gorilla habituation cost" v-bind:costs="permit_costs.gorilla_habituation"/></b-card-text>
      </b-tab>
      <b-tab title="$ Chimp Habituation Cost">
      <b-card-text><PermitCosts costTitle="chimp habituation cost" v-bind:costs="permit_costs.chimpanzee_habituation"/></b-card-text>
      </b-tab>
      <b-tab title="$ Golden Monkey Permits Cost">
      <b-card-text><PermitCosts costTitle="golden monkey permits" v-bind:costs="permit_costs.golden_monkey_permits"/></b-card-text>
      </b-tab>
    </b-tabs>
  </b-card>
</div>
</template>

<script>
import Company from '@/components/Settings/Company.vue'
import Users from '@/components/Settings/Users.vue'
import TrackingSectors from '@/components/Settings/TrackingSectors.vue'
import PermitCosts from '@/components/Settings/PermitCosts.vue'
import DepositExpiry from '@/components/Settings/DepositExpiry.vue'

import axios from 'axios'

const apiUrl = process.env.VUE_APP_APIURL
export default {
  name: 'company',
  data () {
    return {
      permit_costs: {}
    }
  },
  components: {
    Company,
    Users,
    TrackingSectors,
    PermitCosts,
    DepositExpiry
  },
  methods: {
    getCosts () {
      axios.get(apiUrl + '/permit-types')
        .then(permitCosts => {
          this.permit_costs = permitCosts.data.data
          // // this.permit_costs = {
          // //   gorilla_permits: { id: 1, uganda: 11, east_africa: 12, foreign_residents: 13, non_residents: 14 },
          // //   chimp_permits: { id: 2, uganda: 21, east_africa: 22, foreign_residents: 23, non_residents: 24 },
          // //   gorilla_habituation: { id: 3, uganda: 31, east_africa: 32, foreign_residents: 33, non_residents: 34 },
          // //   chimp_habituation: { id: 4, uganda: 41, east_africa: 42, foreign_residents: 43, non_residents: 44 }
          // // }
          // console.log('after')
          return this.permit_costs
        })
        .catch(function (error) {
          console.log(error)
          // console.log(error.response.status)
          // this.error = error.response
          // this.loading = false
        })
    }
  },
  created: function () {
    this.$nextTick(function () {
      // Code that will run only after the
      // entire view has been rendered
      this.getCosts()
    })
  }
}

// function getCosts () {
//   const permitCosts = {
//     gorilla_permits: { id: 1, uganda: 11, east_africa: 12, foreign_residents: 13, non_residents: 14 },
//     chimp_permits: { id: 2, uganda: 21, east_africa: 22, foreign_residents: 23, non_residents: 24 },
//     gorilla_habituation: { id: 3, uganda: 31, east_africa: 32, foreign_residents: 33, non_residents: 34 },
//     chimp_habituation: { id: 4, uganda: 41, east_africa: 42, foreign_residents: 43, non_residents: 44 }
//   }

// console.log(222)
// return permitCosts
// }
</script>

<style  lang="scss">
#setting-nav .col-auto{
  width: 16em !important;
  text-align: left;
  height: 100%;
}
#setting-nav .nav-item{
  margin-top: 1em;
}

#setting-nav .card-header{
  padding: 0.75rem 0rem !important;
}
.user_card
{
  transition-duration: .2s, 1s;
  transition-timing-function: linear, ease-in;
}
.user_card:hover
{
  box-shadow: 10px 10px 10px grey;
  -webkit-transform: translateX(-3px);
  transform: translateX(-3px);
}
.usericon
{
  font-size: 3rem;
  color: #021554;
}
.user-name
{
  font-size: 1rem;
  font-weight:400;
  color: black;
}
</style>
