<template>
    <b-modal id="new-flight-transfer" title="Add Flight Transfer">
        <form>
            <div class="form-group">
                <label for="ft-name">Transfer Name</label>
                <input type="text" class="form-control" id="ft-name" placeholder=" EBB - KIHIHI" required>
            </div>
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="ft-starting_point">starting Point</label>
                    <input type="text" class="form-control" id="ft-starting_point" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="ft-destination">Destination</label>
                    <input type="text" class="form-control" id="ft-destination" required>
                </div>
            </div>
            <div class="form-group">

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="ft-airline_operator">Airline Operator</label>
                    <input type="text" class="form-control" id="ft-airline_operator" placeholder="Aerolink" required>
                </div>

                <div class="form-group col-md-6">
                    <label for="ft-flight_type">Flight Type</label>
                    <select id="ft-flight_type" class="form-control" >
                        <option selected>Choose...</option>
                        <option value="scheduled">Scheduled Flight</option>
                        <option value="chartered">Chartered Flight</option>
                    </select>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="ft-departure_time">Departure Time</label>
                    <input type="time" placeholder="300" class="form-control" id="ft-departure_time" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="ft-arrival_time">Est. Arrival Time</label>
                    <input type="time" class="form-control" placeholder="3" id="ft-arrival_time" required>
                </div>

            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="ft-cost_per_perso">Cost P/P (USD)</label>
                    <input type="number" placeholder="300" class="form-control" id="ft-cost_per_person" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="ft-est_time">Est. Time (Hrs)</label>
                    <input type="time" class="form-control" placeholder="3" id="ft-est_time" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="ft-distance">Distance (KM)</label>
                    <input type="number" class="form-control" placeholder="200" id="ft-distance">
                </div>
            </div>

        </form>
        <template v-slot:modal-footer="{ cancel, ok }">
            <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
            <b-button size="sm" variant="success" @click="ok()">Add Transfer</b-button>
        </template>
    </b-modal>
</template>
