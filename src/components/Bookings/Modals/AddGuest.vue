<template>
    <b-modal id="new-guest" :title="`${mode} Guest`">
        <form>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label for="g-first-name">First Name</label>
                        <input class="form-control" type="text" placeholder="e.g Vicky" v-model="guest.first_name" :class="{ 'is-invalid': errors.first_name}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.first_name">
                            <li v-for="(error) in errors.first_name" :key="error">{{ error }}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label>Passport No</label>
                        <input type="text" class="form-control place" placeholder="input passport no" v-model="guest.passport" :class="{ 'is-invalid': errors.passport}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.passport">
                            <li v-for="(error) in errors.passport" :key="error">{{ error }}</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label>Nationality</label>
                        <!-- object value -->
                        <model-select :options="countries" placeholder="select country" v-model="countriesItem" :class="{ 'is-invalid': errors.nationality}">
                        </model-select>
                        <ul class="list-unstyled invalid-feedback" v-if="errors.nationality">
                            <li v-for="(error) in errors.nationality" :key="error">{{ error }}</li>
                        </ul>
                    </div>

                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Other Names</label>
                        <input class="form-control" type="text" placeholder="e.g Alex" v-model="guest.last_name" :class="{ 'is-invalid': errors.last_name}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.last_name">
                            <li v-for="(error) in errors.last_name" :key="error">{{ error }}</li>
                        </ul>
                    </div>

                    <div class="form-group">
                        <label>Date Of Birth</label>
                        <input type="date" class="form-control place" v-model="guest.dob" :class="{ 'is-invalid': errors.dob}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.dob">
                            <li v-for="(error) in errors.dob" :key="error">{{ error }}</li>
                        </ul>
                    </div>

                </div>
            </div>
        </form>
        <template v-slot:modal-footer="{ cancel}">
            <b-button size="lg" variant="danger" :disabled="loading" @click="cancel()">Cancel</b-button>
            <b-button size="lg" variant="success" :disabled="loading" @click="(`${mode}` == 'create') ? addGuest() : updateGuest()">{{(`${mode}` == 'create') ? 'Add' : 'Update' }} Guest</b-button>
        </template>
        <b-overlay :show="loading" opacity="0.6" no-wrap></b-overlay>
    </b-modal>
</template>

<script>
import {
    ModelSelect
} from 'vue-search-select'
import {
    countries
} from '@/Constants/countries.js'

export default {
    data() {
        return {
            countries: countries,
            countriesItem: {
                value: '',
                text: ''
            },
            loading: false,
            errors: {}
        }
    },
    props: {
        mode: String,
        guest: Object
    },
    methods: {
        addGuest() {
            this.loading = true
            this.errors = {}

            this.$http.post('/bookings/' + this.$route.params.id + '/guests', this.guest)
                .then(response => {
                    this.alertAddSuccess()
                    this.$parent.getGuests()
                    this.$bvModal.hide('new-guest')
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        updateGuest() {
            this.loading = true
            this.errors = {}

            this.$http.patch('/bookings/' + this.$route.params.id + '/guests/' + this.guest.id, this.guest)
                .then(response => {
                    this.toastSuccess('Successfully Updated')
                    this.$parent.getGuests()
                    this.$bvModal.hide('new-guest')
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    components: {
        ModelSelect
    },
    watch: {
        countriesItem: function (val) {
            this.guest.nationality = val.text
        }
    }
}
</script>
