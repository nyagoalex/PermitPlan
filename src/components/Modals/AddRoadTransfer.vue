<template>
    <b-modal id="new-road-transfer" title="Add Road Transfer">
        <form>

            <div class="form-group">
                <label for="rt-name">Transfer Name</label>
                <input type="text" class="form-control" id="rt-name" placeholder=" EBB - KIHIHI" required>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="rt-starting_point">starting Point</label>
                    <input type="text" class="form-control" id="rt-starting_point" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="rt-destination">Destination</label>
                    <input type="text" class="form-control" id="rt-destination" required>
                </div>
            </div>
            <div class="form-group">
                <label for="rt-vehicle_type">Vehicle Type</label>
                <select  class="form-control" id="rt-vehicle_type" required></select>
            </div>

            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="rt-cost_per_person">Cost P/P (USD)</label>
                    <input type="number" placeholder="300" class="form-control" id="rt-cost_per_person" required>
                </div>
                <div class="form-group col-md-4">
                    <label for="rt-est_time">Est. Time (Hrs)</label>
                    <input type="time" class="form-control" placeholder="3" id="rt-est_time" required>
                </div>

                <div class="form-group col-md-4">
                    <label for="rt-distance">Distance (KM)</label>
                    <input type="number" class="form-control" placeholder="200" id="rt-distance">
                </div>
            </div>
        </form>
        <template v-slot:modal-footer="{ cancel, ok }">
            <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
            <b-button size="sm" variant="success" @click="ok()">Add Transfer</b-button>
        </template>
    </b-modal>
</template>
