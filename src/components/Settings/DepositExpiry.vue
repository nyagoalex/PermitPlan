<template>
    <b-container fluid="md" id='deposit-expiry'>
        <label class="float-left text-uppercase"> <strong> PERMITS EXPIRY </strong></label>
        <br>
        <hr>
        <b-row class="bg-light py-5 pl-5 pr-3">
            <b-col md='7' class="bg-white pr-3 py-4">
                <label><b>Update deposit expiry</b></label>

                <b-form-group class="mt-5 text-left" label="Maximum Period Allowed (In Days)" label-for="expiry_period">
                    <b-form-input id="expiry_period" type="number" v-model="company.permit_expiry_in_days" :class="{ 'is-invalid': errors.permit_expiry_in_days}" size="lg"></b-form-input>
                    <ul class="list-unstyled invalid-feedback" v-if="errors.permit_expiry_in_days">
                        <li v-for="(error) in errors.permit_expiry_in_days" :key="error">{{ error }}</li>
                    </ul>
                </b-form-group>

                <div class="form-group text-right">
                    <b-overlay :show="loading" rounded opacity="0.6" spinner-small class="d-inline-block">
                        <button class="btn btn-success" @click="updateExpiry" :disabled="loading">
                            <b-icon icon="pencil"></b-icon> Update
                        </button>
                    </b-overlay>
                </div>
            </b-col>
            <b-col md='5' class="bg-white pt-5 text-left border-left">
                <h5>You have set the permits to expire after <br><span>{{expiry_period}}</span> Day(s).</h5>

                <p class="mt-4" style="color:#606162"> <span class="" style="color:firebrick"><b>Note: </b>&nbsp;</span>Please note that the syste will remind you when the expiry period is approaching but the system can not make a payment automatically and so after making the payment, please update the booking permits accordingly.</p>
            </b-col>
        </b-row>
    </b-container>
</template>

<script>
export default {
    name: 'deposit-expiry',
    data() {
        return {
            expiry_period: 9,
            loading: false,
            errors: false
        }
    },
    props: {
        company: Object
    },
    methods: {
        updateExpiry() {
            this.loading = true
            this.errors = {}
            this.$http.patch('/settings', this.company)
                .then(response => {
                    this.company = response.data.data
                    this.toastSuccess('Expiry Period Successfully Updated')
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
