<template>
    <b-modal id="new-flight-transfer" title="Add Flight Transfer">
        <form>
            <div class="form-group">
                <label >Transfer Name</label>
                <input type="text" class="form-control"  placeholder=" EBB - KIHIHI" v-model="transfer.name" :class="{ 'is-invalid': errors.name}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.name">
                    <li v-for="(error) in errors.name" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="ft-starting_point">starting Point</label>
                    <input type="text" class="form-control" v-model="transfer.starting_point" :class="{ 'is-invalid': errors.starting_point}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.starting_point">
                    <li v-for="(error) in errors.starting_point" :key="error">{{ error }}</li>
                </ul>
                </div>
                <div class="form-group col-md-6">
                    <label for="ft-destination">Destination</label>
                    <input type="text" class="form-control" v-model="transfer.destination" :class="{ 'is-invalid': errors.destination}">
                    <ul class="list-unstyled invalid-feedback" v-if="errors.destination">
                        <li v-for="(error) in errors.destination" :key="error">{{ error }}</li>
                    </ul>
                </div>
            </div>
            <div class="form-group">

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="ft-airline_operator">Airline Operator</label>
                    <input type="text" class="form-control" placeholder="Aerolink" v-model="transfer.airline_operator" :class="{ 'is-invalid': errors.airline_operator}">
                    <ul class="list-unstyled invalid-feedback" v-if="errors.airline_operator">
                        <li v-for="(error) in errors.airline_operator" :key="error">{{ error }}</li>
                    </ul>
                </div>

                <div class="form-group col-md-6">
                    <label  >Flight Type</label>
                    <select  class="form-control"  v-model="transfer.flight_type" :class="{ 'is-invalid': errors.flight_type}">
                        <option selected>Choose...</option>
                        <option value="scheduled">Scheduled Flight</option>
                        <option value="chartered">Chartered Flight</option>
                    </select>
                    <ul class="list-unstyled invalid-feedback" v-if="errors.flight_type">
                        <li v-for="(error) in errors.flight_type" :key="error">{{ error }}</li>
                    </ul>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="ft-departure_time">Departure Time</label>
                    <input type="time" placeholder="300" class="form-control"   v-model="transfer.departure_time" :class="{ 'is-invalid': errors.departure_time}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.departure_time">
                    <li v-for="(error) in errors.departure_time" :key="error">{{ error }}</li>
                </ul>
                </div>
                <div class="form-group col-md-6">
                    <label for="ft-arrival_time">Est. Arrival Time</label>
                    <input type="time" class="form-control" placeholder="3"    v-model="transfer.arrival_time" :class="{ 'is-invalid': errors.arrival_time}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.arrival_time">
                    <li v-for="(error) in errors.arrival_time" :key="error">{{ error }}</li>
                </ul>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label >Cost P/P (USD)</label>
                    <input type="number" placeholder="300" class="form-control" v-model="transfer.cost_per_person" :class="{ 'is-invalid': errors.cost_per_person}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.cost_per_person">
                    <li v-for="(error) in errors.cost_per_person" :key="error">{{ error }}</li>
                </ul>
                </div>
                <div class="form-group col-md-4">
                    <label for="ft-est_time">Est. Time (Hrs)</label>
                    <input type="time" class="form-control" placeholder="3" v-model="transfer.est_time" :class="{ 'is-invalid': errors.est_time}">
                    <ul class="list-unstyled invalid-feedback" v-if="errors.est_time">
                        <li v-for="(error) in errors.est_time" :key="error">{{ error }}</li>
                    </ul>
                </div>

                <div class="form-group col-md-4">
                    <label for="ft-distance">Distance (KM)</label>
                    <input type="number" class="form-control" placeholder="200" v-model="transfer.distance" :class="{ 'is-invalid': errors.distance}">
                    <ul class="list-unstyled invalid-feedback" v-if="errors.distance">
                        <li v-for="(error) in errors.distance" :key="error">{{ error }}</li>
                    </ul>
                </div>
            </div>
        </form>
        <template v-slot:modal-footer="{ cancel }">
            <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()">Cancel</b-button>
            <b-overlay :show="loading" rounded opacity="0.6" spinner-small  class="d-inline-block">
            <b-button size="sm" variant="success" :disabled="loading" @click="(`${mode}` == 'create') ? addTransfer() : updateTransfer()" >{{(`${mode}` == 'create') ? 'Add' : 'Update' }} Flight Transfer</b-button>
            </b-overlay>
        </template>
    </b-modal>
</template>

<script>

export default {
  data () {
    return {
      loading: false,
      errors: {},
      vehicles: []
    }
  },
  props: {
    mode: String,
    transfer: Object
  },
  methods: {
    addTransfer () {
      this.loading = true
      this.errors = {}
      this.$http.post('/flight-transfers', this.transfer)
        .then(response => {
          this.alertAddSuccess()
          this.$parent.getTransfers()
          this.$bvModal.hide('new-flight-transfer')
        })
        .catch(errors => {
          this.errors = errors.errors
          this.toastError(errors.message)
        })
        .finally(() => { this.loading = false })
    },
    updateTransfer () {
      this.loading = true
      this.errors = {}

      this.$http.patch('/flight-transfers/' + this.transfer.id, this.transfer)
        .then(response => {
          this.toastSuccess('Successfully Updated')
          this.$parent.getTransfers()
          this.$bvModal.hide('new-flight-transfer')
        })
        .catch(errors => {
          this.errors = errors.errors
          this.toastError(errors.message)
        })
        .finally(() => { this.loading = false })
    }
  },
  mounted () {
    this.$http.get('/vehicles').then(vehicles => {
      this.vehicles = vehicles.data.data.map(function (num) {
        return { value: num.id, text: num.type + ' (' + num.code + ')' }
      })
    })
  }
}

</script>
