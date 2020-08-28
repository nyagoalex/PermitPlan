<template>
<b-modal id="new-road-transfer" :title="`${mode} Road Transfer`">
    <form>

        <div class="form-group">
            <label for="rt-name">Transfer Name</label>
            <input type="text" class="form-control" placeholder=" EBB - KIHIHI" v-model="transfer.name" :class="{ 'is-invalid': errors.name}">
            <ul class="list-unstyled invalid-feedback" v-if="errors.name">
                <li v-for="(error) in errors.name" :key="error">{{ error }}</li>
            </ul>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label>starting Point</label>
                <input type="text" class="form-control" v-model="transfer.starting_point" :class="{ 'is-invalid': errors.starting_point}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.starting_point">
                    <li v-for="(error) in errors.starting_point" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div class="form-group col-md-6">
                <label>Destination</label>
                <input type="text" class="form-control" v-model="transfer.destination" :class="{ 'is-invalid': errors.destination}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.destination">
                    <li v-for="(error) in errors.destination" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>
        <div class="form-group">
            <label>Vehicle</label>
            <model-select :options="this.vehicles" placeholder="select Vehicle" v-model="transfer.vehicle_id" :class="{ 'is-invalid': errors.vehicle_id}">
            </model-select>
            <ul class="list-unstyled invalid-feedback" v-if="errors.vehicle_id">
                <li v-for="(error) in errors.vehicle_id" :key="error">{{ error }}</li>
            </ul>
        </div>

        <div class="form-row">
            <div class="form-group col-md-4">
                <label>Cost P/P (USD)</label>
                <input type="number" placeholder="300" class="form-control" v-model="transfer.cost_per_person" :class="{ 'is-invalid': errors.cost_per_person}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.cost_per_person">
                    <li v-for="(error) in errors.cost_per_person" :key="error">{{ error }}</li>
                </ul>
            </div>
            <div class="form-group col-md-4">
                <label>Est. Time (Hrs)</label>
                <input type="time" class="form-control" placeholder="3" v-model="transfer.est_time" :class="{ 'is-invalid': errors.est_time}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.est_time">
                    <li v-for="(error) in errors.est_time" :key="error">{{ error }}</li>
                </ul>
            </div>

            <div class="form-group col-md-4">
                <label>Distance (KM)</label>
                <input type="number" class="form-control" placeholder="200" v-model="transfer.distance" :class="{ 'is-invalid': errors.distance}">
                <ul class="list-unstyled invalid-feedback" v-if="errors.distance">
                    <li v-for="(error) in errors.distance" :key="error">{{ error }}</li>
                </ul>
            </div>
        </div>
    </form>
    <template v-slot:modal-footer="{ cancel }">
        <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()">Cancel</b-button>
        <b-overlay :show="loading" rounded opacity="0.6" spinner-small class="d-inline-block">
            <b-button size="sm" variant="success" :disabled="loading" @click="(`${mode}` == 'create') ? addTransfer() : updateTransfer()">{{(`${mode}` == 'create') ? 'Add' : 'Update' }} Road Transfer</b-button>
        </b-overlay>
    </template>
</b-modal>
</template>

<script>
import {
    ModelSelect
} from 'vue-search-select'
export default {
    data() {
        return {
            loading: false,
            errors: {},
            vehicles: []
        }
    },
    components: {
        ModelSelect
    },
    props: {
        mode: String,
        transfer: Object
    },
    methods: {
        addTransfer() {
            this.loading = true
            this.errors = {}
            this.$http.post('/road-transfers', this.transfer)
                .then(response => {
                    this.alertAddSuccess()
                    this.$parent.getTransfers()
                    this.$bvModal.hide('new-road-transfer')
                })
                .catch(errors => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        },
        updateTransfer() {
            this.loading = true
            this.errors = {}

            this.$http.patch('/road-transfers/' + this.transfer.id, this.transfer)
                .then(response => {
                    this.toastSuccess('Successfully Updated')
                    this.$parent.getTransfers()
                    this.$bvModal.hide('new-road-transfer')
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
    mounted() {
        this.$http.get('/vehicles').then(vehicles => {
            this.vehicles = vehicles.data.data.map(function (num) {
                return {
                    value: num.id,
                    text: num.type + ' (' + num.code + ')'
                }
            })
        })
    }
}
</script>
