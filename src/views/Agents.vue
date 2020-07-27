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
    >
      <template v-slot:table-caption>
        <b-row>
          <b-col><span class='font-weight-bold'>Agents</span></b-col>
          <b-col class='text-center'><b-button v-b-modal.new-agent size="sm"  variant="success"><b-icon icon="plus"></b-icon> Add Agent</b-button></b-col>
          <b-col><b-button @click="showfilters" class='float-right' variant="link"><b-icon icon="funnel"></b-icon> show filters</b-button></b-col>
        </b-row>
        <b-row v-show="filters" class="pt-3" style="height: 50px; background-color:#F5F9F7;">
          <b-col>
            <b>Status: </b>
            <b-badge pill variant="primary" class="ml-2">All</b-badge>
            <b-badge pill variant="light" class="bg-white ml-2">Active</b-badge>
            <b-badge pill variant="light" class="bg-white ml-2">Inactive</b-badge>

          </b-col>
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
    <AddAgent/>
  </div>
</template>
<script>
import AddAgent from '@/components/Modals/AddAgent.vue'

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
        { key: 'ID', sortable: true },
        { key: 'name', sortable: true },
        { key: 'location', sortable: true },
        { key: 'email', sortable: true },
        { key: 'contact', sortable: true },
        { key: 'no_of_booking', sortable: true },
        { key: 'status' },
        { key: 'action', sortable: true }
      ],
      items: this.fakeBookings()
    }
  },
  components: {
    AddAgent
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
        const v = { no: i, ID: faker.random.number(), name: faker.name.lastName(), location: faker.address.state(), email: faker.internet.email(), contact: faker.phone.phoneNumber(), no_of_booking: faker.random.number(), status: faker.random.arrayElement(['active', 'inactive']) }
        s.push(v)
      }
      return s
    }
  }
}
</script>
