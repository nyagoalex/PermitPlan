<template>
<b-modal id="overall_payment_modal" title="Register Overall Payment" size="sm">
    <form>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Date</label>
                    <input type="date" class="form-control place" id="overall_payment_date" required>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Amount </label>
                    <input type="number" class="form-control place" id="overall_payment_amount" placeholder="input amount" required>
                    <label>
                        Bal: <span class="mr-2 text-grey">$</span>
                        30%: <span class="text-yellow">$</span>
                    </label>
                </div>
            </div>
        </div>

    </form>
    <template v-slot:modal-footer="{ cancel, ok }">
        <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
        <b-button size="sm" variant="success" @click="ok()">Register Payment</b-button>
    </template>
</b-modal>
</template>
