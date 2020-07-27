<template>
    <b-modal id="new-permit" title="Add Permit">
        <form>
            <div class="row">
                <div class="col-6">
                    <div class="form-group">
                        <label>Permit Type</label>
                        <select class="form-control place" id="p-permit_type" required onchange="getPermitCost(value)"></select>
                    </div>
                    <div class="form-group">
                        <label>No. of Permits</label>
                        <input type="number" class="form-control place" id="p-no_of_permits" placeholder="1" required>
                    </div>

                </div>
                <div class="col-6">

                    <div class="form-group">
                        <label>Prefferred Sector</label>
                        <select class="form-control place" id="p-sector" required></select>
                        <h6 class="no-sectors" style='color:red; display: none;'><i class='fa fa-exclamation-triangle'></i> Add sectors in setting to continue</h6>
                    </div>
                    <div class="form-group">
                        <label>Tracking Date</label>
                        <input type="datetime-local" class="form-control place" id="p-tracking_date" required>
                    </div>

                </div>
            </div>
            <div class="row m-2">
                <div class="col-12" id="p-unit_cost">
                    <center> Select Price Per Permits</center>
                    <hr>
                    <label><input type="radio" name="p-unit_cost" value="0" id="c-i-ea" checked> Foreign Residents ($<span id="c-l-ea" class="text-info">0.00</span>)</label><br>
                    <label><input type="radio" name="p-unit_cost" value="0" id="c-i-fr"> Non-Residents
                        ($<span id="c-l-fr" class="text-info">0.00</span>)</label><br>
                    <label><input type="radio" name="p-unit_cost" value="0" id="c-i-nr"> Ugandans
                        ($<span id="c-l-nr" class="text-info">0.00</span>)</label><br>
                    <label><input type="radio" name="p-unit_cost" value="0" id="c-i-ug"> East Africans
                        ($<span id="c-l-ug" class="text-info">0.00</span>)</label>
                </div>
            </div>
        </form>
        <template v-slot:modal-footer="{ cancel, ok }">
            <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
            <b-button size="sm" variant="success" @click="ok()">Add Permit</b-button>
        </template>
    </b-modal>
</template>
