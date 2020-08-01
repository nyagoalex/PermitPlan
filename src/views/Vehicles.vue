<template>
  <div class="bg-white text-left mt-3 mx-4" >
    <b-table
      class="acc-tb"
      :striped="true"
      :outlined="true"
      :hover="true"
      :no-border-collapse="true"
      :items="vehicles"
      :fields="fields"
      caption-top
      :sort-by.sync="sortBy"
      :sort-desc.sync="sortDesc"
      sort-icon-left
      responsive="sm"
      :per-page="per_page"
      :current-page="current_page"
      @row-clicked="item=>$set(item, '_showDetails', !item._showDetails)"
    >
      <template v-slot:table-caption>
        <b-row>
          <b-col><span class='font-weight-bold'>Vehicles</span></b-col>
          <b-col class='text-center'><b-button @click="newVehicleModal" size="sm"  variant="success"><b-icon icon="plus"></b-icon> Add Vehicle</b-button></b-col>
          <b-col><b-button :pressed.sync="show_filters" class='float-right' variant="link"><b-icon icon="funnel"></b-icon> show filters</b-button></b-col>
        </b-row>
        <b-row v-show="show_filters" class="pt-3"  style="height: 50px; background-color:#F5F9F7;">
          <b-col>
            <b>Status: </b>
            <b-badge pill :variant="`${(filters.status === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != null, 'ml-2': true }" @click="filters.status = null">All</b-badge>
            <b-badge pill :variant="`${(filters.status === 'ready') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'ready', 'ml-2': true }" @click="filters.status = 'ready'">Ready</b-badge>
            <b-badge pill :variant="`${(filters.status === 'disposed_off') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'disposed_off', 'ml-2': true }" @click="filters.status = 'disposed_off'">Disposed Off</b-badge>
            <b-badge pill :variant="`${(filters.status === 'too_old') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'too_old', 'ml-2': true }" @click="filters.status = 'too_old'">Too Old</b-badge>
            <b-badge pill :variant="`${(filters.status === 'has_issues') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'has_issues', 'ml-2': true }" @click="filters.status = 'has_issues'">Has issues</b-badge>

          </b-col>
          <b-col class="text-right">
            <b>Owner: </b>
            <b-badge pill :variant="`${(filters.ownership === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.ownership != null, 'ml-2': true }" @click="filters.ownership = null">All</b-badge>
            <b-badge pill :variant="`${(filters.ownership === 'company') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.ownership != 'company', 'ml-2': true }" @click="filters.ownership = 'company'">Company</b-badge>
            <b-badge pill :variant="`${(filters.ownership === 'hired') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.ownership != 'hired', 'ml-2': true }" @click="filters.ownership = 'hired'">Hired</b-badge>

          </b-col>
        </b-row>
      </template>
       <template v-slot:cell(#)="row">
        {{ row.index + 1 }}
      </template>
       <template v-slot:cell(status)="row">
       <span :class="{ badge: true, 'badge-success': row.item.status == 'ready', 'badge-danger': row.item.status == 'disposed_off', 'badge-info': row.item.status == 'too_old', 'badge-warning': row.item.status == 'has_issues'}">
        {{ row.item.status.replace("_", " ")}}</span>
      </template>
      <template v-slot:row-details="row">
        <b-row>
          <b-col><strong>Ownership: </strong> {{row.item.ownership}}</b-col>
          <b-col><strong>Registration Number: </strong> {{row.item.reg_no}}</b-col>
          <b-col><strong>Color: </strong> <b-badge pill size="sm" variant="success"> {{row.item.color}} </b-badge></b-col>
          <b-col class="text-center">
            <b-button pill size="sm" variant="warning" @click="editVehicleModal(row.item)"  class="mr-4">Edit</b-button>
            <b-button pill size="sm" variant="danger" @click="deleteVehicle(row.item.id)"> Delete</b-button>
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
        @input="getVehicles(current_page)"
      ></b-pagination>
    </div>
    <AddVehicle v-bind:vehicle="vehicle" v-bind:mode="mode"/>
  </div>
</template>
<script>
import AddVehicle from '@/components/Modals/AddVehicle.vue'

export default {
  data () {
    return {
      sortBy: 'code',
      sortDesc: false,
      filters: {
        status: null,
        ownership: null,
        page: 1
      },
      show_filters: false,
      fields: [
        { key: '#', sortable: false },
        { key: 'code', sortable: true },
        // { key: 'reg_number', sortable: true },
        { key: 'type', sortable: true },
        // { key: 'color', sortable: true },
        { key: 'no_of_seats', sortable: true },
        { key: 'cost_per_day', sortable: true },
        // { key: 'ownership', sortable: true },
        { key: 'status' }
      ],
      vehicles: [],
      vehicle: this.resetModal(),
      mode: '',
      current_page: process.env.VUE_APP_CURRENTPAGE,
      per_page: process.env.VUE_APP_PERPAGE,
      total: process.env.VUE_APP_TOTALROWS
    }
  },
  components: {
    AddVehicle
  },
  methods: {
    getVehicles (page = 1) {
      const filters = this.filters
      filters.page = page
      this.$http.get('/vehicles', { params: filters }).then(vehicles => {
        this.vehicles = vehicles.data.data
        const meta = vehicles.data.meta
        this.current_page = meta.current_page
        this.per_page = meta.per_page
        this.total = meta.total
      })
    },
    deleteVehicle (id) {
      this.ConfirmDelete().then((result) => {
        if (result.value) {
          this.$http.delete('/vehicles/' + id).then(() => {
            this.vehicles = this.vehicles.filter(item => item.id !== id)
            this.$swal.fire('Deleted!', 'Vehicle has been deleted.', 'success')
          })
        }
      })
    },
    newVehicleModal () {
      this.vehicle = this.resetModal()
      this.mode = 'create'
      this.$bvModal.show('new-vehicle')
    },
    editVehicleModal (vehicle) {
      this.vehicle = vehicle
      this.mode = 'update'
      this.$bvModal.show('new-vehicle')
    },
    resetModal () {
      return {
        reg_no: '',
        color: '',
        no_of_seats: '',
        type: '',
        status: '',
        ownership: '',
        cost_per_day: '',
        code: ''
      }
    }
  },
  mounted () {
    this.getVehicles()
  },
  watch: {
    'filters.status': function (val, oldVal) {
      this.getVehicles()
    },
    'filters.ownership': function (val, oldVal) {
      this.getVehicles()
    }
  }
}
</script>
