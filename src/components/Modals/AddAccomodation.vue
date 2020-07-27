<template>
    <b-modal id="new-agent" title="Add Lodge / Hotel">
        <form>
          <div class="form-group">
              <label for="l-name">Hotel Name</label>
              <input type="text" class="form-control"  placeholder="Lacel Safari camp" id="l-name" required>
          </div>

          <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="l-email">Email</label>
                  <input type="email" class="form-control" id="l-email">
              </div>
              <div class="form-group col-md-6">
                  <label for="l-phone">Phone Number</label>
                  <input type="text" class="form-control" id="l-phone">
              </div>
          </div>
          <div class="form-group">
              <label for="l-address">Address</label>
              <input type="text" class="form-control" id="l-address" placeholder="1234 Main St">
          </div>

          <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="l-country">Country</label>
                  <model-select :options="countries" placeholder="select country" id="agent-country"  v-model="countries_item">
                  </model-select>
              </div>
              <div class="form-group col-md-6">
                  <label for="l-location">Location</label>
                  <model-select :options="countries_item.regions" placeholder="select location" id="l-location"  v-model="regions_item" :isDisabled="!(countries_item.regions.length > 0)" :isError="!(countries_item.regions.length > 0)">
                      </model-select>
              </div>

          </div>

          <div class="form-row">
              <div class="form-group col-md-6">
                  <label for="l-contracted_rating">Contracted Rate (%)</label>
                  <input type="text" class="form-control"  placeholder="20" id="l-contracted_rating" min='0' max='100' required>
              </div>
              <div class="form-group col-md-6">
                  <label for="l-rating">Hotel Rating</label>
                  <input type="number" placeholder="3" class="form-control" id="l-rating" min='0' max='5' required>
              </div>

          </div>

      </form>
        <template v-slot:modal-footer="{ cancel, ok }">
            <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
            <b-button size="sm" variant="success" @click="ok()">Save Hotel & Continue</b-button>
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
      countries_item: { value: '', text: '', regions: [] },
      regions_item: { value: '', text: '' }
    }
  },
  methods: {
    show () {

    }
  },
  components: {
    ModelSelect
  },
  async created () {
    // alert(this.countries)
  }
}
</script>
