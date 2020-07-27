<template>
    <b-modal id="new-guide" title="Add Tour Guide">
       <form>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="add_first_name">First name</label>
                    <input type="text" class="form-control" id="add_first_name" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="add_last_name">Other Names</label>
                    <input type="text" class="form-control" id="add_last_name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="add_dob">Date of Birth(DOB)</label>
                    <input type="date" class="form-control" id="add_dob" required>
                </div>
                <div class="form-group col-md-6">
                    <label for="add_experience">Guide Experience</label>
                    <input type="date" class="form-control" id="add_experience">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="add_email">Email</label>
                    <input type="email" class="form-control" id="add_email">
                </div>
                <div class="form-group col-md-6">
                    <label for="add_phone">Phone Number</label>
                    <input type="number" class="form-control" id="add_phone">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="add_contract_basis">Contract Basis</label>
                    <select type="text" class="form-control" id="add_contract_basis" required>
                        <option value="">Select employment terms</option>
                        <option value="full_time">Full-Time</option>
                        <option value="freelancer">Freelancer</option>

                    </select>
                </div>
                <div class="form-group col-md-6">
                    <label for="add_status">Guide Status</label>
                    <select type="text" class="form-control" id="add_status" required>
                        <option value="">Select guide status</option>
                        <option value="working">Working</option>
                        <option value="terminated">Terminated</option>
                        <option value="probation">On Probation</option>

                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-12">
                    <label for="add_cost_per_day">Cost Per Day (USD)</label>
                    <input type="number" placeholder="300" class="form-control" id="add_cost_per_day">
                </div>

            </div>

        </form>
        <template v-slot:modal-footer="{ cancel, ok }">
            <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
            <b-button size="sm" variant="success" @click="ok()">Add Guide</b-button>
        </template>
    </b-modal>
</template>
