<template>
    <b-modal id="guide-details" size="xl">
        <template v-slot:modal-header="{ close }">
            <b-col>
                <h5 class="modal-title" >Details for: <span class="guide-label"></span>
                </h5>
            </b-col>

            <b-col class="status_dropdown">
                <b-dropdown text="Working" variant="outline-success">
                    <b-dropdown-item variant="danger"> Terminated</b-dropdown-item>
                    <b-dropdown-item variant="warning"> On Probation</b-dropdown-item>
                </b-dropdown>
            </b-col>
            <b-col>
                <b-icon icon="x-circle" size="sm" variant="danger" class="float-right" @click="close()">Cancel</b-icon>
            </b-col>
        </template>
        <div class="p-4">
            <b-overlay :show="loading" rounded opacity="0.7" >
            <div class="row">

                <div class="col-md-6 col-12 p-4" style="border:1px solid #E1DDD4;">

                    <form id="guide-details-form">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>First name</label>
                                <input type="text" class="form-control" v-model="guide.first_name" :class="{ 'is-invalid': errors.first_name}">
                                <ul class="list-unstyled invalid-feedback" v-if="errors.first_name">
                                    <li v-for="(error) in errors.first_name" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Other Names</label>
                                <input type="text" class="form-control" v-model="guide.last_name" :class="{ 'is-invalid': errors.last_name}">
                                <ul class="list-unstyled invalid-feedback" v-if="errors.last_name">
                                    <li v-for="(error) in errors.last_name" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Date of Birth</label>
                                <input type="date" class="form-control" v-model="guide.dob" :class="{ 'is-invalid': errors.dob}">
                                <ul class="list-unstyled invalid-feedback" v-if="errors.dob">
                                    <li v-for="(error) in errors.dob" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Experience Since</label>
                                <input type="date" class="form-control" v-model="guide.experience_since" :class="{ 'is-invalid': errors.experience_since}">
                                <ul class="list-unstyled invalid-feedback" v-if="errors.experience_since">
                                    <li v-for="(error) in errors.experience_since" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Email</label>
                                <input type="email" class="form-control" v-model="guide.email" :class="{ 'is-invalid': errors.email}">
                                <ul class="list-unstyled invalid-feedback" v-if="errors.email">
                                    <li v-for="(error) in errors.email" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_phone">Phone Number</label>
                                <input type="number" class="form-control" v-model="guide.phone" :class="{ 'is-invalid': errors.phone}">
                                <ul class="list-unstyled invalid-feedback" v-if="errors.phone">
                                    <li v-for="(error) in errors.phone" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label>Contract Basis</label>
                                <select type="text" class="form-control"  v-model="guide.contract_basis" :class="{ 'is-invalid': errors.contract_basis}">
                                    <option value="">Select employment terms</option>
                                    <option value="full_time">Full-Time</option>
                                    <option value="freelancer">Freelancer</option>

                                </select>
                                <ul class="list-unstyled invalid-feedback" v-if="errors.contract_basis">
                                    <li v-for="(error) in errors.contract_basis" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Cost Per Day (USD)</label>
                                <input type="text" placeholder="300" class="form-control" v-model="guide.cost_per_day" :class="{ 'is-invalid': errors.cost_per_day}">
                                <ul class="list-unstyled invalid-feedback" v-if="errors.cost_per_day">
                                    <li v-for="(error) in errors.cost_per_day" :key="error">{{ error }}</li>
                                </ul>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3 col-12 " style="border:1px solid #E1DDD4;">
                    <div class="col-md-12 col-12 pt-1">
                        <strong class="pt-3">Parks Guide Experience</strong>
                        <hr>
                        <form>

                            <!-- <div class="form-group" id="new-park-form">
                                <label>National Park Name</label>
                                <input type="text" class="form-control" id="new-park" required>
                            </div> -->
                            <b-button variant="outline-success" onclick="addPark()"> + Add a new Park</b-button>
                        </form>
                        <div class="pt-4" id="nat-park-tb">
                            <!-- <div class="season mb-3">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="d-inline-block icon icon-xs bg-soft-success rounded-circle mr-2"> <i class="zmdi zmdi-local-activity icon-text icon-text-xs d-inline-block text-success"></i> </div>Kibale National Parks
                                    </div>
                                    <div class="col-md-2">
                                        <span style="color:#C26004"><b><button type="button" class="btn btn-outline-success sm-b">5 Yrs</button></b></span>
                                    </div>
                                    <div class="col-md-2"> <a href="#" title="" onclick=""><i class="zmdi zmdi-eyedropper"></i></a> <br><a href="#" class="text-danger " title="" onclick=""><i class="zmdi zmdi-delete"></i></a> </div>
                                </div>
                            </div>
                            <div class="season mb-3">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="d-inline-block icon icon-xs bg-soft-success rounded-circle mr-2"> <i class="zmdi zmdi-local-activity icon-text icon-text-xs d-inline-block text-success"></i> </div>Kibale National Parks <span class="pl-4" style="color:#C26004"><b><button type="button" class="btn btn-outline-success sm-b">5 Yrs</button></b></span>
                                    </div>
                                    <div class="col-md-2"> <a href="#" title="" onclick=""><i class="zmdi zmdi-eyedropper"></i></a> <a href="#" class="text-danger ml-2" title="" onclick=""><i class="zmdi zmdi-delete"></i></a> </div>
                                </div>
                            </div> -->

                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-12 " style="border:1px solid #E1DDD4;">

                    <div class="col-md-12 col-12 pt-1">
                        <strong class="pt-3">Guide's Vehicles Experience</strong>
                        <hr>
                        <form>
                            <!-- <div class="form-group">
                                <label>Vehicle Type</label>
                                <input type="text" class="form-control">
                            </div> -->

                            <b-button variant="outline-success" onclick="addVehicle()"> + Add a new vehicle Type</b-button>

                        </form>
                        <div class="pt-4" id="vehicle-tb">
                            <!-- <div class="season mb-3">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="d-inline-block icon icon-xs bg-soft-success rounded-circle mr-2"> <i class="zmdi zmdi-local-activity icon-text icon-text-xs d-inline-block text-success"></i> </div>Landcruiser - Manual <span class="pl-4" style="color:#C26004"><b><button type="button" class="btn btn-outline-success sm-b">11 Yrs</button></b></span>
                                    </div>
                                    <div class="col-md-2"> <a href="#" title="" onclick=""><i class="zmdi zmdi-eyedropper"></i></a> <a href="#" class="text-danger ml-2" title="" onclick=""><i class="zmdi zmdi-delete"></i></a> </div>
                                </div>
                            </div>
                            <div class="season mb-3">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="d-inline-block icon icon-xs bg-soft-success rounded-circle mr-2"> <i class="zmdi zmdi-local-activity icon-text icon-text-xs d-inline-block text-success"></i> </div>Mini-Van Automatic <span class="pl-4" style="color:#C26004"><b><button type="button" class="btn btn-outline-success sm-b">10 Yrs</button></b></span>
                                    </div>
                                    <div class="col-md-2"> <a href="#" title="" onclick=""><i class="zmdi zmdi-eyedropper"></i></a> <a href="#" class="text-danger ml-2" title="" onclick=""><i class="zmdi zmdi-delete"></i></a> </div>
                                </div>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>

            </b-overlay>
        </div>
        <template v-slot:modal-footer="{ cancel}">
            <b-button size="sm" variant="danger"  :disabled="loading" @click="cancel()">Cancel</b-button>
                <b-button size="sm" variant="success" :disabled="loading" @click="updateGuide()">Update Guide Details</b-button>
        </template>
        {{guide}}
    </b-modal>
</template>

<script lang="ts">
export default {
  data () {
    return {
      loading: false,
      errors: {}
    }
  },
  props: {
    guide: Object
  },
  methods: {
    updateGuide () {
      this.loading = true
      this.errors = {}
      this.$http.patch('/guides/' + this.guide.id, this.guide)
        .then(response => {
          this.toastSuccess('Successfully Updated')
          this.$parent.getGuides()
          this.$bvModal.hide('guide-details')
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
