<template>
<b-modal id="invoice-details" title="Add Invoice Details">
    <form>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <label>Narration</label>
                    <input type="text" class="form-control place" id="" placeholder="Client Names" required>
                </div>
                <div class="form-group"><textarea class="form-control form-control-lg" data-toggle="autosize" placeholder="type here what you want to show in the invoice...." rows="5" required="" style="overflow: hidden; overflow-wrap: break-word; resize: none; height: 150px; font-size: 15px"></textarea></div>

            </div>

        </div>
    </form>
    <template v-slot:modal-footer="{ cancel, ok }">
        <b-button size="lg" variant="danger" @click="cancel()">Cancel</b-button>
        <b-button size="lg" variant="success" @click="ok()">Save Details</b-button>
    </template>
</b-modal>
</template>
