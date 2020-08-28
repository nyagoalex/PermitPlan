<template>
<b-container fluid="md">
    <label class="float-left text-uppercase"> <strong> {{ costTitle }} </strong></label>
    <br>
    <hr>
    <b-row class="bg-light p-5">
        <b-col md='6' class="bg-white pr-5 py-4 border border-success" style="border-radius:30px 30px 10px 10px; box-shadow: 1px grey;">
            <label><b>Update permit costs</b></label>
            <b-form-group class="mt-5" label-cols-md="5" label="East Africans:" label-align-sm="right" label-for="east-africans">
                <b-form-input id="east-africans" type="number" v-model='costs.east_african_cost' size="lg" :class="{ 'is-invalid': errors.east_african_cost}"></b-form-input>
                <ul class="list-unstyled invalid-feedback" v-if="errors.east_african_cost">
                    <li v-for="(error) in errors.east_african_cost" :key="error">{{ error }}</li>
                </ul>
            </b-form-group>

            <b-form-group label-cols-md="5" label="Foreign Residents:" label-align-sm="right" label-for="foreign-residents">
                <b-form-input id="foreign-residents" type="number" v-model='costs.foreign_resident_cost' size="lg" :class="{ 'is-invalid': errors.foreign_resident_cost}"></b-form-input>
                <ul class="list-unstyled invalid-feedback" v-if="errors.foreign_resident_cost">
                    <li v-for="(error) in errors.foreign_resident_cost" :key="error">{{ error }}</li>
                </ul>
            </b-form-group>

            <b-form-group label-cols-md="5" label="Non Residents:" label-align-sm="right" label-for="non-residents">
                <b-form-input id="non-residents" type="number" v-model='costs.non_resident_cost' size="lg" :class="{ 'is-invalid': errors.non_resident_cost}"></b-form-input>
                <ul class="list-unstyled invalid-feedback" v-if="errors.non_resident_cost">
                    <li v-for="(error) in errors.non_resident_cost" :key="error">{{ error }}</li>
                </ul>
            </b-form-group>

            <b-form-group label-cols-md="5" label="Ugandans:" label-align-sm="right" label-for="ugandans">
                <b-form-input id="ugandans" type="number" size="lg" v-model="costs.ugandan_cost" :class="{ 'is-invalid': errors.ugandan_cost}"></b-form-input>
                <ul class="list-unstyled invalid-feedback" v-if="errors.ugandan_cost">
                    <li v-for="(error) in errors.ugandan_cost" :key="error">{{ error }}</li>
                </ul>
            </b-form-group>

            <div class="form-group text-right">
                <b-overlay :show="loading" rounded opacity="0.6" spinner-small class="d-inline-block">
                    <button class="btn btn-success" @click="updateCost" :disabled="loading">
                        <b-icon icon="pencil"></b-icon> Update
                    </button>
                </b-overlay>
            </div>
        </b-col>
        <b-col class='py-4' offset-md="1">

            <small>last modified on: <b style="color: green;">{{costs.updated_at}}</b></small>
            <div class="card" style="width: 18rem;">
                <div class="card-header"> Summary </div>
                <ul class="list-group list-group-flush text-left">
                    <li class="list-group-item">East Africans <br><span class="lb-cost">USD ${{costs.east_african_cost}}</span></li>
                    <li class="list-group-item">Foreign Residentsn <br><span class="lb-cost">USD ${{costs.foreign_resident_cost}}</span></li>
                    <li class="list-group-item">Non Residents <br><span class="lb-cost">USD ${{costs.non_resident_cost}}</span></li>
                    <li class="list-group-item">Ugandans <br><span class="lb-cost">USD ${{costs.ugandan_cost}}</span></li>
                </ul>
            </div>
        </b-col>
    </b-row>
</b-container>
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
        costTitle: String,
        costs: Object
    },
    methods: {
        updateCost: function () {
            this.loading = true
            this.errors = {}
            this.$http.patch('/permit-types/' + this.costs.name, this.costs)
                .then(response => {
                    this.costs = response.data.data
                    this.toastSuccess(this.costs.name + ' Successfully Updated')
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

<style>
.list-group-item .lb-cost {
    color: #29693a !important;
    font-size: 15px;
}
</style>
