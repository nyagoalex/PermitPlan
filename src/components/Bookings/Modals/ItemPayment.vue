<template>
    <b-modal id="item-payment-modal" :title="`Register Payment For ${model_type}`" size="sm">
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
                    </div>
                </div>
            </div>
            <small>
                Balance:<span class="mr-2 text-info">{{selected_modal.balance}}</span>
                <span v-if="selected_modal.payments.length == 0">
                    30%:<span class="mr-2 text-info">{{(selected_modal.balance * 0.3).toFixed(2)}}</span>
                    70%:<span class="mr-2 text-info">{{(selected_modal.balance * 0.7).toFixed(2)}}</span>
                </span>
            </small>

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
        model_type: String,
        selected_modal: Object
    },
    methods: {
        addPayment() {
            this.loading = true
            this.errors = {}

            this.$http.post('/item-payments/' + this.model_type + '/' + this.selected_modal.id, this.payment)
                .then(response => {
                    this.alertAddSuccess()
                    this.payment = {
                        date: '',
                        amount: ''
                    }
                    this.$parent.callBookings()
                    this.$bvModal.hide('item-payment-modal')
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
