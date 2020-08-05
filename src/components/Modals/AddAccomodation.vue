<template>
    <b-modal id="new-lodge" title="Add Lodge / Hotel">
        <form>
          <div class="form-group">
              <label >Hotel Name</label>
              <input type="text" class="form-control"  placeholder="Lacel Safari camp" v-model="lodge.name"  :class="{ 'is-invalid': errors.name}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.name">
                    <li v-for="(error) in errors.name" :key="error">{{ error }}</li>
                </ul>
          </div>

          <div class="form-row">
              <div class="form-group col-md-6">
                  <label>Email</label>
                  <input type="email" class="form-control" v-model="lodge.email"  :class="{ 'is-invalid': errors.email}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.email">
                    <li v-for="(error) in errors.email" :key="error">{{ error }}</li>
                </ul>
              </div>
              <div class="form-group col-md-6">
                  <label >Phone Number</label>
                  <input type="text" class="form-control" v-model="lodge.phone"  :class="{ 'is-invalid': errors.phone}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.phone">
                    <li v-for="(error) in errors.phone" :key="error">{{ error }}</li>
                </ul>
              </div>
          </div>
          <div class="form-group">
              <label >Address</label>
              <input type="text" class="form-control"  placeholder="1234 Main St" v-model="lodge.address"  :class="{ 'is-invalid': errors.address}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.address">
                    <li v-for="(error) in errors.address" :key="error">{{ error }}</li>
                </ul>
          </div>

          <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="l-country">Country</label>
                    <model-select :options="countries" placeholder="select country" v-model="countriesItem" :class="{ 'is-invalid': errors.country}">
                      </model-select>
                        <ul class="list-unstyled invalid-feedback" v-if="errors.country">
                          <li v-for="(error) in errors.country" :key="error">{{ error }}</li>
                      </ul>
              </div>
              <div class="form-group col-md-6">
                  <label for="l-location">Location</label>
                  <model-select :options="countriesItem.regions" placeholder="select Location" v-model="regionsItem" :isDisabled="!(countriesItem.regions.length > 0)" :isError="!(countriesItem.regions.length > 0)" :class="{ 'is-invalid': errors.location}">
                      </model-select>
                    <ul class="list-unstyled invalid-feedback" v-if="errors.location">
                        <li v-for="(error) in errors.location" :key="error">{{ error }}</li>
                    </ul>
              </div>

          </div>

          <div class="form-row">
              <div class="form-group col-md-6">
                  <label >Contracted Rate (%)</label>
                  <input type="text" class="form-control"  placeholder="20" min='0' max='100' v-model="lodge.contracted_rating"  :class="{ 'is-invalid': errors.contracted_rating}">
                    <ul class="list-unstyled invalid-feedback" v-if="errors.contracted_rating">
                        <li v-for="(error) in errors.contracted_rating" :key="error">{{ error }}</li>
                    </ul>
              </div>
              <div class="form-group col-md-6">
                  <label>Hotel Rating</label>
                  <input type="number" placeholder="3" class="form-control" id="l-rating" min='0' max='5' v-model="lodge.star_rating"  :class="{ 'is-invalid': errors.star_rating}">
                    <ul class="list-unstyled invalid-feedback" v-if="errors.star_rating">
                        <li v-for="(error) in errors.star_rating" :key="error">{{ error }}</li>
                    </ul>
              </div>

          </div>
      </form>
        <template v-slot:modal-footer="{ cancel }">
             <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()">Cancel</b-button>
            <b-overlay :show="loading" rounded opacity="0.6" spinner-small  class="d-inline-block">
            <b-button size="sm" variant="success" :disabled="loading" @click="addLodge" >Save Hotel & Continue</b-button>
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
      errors: {},
      lodge: this.resetModal()
    }
  },
  methods: {
    addLodge () {
      this.loading = true
      this.errors = {}

      this.$http.post('/lodges', this.lodge)
        .then(response => {
          this.alertAddSuccess()
          this.lodge = this.resetModal()
          this.$parent.getLodges()
          this.$bvModal.hide('new-lodge')
        })
        .catch(errors => {
          this.errors = errors.errors
          this.toastError(errors.message)
        })
        .finally(() => { this.loading = false })
    },
    resetModal () {
      return {
        code: '',
        name: '',
        email: '',
        phone: '',
        location: '',
        hotel_star_rating: '',
        contracted_rating: ''
      }
    }
  },
  components: {
    ModelSelect
  },
  watch: {
    countriesItem: function (val) {
      this.lodge.country = val.text
      this.lodge.location = ''
    },
    regionsItem: function (val) {
      this.lodge.location = val.text
    }
  }
}
</script>
