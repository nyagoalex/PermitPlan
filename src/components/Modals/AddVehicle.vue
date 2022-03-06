<template>
<b-modal id="new-vehicle" :title="`${mode} Vehicle`">
    <form>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Vehicle Code</label>
                <input type="text" class="form-control" v-model="vehicle.code" :class="{ 'is-invalid': errors.code}" disabled>
                <ul class="list-unstyled invalid-feedback" v-if="errors.code">
                    <li v-for="(error) in errors.code" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label>vehicle identification</label>
                <input type="text" class="form-control" v-model="vehicle.reg_no" :class="{ 'is-invalid': errors.reg_no}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.reg_no">
                    <li v-for="(error) in errors.reg_no" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Vehicle Color</label>
                <input type="text" class="form-control" v-model="vehicle.color" :class="{ 'is-invalid': errors.color}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.color">
                    <li v-for="(error) in errors.color" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label>No. of Seats</label>
                <input type="number" class="form-control" v-model="vehicle.no_of_seats" :class="{ 'is-invalid': errors.no_of_seats}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.no_of_seats">
                    <li v-for="(error) in errors.no_of_seats" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>

        <div class="form-row">

            <div class="form-group col-md-6">
                <label>Vehicle Type</label>
                <select type="text" class="form-control" v-model="vehicle.type" :class="{ 'is-invalid': errors.type}">
                    <option value="">Select Vehicle type</option>
                    <option value="Toyota Landcruiser-7x">Toyota Landcruiser-7x</option>
                    <option value="Toyota Landcruiser-5x">Toyota Landcruiser-5x</option>
                    <option value="Toyota Landcruiser-3x">Toyota Landcruiser-3x</option>
                    <option value="Toyota Landcruiser-2x">Toyota Landcruiser-2x</option>
                    <option value="Toyota Mini-Van">Toyota Mini-Van</option>
                    <option value="Toyota Super Custom">Toyota Super Custom</option>
                    <option value="Nissan Patrol">Nissan Patrol</option>
                    <option value="Landrover Defender">Landrover Defender</option>
                    <option value="Landrover Discovery">Landrover Discovery</option>
                    <option value="Coaster Bus">Coaster Bus</option>
                    <option value="Bus">Bus</option>
                </select>
                <ul class="list-unstyled invalid-feedback" v-if="errors.type">
                    <li v-for="(error) in errors.type" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">

                <label>Vehicle Status</label>
                <select type="text" class="form-control" v-model="vehicle.status" :class="{ 'is-invalid': errors.status}">
                    <option value="">Select Vehicle status</option>
                    <option value="ready">Ready for Safari</option>
                    <option value="disposed_off">Disposed Off</option>
                    <option value="too_old">Too Old</option>
                    <option value="has_issues">Has Issues</option>

                </select>
                <ul class="list-unstyled invalid-feedback" v-if="errors.status">
                    <li v-for="(error) in errors.status" :key="error">{{ error }}</li>
                </ul>

            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label>Cost Per Day (USD)</label>
                <input type="number" placeholder="300" class="form-control" v-model="vehicle.cost_per_day" :class="{ 'is-invalid': errors.cost_per_day}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.cost_per_day">
                    <li v-for="(error) in errors.cost_per_day" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label>Ownership</label>
                <select type="text" class="form-control" v-model="vehicle.ownership" :class="{ 'is-invalid': errors.ownership}">
                    <option value="">Select Ownership</option>
                    <option value="company">Company Vehicle</option>
                    <option value="hired">Hired Vehicle</option>

                </select>
                <ul class="list-unstyled invalid-feedback" v-if="errors.ownership">
                    <li v-for="(error) in errors.ownership" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>
    </form>
    <template v-slot:modal-footer="{ cancel }">
        <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()">Cancel</b-button>
        <b-overlay :show="loading" rounded opacity="0.6" spinner-small class="d-inline-block">
            <b-button size="sm" variant="success" :disabled="loading" @click="(`${mode}` == 'create') ? addVehicle() : updateVehicle()">{{(`${mode}` == 'create') ? 'Add' : 'Update' }} Vehicle</b-button>
        </b-overlay>
    </template>
</b-modal>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            errors: {}
        }
    },
    props: {
        mode: String,
        vehicle: Object
    },
    methods: {
        addVehicle() {
            this.loading = true
            this.errors = {}

            this.$http.post('/vehicles', this.vehicle)
                .then(response => {
                    this.alertAddSuccess()
                    this.$parent.getVehicles()
                    this.$bvModal.hide('new-vehicle')
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        updateVehicle() {
            this.loading = true
            this.errors = {}

            this.$http.patch('/vehicles/' + this.vehicle.id, this.vehicle)
                .then(response => {
                    this.toastSuccess('Successfully Updated')
                    this.$parent.getVehicles()
                    this.$bvModal.hide('new-vehicle')
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        }
    }
}
</script>
