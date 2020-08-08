<template>
  <div class="bg-white text-left mt-3 mx-4" >
    <b-table
      class="acc-tb"
      :striped="true"
      :outlined="true"
      :hover="true"
      :no-border-collapse="true"
      :items="guides"
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
          <b-col><span class='font-weight-bold'>Tour Guide</span></b-col>
          <b-col class='text-center'><b-button v-b-modal.new-guide size="sm"  variant="success"><b-icon icon="plus"></b-icon> Add Tour Guide</b-button></b-col>
          <b-col><b-button :pressed.sync="show_filters" class='float-right' variant="link"><b-icon icon="funnel"></b-icon> show filters</b-button></b-col>
        </b-row>
         <b-row v-show="show_filters" class="pt-3" style="height: 50px; background-color:#F5F9F7;">
          <b-col>
            <b>Status: </b>
            <b-badge pill :variant="`${(filters.status === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != null, 'ml-2': true }" @click="filters.status = null">All</b-badge>
            <b-badge pill :variant="`${(filters.status === 'working') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'working', 'ml-2': true }" @click="filters.status = 'working'">Working</b-badge>
            <b-badge pill :variant="`${(filters.status === 'terminated') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'terminated', 'ml-2': true }" @click="filters.status = 'terminated'">Teminated</b-badge>
            <b-badge pill :variant="`${(filters.status === 'probation') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.status != 'probation', 'ml-2': true }" @click="filters.status = 'probation'">On Probation</b-badge>
          </b-col>
          <b-col class='text-right'>
            <b>Contract Basis: </b>
             <b-badge pill :variant="`${(filters.contract_basis === null) ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.contract_basis != null, 'ml-2': true }" @click="filters.contract_basis = null">All</b-badge>
            <b-badge pill :variant="`${(filters.contract_basis === 'full_time') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.contract_basis != 'full_time', 'ml-2': true }" @click="filters.contract_basis = 'full_time'">Full Time</b-badge>
            <b-badge pill :variant="`${(filters.contract_basis === 'freelancer') ? 'primary' : 'light'}`" :class="{ 'bg-white': filters.contract_basis != 'freelancer', 'ml-2': true }" @click="filters.contract_basis = 'freelancer'">Freelancer</b-badge>
          </b-col>
        </b-row>
      </template>
      <template v-slot:cell(#)="row"> {{ row.index + 1 }} </template>
      <template v-slot:cell(name)="row"> {{ row.item.full_name}} </template>
       <template v-slot:cell(status)="row">
       <span :class="{ badge: true, 'badge-success': row.item.status == 'working', 'badge-danger': row.item.status == 'terminated', 'badge-warning': row.item.status == 'probation'}">
        {{ row.item.status}}</span>
      </template>
      <template v-slot:row-details="row">
        <b-row>
          <b-col><strong>Age: </strong> {{row.item.age}}</b-col>
          <b-col><strong>Email: </strong> {{row.item.email}}</b-col>
          <b-col><strong>Contract Basis: </strong>{{row.item.contract_basis.replace("_", " ")}} </b-col>
          <b-col class="text-center">
          <b-button pill size="sm" variant="info"  class="mr-4" v-b-modal.guide-details @click="guide = row.item"><b-icon icon="info-circle-fill"> </b-icon> View</b-button>
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
        @input="getGuides(current_page)"
      ></b-pagination>
    </div>
    <AddGuide/>
    <GuideDetails v-if="guide" :guide="guide"/>
  </div>
</template>
<script>
import AddGuide from '@/components/Modals/AddGuide.vue'
import GuideDetails from '@/components/Modals/GuideDetails.vue'

export default {
  data () {
    return {
      sortBy: 'experience_since',
      sortDesc: false,
      filters: {
        status: null,
        contract_basis: null,
        page: 1
      },
      show_filters: false,
      fields: [
        { key: '#', sortable: false },
        { key: 'code', sortable: true },
        { key: 'name', sortable: true },
        { key: 'phone', sortable: true },
        // { key: 'email', sortable: true },
        // { key: 'age', sortable: true },
        { key: 'experience', sortable: true },
        { key: 'cost_per_day', sortable: true },
        // { key: 'contract_basis', sortable: true },
        { key: 'status' }
      ],
      guides: [],
      guide: false,
      current_page: process.env.VUE_APP_CURRENTPAGE,
      per_page: process.env.VUE_APP_PERPAGE,
      total: process.env.VUE_APP_TOTALROWS
    }
  },
  components: {
    AddGuide,
    GuideDetails
  },
  methods: {
    getGuides (page = 1) {
      const filters = this.filters
      filters.page = page
      this.$http.get('/guides', { params: filters }).then(guides => {
        this.guides = guides.data.data
        const meta = guides.data.meta
        this.current_page = meta.current_page
        this.per_page = meta.per_page
        this.total = meta.total
      })
    },
    deleteGuides (id) {
      this.ConfirmDelete().then((result) => {
        if (result.value) {
          this.$http.delete('/guides/' + id).then(() => {
            this.guides = this.guides.filter(item => item.id !== id)
            this.$swal.fire('Deleted!', 'Guides has been deleted.', 'success')
          })
        }
      })
    },
    editGuideModal (guide) {
      this.guide = guide
      this.$bvModal.show('new-guide')
    }
  },
  mounted () {
    this.getGuides()
  },
  watch: {
    'filters.status': function (val, oldVal) {
      this.getGuides()
    },
    'filters.contract_basis': function (val, oldVal) {
      this.getGuides()
    }
  }
}
</script>
