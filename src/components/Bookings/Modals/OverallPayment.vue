<template>
    <b-modal id="overall_payment_modal" title="Register Overall Payment" size="sm">
        <form>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Date</label>
                        <input type="date" class="form-control place" v-model="payment.date" :class="{ 'is-invalid': errors.date}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.date">
                            <li v-for="(error) in errors.date" :key="error">{{ error }}</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group">
                        <label>Amount </label>
                        <input type="number" class="form-control place" placeholder="input amount" v-model="payment.amount" :class="{ 'is-invalid': errors.amount}">
                        <ul class="list-unstyled invalid-feedback" v-if="errors.amount">
                            <li v-for="(error) in errors.amount" :key="error">{{ error }}</li>
                        </ul>
                        <label>
                            Balance: <span class="mr-2 text-info">${{balance}}</span>
                        </label>
                    </div>
                </div>
            </div>

        </form>
        <template v-slot:modal-footer="{ cancel }">
            <b-button size="sm" variant="danger" :disabled="loading" @click="cancel()">Cancel</b-button>
            <b-button size="sm" variant="success" :disabled="loading" @click="addPayment">Register Payment</b-button>
        </template>
        <b-overlay :show="loading" opacity="0.6" no-wrap></b-overlay>
    </b-modal>
</template>

<script>
export default {
    data() {
        return {
            loading: false,
            errors: {},
            payment: {
                date: '',
                amount: ''
            }
        }
    },
    props: {
        balance: Number
    },
    methods: {
        addPayment() {
            this.loading = true
            this.errors = {}

            this.$http.post('/bookings/' + this.$route.params.id + '/payments', this.payment)
                .then(response => {
                    this.alertAddSuccess()
                    this.payment = {
                        date: '',
                        amount: ''
                    }
                    this.$parent.getBooking()
                    this.$bvModal.hide('overall_payment_modal')
                })
                .catch(errors => {
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
