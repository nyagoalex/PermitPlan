<!-- @format -->

<template>
    <b-modal id="overall_payment_modal" title="Register Overall Payment" size="sm">
        <form>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Date</label>
                        <input
                            type="date"
                            class="form-control place"
                            v-model="payment.date"
                            :class="{ 'is-invalid': errors.date }"
                        />
                        <ul class="list-unstyled invalid-feedback" v-if="errors.date">
                            <li v-for="error in errors.date" :key="error">{{ error }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Amount </label>
                        <input
                            type="number"
                            class="form-control place"
                            placeholder="input amount"
                            v-model="payment.amount"
                            :class="{ 'is-invalid': errors.amount }"
                        />
                        <ul class="list-unstyled invalid-feedback" v-if="errors.amount">
                            <li v-for="error in errors.amount" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                        <label>
                            Balance: <span class="mr-2 text-info">${{ balance }}</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Payment Method </label>
                        <model-select
                            :options="this.payment_methods"
                            placeholder="select Payment Method"
                            class="form-control"
                            v-model="payment.method"
                            :class="{ 'is-invalid': errors.method }"
                        >
                        </model-select>
                        <ul class="list-unstyled invalid-feedback" v-if="errors.method">
                            <li v-for="error in errors.method" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" v-if="payment.method == 'cheque'">
                <div class="col-12">
                    <div class="form-group">
                        <label>Cheque No </label>
                        <input
                            type="text"
                            class="form-control place"
                            placeholder="input cheque number"
                            v-model="payment.cheque_no"
                            :class="{ 'is-invalid': errors.cheque_no }"
                        />
                        <ul
                            class="list-unstyled invalid-feedback"
                            v-if="errors.cheque_no"
                        >
                            <li v-for="error in errors.cheque_no" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row" v-if="payment.method == 'bank_transfer'">
                <div class="col-12">
                    <div class="form-group">
                        <label>Ref No </label>
                        <input
                            type="text"
                            class="form-control place"
                            placeholder="input ref no"
                            v-model="payment.ref_no"
                            :class="{ 'is-invalid': errors.ref_no }"
                        />
                        <ul class="list-unstyled invalid-feedback" v-if="errors.ref_no">
                            <li v-for="error in errors.ref_no" :key="error">
                                {{ error }}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </form>
        <template v-slot:modal-footer="{ cancel }">
            <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()"
                >Cancel</b-button
            >
            <b-button size="sm" variant="success" :disabled="loading" @click="addPayment"
                >Register Payment</b-button
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
            payment: {
                date: '',
                amount: '',
                method: '',
                cheque_no: '',
                ref_no: ''
            },
            payment_methods: [
                // prettier-ignore
                {
                    value: 'cash',
                    text: 'Cash'
                },
                {
                    value: 'cheque',
                    text: 'Cheque'
                },
                {
                    value: 'bank_transfer',
                    text: 'Bank Transfer'
                },
                {
                    value: 'credit_card',
                    text: 'Credit Card'
                },
                {
                    value: 'complementary',
                    text: 'Complementary'
                }
            ]
        }
    },
    components: {
        ModelSelect
    },
    props: {
        balance: Number
    },
    methods: {
        addPayment() {
            this.loading = true
            this.errors = {}
            if (this.payment.method !== 'cheque') {
                this.payment.cheque_no = ''
            }
            if (this.payment.method !== 'bank_transfer') {
                this.payment.ref_no = ''
            }
            this.$http
                .post('/bookings/' + this.$route.params.id + '/payments', this.payment)
                .then((response) => {
                    this.alertAddSuccess()
                    this.payment = {
                        date: '',
                        amount: ''
                    }
                    this.$parent.getBooking()
                    this.$bvModal.hide('overall_payment_modal')
                })
                .catch((errors) => {
                    if ('errors' in errors) {
                        this.errors = errors.errors
                    }
                    this.toastError(errors.message)
                })
                .finally(() => {
                    this.loading = false
                })
        }
    }
}
</script>
