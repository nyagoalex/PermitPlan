<template>
    <b-modal id="new-vehicle" title="Add Vehicle">
       <form>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="code">Vehicle Code</label>
                    <input type="text" class="form-control" id="code" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="reg_no">Vehicle Reg.Number</label>
                    <input type="text" class="form-control" id="reg_no" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="v-color">Vehicle Color</label>
                    <input type="text" class="form-control" id="v-color" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="no_of_seats">No. of Seats</label>
                    <input type="number" class="form-control" id="no_of_seats">
                </div>
            </div>

            <div class="form-row">

                <div class="form-group col-md-6">
                    <label for="v-type">Vehicle Type</label>
                    <select type="text" class="form-control" id="v-type" required>
                        <option value="">Select Vehicle type</option>
                        <option value="Toyota Landcruiser-7x">Toyota Landcruiser-7x</option>
                        <option value="Toyota Landcruiser-5x">Toyota Landcruiser-5x</option>
                        <option value="Toyota Landcruiser-3x">Toyota Landcruiser-3x</option>
                        <option value="Toyota Landcruiser-2x">Toyota Landcruiser-2x</option>
                        <option value="Toyota Mini-Van">Toyota Mini-Van</option>
                        <option value="Toyota Super Custom">Toyota Super Custom</option>
                        <option value="Nissan Patrol">Nissan Patrol</option>
                        <option value="Landrover Defender">Landrover Defender</option>
                        <option value="Landrover Discovery">Landrover Discovery</option>
                        <option value="Coaster Bus">Coaster Bus</option>
                        <option value="Bus">Bus</option>
                    </select>
                </div>
                <div class="form-group col-md-6">

                    <label for="status">Vehicle Status</label>
                    <select type="text" class="form-control" id="status" required>
                        <option value="">Select Vehicle status</option>
                        <option value="ready">Ready for Safari</option>
                        <option value="disposed_off">Disposed off</option>
                        <option value="too_old">Too Old</option>
                        <option value="has_issues">Has issues</option>

                    </select>

                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cost_per_day">Cost Per Day (USD)</label>
                    <input type="text" placeholder="300" class="form-control" id="cost_per_day">
                </div>
                <div class="form-group col-md-6">
                    <label for="ownership">Ownership</label>
                    <select type="text" class="form-control" id="ownership" required>
                        <option value="">Select Ownership</option>
                        <option value="company">Company Vehicle</option>
                        <option value="hired">Hired Vehicle</option>

                    </select>
                </div>
            </div>
        </form>
        <template v-slot:modal-footer="{ cancel, ok }">
            <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
            <b-button size="sm" variant="success" @click="ok()">Add Guest</b-button>
        </template>
    </b-modal>
</template>
