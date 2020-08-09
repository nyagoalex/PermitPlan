<template>
  <div class="bg-white text-left mt-3 mx-4" >
    <b-table
        class="acc-tb"
      :striped="true"
      :outlined="true"
      :hover="true"
      :no-border-collapse="true"
      :items="transfers"
      :fields="fields"
      caption-top
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      sort-icon-left
      responsive="sm"
      sticky-header
      @row-clicked="item=>$set(item, '_showDetails', !item._showDetails)"
    >
      <template v-slot:table-caption>
        <b-row>
          <b-col><span class='font-weight-bold'>Flight Transfers</span></b-col>
          <b-col><b-button @click="newTransferModal" class='float-right' size="sm"  variant="success"><b-icon icon="plus"></b-icon> Add Flight Transfer</b-button></b-col>
        </b-row>
      </template>
      <template v-slot:cell(#)="row"> {{ row.index + 1 }} </template>
      <template v-slot:row-details="row">
        <b-row>
          <b-col><strong>Cost Per Person: </strong>{{row.item.cost_per_person}} </b-col>
          <b-col><strong>Airline Operator: </strong>{{row.item.airline_operator}} </b-col>
          <b-col class="text-right">
          <b-button pill size="sm" variant="info"  class="mr-4" v-b-modal.new-flight-transfer @click="transfer = row.item, mode = 'update'"><b-icon icon="info-circle-fill"> </b-icon> View</b-button>
          <b-button pill size="sm" variant="danger" @click="deleteGuides(row.item.id)"><b-icon icon="trash-fill"> </b-icon> Delete</b-button>
          </b-col>
        </b-row>
      </template>
    </b-table>
    <div>
      <label>Sorting By: <b>{{ sortBy }}</b>, Sort Direction:
      <b>{{ sortDesc ? 'Descending' : 'Ascending' }}</b></label>
      <b-pagination class="float-right"
        v-model="current_page"
        :total-rows="total"
        :per-page="per_page"
        last-number
        @input="getTransfers(current_page)"
      ></b-pagination>
    </div>
    <AddFlightTransfer :transfer="transfer" :mode="mode"/>
  </div>
</template>
<script>
import AddFlightTransfer from '@/components/Modals/AddFlightTransfer.vue'
import EventBus from '@/Events/EventBus.js'

export default {
  data () {
    return {
      sortBy: 'name',
      sortDesc: false,
      filters: {
        search: null
      },
      fields: [
        { key: '#' },
        { key: 'name', sortable: true },
        { key: 'starting_point', sortable: true },
        { key: 'destination', sortable: true },
        // { key: 'airline_operator', sortable: true },
        // { key: 'cost_per_person', sortable: true },
        { key: 'flight_type', sortable: true },
        { key: 'distance', sortable: true },
        { key: 'est_time' }
      ],
      transfers: [],
      transfer: this.resetModal(),
      mode: '',
      current_page: process.env.VUE_APP_CURRENTPAGE,
      per_page: process.env.VUE_APP_PERPAGE,
      total: process.env.VUE_APP_TOTALROWS
    }
  },
  components: {
    AddFlightTransfer
  },
  methods: {
    getTransfers (page = 1) {
      const filters = this.filters
      filters.page = page
      this.$http.get('/flight-transfers', { params: filters }).then(transfers => {
        this.transfers = transfers.data.data
        const meta = transfers.data.meta
        this.current_page = meta.current_page
        this.per_page = meta.per_page
        this.total = meta.total
      })
    },
    deleteTransfer (id) {
      this.ConfirmDelete().then((result) => {
        if (result.value) {
          this.$http.delete('/flight-transfers/' + id).then(() => {
            this.transfers = this.transfers.filter(item => item.id !== id)
            this.$swal.fire('Deleted!', 'Flight Transfers has been deleted.', 'success')
          })
        }
      })
    },
    newTransferModal () {
      this.transfer = this.resetModal()
      this.mode = 'create'
      this.$bvModal.show('new-flight-transfer')
    },
    resetModal () {
      return {
        name: '',
        starting_point: '',
        destination: '',
        airline_operator: '',
        cost_per_person: '',
        flight_type: '',
        distance: '',
        est_time: ''
      }
    }
  },
  mounted () {
    this.getTransfers()
    EventBus.$on('EVENT_SEARCH', (search) => {
      if (this.$route.name === 'Transfers') {
        this.filters.search = search
      }
    })
  },
  watch: {
    'filters.search': function (val, oldVal) {
      this.getTransfers()
    }
  }
}
</script>
