<template>
    <b-modal id="new-booking" title="Add Booking" size="lg">
      <form>
        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Booking Reference</label>
                    <input class="form-control place" id="b-ref-new" placeholder="Eg. Edgar X20" required>
                </div>
                <div class="form-group">
                    <label>Booking Status</label>
                    <select class="form-control place" id="b-status-new" required>
                        <option value="tentative">Tentative</option>
                        <option value="confirmed">Confirmed</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Tour Name</label>
                    <input class="form-control place" id="b-clientname-new" placeholder="Eg. 4 Days Bwindi Gorilla safari" required>
                </div>
                <div class="form-group">
                    <label>No. of Persons</label>
                    <input type="number" class="form-control place" id="b-no_of_persons-new" placeholder="eg. 2" required>
                </div>
            </div>
            <div class="col-6">
                <div class="form-group">
                    <label>Arrival Date</label>
                    <input type="date" class="form-control place" id="b-startdate-new" placeholder="input number" required>
                </div>
                <div class="form-group">
                    <label>Departure Date</label>
                    <input type="date" class="form-control place" id="b-enddate-new" placeholder="input number" required>
                </div>
                <div class="form-group">
                    <label>Cost Per Person</label>
                    <input type="number" class="form-control place" id="b-cost_per_person-new" placeholder="Enter price per person" required>
                </div>

                <div class="form-group">
                    <label>Source</label>
                    <select class="form-control place" id="b-source-new" v-model="source_selected" required>
                        <option disabled value="">--select source--</option>
                        <option value="direct">Direct</option>
                        <option value="agent">Agent</option>
                    </select>
                </div>
                <div class="form-group" v-if="source_selected == 'agent'">
                    <label><small>Select agent</small></label>
                    <select class="form-control" id="agents-tb-booking"></select>
                </div>
              </div>
              </div>
          </form>
        <template v-slot:modal-footer="{ cancel }">
            <b-button size="sm" variant="danger" :disabled="busy" @click="cancel()">Cancel</b-button>
            <b-button size="sm" variant="success"  :disabled="busy" ref="button" @click="onSubmit">Add Booking</b-button>
        </template>
        <b-overlay :show="busy" opacity="0.6" no-wrap></b-overlay>
    </b-modal>
</template>

<script>
export default {
  data () {
    return {
      source_selected: '',
      busy: false
    }
  },
  methods: {
    onSubmit () {
      this.busy = true
      // Simulate an async request
      setTimeout(() => {
        this.busy = false
      }, 5000)
    }
  }
}
</script>
