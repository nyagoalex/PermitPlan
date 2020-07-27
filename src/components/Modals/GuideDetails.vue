<template>
    <b-modal id="guide-details" title="Add Vehicle" size="xl">
        <template v-slot:modal-header="{ close }">
            <b-col>
                <h5 class="modal-title" >Details for: <span class="guide-label"></span>
                </h5>
            </b-col>

            <b-col class="status_dropdown">
                <b-dropdown text="Working" variant="outline-success">
                    <b-dropdown-item variant="danger"> Terminated</b-dropdown-item>
                    <b-dropdown-item variant="warning"> On Probation</b-dropdown-item>
                </b-dropdown>
            </b-col>
            <b-col>
                <b-icon icon="x-circle" size="sm" variant="danger" class="float-right" @click="close()">Cancel</b-icon>
            </b-col>
        </template>
        <div class="p-4">

            <div class="row">

                <div class="col-md-4 col-12 p-4" style="border:1px solid #E1DDD4;">

                    <form id="guide-details-form">

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_first_name">First name</label>
                                <input type="text" class="form-control" id="edit_first_name" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_last_name">Other Names</label>
                                <input type="text" class="form-control" id="edit_last_name" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_dob">Date of Birth(DOB)</label>
                                <input type="date" class="form-control" id="edit_dob" required>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_experience">Guide Experience</label>
                                <input type="text" class="form-control" id="edit_experience">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_email">Email</label>
                                <input type="email" class="form-control" id="edit_email">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_phone">Phone Number</label>
                                <input type="number" class="form-control" id="edit_phone">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="edit_contract_basis">Contract Basis</label>
                                <select type="text" class="form-control" id="edit_contract_basis" required>
                                    <option value="">Select employment terms</option>
                                    <option value="full_time">Full-Time</option>
                                    <option value="freelancer">Freelancer</option>

                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="edit_cost_per_day">Cost Per Day (USD)</label>
                                <input type="text" placeholder="300" class="form-control" id="edit_cost_per_day">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-4 col-12 " style="border:1px solid #E1DDD4;">
                    <div class="col-md-12 col-12 pt-1">
                        <h5 class="pt-3">Parks Guide Experience</h5>
                        <hr>
                        <form>

                            <!-- <div class="form-group" id="new-park-form">
                                <label>National Park Name</label>
                                <input type="text" class="form-control" id="new-park" required>
                            </div> -->
                            <b-button variant="outline-success" onclick="addPark()"> + Add a new Park</b-button>
                        </form>
                        <div class="pt-4" id="nat-park-tb">
                            <!-- <div class="season mb-3">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="d-inline-block icon icon-xs bg-soft-success rounded-circle mr-2"> <i class="zmdi zmdi-local-activity icon-text icon-text-xs d-inline-block text-success"></i> </div>Kibale National Parks
                                    </div>
                                    <div class="col-md-2">
                                        <span style="color:#C26004"><b><button type="button" class="btn btn-outline-success sm-b">5 Yrs</button></b></span>
                                    </div>
                                    <div class="col-md-2"> <a href="#" title="" onclick=""><i class="zmdi zmdi-eyedropper"></i></a> <br><a href="#" class="text-danger " title="" onclick=""><i class="zmdi zmdi-delete"></i></a> </div>
                                </div>
                            </div>
                            <div class="season mb-3">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="d-inline-block icon icon-xs bg-soft-success rounded-circle mr-2"> <i class="zmdi zmdi-local-activity icon-text icon-text-xs d-inline-block text-success"></i> </div>Kibale National Parks <span class="pl-4" style="color:#C26004"><b><button type="button" class="btn btn-outline-success sm-b">5 Yrs</button></b></span>
                                    </div>
                                    <div class="col-md-2"> <a href="#" title="" onclick=""><i class="zmdi zmdi-eyedropper"></i></a> <a href="#" class="text-danger ml-2" title="" onclick=""><i class="zmdi zmdi-delete"></i></a> </div>
                                </div>
                            </div> -->

                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-12 " style="border:1px solid #E1DDD4;">

                    <div class="col-md-12 col-12 pt-1">
                        <h5 class="pt-3">Guide's Vehicles Experience</h5>
                        <hr>
                        <form>
                            <!-- <div class="form-group">
                                <label>Vehicle Type</label>
                                <input type="text" class="form-control">
                            </div> -->

                            <b-button variant="outline-success" onclick="addVehicle()"> + Add a new vehicle Type</b-button>

                        </form>
                        <div class="pt-4" id="vehicle-tb">
                            <!-- <div class="season mb-3">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="d-inline-block icon icon-xs bg-soft-success rounded-circle mr-2"> <i class="zmdi zmdi-local-activity icon-text icon-text-xs d-inline-block text-success"></i> </div>Landcruiser - Manual <span class="pl-4" style="color:#C26004"><b><button type="button" class="btn btn-outline-success sm-b">11 Yrs</button></b></span>
                                    </div>
                                    <div class="col-md-2"> <a href="#" title="" onclick=""><i class="zmdi zmdi-eyedropper"></i></a> <a href="#" class="text-danger ml-2" title="" onclick=""><i class="zmdi zmdi-delete"></i></a> </div>
                                </div>
                            </div>
                            <div class="season mb-3">
                                <div class="row">
                                    <div class="col-md-10">
                                        <div class="d-inline-block icon icon-xs bg-soft-success rounded-circle mr-2"> <i class="zmdi zmdi-local-activity icon-text icon-text-xs d-inline-block text-success"></i> </div>Mini-Van Automatic <span class="pl-4" style="color:#C26004"><b><button type="button" class="btn btn-outline-success sm-b">10 Yrs</button></b></span>
                                    </div>
                                    <div class="col-md-2"> <a href="#" title="" onclick=""><i class="zmdi zmdi-eyedropper"></i></a> <a href="#" class="text-danger ml-2" title="" onclick=""><i class="zmdi zmdi-delete"></i></a> </div>
                                </div>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <template v-slot:modal-footer="{ cancel, ok }">
            <b-button size="sm" variant="danger" @click="cancel()">Cancel</b-button>
            <b-button size="sm" variant="success" @click="ok()">Update Guide Details</b-button>
        </template>
    </b-modal>
</template>
