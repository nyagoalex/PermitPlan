<template>
    <b-modal id="new-season" title="Add Season">
        <form>
            <div class="form-group">
                <label for="s-name">Season Name</label>
                <input type="text" class="form-control" id="s-name" placeholder="High season, Low Season, or peak season" required>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="s-date-from">From</label>
                    <input type="date" class="form-control" id="s-date-from" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="inputPassword4">To</label>
                    <input type="date" class="form-control" id="s-date-to" required>
                </div>
            </div>
        </form>
        <template v-slot:modal-footer="{ cancel, ok }">
            <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
            <b-button size="sm" variant="success" @click="ok()">Add Guest</b-button>
        </template>
    </b-modal>
</template>
