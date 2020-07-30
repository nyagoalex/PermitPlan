<template>
      <b-container fluid="md">
      <label class="float-left"> <strong> TRACKING & HABITUATION SECTORS </strong></label>
      <b-button pill variant="outline-success" class="float-right" @click="newSectorModal"><b-icon icon="plus-circle"></b-icon> add sector</b-button>
      <br><hr>
        <div class="row pl-3" >
          <b-col v-for="sector in sectors" v-bind:key="sector.id" md='3' class="m-4 user_card" style="background-color:#F5F9F7;">
            <b-row class="mb-2">
                <b-col md='3' style="font-size: 2rem;"> <b-icon icon="tag-fill"></b-icon></b-col>
                <label class="user-name pt-3 px-0">{{sector.name}} </label><br>
            </b-row>
            <b-row>
              <label class="user-name mx-3">{{sector.national_park}} </label><br>
            </b-row>
            <b-row >
             <b-col class="p-0" ><b-button block variant="outline-success" @click="editSectorModal(sector)" style="height: 2em;"> <b-icon icon="pen"></b-icon></b-button></b-col>
             <b-col class="p-0"><b-button block variant="outline-danger" @click="deleteSector(sector.id)" style="height: 2em;"> <b-icon icon="trash"></b-icon></b-button></b-col>
            </b-row>
          </b-col>
        </div>
        <b-pagination align="right" pills
        v-model="current_page"
        :total-rows="total"
        :per-page="per_page"
        last-number
        @input="getSectors(current_page)"
      ></b-pagination>
      <AddSector v-bind:sector="sector" v-bind:mode="mode"/>
      </b-container>
</template>

<script>
import AddSector from '@/components/Modals/AddSector.vue'

export default {
  name: 'sectors',
  data () {
    return {
      sectors: this.getSectors(),
      sector: this.resetModal(),
      mode: '',
      current_page: process.env.VUE_APP_CURRENTPAGE,
      per_page: process.env.VUE_APP_PERPAGE,
      total: process.env.VUE_APP_TOTALROWS
    }
  },
  components: {
    AddSector
  },
  methods: {
    getSectors (page = 1) {
      this.$http.get('/sectors?page=' + page).then(sectors => {
        this.sectors = sectors.data.data
        const meta = sectors.data.meta
        this.current_page = meta.current_page
        this.per_page = meta.per_page
        this.total = meta.total
      })
    },
    deleteSector (id) {
      this.ConfirmDelete().then((result) => {
        if (result.value) {
          this.$http.delete('/sectors/' + id).then(() => {
            this.sectors = this.sectors.filter(item => item.id !== id)
            this.$swal.fire('Deleted!', 'Sector has been deleted.', 'success')
          })
        }
      })
    },
    updateSector (id) {
      this.ConfirmDelete().then((result) => {
        if (result.value) {
          this.$http.delete('/sectors/' + id).then(() => {
            this.sectors = this.sectors.filter(item => item.id !== id)
            this.$swal.fire('Deleted!', 'Sector has been deleted.', 'success')
          })
        }
      })
    },
    newSectorModal () {
      this.sector = this.resetModal()
      this.mode = 'create'
      this.$bvModal.show('new-sector')
    },
    editSectorModal (sector) {
      this.sector = sector
      this.mode = 'update'
      this.$bvModal.show('new-sector')
    },
    resetModal () {
      return {
        name: '',
        national_park: '',
        tracking_activity: ''
      }
    }
  }
}

</script>
