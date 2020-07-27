<template>
  <div class="tab-content">
    <div class="tab-pane fade active show" id="lodge-details" role="tabpanel">
      <div class="row justify-content-between pt-4">
          <div class="col-lg-8" id="hotel-details">
              <div class="card mb-0">
                  <div class="card-body p-lg-5" style="color:black !important; font-size: 14px;">
                      <form>
                          <div class="row">
                              <div class="col-md-6">
                                  <div class="form-group">

                                      <label for="l-name">Hotel/Lodge Name</label>
                                      <input class="form-control" type="text" style="text-transform:capitalize ;" id="l-name" value="lodge name" required>
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="l-email">Email</label>
                                      <input class="form-control" type="text" id="l-email" value="email">
                                  </div>
                              </div>
                          </div>
                          <div class="row align-items-center">
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="l-phone">Phone Number</label>
                                      <input class="form-control" type="text" id="l-phone" value="phone">
                                  </div>
                              </div>
                              <div class="col-md-6">
                                  <div class="form-group">
                                      <label for="l-country">Country</label>
                                      <model-select :options="countries" placeholder="select country" id="ountry"  v-model="countries_item">
                                      </model-select>
                                  </div>
                              </div>
                          </div>

                          <div class="row align-items-center">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label for="l-location">Location</label>
                                      <model-select :options="countries_item.regions" placeholder="select country" id="agent-city"  v-model="regions_item" :isDisabled="!(countries_item.regions.length > 0)" :isError="!(countries_item.regions.length > 0)">
                                      </model-select>
                                  </div>
                              </div>
                          </div>
                          <div class="row">
                              <div class="col-md-12">
                                  <div class="form-group">
                                      <label for="l-address">Address</label>
                                      <textarea class="form-control" placeholder="Where do you see yourself in years?" rows="6" id="l-address">address</textarea></div>
                              </div>
                          </div>
                          <div class="mt-4"><button type="button" class="btn btn-primary" onclick="updateLodge(this)">Update Hotel Details</button></div>
                      </form>
                  </div>
              </div>
          </div>

          <div class="col-lg-4">
              <div class="alert alert-primary" role="alert">

                  <h5>Hotel Details Summary</h5>
                  Please check these details summary and make edits where necessary.

                  <div class="pt-4">

                      <div class="card card-fluid border-0" style="background-color:transparent !important;">
                          <div class="card-body">
                              <div class="row align-items-center">
                                  <div class="col">
                                      <h6 class="text-sm mb-0"><i class="zmdi zmdi-hotel mr-2"></i>Lodge Name</h6>
                                  </div>
                                  <div class="col-auto"><span class="text-sm l-name-label">
                                          lodge name</span></div>
                              </div>
                              <hr class="my-3">
                              <div class="row align-items-center">
                                  <div class="col">
                                      <h6 class="text-sm mb-0"><i class="zmdi zmdi-email mr-2"></i>Email</h6>
                                  </div>
                                  <div class="col-auto"><a href="#" class="text-sm l-email-label">
                                          email</a></div>
                              </div>
                              <hr class="my-3">
                              <div class="row align-items-center">
                                  <div class="col">
                                      <h6 class="text-sm mb-0"><i class="zmdi zmdi-smartphone-android mr-2"></i>Phone</h6>
                                  </div>
                                  <div class="col-auto"><span class="text-sm l-phone-label">
                                          email</span></div>
                              </div>
                              <hr class="my-3">
                              <div class="row align-items-center">
                                  <div class="col">
                                      <h6 class="text-sm mb-0"><i class="zmdi zmdi-navigation mr-2"></i>Location</h6>
                                  </div>
                                  <div class="col-auto"><span class="text-sm l-location-label">
                                          location</span></div>
                              </div>
                          </div>
                      </div>

                  </div>

                  <br>
                  <br>
              </div>
          </div>
      </div>
    </div>
  </div>
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
  components: {
    ModelSelect
  }
}
</script>
