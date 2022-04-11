<template>
<!-- new payment modal-->
<div class="modal fade " id="new-payment" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="lineModalLabelo">Add Payment</h3>
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Date</label>
                            <input type="date" class="form-control place" id="payment_date" required>
                        </div>

                        <div class="form-group">
                            <label>Sector Bought</label>
                            <select class="form-control place" id="payment_sector" required></select>
                            <h6 class="no-sectors" style='color:red; display: none;'><i class='fa fa-exclamation-triangle'></i> Add sectors in setting to continue</h6>
                        </div>

                    </div>

                    <div class="col-8">

                        <p>Permit With Balances</p>
                        <div id="collap-amounts">
                        </div>

                    </div>
                </div>
                <!-- </form> -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn  btn-lg btn-success" id="save_permit" onclick="addPayment(this)">Save</button>
                <button type="button" class="btn btn-lg btn-danger" data-dismiss="modal" id="produce_dismiss">Cancel</button>
            </div>
        </div>
    </div>
</div>
</template>
