<template>
    <b-modal id="new-guest" title="Add Guest">
        <form>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="g-first-name">First Name</label>
                        <input class="form-control" type="text" id="g-first-name" placeholder="e.g Vicky" required>
                    </div>
                    <div class="form-group">
                        <label>Passport No</label>
                        <input type="text" class="form-control place" id="g-passport" placeholder="input passport no" required>
                    </div>
                    <div class="form-group">
                      <label for="g-nationality">Nationality</label>
                         <!-- object value -->
                      <model-select :options="countries" placeholder="select country" id="nationality"  v-model="item">
                      </model-select>
                    </div>

                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label for="last-name">Other Names</label>
                        <input class="form-control" type="text" id="g-last-name" placeholder="e.g Alex" required>
                    </div>

                    <div class="form-group">
                        <label>Date Of Birth</label>
                        <input type="date" class="form-control place" id="g-dob"  required>
                    </div>

                </div>
                <b-button @click="show"> </b-button>
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
      item: { value: '', text: '' }
    }
  },
  methods: {
    show () {
      alert(JSON.stringify(this.item))
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
