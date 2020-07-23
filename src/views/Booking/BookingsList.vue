<template>
  <b-container class="bg-white text-left mt-5">
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
          <b-col><span class='font-weight-bold'>Bookings</span></b-col>
          <b-col><b-button @click="showfilters" class='float-right' variant="link"><b-icon icon="funnel"></b-icon> show filters</b-button></b-col>
        </b-row>
        <b-row v-show="filters" class="pt-3" style="height: 50px; background-color:#F5F9F7;">
          <b-col>
            <b>Status: </b>
            <b-badge pill variant="primary" class="ml-2">Confirmed</b-badge>
            <b-badge pill variant="white" class="bg-white ml-2">Tentative</b-badge>
            <b-badge pill variant="light" class="bg-white ml-2">Cancelled</b-badge>

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
  </b-container>
</template>

<script>

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
        { key: 'booking_no', sortable: true },
        { key: 'booking_ref', sortable: true },
        { key: 'source', sortable: true },
        { key: 'status', sortable: true },
        { key: 'no_of_pax', sortable: true },
        { key: 'permits_booked', sortable: true },
        { key: 'created_by', sortable: true },
        { key: 'created_at', sortable: true }
      ],
      items: this.fakeBookings()
    }
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
        const v = { no: i, booking_no: faker.random.number(), booking_ref: faker.random.number(), source: faker.random.word(), no_of_pax: faker.random.number(), permits_booked: faker.random.number(), created_by: faker.name.lastName(), created_at: 'Jul 16 2020' }
        s.push(v)
      }
      return s
    }
  }
}
</script>
