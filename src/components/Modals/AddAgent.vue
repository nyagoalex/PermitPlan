<template>
    <b-modal id="new-agent" :title="`${mode} Agent`">
        <form>
          <div class="row">
              <div class="col-6">
                  <div class="form-group">
                      <label>Agent Name</label>
                      <input type="text" class="form-control place" v-model="agent.name" placeholder="Enter Agent name" :class="{ 'is-invalid': errors.name}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.name">
                          <li v-for="(error) in errors.name" :key="error">{{ error }}</li>
                      </ul>
                  </div>

                  <div class="form-group">
                      <label>Country</label>
                      <model-select :options="countries" placeholder="select country" v-model="countriesItem" :class="{ 'is-invalid': errors.country}">
                      </model-select>
                        <ul class="list-unstyled invalid-feedback" v-if="errors.country">
                          <li v-for="(error) in errors.country" :key="error">{{ error }}</li>
                      </ul>
                  </div>

                  <div class="form-group">
                    <label>Contact</label>
                    <input type="number" class="form-control" v-model="agent.phone" placeholder="256 ...." :class="{ 'is-invalid': errors.phone}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.phone">
                          <li v-for="(error) in errors.phone" :key="error">{{ error }}</li>
                      </ul>
                  </div>

              </div>
              <div class="col-6">
                  <div class="form-group">
                      <label>Code:</label>
                      <input type="text" style="text-transform:uppercase" class="form-control" v-model="agent.code" placeholder="TYEY-8" :class="{ 'is-invalid': errors.code}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.code">
                          <li v-for="(error) in errors.code" :key="error">{{ error }}</li>
                      </ul>
                  </div>
                  <div class="form-group">
                      <label>Location/City</label>
                      <model-select :options="countriesItem.regions" placeholder="select country" id="agent-city"  v-model="regionsItem" :isDisabled="!(countriesItem.regions.length > 0)" :isError="!(countriesItem.regions.length > 0)" :class="{ 'is-invalid': errors.city}">
                      </model-select>
                      <ul class="list-unstyled invalid-feedback" v-if="errors.city">
                          <li v-for="(error) in errors.city" :key="error">{{ error }}</li>
                      </ul>
                  </div>
                  <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control" v-model="agent.email" placeholder="myemail@example.com" :class="{ 'is-invalid': errors.email}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.email">
                          <li v-for="(error) in errors.email" :key="error">{{ error }}</li>
                      </ul>
                  </div>

              </div>
          </div>
      </form>
        <template v-slot:modal-footer="{ cancel}">
            <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()">Cancel</b-button>
            <b-overlay :show="loading" rounded opacity="0.6" spinner-small  class="d-inline-block">
            <b-button size="sm" variant="success" :disabled="loading" @click="(`${mode}` == 'create') ? addAgent() : updateAgent()" >{{(`${mode}` == 'create') ? 'Add' : 'Update' }} Agent</b-button>
            </b-overlay>
        </template>
    </b-modal>
</template>

<script>
import { ModelSelect } from 'vue-search-select'
import { countries } from '@/Constants/countries.js'

export default {
  data () {
    return {
      countries: countries,
      countriesItem: { value: '', text: '', regions: [] },
      regionsItem: { value: '', text: '' },
      loading: false,
      errors: {}
    }
  },
  props: {
    mode: String,
    agent: Object
  },
  methods: {
    addAgent () {
      this.loading = true
      this.errors = {}

      this.$http.post('/agents', this.agent)
        .then(response => {
          this.alertAddSuccess()
          this.$parent.getAgents()
          this.$bvModal.hide('new-agent')
        })
        .catch(errors => {
          this.errors = errors.errors
          this.toastError(errors.message)
        })
        .finally(() => { this.loading = false })
    },
    updateAgent () {
      this.loading = true
      this.errors = {}

      this.$http.patch('/agents/' + this.agent.id, this.agent)
        .then(response => {
          this.toastSuccess('Successfully Updated')
          this.$parent.getAgents()
          this.$bvModal.hide('new-agent')
        })
        .catch(errors => {
          this.errors = errors.errors
          this.toastError(errors.message)
        })
        .finally(() => { this.loading = false })
    }
  },
  components: {
    ModelSelect
  },
  watch: {
    countriesItem: function (val) {
      this.agent.country = val.text
      this.agent.city = ''
    },
    regionsItem: function (val) {
      this.agent.city = val.text
    }
  }
}
</script>
