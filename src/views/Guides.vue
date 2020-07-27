<template>
  <div class="bg-white text-left mt-3 mx-4" >
    <b-table
      class="acc-tb"
      :striped="true"
      :outlined="true"
      :hover="true"
      :no-border-collapse="true"
      :items="items"
      :fields="fields"
      caption-top
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      sort-icon-left
      responsive="sm"
      :per-page="perPage"
      :current-page="currentPage"
      @row-clicked="item=>$set(item, '_showDetails', !item._showDetails)"
    >
      <template v-slot:table-caption>
        <b-row>
          <b-col><span class='font-weight-bold'>Tour Guide</span></b-col>
          <b-col class='text-center'><b-button @click="showfilters" variant="link"><b-icon icon="funnel"></b-icon> show filters</b-button></b-col>
          <b-col class='text-center'><b-button v-b-modal.new-guide size="sm"  class='float-right' variant="success"><b-icon icon="plus"></b-icon> Add Tour Guide</b-button></b-col>
        </b-row>
         <b-row v-show="filters" class="pt-3" style="height: 50px; background-color:#F5F9F7;">
          <b-col>
            <b>Status: </b>
            <b-badge pill variant="primary" class="ml-2">All</b-badge>
            <b-badge pill variant="light" class="bg-white  ml-2">Working</b-badge>
            <b-badge pill variant="light" class="bg-white  ml-2">Teminated</b-badge>
            <b-badge pill variant="light" class="bg-white  ml-2">On Probation</b-badge>
          </b-col>
          <b-col>
            <b>Contract Basis: </b>
            <b-badge pill variant="primary" class="ml-2">All</b-badge>
            <b-badge pill variant="light" class="bg-white ml-2">Full Time</b-badge>
            <b-badge pill variant="light" class="bg-white ml-2">Freelancer</b-badge>
          </b-col>
        </b-row>
      </template>
      <template v-slot:row-details="row">
        <b-row>
          <b-col><strong>Age: </strong> {{row.item.age}}</b-col>
          <b-col><strong>Email: </strong> {{row.item.email}}</b-col>
          <b-col><strong>Contract Basis: </strong>{{row.item.contract_basis}} </b-col>
          <b-col class="text-center">
          <b-button pill size="sm" variant="info"  class="mr-4" v-b-modal.guide-details><b-icon icon="info-circle-fill"> </b-icon> View</b-button>
          <b-button pill size="sm" variant="danger" > Delete</b-button>
          </b-col>
        </b-row>
      </template>
    </b-table>
    <div>
      <label>Sorting By: <b>{{ sortBy }}</b>, Sort Direction:
      <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b></label>
      <b-pagination class="float-right"
        v-model="currentPage"
        :total-rows="rows"
        :per-page="perPage"
        aria-controls="my-table"
      ></b-pagination>
    <p class="mt-3">Current Page: {{ currentPage }}</p>
    </div>
    <AddGuide/>
    <GuideDetails/>
  </div>
</template>
<script>
import AddGuide from '@/components/Modals/AddGuide.vue'
import GuideDetails from '@/components/Modals/GuideDetails.vue'

const faker = require('faker')

export default {
  data () {
    return {
      sortBy: 'age',
      sortDesc: false,
      perPage: 6,
      currentPage: 1,
      filters: false,
      fields: [
        { key: 'no', sortable: false },
        { key: 'code', sortable: true },
        { key: 'name', sortable: true },
        { key: 'phone_number', sortable: true },
        // { key: 'email', sortable: true },
        // { key: 'age', sortable: true },
        { key: 'experience', sortable: true },
        { key: 'cost_per_day', sortable: true },
        // { key: 'contract_basis', sortable: true },
        { key: 'status' }
      ],
      items: this.fakeBookings()
    }
  },
  components: {
    AddGuide,
    GuideDetails
  },
  computed: {
    rows () {
      return this.items.length
    }
  },
  methods: {
    showfilters () {
      this.filters = !this.filters
    },
    fakeBookings () {
      const s = []
      for (let i = 1; i < 20; i++) {
        const v = { no: i, code: faker.address.zipCode(), name: faker.name.findName(), phone_number: faker.phone.phoneNumber(), email: faker.internet.email(), cost_per_day: faker.random.number(), contract_basis: faker.random.arrayElement(['Full-Time', 'Freelancer']), status: faker.random.arrayElement(['Working', 'Terminated', 'On Probation']), age: '45  years', experience: '7 years' }
        s.push(v)
      }
      return s
    }
  }
}
</script>
