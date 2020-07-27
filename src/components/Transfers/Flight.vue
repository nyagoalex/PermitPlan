<template>
  <div class="bg-white text-left mt-3 mx-4" >
    <b-table
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
      class="acc-tb"
    >
      <template v-slot:table-caption>
        <b-row>
          <b-col><span class='font-weight-bold'>Flight Transfers</span></b-col>
          <b-col><b-button  v-b-modal.new-flight-transfer class='float-right' size="sm"  variant="success"><b-icon icon="plus"></b-icon> Add Flight Transfer</b-button></b-col>
        </b-row>
      </template>
      <template v-slot:cell(action)="row">
        <b-button pill size="sm" variant="outline-info" @click="info(row.item, row.index, $event.target)" class="mr-2">
          Edit
        </b-button>
        <b-button pill size="sm" class="float-right" variant="outline-danger" @click="row.toggleDetails"> Delete
        </b-button>
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
    <AddFlightTransfer/>
  </div>
</template>
<script>
import AddFlightTransfer from '@/components/Modals/AddFlightTransfer.vue'

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
        { key: 'no' },
        { key: 'name', sortable: true },
        { key: 'starting_point', sortable: true },
        { key: 'destination', sortable: true },
        { key: 'airline_operator', sortable: true },
        { key: 'cost_per_person', sortable: true },
        { key: 'flight_type', sortable: true },
        { key: 'distance', sortable: true },
        { key: 'est_time' },
        { key: 'action' }
      ],
      items: this.fakeBookings()
    }
  },
  components: {
    AddFlightTransfer
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
        const v = { no: i, name: faker.name.lastName(), starting_point: faker.address.state(), destination: faker.address.state(), flight_type: faker.name.lastName(), airline_operator: faker.name.lastName(), cost_per_person: faker.random.number(), distance: faker.random.number(), est_time: '16:05:00 Hrs' }
        s.push(v)
      }
      return s
    }
  }
}
</script>
