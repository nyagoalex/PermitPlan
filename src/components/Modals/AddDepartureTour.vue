<template>
    <b-modal id="new-departure-tour" :title="`${mode} Departure Tour`">
        <form>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Tour Name</label>
                        <input type="text" class="form-control place" v-model="tour.name" placeholder="Enter Tour name" :class="{ 'is-invalid': errors.name}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.name">
                            <li v-for="(error) in errors.name" :key="error">{{ error }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-6">
                    <label>Arrival Date</label>
                    <input type="date" class="form-control place" placeholder="input date" v-model="tour.arrival_date" :class="{ 'is-invalid': errors.arrival_date}">
                    <ul class="list-unstyled invalid-feedback" v-if="errors.arrival_date">
                        <li v-for="(error) in errors.arrival_date" :key="error">{{ error }}</li>
                    </ul>
                </div>
                <div class="form-group col-6">
                    <label>Departure Date</label>
                    <input type="date" class="form-control place" placeholder="input date" v-model="tour.departure_date" :class="{ 'is-invalid': errors.departure_date}">
                    <ul class="list-unstyled invalid-feedback" v-if="errors.departure_date">
                        <li v-for="(error) in errors.departure_date" :key="error">{{ error }}</li>
                    </ul>
                </div>
            </div>
        </form>
        <template v-slot:modal-footer="{ cancel}">
            <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()">Cancel</b-button>
            <b-overlay :show="loading" rounded opacity="0.6" spinner-small class="d-inline-block">
                <b-button size="sm" variant="success" :disabled="loading" @click="(`${mode}` == 'create') ? addTour() : updateTour()">{{(`${mode}` == 'create') ? 'Add' : 'Update' }} Departure Tour</b-button>
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
        tour: Object
    },
    methods: {
        addTour() {
            this.loading = true
            this.errors = {}

            this.$http.post('/departure-tours', this.tour)
                .then(response => {
                    this.alertAddSuccess()
                    this.$parent.getTours()
                    this.$bvModal.hide('new-departure-tour')
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        updateTour() {
            this.loading = true
            this.errors = {}

            this.$http.patch('/departure-tours/' + this.tour.id, this.tour)
                .then(response => {
                    this.toastSuccess('Successfully Updated')
                    this.$parent.getTours()
                    this.$bvModal.hide('new-departure-tour')
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
