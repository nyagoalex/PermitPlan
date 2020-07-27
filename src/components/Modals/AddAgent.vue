<template>
    <b-modal id="new-agent" title="Add Agent">
        <form>
          <div class="row">
              <div class="col-6">
                  <div class="form-group">
                      <label>Agent Name</label>
                      <input type="text" class="form-control place" id="agent-name" placeholder="Enter Agent name" required>
                  </div>

                  <div class="form-group">
                      <label>Country</label>
                      <model-select :options="countries" placeholder="select country" id="agent-country"  v-model="countries_item">
                      </model-select>
                  </div>

                  <div class="form-group">
                    <label>Contact</label>
                    <input type="number" class="form-control place" id="agent-phone" placeholder="+256 ....">
                  </div>

              </div>
              <div class="col-6">
                  <div class="form-group">
                      <label>Email</label>
                      <input type="email" class="form-control place" id="agent-email" placeholder="myemail@example.com" required>
                  </div>
                  <div class="form-group">
                      <label>Location/City</label>
                      <model-select :options="countries_item.regions" placeholder="select country" id="agent-city"  v-model="regions_item" :isDisabled="!(countries_item.regions.length > 0)" :isError="!(countries_item.regions.length > 0)">
                      </model-select>
                  </div>

              </div>

          </div>
      </form>
        <template v-slot:modal-footer="{ cancel, ok }">
            <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
            <b-button size="sm" variant="success" @click="ok()">Add Guest</b-button>
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
