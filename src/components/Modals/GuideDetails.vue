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

                <div class="col-md-4 col-12 p-4" style="border:1px solid #E1DDD4;">

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
                <div class="col-md-4 col-12 " style="border:1px solid #E1DDD4;">
                    <div class="col-md-12 col-12 pt-1">
                        <strong class="pt-3">Parks Guide Experience</strong>
                        <hr>
                        <form>
                            <b-button variant="outline-success" @click="OpenAddPark"> + Add a new Park</b-button>
                        </form>
                        <div class="pt-5" v-if="guide.parks_experience.length == 0">
                        <strong > Tour Guide Has no Experience in parks click to Add</strong>
                        </div>
                        <div class="pt-4">
                            <div class="season mb-3" v-for="(park, index) in guide.parks_experience" :key="park.name">
                                <div class="row">
                                    <div class="col-md-8 pr-0">
                                        <div class="d-inline-block icon icon-xs bg-soft-success rounded-circle mr-1">
                                        <b-icon icon="emoji-sunglasses" class="d-inline-block text-success"></b-icon> </div>
                                       {{park.name}}
                                    </div>
                                    <div class="col-md-3 pl-0 text-right">
                                        <b-button pill size="sm" variant="outline-success"><small> {{calculateAge(park.since)}} Yrs</small></b-button>
                                    </div>
                                    <div class="col-md-1 pl-0 text-right">
                                      <span style="cursor: pointer;" v-b-tooltip.hover title="Edit Park Experience" @click="OpenEditPark(index, park)"><b-icon icon="pen"></b-icon></span> <br>
                                      <span style="cursor: pointer;" class="text-danger " v-b-tooltip.hover title="Remove Park Experience" @click="removePark(index)"><b-icon icon="trash"></b-icon></span> </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12 " style="border:1px solid #E1DDD4;">

                    <div class="col-md-12 col-12 pt-1">
                        <strong class="pt-3">Guide's Vehicles Experience</strong>
                        <hr>
                        <form>
                            <!-- <div class="form-group">
                                <label>Vehicle Type</label>
                                <input type="text" class="form-control">
                            </div> -->

                            <b-button variant="outline-success" @click="OpenAddVehicle"> + Add a new vehicle Type</b-button>
                          <div class="pt-5" v-if="guide.vehicle_types_experience.length == 0">
                          <strong > Tour Guide Has no Experience in Vehicles click to Add</strong>
                        </div>
                        </form>
                           <div class="pt-4">
                            <div class="season mb-3" v-for="(park, index) in guide.vehicle_types_experience" :key="park.name">
                                <div class="row">
                                    <div class="col-md-8 pr-0">
                                        <div class="d-inline-block icon icon-xs bg-soft-success rounded-circle mr-1">
                                        <b-icon icon="emoji-sunglasses" class="d-inline-block text-success"></b-icon> </div>
                                       {{park.name}}
                                    </div>
                                    <div class="col-md-3 pl-0 text-right">
                                        <b-button pill size="sm" variant="outline-success"><small> {{calculateAge(park.since)}} Yrs</small></b-button>
                                    </div>
                                    <div class="col-md-1 pl-0 text-right">
                                      <span style="cursor: pointer;" v-b-tooltip.hover title="Edit Park Experience" @click="OpenEditVehicle(index, park)"><b-icon icon="pen"></b-icon></span> <br>
                                      <span style="cursor: pointer;" class="text-danger " v-b-tooltip.hover title="Remove Park Experience" @click="removeVehicle(index)"><b-icon icon="trash"></b-icon></span> </div>
                                </div>
                            </div>

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

        <b-modal id="experience-modal" :title="exp_modal_title">
          <form @submit.stop.prevent>
            <div class="form-group">
                <label >Name</label>
                <input type="text" class="form-control" placeholder="Name" v-model="experience_form.name" :class="{ 'is-invalid': !experience_form.name }">
                <span class="invalid-feedback" v-if="!experience_form.name"> name is required</span>

            </div>
            <div class="form-group">
                <label>Since</label>
                <input type="date" class="form-control"  v-model="experience_form.since" :class="{ 'is-invalid': !experience_form.since }">
                <span class="invalid-feedback" v-if="!experience_form.since"> since field is required</span>
            </div>
          </form>
          <template v-slot:modal-footer="{ cancel}">
            <b-button size="sm" variant="danger"  @click="cancel()">Cancel</b-button>
            <b-button size="sm" type="submit" variant="success" :disabled="!experience_form.since || !experience_form.name"  @click="exp_btn_fn">{{exp_btn_text}}</b-button>
          </template>
        </b-modal>

    </b-modal>
</template>

<script lang="ts">
export default {
  data () {
    return {
      loading: false,
      errors: {},
      exp_btn_text: '',
      exp_modal_title: '',
      exp_btn_fn: '',
      experience_form: this.resetModal(),
      edit_index: null
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
    },
    OpenAddPark () {
      this.exp_btn_text = 'Add National Park'
      this.exp_modal_title = 'Add National Park'
      this.exp_btn_fn = this.addPark
      this.experience_form = this.resetModal()
      this.$bvModal.show('experience-modal')
    },
    addPark () {
      this.guide.parks_experience.push(this.experience_form)
      this.$bvModal.hide('experience-modal')
    },
    OpenEditPark (index, experience) {
      this.edit_index = index
      this.exp_btn_text = 'Edit National Park'
      this.exp_modal_title = 'Updated National Park'
      this.exp_btn_fn = this.updatePark
      this.experience_form = experience
      this.$bvModal.show('experience-modal')
    },
    updatePark () {
      this.$set(this.guide.parks_experience, this.edit_index, this.experience_form)
      this.$bvModal.hide('experience-modal')
    },
    removePark (index) {
      this.guide.parks_experience.splice(index, 1)
    },
    OpenAddVehicle () {
      this.exp_btn_text = 'Add Vehicle'
      this.exp_modal_title = 'Add Vehicle'
      this.exp_btn_fn = this.addVehicle
      this.experience_form = this.resetModal()
      this.$bvModal.show('experience-modal')
    },
    addVehicle () {
      this.guide.vehicle_types_experience.push(this.experience_form)
      this.$bvModal.hide('experience-modal')
    },
    OpenEditVehicle (index, experience) {
      this.edit_index = index
      this.exp_btn_text = 'Edit Vehicle'
      this.exp_modal_title = 'Updated Vehicle'
      this.exp_btn_fn = this.updateVehicle
      this.experience_form = experience
      this.$bvModal.show('experience-modal')
    },
    updateVehicle () {
      this.$set(this.guide.vehicle_types_experience, this.edit_index, this.experience_form)
      this.$bvModal.hide('experience-modal')
    },
    removeVehicle (index) {
      this.guide.vehicle_types_experience.splice(index, 1)
    },
    calculateAge (dob) {
      dob = new Date(dob)
      var diff = Date.now() - dob.getTime()
      var age = new Date(diff)
      var age1 = age.getUTCFullYear() - 1970
      return age1 > 0 ? age1 : 0
    },
    resetModal () {
      return {
        name: '',
        since: ''
      }
    }
  }
}
</script>
