<template>
  <div class="tab-pane">
    <div>
    <div class="row pl-4 pt-4"><h5>Hotel/Lodge Activities</h5></div>
      <hr class="mt-0 mb-3">
      <div class="row">
        <div class="form-group col-md-3">
            <label>Add New Activity </label>
            <input class="form-control" type="text" ref="activity_name" :class="{ 'is-invalid': activity_errors.name}">
              <ul class="list-unstyled invalid-feedback" v-if="activity_errors.name">
                <li v-for="(error) in activity_errors.name" :key="error">{{ error }}</li>
            </ul>
        </div>

        <div class="form-group col-md-3">
            <label>Activity Price P/P </label>
            <input class="form-control" type="number"  ref="activity_price" :class="{ 'is-invalid': activity_errors.cost_per_person}">
              <ul class="list-unstyled invalid-feedback" v-if="activity_errors.cost_per_person">
                <li v-for="(error) in activity_errors.cost_per_person" :key="error">{{ error }}</li>
            </ul>
        </div>
        <div class="text-right' col-md-3">
          <br>
          <b-overlay :show="loading" rounded opacity="0.6" spinner-small  class="d-inline-block">
            <b-button variant="outline-success" :disabled="loading" @click="addActivity"> + Add a new Activity</b-button>
          </b-overlay>
        </div>
      </div>
      <div class="row">
          <div class='season m-5 ' v-if="!activities || !activities.length"><p class='text-muted p-2'>No activities Registered Yet.</p></div>
          <b-col v-for="(item, index) in activities" v-bind:key="item.id" md='3' class="m-4 user_card" style="background-color:#F5F9F7;">
            <b-row class="mb-2">
                <b-col md='3' style="font-size: 2rem;"> <b-icon icon="check-circle-fill"></b-icon></b-col>
                <label class="pt-3 px-0">{{item.name}} </label><br>
            </b-row>
            <b-row> <label class="text-primary mx-3">$ {{item.cost_per_person}}</label><br></b-row>
            <b-row >
            <b-col class="p-0" ><b-button block variant="outline-success" @click="editActivity(index)" style="height: 2em;"> <b-icon icon="pen"></b-icon></b-button></b-col>
            <b-col class="p-0"><b-button block variant="outline-danger" @click="deleteActivity(index)" style="height: 2em;"> <b-icon icon="trash"></b-icon></b-button></b-col>
            </b-row>
          </b-col>
      </div>
    </div>

    <div>
    <div class="row pl-4 pt-4"><h5>Hotel/Lodge Facilities</h5></div>
      <hr class="mt-0 mb-3">
      <div class="row">
        <div class="form-group col-md-3">
            <label>Add New Facility </label>
            <input class="form-control" type="text" ref="facility_name" :class="{ 'is-invalid': facility_errors.name}">
              <ul class="list-unstyled invalid-feedback" v-if="facility_errors.name">
                <li v-for="(error) in facility_errors.name" :key="error">{{ error }}</li>
            </ul>
        </div>

        <div class="form-group col-md-3">
            <label>Facility Price P/P </label>
            <input class="form-control" type="number"  ref="facility_price" :class="{ 'is-invalid': facility_errors.cost_per_person}">
              <ul class="list-unstyled invalid-feedback" v-if="facility_errors.cost_per_person">
                <li v-for="(error) in facility_errors.cost_per_person" :key="error">{{ error }}</li>
            </ul>
        </div>
        <div class="text-right' col-md-3">
          <br>
          <b-overlay :show="loading" rounded opacity="0.6" spinner-small  class="d-inline-block">
            <b-button variant="outline-success" :disabled="loading" @click="addFacility"> + Add a new Facility</b-button>
          </b-overlay>
        </div>
      </div>
      <div class="row">
          <div class='season m-5 ' v-if="!facilities || !facilities.length"><p class='text-muted p-2'>No facilities Registered Yet.</p></div>
          <b-col v-for="(item, index) in facilities" v-bind:key="item.id" md='3' class="m-4 user_card" style="background-color:#F5F9F7;">
            <b-row class="mb-2">
                <b-col md='3' style="font-size: 2rem;"> <b-icon icon="check-circle-fill"></b-icon></b-col>
                <label class="pt-3 px-0">{{item.name}} </label><br>
            </b-row>
            <b-row> <label class="text-primary mx-3">$ {{item.cost_per_person}}</label><br></b-row>
            <b-row >
            <b-col class="p-0" ><b-button block variant="outline-success" @click="editFacility(index)" style="height: 2em;"> <b-icon icon="pen"></b-icon></b-button></b-col>
            <b-col class="p-0"><b-button block variant="outline-danger" @click="deleteFacility(index)" style="height: 2em;"> <b-icon icon="trash"></b-icon></b-button></b-col>
            </b-row>
          </b-col>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  data () {
    return {
      loading: false,
      activity_errors: {},
      facility_errors: {}
    }
  },
  props: {
    activities: Array,
    facilities: Array
  },
  methods: {
    addActivity () {
      // this.loading = true
      this.errors = {}
      const activity_name  = this.$refs.activity_name.value // eslint-disable-line
      const activity_price  = this.$refs.activity_price.value // eslint-disable-line

      this.$http.post('/lodges/' + this.$route.params.id + '/activities', { name: activity_name, cost_per_person: activity_price })
        .then(response => {
          this.alertAddSuccess()
          this.name = ''
          const { id, name, cost_per_person} = response.data.data // eslint-disable-line
          this.activities.push({ id: id, name: name, cost_per_person: cost_per_person })
          this.$refs.activity_name.value = ''
          this.$refs.activity_price.value = ''
        })
        .catch(errors => {
          this.activity_errors = errors.errors
          this.toastError(errors.message)
        })
        .finally(() => { this.loading = false })
    },
    deleteActivity (index) {
      const id = this.activities[index].id

      this.ConfirmDelete().then((result) => {
        if (result.value) {
          this.$http.delete('/lodges/' + this.$route.params.id + '/activities/' + id)
            .then(() => {
              this.activities = this.activities.filter(item => item.id !== id)
              this.$swal.fire('Deleted!', 'Activity has been deleted.', 'success')
            })
            .catch(errors => {
              this.toastError(errors.message)
            })
        }
      })
    },
    async editActivity (index) {
      const {id, name, cost_per_person}  = this.activities[index] // eslint-disable-line
      const { value: formValues } = await this.$swal.fire({
        title: 'Update Activity',
        html: 'Name: <input id="swal-input1" class="swal2-input" value="' + name + '" type="text">' +
              'Activity Price P/P:<br></input><input id="swal-input2" class="swal2-input" value="' + cost_per_person + '" type="number">',// eslint-disable-line
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Update Room',
        reverseButtons: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return [
            document.getElementById('swal-input1').value,
            document.getElementById('swal-input2').value
          ]
        }
      })
      if (formValues) {
        this.$http.patch('/lodges/' + this.$route.params.id + '/activities/' + id, { name: formValues[0], cost_per_person: formValues[1] })
          .then(response => {
            this.toastSuccess('Successfully Updated')
            // this.name = ''
            const { id, name, cost_per_person } = response.data.data // eslint-disable-line

            this.$set(this.activities, index, { id: id, name: name, cost_per_person: cost_per_person })
          })
          .catch(errors => {
            this.$swal.fire('Failed!', errors.message, 'error')
          })
      }
    },
    addFacility () {
      // this.loading = true
      this.errors = {}
      const facility_name  = this.$refs.facility_name.value // eslint-disable-line
      const facility_price  = this.$refs.facility_price.value // eslint-disable-line
      this.$http.post('/lodges/' + this.$route.params.id + '/facilities', { name: facility_name, cost_per_person: facility_price })
        .then(response => {
          this.alertAddSuccess()
          this.name = ''
          const { id, name, cost_per_person} = response.data.data // eslint-disable-line
          this.facilities.push({ id: id, name: name, cost_per_person: cost_per_person })
          this.$refs.facility_name.value = ''
          this.$refs.facility_price.value = ''
        })
        .catch(errors => {
          this.facility_errors = errors.errors
          this.toastError(errors.message)
        })
        .finally(() => { this.loading = false })
    },
    deleteFacility (index) {
      const id = this.facilities[index].id

      this.ConfirmDelete().then((result) => {
        if (result.value) {
          this.$http.delete('/lodges/' + this.$route.params.id + '/facilities/' + id)
            .then(() => {
              this.facilities = this.facilities.filter(item => item.id !== id)
              this.$swal.fire('Deleted!', 'Facility has been deleted.', 'success')
            })
            .catch(errors => {
              this.toastError(errors.message)
            })
        }
      })
    },
    async editFacility (index) {
      const {id, name, cost_per_person}  = this.facilities[index] // eslint-disable-line
      const { value: formValues } = await this.$swal.fire({
        title: 'Update Facility',
        html: 'Name: <input id="swal-input1" class="swal2-input" value="' + name + '" type="text">' +
              'Facility Price P/P:<br></input><input id="swal-input2" class="swal2-input" value="' + cost_per_person + '" type="number">',// eslint-disable-line
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Update Room',
        reverseButtons: true,
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return [
            document.getElementById('swal-input1').value,
            document.getElementById('swal-input2').value
          ]
        }
      })
      if (formValues) {
        this.$http.patch('/lodges/' + this.$route.params.id + '/facilities/' + id, { name: formValues[0], cost_per_person: formValues[1] })
          .then(response => {
            this.toastSuccess('Successfully Updated')
            // this.name = ''
            const { id, name, cost_per_person } = response.data.data // eslint-disable-line

            this.$set(this.facilities, index, { id: id, name: name, cost_per_person: cost_per_person })
          })
          .catch(errors => {
            this.$swal.fire('Failed!', errors.message, 'error')
          })
      }
    }
  }
}
</script>
