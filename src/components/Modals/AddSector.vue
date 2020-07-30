<template>
    <b-modal  id="new-sector" :title="`${mode} Sector`"
>
        <form>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="">Sector Name  {{mode}}</label>
                        <input class="form-control" type="text" v-model="sector.name" placeholder="e.g Buhoma Sector" :class="{ 'is-invalid': errors.name}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.name">
                          <li v-for="(error) in errors.name" :key="error">{{ error }}</li>
                      </ul>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="account-ln">National Park</label>
                        <input class="form-control" type="text" v-model="sector.national_park" placeholder="e.g Bwindi Forest" :class="{ 'is-invalid': errors.national_park}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.national_park">
                          <li v-for="(error) in errors.national_park" :key="error">{{ error }}</li>
                      </ul>
                    </div>
                </div>

            </div>

            <div class="form-group">
                <label for="account-fn">Tracking Activity</label>
                <input class="form-control" type="text" v-model="sector.tracking_activity" placeholder="e.g Gorilla Tracking" :class="{ 'is-invalid': errors.tracking_activity}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.tracking_activity">
                          <li v-for="(error) in errors.tracking_activity" :key="error">{{ error }}</li>
                      </ul>
            </div>
        </form>
        <template v-slot:modal-footer="{ cancel }">
            <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()">Cancel</b-button>
            <b-overlay :show="loading" rounded opacity="0.6" spinner-small  class="d-inline-block">
            <b-button size="sm" variant="success" :disabled="loading" @click="(`${mode}` == 'create') ? addSectors() : updateSectors()" >{{(`${mode}` == 'create') ? 'Add' : 'Update' }} Sector </b-button>
            </b-overlay>

        </template>
    </b-modal>
</template>

<script>

export default {
  name: 'company',
  data () {
    return {
      loading: false,
      errors: {}
    }
  },
  props: {
    mode: String,
    sector: Object
  },
  methods: {
    addSectors () {
      this.loading = true
      this.errors = {}

      this.$http.post('/sectors', this.sector)
        .then(response => {
          this.alertAddSuccess()
          this.$parent.getSectors()
          this.$bvModal.hide('new-sector')
        })
        .catch(errors => {
          this.errors = errors.errors
          this.toastError(errors.message)
        })
        .finally(() => { this.loading = false })
    },
    updateSectors () {
      this.loading = true
      this.errors = {}

      this.$http.patch('/sectors/' + this.sector.id, this.sector)
        .then(response => {
          this.toastSuccess('Successfully Updated')
          this.$parent.getSectors()
          this.$bvModal.hide('new-sector')
        })
        .catch(errors => {
          this.errors = errors.errors
          this.toastError(errors.message)
        })
        .finally(() => { this.loading = false })
    }
  }
}
</script>
