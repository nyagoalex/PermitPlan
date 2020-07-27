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
      @row-clicked="onRowClicked"
      class="acc-tb"
    >
      <template v-slot:table-caption>
        <b-row>
          <b-col><span class='font-weight-bold'>Lodges + Hotels</span></b-col>
          <b-col><b-button v-b-modal.new-agent class='float-right' size="sm"  variant="success"><b-icon icon="plus"></b-icon> Add Lodges / Hotels</b-button></b-col>
        </b-row>
      </template>
      <template v-slot:cell(hotel_star_rating)="row">
        <span><star-rating :rating="row.item.hotel_star_rating" :star-size="20" :read-only="true" :increment="0.01" :show-rating="false"></star-rating></span>
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
    <AddAccomodation/>
  </div>
</template>
<script>
import AddAccomodation from '@/components/Modals/AddAccomodation.vue'
import StarRating from 'vue-star-rating'

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
        { key: 'Lodge_ID', sortable: true },
        { key: 'name', sortable: true },
        { key: 'email', sortable: true },
        { key: 'phone', sortable: true },
        { key: 'location', sortable: true },
        { key: 'hotel_star_rating', sortable: true },
        { key: 'contracted_rates', sortable: true }
      ],
      items: this.fakeBookings()
    }
  },
  components: {
    AddAccomodation,
    StarRating
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
        const v = { no: i, Lodge_ID: faker.random.number(), name: faker.name.lastName(), location: faker.address.state(), email: faker.internet.email(), phone: faker.phone.phoneNumber(), hotel_star_rating: 2.56, contracted_rates: 4.6 }
        s.push(v)
      }
      return s
    },
    onRowClicked (item, index, event) {
      this.$router.push({ name: 'AccommodationDetails', params: { id: item.no } })
    }
  }
}
</script>
