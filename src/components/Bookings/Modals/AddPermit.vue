<!-- @format -->

<template>
    <b-modal id="new-permit" title="Add Permit">
        <form>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Permit Type</label>
                        <model-select
                            :options="this.permit_types"
                            placeholder="select Permit Type"
                            class="form-control"
                            v-model="permit_type"
                            :class="{ 'is-invalid': errors.permit_type_id }"
                        >
                        </model-select>
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.permit_type_id"
                        >
                            <li v-for="error in errors.permit_type_id" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label>No. of Permits</label>
                        <input
                            type="number"
                            class="form-control place"
                            id="p-no_of_permits"
                            placeholder="1"
                            v-model="permit.no_of_permits"
                            :class="{ 'is-invalid': errors.no_of_permits }"
                        />
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.no_of_permits"
                        >
                            <li v-for="error in errors.no_of_permits" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label>Prefferred Sector</label>
                        <model-select
                            :options="sectors"
                            placeholder="select Permit Type"
                            class="form-control"
                            v-model="permit.sector_id"
                            :class="{ 'is-invalid': errors.sector_id }"
                        >
                        </model-select>
                        <small v-if="!sectors.length" style="color: red"
                            ><i class="fa fa-exclamation-triangle"></i> Add sectors in
                            setting to continue</small
                        >
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.sector_id"
                        >
                            <li v-for="error in errors.sector_id" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                    <div class="form-group">
                        <label>Tracking Date</label>
                        <input
                            type="date"
                            class="form-control place"
                            v-model="permit.tracking_date"
                            :class="{ 'is-invalid': errors.tracking_date }"
                        />
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.tracking_date"
                        >
                            <li v-for="error in errors.tracking_date" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row m-2">
                <div class="col-12" id="p-unit_cost">
                    <center>Select Price Per Permits</center>
                    <hr />
                    <b-form-radio-group
                        v-model="permit.cost"
                        v-if="permit_costs[permit_type]"
                        :class="{ 'is-invalid': errors.cost }"
                    >
                        <b-form-radio
                            class="mb-2"
                            :value="permit_costs[permit_type].east_african_cost"
                            >Foreign Residents ($<span class="text-info">{{
                                permit_costs[permit_type].east_african_cost
                            }}</span
                            >)
                        </b-form-radio>
                        <br />
                        <b-form-radio
                            class="mb-2"
                            :value="permit_costs[permit_type].non_resident_cost"
                            >Non-Residents ($<span class="text-info">{{
                                permit_costs[permit_type].non_resident_cost
                            }}</span
                            >)
                        </b-form-radio>
                        <br />
                        <b-form-radio
                            class="mb-2"
                            :value="permit_costs[permit_type].ugandan_cost"
                            >Ugandans ($<span class="text-info">{{
                                permit_costs[permit_type].ugandan_cost
                            }}</span
                            >)
                        </b-form-radio>
                        <br />
                        <b-form-radio :value="permit_costs[permit_type].east_african_cost"
                            >East Africans ($<span class="text-info">{{
                                permit_costs[permit_type].east_african_cost
                            }}</span
                            >)
                        </b-form-radio>
                    </b-form-radio-group>
                    <ul class="list-unstyled invalid-feedback" v-if="errors.cost">
                        <li v-for="error in errors.cost" :key="error">{{ error }}</li>
                    </ul>
                </div>
            </div>
        </form>
        <template v-slot:modal-footer="{ cancel }">
            <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()"
                >Cancel</b-button
            >
            <b-button size="sm" variant="success" :disabled="loading" @click="addPermit"
                >Add Permit</b-button
            >
        </template>
        <b-overlay :show="loading" opacity="0.6" no-wrap></b-overlay>
    </b-modal>
</template>

<script>
import { ModelSelect } from 'vue-search-select'
export default {
    data() {
        return {
            loading: false,
            errors: {},
            permit: {},
            permit_type: null,
            permit_costs: {},
            permit_types: [],
            sectors: []
        }
    },
    components: {
        ModelSelect
    },
    props: {
        booking: Object
    },
    methods: {
        getPermitTypeCosts() {
            this.$http.get('/permit-types').then((permitCosts) => {
                this.permit_costs = permitCosts.data.data

                this.permit_types = []

                for (var key in this.permit_costs) {
                    this.permit_types.push({
                        value: key,
                        text: key.replaceAll('_', ' ')
                    })
                }
            })
        },
        getSectors() {
            this.$http.get('/sectors').then((sectors) => {
                this.sectors = sectors.data.data.map(function (num) {
                    return {
                        value: num.id,
                        text: num.name
                    }
                })
            })
        },
        addPermit() {
            this.loading = true
            this.errors = {}

            this.$http
                .post('/bookings/' + this.$route.params.id + '/permits', this.permit)
                .then((response) => {
                    this.alertAddSuccess()
                    this.permit = {}
                    this.$parent.getBooking()
                    this.$bvModal.hide('new-permit')
                })
                .catch((errors) => {
                    this.errors = errors.errors
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        }
    },
    mounted() {
        this.getPermitTypeCosts()
        this.getSectors()
    },
    watch: {
        permit_type: function (val) {
            this.permit.permit_type_id = this.permit_costs[val].id
            this.permit.cost = null
        }
    }
}
</script>
