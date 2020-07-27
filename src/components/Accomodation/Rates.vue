<template>
  <div class="tab-pane" id="rates" >
    <div class="pt-4">
      <div class="row">
          <div class="col-md-6 col-12">

              <span>
                  <h6>The Contracted Rate (Percentage)</h6>
                  <input class="form-control" style="height: calc(1.5em + 1.5rem + 2px);" type="text" id="l-contracted_rating" value="contracted_rating" required>
              </span>

              <div class="pt-3">
                  <b-button variant="outline-success" onclick="changeContractedRating()"> + Update contract Rate</b-button>
              </div>
          </div>

          <div class="col-md-6 col-12 border-left pt-1">
              <div id="season-tb">
              <div class='season mb-3'><p class='text-muted p-2'>No Seasons Registered Yet.</p></div>
              </div>
              <b-button variant="outline-success"  v-b-modal.new-season> + Add a new Season</b-button>
          </div>

      </div>
      <div class="container-fluid" id="seasonal-cost">
      </div>
  </div>
  <AddSeason/>
  </div>
</template>
<script>
import AddSeason from '@/components/Modals/AddSeason.vue'

export default {
  components: {
    AddSeason
  }
}
</script>
