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
          <b-col><span class='font-weight-bold'>Vehicles</span></b-col>
          <b-col class='text-center'><b-button v-b-modal.new-vehicle size="sm"  class='float-right' variant="success"><b-icon icon="plus"></b-icon> Add Vehicle</b-button></b-col>
        </b-row>
      </template>
      <!-- <template v-slot:cell(action)="row">
        <b-button pill size="sm" variant="outline-info" @click="info(row.item, row.index, $event.target)" class="mr-2">
          Edit
        </b-button>
        <b-button pill size="sm" class="float-right" variant="outline-danger" @click="row.toggleDetails"> Delete
        </b-button>
      </template>
      <template v-slot:cell(color)="row">
        <b-badge pill size="sm" variant="success"> {{row.item.color}} </b-badge>
      </template> -->
      <template v-slot:row-details="row">
        <b-row>
          <b-col><strong>Ownership: </strong> {{row.item.ownership}}</b-col>
          <b-col><strong>Registration Number: </strong> {{row.item.reg_number}}</b-col>
          <b-col><strong>Color: </strong> <b-badge pill size="sm" variant="success"> {{row.item.color}} </b-badge></b-col>
          <b-col class="text-center"><b-button pill size="sm" variant="warning"  class="mr-4">Edit</b-button>
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
    <AddVehicle/>
  </div>
</template>
<script>
import AddVehicle from '@/components/Modals/AddVehicle.vue'

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
        // { key: 'reg_number', sortable: true },
        { key: 'type', sortable: true },
        // { key: 'color', sortable: true },
        { key: 'no_of_seats', sortable: true },
        { key: 'cost_per_day', sortable: true },
        // { key: 'ownership', sortable: true },
        { key: 'status' }
      ],
      items: this.fakeBookings()
    }
  },
  components: {
    AddVehicle
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
        const v = { no: i, code: faker.address.zipCode(), reg_number: faker.company.companySuffix(), type: 'large', color: faker.commerce.color(), no_of_seats: faker.random.number(), cost_per_day: faker.random.number(), ownership: faker.random.arrayElement(['company', 'hired']), status: faker.random.arrayElement(['Ready for Safari', 'Disposed off', 'Too Old', 'Has issues']) }
        s.push(v)
      }
      return s
    }
  }
}
</script>
